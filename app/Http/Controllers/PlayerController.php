<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameEvent;

class PlayerController extends Controller
{
    /**
     * @group Players
     * GET /players → lista de jogadores com dados básicos
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam level_min int Opcional. Nível mínimo dos jogadores a serem listados.
     * 
     * @queryParam level_max int Opcional. Nível máximo dos jogadores a serem listados.
     * 
     * @queryParam zone string Opcional. Zona a ser filtrada.
     * 
     * @queryParam sort_by string Opcional. Campo pelo qual a lista será ordenada.
     * 
     * @queryParam sort_dir string Opcional. Direção da ordenação.
     * 
     * @queryParam per_page int Opcional. Número de jogadores por página.
     * 
     * @queryParam page int Opcional. Número da página a ser exibida.
     * 
     * 
     * @response 200 {
	 *     "success": true,
	 *     "data": [
	 *         {
	 *             "id": 1,
	 *             "player_id": "p2",
	 *             "name": "\"Quest",
	 *             "level": 25,
	 *             "current_zone": "AncientRuins",
	 *             "total_score": 0,
	 *             "total_xp": 0,
	 *             "total_gold": 0,
	 *             "deaths": 0,
	 *             "kills": 0,
	 *             "bosses_defeated": 0,
	 *             "quests_completed": 0,
	 *             "last_seen": "2025-08-09T22:48:46.000000Z",
	 *             "created_at": "2025-08-09T22:48:39.000000Z",
	 *             "updated_at": "2025-08-09T22:48:46.000000Z"
	 *         }
	 *     ]
	 * }
     * 
     */
    public function index(Request $request)
    {
        $query = Player::query();

        // Filtros opcionais
        if ($request->has('level_min')) {
            $query->where('level', '>=', $request->level_min);
        }

        if ($request->has('level_max')) {
            $query->where('level', '<=', $request->level_max);
        }

        if ($request->has('zone')) {
            $query->where('current_zone', $request->zone);
        }

        // Ordenação
        $sortBy = $request->get('sort_by', 'total_score');
        $sortDir = $request->get('sort_dir', 'desc');
        
        if (in_array($sortBy, ['total_score', 'level', 'total_xp', 'total_gold', 'last_seen'])) {
            $query->orderBy($sortBy, $sortDir);
        }

        // Paginação
        $perPage = min($request->get('per_page', 20), 100);
        $players = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $players->items(),
            'pagination' => [
                'current_page' => $players->currentPage(),
                'last_page' => $players->lastPage(),
                'per_page' => $players->perPage(),
                'total' => $players->total(),
            ]
        ]);
    }

    /**
     * @group Players
     * GET /players/:id/stats → estatísticas de um jogador
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam player_id string required O ID do jogador.
     * 
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "player_info": {
     *             "player_id": "p2",
     *             "name": "\"Quest",
     *             "level": 25,
     *             "current_zone": "AncientRuins",
     *             "total_score": 0,
     *             "total_xp": 0,
     *             "total_gold": 0,
     *             "deaths": 0,
     *             "kills": 0,
     *             "bosses_defeated": 0,
     *             "quests_completed": 0,
     *             "last_seen": "2025-08-09T22:48:46.000000Z",
     *             "created_at": "2025-08-09T22:48:39.000000Z",
     *             "updated_at": "2025-08-09T22:48:46.000000Z"
     *         },
     *         "combat_stats": {
     *             "total_score": 0,
     *             "kills": 0,
     *             "deaths": 0,
     *             "kd_ratio": 0,
     *             "bosses_defeated": 0
     *         },
     *         "progression_stats": {
     *             "total_xp": 0,
     *             "total_gold": 0,
     *             "quests_completed": 0
     *         },
     *         "activity_stats": {
     *             "total_events": 0,
     *             "chat_messages": 0,
     *             "items_collected": 0,
     *             "zones_visited": 0
     *         },
     *         "recent_activity": [
     *             {
     *                 "timestamp": "2025-08-09T22:48:46.000000Z",
     *                 "category": "combat",
     *                 "event_type": "BOSS_DEFEAT",
     *                 "description": "Derrotou Boss e ganhou 0 XP e 0 gold"
     *             }
     *         ]
     *     }
     * }
     */
    public function stats($playerId)
    {
        $player = Player::where('player_id', $playerId)->first();

        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'Jogador não encontrado'
            ], 404);
        }

        // Buscar eventos do jogador
        $events = GameEvent::where('player_id', $playerId)->get();

        // Calcular estatísticas detalhadas
        $stats = [
            'player_info' => [
                'player_id' => $player->player_id,
                'name' => $player->name,
                'level' => $player->level,
                'current_zone' => $player->current_zone,
                'last_seen' => $player->last_seen,
            ],
            'combat_stats' => [
                'total_score' => $player->total_score,
                'kills' => $player->kills,
                'deaths' => $player->deaths,
                'kd_ratio' => $player->kill_death_ratio,
                'bosses_defeated' => $player->bosses_defeated,
            ],
            'progression_stats' => [
                'total_xp' => $player->total_xp,
                'total_gold' => $player->total_gold,
                'quests_completed' => $player->quests_completed,
            ],
            'activity_stats' => [
                'total_events' => $events->count(),
                'chat_messages' => $events->where('event_type', 'MESSAGE')->count(),
                'items_collected' => $events->where('event_type', 'ITEM_PICKUP')->count(),
                'zones_visited' => $events->whereIn('event_type', ['ZONE_ENTER'])->pluck('event_data.zone')->filter()->unique()->count(),
            ],
            'recent_activity' => $events->sortByDesc('timestamp')->take(10)->map(function($event) {
                return [
                    'timestamp' => $event->timestamp,
                    'category' => $event->category,
                    'event_type' => $event->event_type,
                    'description' => $this->formatEventDescription($event),
                ];
            })->values(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * @group Players
     * GET /leaderboard → ranking de jogadores por pontuação
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam type string Opcional. Tipo de ranking a ser exibido.
     * 
     * @queryParam limit int Opcional. Número máximo de jogadores a serem exibidos.
     * 
     * 
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "type": "score",
     *         "leaderboard": [
     *             {
     *                 "rank": 1,
     *                 "player_id": "p1",
     *                 "name": "Jogador 1",
     *                 "level": 30,
     *                 "value": 1500,
     *                 "last_seen": "2025-08-09T22:48:46.000000Z"
     *             },
     *             {
     *                 "rank": 2,
     *                 "player_id": "p2",
     *                 "name": "Jogador 2",
     *                 "level": 28,
     *                 "value": 1200,
     *                 "last_seen": "2025-08-09T22:48:46.000000Z"
     *             }
     *         ]
     *     }
     * }
     */
    public function leaderboard(Request $request)
    {
        $type = $request->get('type', 'score'); // score, xp, gold, kills, bosses
        $limit = min($request->get('limit', 10), 100);

        $query = Player::query();

        switch ($type) {
            case 'xp':
                $query->orderBy('total_xp', 'desc');
                break;
            case 'gold':
                $query->orderBy('total_gold', 'desc');
                break;
            case 'kills':
                $query->orderBy('kills', 'desc');
                break;
            case 'bosses':
                $query->orderBy('bosses_defeated', 'desc');
                break;
            case 'score':
            default:
                $query->orderBy('total_score', 'desc');
                break;
        }

        $players = $query->limit($limit)->get();

        $leaderboard = $players->map(function($player, $index) use ($type) {
            return [
                'rank' => $index + 1,
                'player_id' => $player->player_id,
                'name' => $player->name,
                'level' => $player->level,
                'value' => $this->getLeaderboardValue($player, $type),
                'last_seen' => $player->last_seen,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'type' => $type,
                'leaderboard' => $leaderboard
            ]
        ]);
    }

    private function formatEventDescription($event)
    {
        $data = $event->event_data ?? [];
        
        try {
            switch ($event->event_type) {
                case 'BOSS_DEFEAT':
                    $bossName = $data['boss_name'] ?? 'Boss desconhecido';
                    $xp = $data['xp'] ?? 0;
                    $gold = $data['gold'] ?? 0;
                    return "Derrotou {$bossName} e ganhou {$xp} XP e {$gold} gold";
                    
                case 'QUEST_COMPLETE':
                    $questName = $data['name'] ?? $data['quest_id'] ?? 'Quest desconhecida';
                    $xp = $data['xp'] ?? 0;
                    $gold = $data['gold'] ?? 0;
                    return "Completou {$questName} e ganhou {$xp} XP e {$gold} gold";
                    
                case 'QUEST_START':
                    $questName = $data['name'] ?? $data['quest_id'] ?? 'Quest desconhecida';
                    return "Iniciou {$questName}";
                    
                case 'ITEM_PICKUP':
                    $item = $data['item'] ?? 'item desconhecido';
                    $qty = $data['qty'] ?? 1;
                    return "Coletou {$qty}x {$item}";
                    
                case 'DEATH':
                    $killer = $data['killer_id'] ?? 'desconhecido';
                    $method = $data['method'] ?? 'método desconhecido';
                    return "Foi morto por {$killer} com {$method}";
                    
                case 'ZONE_ENTER':
                    $zone = $data['zone'] ?? 'zona desconhecida';
                    return "Entrou em {$zone}";
                    
                case 'ZONE_EXIT':
                    $zone = $data['zone'] ?? 'zona desconhecida';
                    return "Saiu de {$zone}";
                    
                case 'MESSAGE':
                    $message = $data['message'] ?? '';
                    return "Disse: \"{$message}\"";
                    
                case 'PLAYER_JOIN':
                    $name = $data['name'] ?? $event->player_id ?? 'Jogador';
                    $level = $data['level'] ?? 1;
                    $zone = $data['zone'] ?? 'local desconhecido';
                    return "{$name} (nível {$level}) entrou no jogo em {$zone}";
                    
                case 'PLAYER_RESPAWN':
                    $location = $data['location'] ?? 'local desconhecido';
                    $hp = $data['hp'] ?? 100;
                    return "Respawn em {$location} com {$hp} HP";
                    
                case 'BOSS_DAMAGE':
                    $bossName = $data['boss_name'] ?? 'Boss';
                    $damage = $data['damage'] ?? 0;
                    return "Causou {$damage} de dano em {$bossName}";
                    
                case 'BOSS_FIGHT_START':
                    $bossName = $data['boss_name'] ?? 'Boss';
                    $hp = $data['hp'] ?? 0;
                    return "Iniciou luta contra {$bossName} (HP: {$hp})";
                    
                case 'SCORE':
                    $points = $data['points'] ?? 0;
                    $reason = $data['reason'] ?? 'ação';
                    return "Ganhou {$points} pontos por {$reason}";
                    
                default:
                    return ucfirst(strtolower(str_replace('_', ' ', $event->event_type)));
            }
        } catch (\Exception $e) {
            return ucfirst(strtolower(str_replace('_', ' ', $event->event_type)));
        }
    }

    private function getLeaderboardValue($player, $type)
    {
        switch ($type) {
            case 'xp': return $player->total_xp;
            case 'gold': return $player->total_gold;
            case 'kills': return $player->kills;
            case 'bosses': return $player->bosses_defeated;
            case 'score':
            default: return $player->total_score;
        }
    }
} 