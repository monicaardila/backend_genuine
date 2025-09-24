<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Presentation\Http\Controllers\StudentController;

// Ruta de healthcheck para Railway
Route::get('/health', function () {
    try {
        // Verificar que la base de datos esté conectada
        \DB::connection()->getPdo();
        
        // Verificar que existe al menos un usuario
        $userCount = \App\Models\User::count();
        
        if ($userCount === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No users found in database',
                'timestamp' => now()->toISOString()
            ], 500);
        }
        
        // Intentar hacer login con usuario de prueba
        $testUser = \App\Models\User::first();
        if (!$testUser) {
            return response()->json([
                'status' => 'error',
                'message' => 'No test user found',
                'timestamp' => now()->toISOString()
            ], 500);
        }
        
        // Verificar que JWT funciona
        $token = \Auth::login($testUser);
        
        return response()->json([
            'status' => 'ok',
            'message' => 'API is running and authenticated',
            'database' => 'connected',
            'users_count' => $userCount,
            'jwt_working' => !empty($token),
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
