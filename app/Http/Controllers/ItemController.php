<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\GameEvent;

class ItemController extends Controller
{
    /**
     * @group Items
     * GET /items/top → itens mais coletados
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam limit int Opcional. Número máximo de itens a serem exibidos.
     * 
     * @queryParam sort_by string Opcional. Campo pelo qual a lista será ordenada.
     * 
     * 
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "sorted_by": "total_pickups",
     *         "items": [
     *             {
     *                 "rank": 1,   
     *                 "name": "Item 1",
     *                 "total_pickups": 100,
     *                 "total_quantity": 500,
     *                 "avg_quantity_per_pickup": 5
     *             },
     *             {
     *                 "rank": 2,
     *                 "name": "Item 2",
     *                 "total_pickups": 80,
     *                 "total_quantity": 400,
     *                 "avg_quantity_per_pickup": 5
     *             }
     *         ]
     *     }
     * }
     */
    public function top(Request $request)
    {
        $limit = min($request->get('limit', 20), 100);
        $sortBy = $request->get('sort_by', 'total_pickups'); // total_pickups, total_quantity

        $query = Item::query();

        if ($sortBy === 'total_quantity') {
            $query->orderBy('total_quantity', 'desc');
        } else {
            $query->orderBy('total_pickups', 'desc');
        }

        $items = $query->limit($limit)->get();

        $topItems = $items->map(function($item, $index) {
            return [
                'rank' => $index + 1,
                'name' => $item->name,
                'total_pickups' => $item->total_pickups,
                'total_quantity' => $item->total_quantity,
                'avg_quantity_per_pickup' => $item->total_pickups > 0 ? 
                    round($item->total_quantity / $item->total_pickups, 2) : 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'sorted_by' => $sortBy,
                'items' => $topItems
            ]
        ]);
    }

    /**
     * @group Items
     * GET /items → lista todos os itens com estatísticas
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam search string Opcional. Nome do item a ser buscado.
     * 
     * @queryParam sort_by string Opcional. Campo pelo qual a lista será ordenada.
     * 
     * @queryParam sort_dir string Opcional. Direção da ordenação.
     * 
     * @queryParam per_page int Opcional. Número de itens por página.
     * 
     * @queryParam page int Opcional. Número da página a ser exibida.
     * 
     * 
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "items": [
     *             {
     *                 "name": "Item 1",
     *                 "total_pickups": 100,
     *                 "total_quantity": 500,
     *                 "avg_quantity_per_pickup": 5
     *             },
     *             {
     *                 "name": "Item 2",
     *                 "total_pickups": 80,
     *                 "total_quantity": 400,
     *                 "avg_quantity_per_pickup": 5
     *             }
     *         ],
     *         "pagination": {
     *             "current_page": 1,
     *             "last_page": 1,
     *             "per_page": 20,
     *             "total": 2
     *         }
     *     }
     * }
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // Filtro por nome
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ordenação
        $sortBy = $request->get('sort_by', 'total_pickups');
        $sortDir = $request->get('sort_dir', 'desc');

        if (in_array($sortBy, ['name', 'total_pickups', 'total_quantity'])) {
            $query->orderBy($sortBy, $sortDir);
        }

        $perPage = min($request->get('per_page', 20), 100);
        $items = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $items->items(),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ]
        ]);
    }

    /**
     * @group Items
     * GET /items/:name/stats → estatísticas detalhadas de um item
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam item_name string required O nome do item.
     * 
     * 
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "item_info": {
     *             "name": "Item 1",
     *             "total_pickups": 100,
     *             "total_quantity": 500,
     *             "avg_quantity_per_pickup": 5
     *         },
     *         "top_collectors": [
     *             {
     *                 "player_id": "p1",
     *                 "player_name": "Jogador 1",
     *                 "total_pickups": 100,
     *                 "total_quantity": 500,
     *                 "last_pickup": "2025-08-09T22:48:46.000000Z"
     *             },
     *             {
     *                 "player_id": "p2",
     *                 "player_name": "Jogador 2",
     *                 "total_pickups": 80,
     *                 "total_quantity": 400,
     *                 "last_pickup": "2025-08-09T22:48:46.000000Z"
     *             }
     *         ],
     *         "pickup_locations": [
     *             {
     *                 "location": "Zona 1",
     *                 "total_pickups": 100,
     *                 "total_quantity": 500
     *             },
     *             {
     *                 "location": "Zona 2",
     *                 "total_pickups": 80,
     *                 "total_quantity": 400
     *             }
     *         ],
     *         "recent_pickups": [
     *             {
     *                 "timestamp": "2025-08-09T22:48:46.000000Z",
     *                 "player_id": "p1",
     *                 "player_name": "Jogador 1",
     *                 "quantity": 10,
     *                 "location": "Zona 1"
     *             },
     *             {
     *                 "timestamp": "2025-08-09T22:48:46.000000Z",
     *                 "player_id": "p2",
     *                 "player_name": "Jogador 2",
     *                 "quantity": 5,
     *                 "location": "Zona 2"
     *             }
     *         }
     *     }
     * }
     */
    public function stats($itemName)
    {
        $item = Item::where('name', $itemName)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item não encontrado'
            ], 404);
        }

        // Buscar eventos de pickup deste item
        $pickupEvents = GameEvent::where('event_type', 'ITEM_PICKUP')
            ->where('event_data->item', $itemName)
            ->get();

        // Estatísticas por jogador
        $playerStats = $pickupEvents->groupBy('player_id')->map(function($events, $playerId) {
            $totalQty = $events->sum('event_data.qty');
            $totalPickups = $events->count();
            
            return [
                'player_id' => $playerId,
                'player_name' => $events->first()->player?->name,
                'total_pickups' => $totalPickups,
                'total_quantity' => $totalQty,
                'last_pickup' => $events->max('timestamp'),
            ];
        })->sortByDesc('total_quantity')->take(10)->values();

        // Estatísticas por zona
        $zoneStats = $pickupEvents->groupBy('event_data.location')->map(function($events, $location) {
            return [
                'location' => $location,
                'total_pickups' => $events->count(),
                'total_quantity' => $events->sum('event_data.qty'),
            ];
        })->sortByDesc('total_quantity')->take(5)->values();

        $stats = [
            'item_info' => [
                'name' => $item->name,
                'total_pickups' => $item->total_pickups,
                'total_quantity' => $item->total_quantity,
                'avg_quantity_per_pickup' => $item->total_pickups > 0 ? 
                    round($item->total_quantity / $item->total_pickups, 2) : 0,
            ],
            'top_collectors' => $playerStats,
            'pickup_locations' => $zoneStats,
            'recent_pickups' => $pickupEvents->sortByDesc('timestamp')->take(10)->map(function($event) {
                return [
                    'timestamp' => $event->timestamp,
                    'player_id' => $event->player_id,
                    'player_name' => $event->player?->name,
                    'quantity' => $event->event_data['qty'],
                    'location' => $event->event_data['location'] ?? null,
                ];
            })->values(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}