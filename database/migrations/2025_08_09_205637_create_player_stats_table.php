<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->string('player_id');
            $table->date('date');
            $table->integer('score_gained')->default(0);
            $table->integer('xp_gained')->default(0);
            $table->integer('gold_gained')->default(0);
            $table->integer('deaths_count')->default(0);
            $table->integer('kills_count')->default(0);
            $table->integer('bosses_defeated_count')->default(0);
            $table->integer('quests_completed_count')->default(0);
            $table->integer('items_picked_count')->default(0);
            $table->integer('messages_sent')->default(0);
            $table->timestamps();
            
            $table->unique(['player_id', 'date']);
            $table->index('date');
            $table->index(['player_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('player_stats');
    }
};