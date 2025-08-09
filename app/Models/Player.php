<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'name',
        'level',
        'current_zone',
        'total_score',
        'total_xp',
        'total_gold',
        'deaths',
        'kills',
        'bosses_defeated',
        'quests_completed',
        'last_seen'
    ];

    protected $casts = [
        'last_seen' => 'datetime',
        'level' => 'integer',
        'total_score' => 'integer',
        'total_xp' => 'integer',
        'total_gold' => 'integer',
        'deaths' => 'integer',
        'kills' => 'integer',
        'bosses_defeated' => 'integer',
        'quests_completed' => 'integer',
    ];

    // Relacionamentos
    public function gameEvents()
    {
        return $this->hasMany(GameEvent::class, 'player_id', 'player_id');
    }

    public function playerStats()
    {
        return $this->hasMany(PlayerStats::class, 'player_id', 'player_id');
    }

    // Scopes
    public function scopeByScore($query, $direction = 'desc')
    {
        return $query->orderBy('total_score', $direction);
    }

    public function scopeActive($query, $hours = 24)
    {
        return $query->where('last_seen', '>=', now()->subHours($hours));
    }

    // Métodos auxiliares
    public function getKillDeathRatioAttribute()
    {
        return $this->deaths > 0 ? round($this->kills / $this->deaths, 2) : $this->kills;
    }

    public function updateStats()
    {
        // Recalcular estatísticas baseado nos eventos
        $events = $this->gameEvents;
        
        $this->total_score = $events->where('event_type', 'SCORE')->sum('event_data.points');
        $this->total_xp = $events->whereIn('event_type', ['BOSS_DEFEAT', 'QUEST_COMPLETE'])->sum('event_data.xp');
        $this->total_gold = $events->whereIn('event_type', ['BOSS_DEFEAT', 'QUEST_COMPLETE'])->sum('event_data.gold');
        $this->deaths = $events->where('event_type', 'DEATH')->where('event_data.victim_id', $this->player_id)->count();
        $this->kills = $events->where('event_type', 'DEATH')->where('event_data.killer_id', $this->player_id)->count();
        $this->bosses_defeated = $events->where('event_type', 'BOSS_DEFEAT')->where('event_data.defeated_by', $this->player_id)->count();
        $this->quests_completed = $events->where('event_type', 'QUEST_COMPLETE')->count();
        $this->last_seen = $events->max('timestamp');
        
        $this->save();
    }
} 