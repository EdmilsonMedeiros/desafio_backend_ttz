<?php

namespace App\Jobs;

use App\Models\UploadedFile;
use App\Services\ParseFileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessLogFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; // 5 minutos timeout
    public $tries = 3; // 3 tentativas
    public $backoff = [30, 60, 120]; // Backoff em segundos

    private $uploadedFile;

    /**
     * Create a new job instance.
     */
    public function __construct(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Log::info("Iniciando processamento do arquivo: {$this->uploadedFile->name}");

            // Marcar como processando
            $this->uploadedFile->update(['status' => 'processing']);

            // Processar arquivo
            $parseFileService = new ParseFileService();
            $result = $parseFileService->parseFile($this->uploadedFile->file_path);

            // Log do resultado
            Log::info("Arquivo processado com sucesso", [
                'file_id' => $this->uploadedFile->id,
                'events_processed' => $result['events_processed'],
                'events_skipped' => $result['events_skipped']
            ]);

        } catch (\Exception $e) {
            Log::error("Erro ao processar arquivo: {$e->getMessage()}", [
                'file_id' => $this->uploadedFile->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Marcar como falhou
            $this->uploadedFile->update(['status' => 'failed']);

            // Re-lançar a exceção para que o Laravel saiba que o job falhou
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error("Job de processamento falhou definitivamente", [
            'file_id' => $this->uploadedFile->id,
            'error' => $exception->getMessage()
        ]);

        // Marcar como falhou no banco
        $this->uploadedFile->update(['status' => 'failed']);
    }
}
