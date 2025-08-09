<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bosses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('total_defeats')->default(0);
            $table->integer('total_damage_taken')->default(0);
            $table->integer('times_spawned')->default(0);
            $table->timestamps();
            
            $table->index('name');
            $table->index('total_defeats');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bosses');
    }
};