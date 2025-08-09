<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_visits',
        'current_players'
    ];

    protected $casts = [
        'total_visits' => 'integer',
        'current_players' => 'integer',
    ];

    // Relacionamentos com eventos
    public function enterEvents()
    {
        return GameEvent::where('event_type', 'ZONE_ENTER')
                       ->where('event_data->zone', $this->name);
    }

    public function exitEvents()
    {
        return GameEvent::where('event_type', 'ZONE_EXIT')
                       ->where('event_data->zone', $this->name);
    }

    // Scopes
    public function scopeByVisits($query, $direction = 'desc')
    {
        return $query->orderBy('total_visits', $direction);
    }

    // Métodos auxiliares
    public function updateStats()
    {
        $this->total_visits = $this->enterEvents()->count();
        $this->current_players = Player::where('current_zone', $this->name)->count();
        $this->save();
    }
} 