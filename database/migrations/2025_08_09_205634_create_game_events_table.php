<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('game_events', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp');
            $table->string('category'); // COMBAT, GAME, CHAT, SYSTEM, INFO
            $table->string('event_type'); // BOSS_DEFEAT, QUEST_START, etc.
            $table->string('player_id')->nullable();
            $table->json('event_data'); // Dados específicos do evento
            $table->timestamps();
            
            $table->index(['timestamp', 'category']);
            $table->index(['player_id', 'event_type']);
            $table->index('event_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_events');
    }
};