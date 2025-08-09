<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('total_pickups')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->timestamps();
            
            $table->index('name');
            $table->index('total_pickups');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};