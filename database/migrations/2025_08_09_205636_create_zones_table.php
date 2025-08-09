<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('total_visits')->default(0);
            $table->integer('current_players')->default(0);
            $table->timestamps();
            
            $table->index('name');
            $table->index('total_visits');
        });
    }

    public function down()
    {
        Schema::dropIfExists('zones');
    }
};