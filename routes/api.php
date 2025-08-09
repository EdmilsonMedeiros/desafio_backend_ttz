<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rotas protegidas por autenticação
Route::middleware('auth:sanctum')->group(function () {
    // ROTAS DE UPLOAD
    Route::post('/upload', [UploadController::class, 'upload']);
    Route::get('/upload/{uploadedFileId}/status', [UploadController::class, 'status']);
    Route::get('/uploads', [UploadController::class, 'index']);
    
    // REQUISITOS OBRIGATÓRIOS
    Route::get('/players', [PlayerController::class, 'index']);
    Route::get('/players/{playerId}/stats', [PlayerController::class, 'stats']);
    Route::get('/leaderboard', [PlayerController::class, 'leaderboard']);
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/items/top', [ItemController::class, 'top']);
    
    // ENDPOINTS EXTRAS
    Route::get('/events/summary', [EventController::class, 'summary']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{itemName}/stats', [ItemController::class, 'stats']);
    
    // DESAFIO EXTRA
    Route::get('/dashboard', [DashboardController::class, 'index']);
});


require __DIR__ . '/auth.php';
