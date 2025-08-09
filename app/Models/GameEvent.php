<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'timestamp',
        'category',
        'event_type',
        'player_id',
        'event_data'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'event_data' => 'array'
    ];

    // Relacionamentos
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'player_id');
    }

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByEventType($query, $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeByPlayer($query, $playerId)
    {
        return $query->where('player_id', $playerId);
    }

    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('timestamp', [$startDate, $endDate]);
    }

    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('timestamp', 'desc')->limit($limit);
    }

    // Métodos auxiliares
    public function getEventDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setEventDataAttribute($value)
    {
        $this->attributes['event_data'] = json_encode($value);
    }
} 