<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadedFile;
use App\Jobs\ProcessLogFileJob;

class UploadController extends Controller
{
    /**
     * @group Upload
     * POST Enviar arquivo para processamento
     * 
     * @header Authorization Bearer {token}
     * 
     * @bodyParam file file required O arquivo de log a ser processado.
     * 
     * @response 200 {
	 *    "success": true,
	 *    "message": "Arquivo já foi processado anteriormente",
	 *    "data": {
	 *    "path": "uploaded_logs/KSX43oS0NKfmtgfVqjVx5ybaarcbxr8veFOZUaPq.txt",
	 *    "filename": "game_log_reduzido.txt",
	 *    "uploaded_file_id": 3,
	 *    "events_processed": 0,
	 *    "events_skipped": 0,
	 *    "duplicate_file": true,
	 *    "status": "completed"
	 *    }
	 * }
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('uploaded_logs', 'public');
            $fileHash = hash('sha256', $file->get());

            // Verificar se o arquivo já foi processado
            $existingFile = UploadedFile::where('file_hash', $fileHash)
                ->where('status', 'completed')
                ->first();

            if ($existingFile) {
                return response()->json([
                    'success' => true,
                    'message' => 'Arquivo já foi processado anteriormente',
                    'data' => [
                        'path' => $path,
                        'filename' => $file->getClientOriginalName(),
                        'uploaded_file_id' => $existingFile->id,
                        'events_processed' => $existingFile->events_count,
                        'events_skipped' => 0,
                        'duplicate_file' => true,
                        'status' => 'completed'
                    ]
                ]);
            }

            // Criar registro do upload
            $uploadedFile = UploadedFile::create([
                'file_path' => $path,
                'name' => $file->getClientOriginalName(),
                'file_hash' => $fileHash,
                'status' => 'pending'
            ]);

            // Despachar job para processamento em background
            ProcessLogFileJob::dispatch($uploadedFile);
            
            return response()->json([
                'success' => true,
                'message' => 'Arquivo enviado com sucesso e está sendo processado em background',
                'data' => [
                    'path' => $path,
                    'filename' => $file->getClientOriginalName(),
                    'uploaded_file_id' => $uploadedFile->id,
                    'status' => 'pending',
                    'processing_started' => true
                ]
            ]);
            
        } catch(\Exception $e) {  
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar o arquivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Upload
     * GET Verificar status do processamento de um arquivo
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam uploadedFileId int required O ID do arquivo de upload.
     * 
     * @response 200 {
	 * "success": true,
	 *      "data": {
	 *          "id": 3,
	 *          "filename": "game_log_reduzido.txt",
	 *          "status": "completed",
	 *          "events_count": 0,
	 *          "created_at": "2025-08-09T22:51:40.000000Z",
	 *          "processed_at": "2025-08-09 22:51:45",
	 *          "processing_time": "5 seconds before"
	 *      },
	 * "message": "Arquivo processado com sucesso"
	 * }
     */
    public function status($uploadedFileId)
    {
        $uploadedFile = UploadedFile::find($uploadedFileId);

        if (!$uploadedFile) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo não encontrado'
            ], 404);
        }

        $response = [
            'success' => true,
            'data' => [
                'id' => $uploadedFile->id,
                'filename' => $uploadedFile->name,
                'status' => $uploadedFile->status,
                'events_count' => $uploadedFile->events_count,
                'created_at' => $uploadedFile->created_at,
                'processed_at' => $uploadedFile->processed_at,
            ]
        ];

        // Adicionar informações específicas baseadas no status
        switch ($uploadedFile->status) {
            case 'pending':
                $response['message'] = 'Arquivo aguardando processamento';
                break;
            case 'processing':
                $response['message'] = 'Arquivo sendo processado';
                break;
            case 'completed':
                $response['message'] = 'Arquivo processado com sucesso';
                $response['data']['processing_time'] = $uploadedFile->created_at->diffForHumans($uploadedFile->processed_at);
                break;
            case 'failed':
                $response['message'] = 'Falha no processamento do arquivo';
                break;
        }

        return response()->json($response);
    }

    /**
     * @group Upload
     * GET Listar uploads com seus status
     * 
     * @header Authorization Bearer {token}
     * 
     * @queryParam per_page int Opcional. Número de uploads por página.
     * 
     * @queryParam page int Opcional. Número da página a ser exibida.
     * 
     * 
     * @response 200 {
     *     "success": true,
     *     "data": [
     *         {
     *             "id": 1,
     *             "filename": "game_log_reduzido.txt",
     *             "status": "completed",
     *             "created_at": "2023-01-01 12:00:00",
     *             "processed_at": "2023-01-01 12:05:00"
     *         }
     *     ]
     * }
     */
    public function index(Request $request)
    {
        $query = UploadedFile::orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = min($request->get('per_page', 20), 100);
        $uploads = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $uploads->items(),
            'pagination' => [
                'current_page' => $uploads->currentPage(),
                'last_page' => $uploads->lastPage(),
                'per_page' => $uploads->perPage(),
                'total' => $uploads->total(),
            ]
        ]);
    }
}
