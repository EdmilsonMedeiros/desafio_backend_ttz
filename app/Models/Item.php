<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_pickups',
        'total_quantity'
    ];

    protected $casts = [
        'total_pickups' => 'integer',
        'total_quantity' => 'integer',
    ];

    // Relacionamentos com eventos
    public function pickupEvents()
    {
        return GameEvent::where('event_type', 'ITEM_PICKUP')
                       ->where('event_data->item', $this->name);
    }

    // Scopes
    public function scopeByPickups($query, $direction = 'desc')
    {
        return $query->orderBy('total_pickups', $direction);
    }

    public function scopeByQuantity($query, $direction = 'desc')
    {
        return $query->orderBy('total_quantity', $direction);
    }

    // Métodos auxiliares
    public function updateStats()
    {
        $events = $this->pickupEvents()->get();
        $this->total_pickups = $events->count();
        $this->total_quantity = $events->sum('event_data.qty');
        $this->save();
    }
} 