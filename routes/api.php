<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Presentation\Http\Controllers\StudentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('students', StudentController::class);
});
