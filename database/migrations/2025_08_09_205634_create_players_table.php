<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('player_id')->unique(); // p1, p2, etc.
            $table->string('name');
            $table->integer('level')->default(1);
            $table->string('current_zone')->nullable();
            $table->integer('total_score')->default(0);
            $table->integer('total_xp')->default(0);
            $table->integer('total_gold')->default(0);
            $table->integer('deaths')->default(0);
            $table->integer('kills')->default(0);
            $table->integer('bosses_defeated')->default(0);
            $table->integer('quests_completed')->default(0);
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
            
            $table->index('player_id');
            $table->index('total_score');
            $table->index('last_seen');
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
};