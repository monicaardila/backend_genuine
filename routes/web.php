<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta de healthcheck para Railway
Route::get('/health', fn() => response('ok', 200));

// Ruta para el middleware de autenticación
Route::get('/login', function () {
    return response()->json(['message' => 'Por favor, inicia sesión'], 401);
})->name('login');
