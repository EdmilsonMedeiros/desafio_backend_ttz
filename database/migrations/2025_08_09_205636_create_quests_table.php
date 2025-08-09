<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('quest_id')->unique(); // q285, q593, etc.
            $table->string('name');
            $table->integer('times_started')->default(0);
            $table->integer('times_completed')->default(0);
            $table->timestamps();
            
            $table->index('quest_id');
            $table->index('times_completed');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quests');
    }
};