<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boss extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_defeats',
        'total_damage_taken',
        'times_spawned'
    ];

    protected $casts = [
        'total_defeats' => 'integer',
        'total_damage_taken' => 'integer',
        'times_spawned' => 'integer',
    ];

    // Relacionamentos com eventos
    public function defeatEvents()
    {
        return GameEvent::where('event_type', 'BOSS_DEFEAT')
                       ->where('event_data->boss_name', $this->name);
    }

    public function damageEvents()
    {
        return GameEvent::where('event_type', 'BOSS_DAMAGE')
                       ->where('event_data->boss_name', $this->name);
    }

    public function fightStartEvents()
    {
        return GameEvent::where('event_type', 'BOSS_FIGHT_START')
                       ->where('event_data->boss_name', $this->name);
    }

    // Scopes
    public function scopeByDefeats($query, $direction = 'desc')
    {
        return $query->orderBy('total_defeats', $direction);
    }

    // Métodos auxiliares
    public function updateStats()
    {
        $this->total_defeats = $this->defeatEvents()->count();
        $this->total_damage_taken = $this->damageEvents()->sum('event_data->damage');
        $this->times_spawned = $this->fightStartEvents()->count();
        $this->save();
    }
} 