<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Presentation\Http\Controllers\StudentController;

// Ruta de healthcheck para Railway
Route::get('/health', function () {
    try {
        // Verificación básica de la aplicación
        return response()->json([
            'status' => 'ok',
            'message' => 'API is running',
            'timestamp' => now()->toISOString()
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Health check failed: ' . $e->getMessage(),
            'timestamp' => now()->toISOString()
        ], 500);
    }
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('students', StudentController::class);
});
