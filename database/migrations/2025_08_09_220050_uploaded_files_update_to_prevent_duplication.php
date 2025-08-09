<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Atualizar tabela uploaded_files
        Schema::table('uploaded_files', function (Blueprint $table) {
            $table->timestamp('processed_at')->nullable()->after('file_hash');
            $table->integer('events_count')->default(0)->after('processed_at');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending')->after('events_count');
        });

        // Atualizar tabela game_events
        Schema::table('game_events', function (Blueprint $table) {
            $table->unsignedBigInteger('uploaded_file_id')->nullable()->after('event_data');
            $table->string('event_hash', 32)->nullable()->after('uploaded_file_id'); // MD5 hash
            
            $table->foreign('uploaded_file_id')->references('id')->on('uploaded_files');
            $table->index('event_hash'); // Índice para busca rápida
            $table->index(['timestamp', 'event_type']); // Índice composto para verificação de duplicatas
        });
    }

    public function down()
    {
        Schema::table('game_events', function (Blueprint $table) {
            $table->dropForeign(['uploaded_file_id']);
            $table->dropIndex(['timestamp', 'event_type']);
            $table->dropColumn(['uploaded_file_id', 'event_hash']);
        });

        Schema::table('uploaded_files', function (Blueprint $table) {
            $table->dropColumn(['processed_at', 'events_count', 'status']);
        });
    }
};
