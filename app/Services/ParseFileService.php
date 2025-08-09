<?php

namespace App\Services;

use App\Models\Player;
use App\Models\GameEvent;
use App\Models\Boss;
use App\Models\Item;
use App\Models\Zone;
use App\Models\Quest;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ParseFileService
{
    private $uploadedFile;
    private $processedEvents = 0;
    private $skippedEvents = 0;
    private $hashCache = []; // Cache para hashes já verificados

    public function parseFile($filePath)
    {
        $fullPath = Storage::disk('public')->path($filePath);
        
        if (!file_exists($fullPath)) {
            throw new \Exception('Arquivo não encontrado');
        }

        $fileHash = hash_file('sha256', $fullPath);
        
        // VERIFICAÇÃO DE ARQUIVO DUPLICADO
        $existingFile = UploadedFile::where('file_hash', $fileHash)
            ->where('status', 'completed')
            ->first();

        if ($existingFile) {
            return [
                'message' => 'Arquivo já foi processado anteriormente',
                'uploaded_file_id' => $existingFile->id,
                'events_processed' => 0,
                'events_skipped' => $existingFile->events_count,
                'duplicate_file' => true
            ];
        }

        // Criar/atualizar registro do upload
        $this->uploadedFile = UploadedFile::where('file_path', $filePath)->first();
        if ($this->uploadedFile) {
            $this->uploadedFile->update([
                'file_hash' => $fileHash,
                'status' => 'processing'
            ]);
        } else {
            $this->uploadedFile = UploadedFile::create([
                'file_path' => $filePath,
                'name' => basename($filePath),
                'file_hash' => $fileHash,
                'status' => 'processing'
            ]);
        }

        try {
            DB::beginTransaction();

            // Carregar hashes existentes para cache (otimização)
            $this->loadExistingHashes();

            $lines = file($fullPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $parsedEvents = [];

            foreach ($lines as $lineNumber => $line) {
                $event = $this->parseLine($line, $lineNumber);
                if ($event) {
                    $processedEvent = $this->processEvent($event);
                    if ($processedEvent) {
                        $parsedEvents[] = $processedEvent;
                    }
                }
            }

            // Recalcular estatísticas apenas dos jogadores afetados
            $this->recalculateAffectedStats();

            // Marcar como concluído
            $this->uploadedFile->update([
                'status' => 'completed',
                'processed_at' => now(),
                'events_count' => $this->processedEvents
            ]);

            DB::commit();

            return [
                'message' => 'Arquivo processado com sucesso',
                'uploaded_file_id' => $this->uploadedFile->id,
                'events_processed' => $this->processedEvents,
                'events_skipped' => $this->skippedEvents,
                'duplicate_file' => false
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->uploadedFile->update(['status' => 'failed']);
            
            throw new \Exception('Erro ao processar arquivo: ' . $e->getMessage());
        }
    }

    private function loadExistingHashes()
    {
        // Carregar hashes dos últimos 7 dias para otimização
        $recentHashes = GameEvent::where('created_at', '>=', now()->subDays(7))
            ->whereNotNull('event_hash')
            ->pluck('event_hash')
            ->toArray();
            
        $this->hashCache = array_flip($recentHashes); // Usar como array associativo para O(1) lookup
    }

    private function parseLine($line, $lineNumber)
    {
        // Regex para capturar: timestamp [categoria] tipo dados
        $pattern = '/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}) \[(\w+)\] (\w+) (.+)$/';
        
        if (preg_match($pattern, $line, $matches)) {
            return [
                'timestamp' => Carbon::parse($matches[1]),
                'category' => $matches[2],
                'event_type' => $matches[3],
                'data_string' => $matches[4],
                'raw_line' => $line
            ];
        }

        return null;
    }

    private function processEvent($event)
    {
        $eventData = $this->parseEventData($event['data_string']);
        
        // CAMADA 1: VERIFICAÇÃO RÁPIDA POR HASH
        $eventHash = $this->generateEventHash($event, $eventData);
        
        // Verificar no cache primeiro (mais rápido)
        if (isset($this->hashCache[$eventHash])) {
            $this->skippedEvents++;
            return null;
        }

        // Verificar no banco se não está no cache
        if (GameEvent::where('event_hash', $eventHash)->exists()) {
            $this->hashCache[$eventHash] = true; // Adicionar ao cache
            $this->skippedEvents++;
            return null;
        }

        // CAMADA 2: VERIFICAÇÃO PRECISA POR CAMPOS ÚNICOS
        if ($this->isDuplicateEventByFields($event, $eventData)) {
            $this->skippedEvents++;
            return null;
        }

        // Processar entidades relacionadas
        $this->processRelatedEntities($event, $eventData);

        // Criar evento
        $gameEvent = GameEvent::create([
            'timestamp' => $event['timestamp'],
            'category' => $event['category'],
            'event_type' => $event['event_type'],
            'player_id' => $eventData['player_id'] ?? null,
            'event_data' => $eventData,
            'uploaded_file_id' => $this->uploadedFile->id,
            'event_hash' => $eventHash
        ]);

        // Adicionar hash ao cache
        $this->hashCache[$eventHash] = true;
        $this->processedEvents++;
        
        return $gameEvent;
    }

    private function generateEventHash($event, $eventData)
    {
        // Hash incluindo timestamp completo + dados essenciais
        $hashData = [
            'timestamp' => $event['timestamp']->format('Y-m-d H:i:s'),
            'category' => $event['category'],
            'event_type' => $event['event_type'],
            'event_data' => $this->normalizeEventDataForHash($eventData)
        ];
        
        // ✅ CORREÇÃO: Usar serialize + ksort para garantir ordem consistente
        ksort($hashData);
        $normalizedData = $this->arrayToSortedString($hashData);
        
        return hash('md5', $normalizedData);
    }

    private function arrayToSortedString($array)
    {
        // Função personalizada para converter array em string ordenada
        $parts = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                ksort($value);
                $value = $this->arrayToSortedString($value);
            }
            $parts[] = $key . ':' . $value;
        }
        sort($parts);
        return implode('|', $parts);
    }

    private function normalizeEventDataForHash($eventData)
    {
        // Normalizar dados para hash consistente
        $normalized = $eventData;
        
        // Remover campos que podem variar mas não afetam a unicidade
        unset($normalized['location_x'], $normalized['location_y']); // Manter apenas 'location'
        
        // Ordenar para garantir hash consistente
        if (is_array($normalized)) {
            ksort($normalized);
        }
        
        return $normalized;
    }

    private function isDuplicateEventByFields($event, $eventData)
    {
        // Verificação mais precisa para casos especiais
        $query = GameEvent::where('timestamp', $event['timestamp'])
                          ->where('event_type', $event['event_type']);

        // Aplicar verificações específicas por tipo de evento
        switch ($event['event_type']) {
            case 'BOSS_DEFEAT':
                $query->where('event_data->boss_name', $eventData['boss_name'] ?? null)
                      ->where('event_data->defeated_by', $eventData['defeated_by'] ?? null);
                break;
                
            case 'QUEST_COMPLETE':
            case 'QUEST_START':
                $query->where('player_id', $eventData['player_id'] ?? null)
                      ->where('event_data->quest_id', $eventData['quest_id'] ?? null);
                break;
                
            case 'DEATH':
                $query->where('event_data->victim_id', $eventData['victim_id'] ?? null)
                      ->where('event_data->killer_id', $eventData['killer_id'] ?? null);
                break;
                
            case 'ITEM_PICKUP':
                $query->where('player_id', $eventData['player_id'] ?? null)
                      ->where('event_data->item', $eventData['item'] ?? null)
                      ->where('event_data->location', $eventData['location'] ?? null);
                break;
                
            case 'MESSAGE':
                $query->where('player_id', $eventData['player_id'] ?? null)
                      ->where('event_data->message', $eventData['message'] ?? null);
                break;
                
            case 'PLAYER_JOIN':
                $query->where('event_data->id', $eventData['id'] ?? null)
                      ->where('event_data->name', $eventData['name'] ?? null);
                break;
                
            case 'ZONE_ENTER':
            case 'ZONE_EXIT':
                $query->where('player_id', $eventData['player_id'] ?? null)
                      ->where('event_data->zone', $eventData['zone'] ?? null);
                break;
                
            case 'SCORE':
                $query->where('player_id', $eventData['player_id'] ?? null)
                      ->where('event_data->points', $eventData['points'] ?? null);
                break;
                
            default:
                // Para eventos não mapeados, verificar apenas timestamp + tipo + player
                $query->where('player_id', $eventData['player_id'] ?? null);
                break;
        }

        return $query->exists();
    }

    private function parseEventData($dataString)
    {
        $data = [];
        
        // Parse key=value pairs (including quoted values)
        $patterns = [
            '/(\w+)="([^"]*)"/',  // key="value with spaces"
            '/(\w+)=([^\s]+)/',   // key=value
        ];

        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $dataString, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $key = $match[1];
                $value = $match[2];
                
                // Converter números
                if (is_numeric($value)) {
                    $value = is_float($value) ? (float)$value : (int)$value;
                }
                
                $data[$key] = $value;
            }
        }

        // Parse special cases like location=(x,y)
        if (preg_match('/location=\((\d+),(\d+)\)/', $dataString, $matches)) {
            $data['location'] = "({$matches[1]},{$matches[2]})";
            $data['location_x'] = (int)$matches[1];
            $data['location_y'] = (int)$matches[2];
        }

        return $data;
    }

    private function processRelatedEntities($event, $eventData)
    {
        // Processar jogadores principais
        if (isset($eventData['player_id'])) {
            $this->ensurePlayerExists($eventData['player_id'], $eventData);
        }

        // Processar outros IDs de jogadores
        foreach (['defeated_by', 'victim_id', 'killer_id', 'id'] as $field) {
            if (isset($eventData[$field]) && str_starts_with($eventData[$field], 'p')) {
                $this->ensurePlayerExists($eventData[$field], $eventData);
            }
        }

        // Processar entidades (usar firstOrCreate é eficiente com índices)
        if (isset($eventData['boss_name'])) {
            Boss::firstOrCreate(['name' => $eventData['boss_name']]);
        }

        if (isset($eventData['zone'])) {
            Zone::firstOrCreate(['name' => $eventData['zone']]);
        }

        if (isset($eventData['item'])) {
            Item::firstOrCreate(['name' => $eventData['item']]);
        }

        if (isset($eventData['quest_id'])) {
            Quest::firstOrCreate(
                ['quest_id' => $eventData['quest_id']],
                ['name' => $eventData['name'] ?? "Quest {$eventData['quest_id']}"]
            );
        }
    }

    private function ensurePlayerExists($playerId, $eventData)
    {
        $player = Player::firstOrCreate(
            ['player_id' => $playerId],
            [
                'name' => $eventData['name'] ?? "Player {$playerId}",
                'level' => isset($eventData['level']) ? (int)$eventData['level'] : 1,
                'current_zone' => $eventData['zone'] ?? null,
                'last_seen' => now()
            ]
        );

        // Atualizar apenas se necessário
        $updates = [];
        
        if (isset($eventData['name']) && $eventData['name'] !== "Player {$playerId}" && $player->name === "Player {$playerId}") {
            $updates['name'] = $eventData['name'];
        }

        if (isset($eventData['level']) && (int)$eventData['level'] > $player->level) {
            $updates['level'] = (int)$eventData['level'];
        }

        if (isset($eventData['zone'])) {
            $updates['current_zone'] = $eventData['zone'];
        }

        // Sempre atualizar last_seen
        $updates['last_seen'] = now();

        if (!empty($updates)) {
            $player->update($updates);
        }

        return $player;
    }

    private function recalculateAffectedStats()
    {
        // Buscar apenas jogadores que tiveram eventos neste upload
        $affectedPlayerIds = GameEvent::where('uploaded_file_id', $this->uploadedFile->id)
            ->whereNotNull('player_id')
            ->distinct()
            ->pluck('player_id');

        // Processar diretamente para evitar complexidade desnecessária
        foreach ($affectedPlayerIds as $playerId) {
            $this->updatePlayerStatsFromEvents($playerId);
        }

        // Recalcular estatísticas de entidades afetadas
        $this->recalculateEntityStats();
    }

    private function updatePlayerStatsFromEvents($playerId)
    {
        $player = Player::where('player_id', $playerId)->first();
        if (!$player) return;

        // Buscar todos os eventos do jogador e calcular estatísticas
        $events = GameEvent::where('player_id', $playerId)->get();

        $totalScore = $events->where('event_type', 'SCORE')->sum(function($event) {
            return $event->event_data['points'] ?? 0;
        });

        $totalXp = $events->whereIn('event_type', ['BOSS_DEFEAT', 'QUEST_COMPLETE'])->sum(function($event) {
            return $event->event_data['xp'] ?? 0;
        });

        $totalGold = $events->whereIn('event_type', ['BOSS_DEFEAT', 'QUEST_COMPLETE'])->sum(function($event) {
            return $event->event_data['gold'] ?? 0;
        });

        $deaths = GameEvent::where('event_type', 'DEATH')
            ->where('event_data->victim_id', $playerId)
            ->count();

        $kills = GameEvent::where('event_type', 'DEATH')
            ->where('event_data->killer_id', $playerId)
            ->count();

        $bossesDefeated = GameEvent::where('event_type', 'BOSS_DEFEAT')
            ->where('event_data->defeated_by', $playerId)
            ->count();

        $questsCompleted = $events->where('event_type', 'QUEST_COMPLETE')->count();

        $lastSeen = $events->max('timestamp');

        // Atualizar jogador
        $player->update([
            'total_score' => $totalScore,
            'total_xp' => $totalXp,
            'total_gold' => $totalGold,
            'deaths' => $deaths,
            'kills' => $kills,
            'bosses_defeated' => $bossesDefeated,
            'quests_completed' => $questsCompleted,
            'last_seen' => $lastSeen,
        ]);
    }

    private function recalculateEntityStats()
    {
        // Recalcular apenas entidades afetadas neste upload
        $affectedBosses = GameEvent::where('uploaded_file_id', $this->uploadedFile->id)
            ->whereIn('event_type', ['BOSS_DEFEAT', 'BOSS_DAMAGE', 'BOSS_FIGHT_START'])
            ->get()
            ->pluck('event_data.boss_name')
            ->filter()
            ->unique();

        $affectedItems = GameEvent::where('uploaded_file_id', $this->uploadedFile->id)
            ->where('event_type', 'ITEM_PICKUP')
            ->get()
            ->pluck('event_data.item')
            ->filter()
            ->unique();

        $affectedZones = GameEvent::where('uploaded_file_id', $this->uploadedFile->id)
            ->whereIn('event_type', ['ZONE_ENTER', 'ZONE_EXIT'])
            ->get()
            ->pluck('event_data.zone')
            ->filter()
            ->unique();

        // Atualizar estatísticas
        foreach ($affectedBosses as $bossName) {
            $boss = Boss::where('name', $bossName)->first();
            if ($boss) {
                $boss->updateStats();
            }
        }

        foreach ($affectedItems as $itemName) {
            $item = Item::where('name', $itemName)->first();
            if ($item) {
                $item->updateStats();
            }
        }

        foreach ($affectedZones as $zoneName) {
            $zone = Zone::where('name', $zoneName)->first();
            if ($zone) {
                $zone->updateStats();
            }
        }
    }
}