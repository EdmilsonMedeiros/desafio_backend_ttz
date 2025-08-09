<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'name',
        'times_started',
        'times_completed'
    ];

    protected $casts = [
        'times_started' => 'integer',
        'times_completed' => 'integer',
    ];

    // Relacionamentos com eventos
    public function startEvents()
    {
        return GameEvent::where('event_type', 'QUEST_START')
                       ->where('event_data->quest_id', $this->quest_id);
    }

    public function completeEvents()
    {
        return GameEvent::where('event_type', 'QUEST_COMPLETE')
                       ->where('event_data->quest_id', $this->quest_id);
    }

    // Scopes
    public function scopeByCompletions($query, $direction = 'desc')
    {
        return $query->orderBy('times_completed', $direction);
    }

    // Métodos auxiliares
    public function getCompletionRateAttribute()
    {
        return $this->times_started > 0 ? 
               round(($this->times_completed / $this->times_started) * 100, 2) : 0;
    }

    public function updateStats()
    {
        $this->times_started = $this->startEvents()->count();
        $this->times_completed = $this->completeEvents()->count();
        $this->save();
    }
} 