<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameEvent;

class EventController extends Controller
{
    /**
     * @group Events
     * GET /events → últimos eventos com filtros
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam category string Opcional. Categoria do evento.
     * 
     * @queryParam event_type string Opcional. Tipo de evento.
     * 
     * @queryParam player_id string Opcional. ID do jogador.
     * 
     * @queryParam date_from string Opcional. Data inicial para o filtro.
     * 
     * @queryParam date_to string Opcional. Data final para o filtro.
     * 
     * @queryParam limit int Opcional. Número máximo de eventos a serem retornados.
     * 
     * @response 200 {
     *     "success": true,
     *     "data": [
     *         {
     *             "id": 1,
     *             "timestamp": "2025-08-09T22:48:46.000000Z",
     *             "category": "combat",
     *             "event_type": "BOSS_DEFEAT",
     *             "player_id": "p1",
     *             "player_name": "Jogador 1",
     *             "event_data": {
     *                 "boss_name": "Boss 1",
     *                 "defeated_by": "Jogador 2"
     *             },
     *             "description": "Jogador 1 derrotou Boss 1"
     *         },
     *         {
     *             "id": 2,
     *             "timestamp": "2025-08-09T22:48:46.000000Z",
     *             "category": "progression",
     *             "event_type": "QUEST_COMPLETE",
     *             "player_id": "p2",
     *             "player_name": "Jogador 2",
     *             "event_data": {
     *                 "name": "Quest 1",
     *                 "quest_id": "q1"
     *             },
     *             "description": "Jogador 2 completou Quest 1"
     *         }
     *     ],
     *     "total": 2,
     *     "limit": 50  
     * }
     */
    public function index(Request $request)
    {
        $query = GameEvent::with('player')->orderBy('timestamp', 'desc');

        // Filtros
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->has('player_id')) {
            $query->where('player_id', $request->player_id);
        }

        if ($request->has('date_from')) {
            $query->where('timestamp', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('timestamp', '<=', $request->date_to);
        }

        // Paginação dinâmica (máximo 1000 para evitar sobrecarga)
        $limit = min($request->get('limit', 50), 1000);
        $events = $query->limit($limit)->get();

        $formattedEvents = $events->map(function($event) {
            return [
                'id' => $event->id,
                'timestamp' => $event->timestamp,
                'category' => $event->category,
                'event_type' => $event->event_type,
                'player_id' => $event->player_id,
                'player_name' => $event->player?->name ?? 'Desconhecido',
                'event_data' => $event->event_data,
                'description' => $this->formatEventDescription($event),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedEvents,
            'total' => $events->count(),
            'limit' => $limit
        ]);
    }

    /**
     * @group Events
     * GET /events/summary → resumo de eventos por categoria/tipo
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam date_from string Opcional. Data inicial para o resumo.
     * 
     * @queryParam date_to string Opcional. Data final para o resumo.
     * 
     * 
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "total_events": 100,
     *         "date_range": {
     *             "from": "2025-08-01 00:00:00",
     *             "to": "2025-08-07 23:59:59"
     *         },
     *         "by_category": {
     *             "combat": 30,
     *             "progression": 20,
     *             "social": 15,
     *             "other": 35
     *         },
     *         "by_event_type": {
     *             "BOSS_DEFEAT": 30,
     *             "QUEST_COMPLETE": 20,
     *             "ITEM_PICKUP": 15,
     *             "DEATH": 35
     *         },
     *         "most_active_players": [
     *             {
     *                 "player_id": "p1",
     *                 "player_name": "Jogador 1",
     *                 "total_events": 100
     *             },
     *             {
     *                 "player_id": "p2",
     *                 "player_name": "Jogador 2",
     *                 "total_events": 80
     *             }
     *         }
     *     }
     * }
     */
    public function summary(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(7));
        $dateTo = $request->get('date_to', now());

        $events = GameEvent::whereBetween('timestamp', [$dateFrom, $dateTo])->get();

        $summary = [
            'total_events' => $events->count(),
            'date_range' => [
                'from' => $dateFrom,
                'to' => $dateTo
            ],
            'by_category' => $events->groupBy('category')->map->count(),
            'by_event_type' => $events->groupBy('event_type')->map->count(),
            'most_active_players' => $events->whereNotNull('player_id')
                ->groupBy('player_id')
                ->map->count()
                ->sortDesc()
                ->take(10),
        ];

        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }

    private function formatEventDescription($event)
    {
        $data = $event->event_data ?? [];
        
        try {
            switch ($event->event_type) {
                case 'BOSS_DEFEAT':
                    $bossName = $data['boss_name'] ?? 'Boss desconhecido';
                    $defeatedBy = $data['defeated_by'] ?? $event->player_id ?? 'Desconhecido';
                    $playerName = $event->player?->name ?? $defeatedBy;
                    return "{$playerName} derrotou {$bossName}";
                    
                case 'QUEST_COMPLETE':
                    $questName = $data['name'] ?? $data['quest_id'] ?? 'Quest desconhecida';
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} completou {$questName}";
                    
                case 'QUEST_START':
                    $questName = $data['name'] ?? $data['quest_id'] ?? 'Quest desconhecida';
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} iniciou {$questName}";
                    
                case 'ITEM_PICKUP':
                    $item = $data['item'] ?? 'item desconhecido';
                    $qty = $data['qty'] ?? 1;
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} coletou {$qty}x {$item}";
                    
                case 'DEATH':
                    $victim = $data['victim_id'] ?? 'Desconhecido';
                    $killer = $data['killer_id'] ?? 'Desconhecido';
                    $method = $data['method'] ?? 'método desconhecido';
                    return "{$victim} foi morto por {$killer} com {$method}";
                    
                case 'ZONE_ENTER':
                    $zone = $data['zone'] ?? 'zona desconhecida';
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} entrou em {$zone}";
                    
                case 'ZONE_EXIT':
                    $zone = $data['zone'] ?? 'zona desconhecida';
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} saiu de {$zone}";
                    
                case 'MESSAGE':
                    $message = $data['message'] ?? '';
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName}: \"{$message}\"";
                    
                case 'PLAYER_JOIN':
                    $name = $data['name'] ?? $event->player_id ?? 'Jogador';
                    $level = $data['level'] ?? 1;
                    $zone = $data['zone'] ?? 'local desconhecido';
                    return "{$name} entrou no jogo (nível {$level}) em {$zone}";
                    
                case 'SERVER_ANNOUNCEMENT':
                    $text = $data['text'] ?? 'Anúncio do servidor';
                    return "Servidor: {$text}";
                    
                case 'BOSS_DAMAGE':
                    $bossName = $data['boss_name'] ?? 'Boss';
                    $damage = $data['damage'] ?? 0;
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} causou {$damage} de dano em {$bossName}";
                    
                case 'BOSS_FIGHT_START':
                    $bossName = $data['boss_name'] ?? 'Boss';
                    $hp = $data['hp'] ?? 0;
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} iniciou luta contra {$bossName} (HP: {$hp})";
                    
                case 'SCORE':
                    $points = $data['points'] ?? 0;
                    $reason = $data['reason'] ?? 'ação';
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} ganhou {$points} pontos por {$reason}";
                    
                case 'PLAYER_RESPAWN':
                    $location = $data['location'] ?? 'local desconhecido';
                    $hp = $data['hp'] ?? 100;
                    $playerName = $event->player?->name ?? $event->player_id ?? 'Desconhecido';
                    return "{$playerName} respawn em {$location} com {$hp} HP";
                    
                default:
                    return ucfirst(strtolower(str_replace('_', ' ', $event->event_type)));
            }
        } catch (\Exception $e) {
            return ucfirst(strtolower(str_replace('_', ' ', $event->event_type)));
        }
    }
} 