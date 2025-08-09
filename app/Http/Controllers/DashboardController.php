<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\GameEvent;
use App\Models\Boss;
use App\Models\Item;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * @group Dashboard
     * GET /dashboard → métricas do dashboard
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam hours int Opcional. Intervalo em horas para as métricas.
     * 
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "time_range": {
     *             "from": "2025-08-09 00:00:00",
     *             "to": "2025-08-09 23:59:59",
     *             "hours": 24
     *         },
     *         "players": {
     *             "total_players": 100,
     *             "active_players": 50,
     *             "new_players": 20,
     *             "activity_rate": 50.00
     *         },
     *         "combat": {
     *             "total_deaths": 100,
     *             "bosses_defeated": 50,
     *             "players_with_most_deaths": [
     *                 {
     *                     "player_id": "p1",
     *                     "player_name": "Jogador 1",
     *                     "death_count": 10
     *                 },
     *                 {
     *                     "player_id": "p2",
     *                     "player_name": "Jogador 2",
     *                     "death_count": 8
     *                 }
     *             ]
     *         },
     *         "economy": {
     *             "total_xp_gained": 10000,
     *             "total_gold_gained": 500,
     *             "avg_xp_per_player": 100,
     *             "avg_gold_per_player": 5
     *         },
     *         "activity": {
     *             "total_events": 1000,
     *             "chat_messages": 500,
     *             "quests_completed": 200,
     *             "avg_events_per_hour": 41.67
     *         },
     *         "items": {
     *             "total_items_picked": 1000,
     *             "total_pickup_events": 500,
     *             "most_collected_items": [
     *                 {
     *                     "item": "Item 1",
     *                     "pickups": 100,
     *                     "total_quantity": 500
     *                 },
     *                 {
     *                     "item": "Item 2",
     *                     "pickups": 80,
     *                     "total_quantity": 400
     *                 }
     *             ]
     *         },
     *         "bosses": {
     *             "total_boss_fights": 100,
     *             "total_boss_defeats": 50,
     *             "bosses_defeated": [
     *                 {
     *                     "boss_name": "Boss 1",
     *                     "defeats": 10
     *                 },
     *                 {
     *                     "boss_name": "Boss 2",
     *                     "defeats": 8
     *                 }
     *             ]
     *         }
     *     }
     * }
     */
    public function index(Request $request)
    {
        $hours = $request->get('hours', 24); // Intervalo em horas
        $dateFrom = now()->subHours($hours);
        $dateTo = now();

        $dashboard = [
            'time_range' => [
                'from' => $dateFrom,
                'to' => $dateTo,
                'hours' => $hours
            ],
            'players' => $this->getPlayerMetrics($dateFrom, $dateTo),
            'combat' => $this->getCombatMetrics($dateFrom, $dateTo),
            'economy' => $this->getEconomyMetrics($dateFrom, $dateTo),
            'activity' => $this->getActivityMetrics($dateFrom, $dateTo),
            'items' => $this->getItemMetrics($dateFrom, $dateTo),
            'bosses' => $this->getBossMetrics($dateFrom, $dateTo),
        ];

        return response()->json([
            'success' => true,
            'data' => $dashboard
        ]);
    }

    private function getPlayerMetrics($dateFrom, $dateTo)
    {
        $activePlayers = Player::where('last_seen', '>=', $dateFrom)->count();
        $totalPlayers = Player::count();
        $newPlayers = GameEvent::where('event_type', 'PLAYER_JOIN')
            ->whereBetween('timestamp', [$dateFrom, $dateTo])
            ->distinct('player_id')
            ->count();

        return [
            'total_players' => $totalPlayers,
            'active_players' => $activePlayers,
            'new_players' => $newPlayers,
            'activity_rate' => $totalPlayers > 0 ? round(($activePlayers / $totalPlayers) * 100, 2) : 0,
        ];
    }

    private function getCombatMetrics($dateFrom, $dateTo)
    {
        $events = GameEvent::whereBetween('timestamp', [$dateFrom, $dateTo]);
        
        $deaths = $events->where('event_type', 'DEATH')->count();
        $bossDefeats = $events->where('event_type', 'BOSS_DEFEAT')->count();
        
        // Jogadores com mais mortes
        $topDeaths = GameEvent::where('event_type', 'DEATH')
            ->whereBetween('timestamp', [$dateFrom, $dateTo])
            ->get()
            ->groupBy('event_data.victim_id')
            ->map->count()
            ->sortDesc()
            ->take(5);

        return [
            'total_deaths' => $deaths,
            'bosses_defeated' => $bossDefeats,
            'players_with_most_deaths' => $topDeaths->map(function($count, $playerId) {
                $player = Player::where('player_id', $playerId)->first();
                return [
                    'player_id' => $playerId,
                    'player_name' => $player?->name,
                    'death_count' => $count,
                ];
            })->values(),
        ];
    }

    private function getEconomyMetrics($dateFrom, $dateTo)
    {
        $events = GameEvent::whereBetween('timestamp', [$dateFrom, $dateTo])
            ->whereIn('event_type', ['BOSS_DEFEAT', 'QUEST_COMPLETE']);

        $totalXp = 0;
        $totalGold = 0;

        foreach ($events->get() as $event) {
            $data = $event->event_data;
            $totalXp += $data['xp'] ?? 0;
            $totalGold += $data['gold'] ?? 0;
        }

        return [
            'total_xp_gained' => $totalXp,
            'total_gold_gained' => $totalGold,
            'avg_xp_per_player' => Player::avg('total_xp'),
            'avg_gold_per_player' => Player::avg('total_gold'),
        ];
    }

    private function getActivityMetrics($dateFrom, $dateTo)
    {
        $events = GameEvent::whereBetween('timestamp', [$dateFrom, $dateTo]);
        
        $totalEvents = $events->count();
        $chatMessages = $events->where('event_type', 'MESSAGE')->count();
        $questsCompleted = $events->where('event_type', 'QUEST_COMPLETE')->count();

        return [
            'total_events' => $totalEvents,
            'chat_messages' => $chatMessages,
            'quests_completed' => $questsCompleted,
            'avg_events_per_hour' => $totalEvents > 0 ? round($totalEvents / 24, 2) : 0,
        ];
    }

    private function getItemMetrics($dateFrom, $dateTo)
    {
        $pickupEvents = GameEvent::where('event_type', 'ITEM_PICKUP')
            ->whereBetween('timestamp', [$dateFrom, $dateTo])
            ->get();

        $topItems = $pickupEvents->groupBy('event_data.item')
            ->map(function($events, $itemName) {
                return [
                    'item' => $itemName,
                    'pickups' => $events->count(),
                    'total_quantity' => $events->sum('event_data.qty'),
                ];
            })
            ->sortByDesc('total_quantity')
            ->take(5)
            ->values();

        return [
            'total_items_picked' => $pickupEvents->sum('event_data.qty'),
            'total_pickup_events' => $pickupEvents->count(),
            'most_collected_items' => $topItems,
        ];
    }

    private function getBossMetrics($dateFrom, $dateTo)
    {
        $bossEvents = GameEvent::whereIn('event_type', ['BOSS_DEFEAT', 'BOSS_FIGHT_START'])
            ->whereBetween('timestamp', [$dateFrom, $dateTo])
            ->get();

        $defeatedBosses = $bossEvents->where('event_type', 'BOSS_DEFEAT')
            ->groupBy('event_data.boss_name')
            ->map->count();

        $spawnedBosses = $bossEvents->where('event_type', 'BOSS_FIGHT_START')
            ->groupBy('event_data.boss_name')
            ->map->count();

        return [
            'total_boss_fights' => $spawnedBosses->sum(),
            'total_boss_defeats' => $defeatedBosses->sum(),
            'bosses_defeated' => $defeatedBosses->map(function($count, $bossName) {
                return [
                    'boss_name' => $bossName,
                    'defeats' => $count,
                ];
            })->values(),
        ];
    }
} 