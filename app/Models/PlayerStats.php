<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerStats extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'date',
        'score_gained',
        'xp_gained',
        'gold_gained',
        'deaths_count',
        'kills_count',
        'bosses_defeated_count',
        'quests_completed_count',
        'items_picked_count',
        'messages_sent'
    ];

    protected $casts = [
        'date' => 'date',
        'score_gained' => 'integer',
        'xp_gained' => 'integer',
        'gold_gained' => 'integer',
        'deaths_count' => 'integer',
        'kills_count' => 'integer',
        'bosses_defeated_count' => 'integer',
        'quests_completed_count' => 'integer',
        'items_picked_count' => 'integer',
        'messages_sent' => 'integer',
    ];

    // Relacionamentos
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'player_id');
    }

    // Scopes
    public function scopeByDate($query, $date)
    {
        return $query->where('date', $date);
    }

    public function scopeByPlayer($query, $playerId)
    {
        return $query->where('player_id', $playerId);
    }

    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
} 