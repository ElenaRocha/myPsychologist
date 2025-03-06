<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PassController;
use App\Http\Controllers\BookingController;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/perfil', [AuthController::class, 'user']);
    Route::put('/perfil', [UserController::class, 'update']);

    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas para CLIENTES
    Route::middleware('role:client')->group(function () {
        Route::get('/mis-bonos', [PassController::class, 'getUserPasses']); // Sigue mostrando los pases con sesiones restantes
        Route::post('/comprar-bono', [PassController::class, 'store']);
    
        Route::get('/mis-sesiones', [BookingController::class, 'getUserBookings']); // NUEVA ruta para mostrar todas las reservas juntas
        Route::post('/reservar-sesion', [BookingController::class, 'store']);
    });

    // Rutas para ADMINISTRADORES
    Route::middleware('role:admin')->group(function () {
        Route::get('/clientes', [UserController::class, 'index']);
        Route::post('/clientes', [UserController::class, 'store']);
        Route::get('/clientes/{id}', [UserController::class, 'show']);
        Route::put('/clientes/{id}', [UserController::class, 'update']);
        Route::delete('/clientes/{id}', [UserController::class, 'destroy']);
        Route::get('/clientes/{id}/bonos', [PassController::class, 'getUserPassesAdmin']);
        Route::get('/clientes/{id}/reservas', [BookingController::class, 'getUserBookingsAdmin']);

        Route::get('/bonos', [PassController::class, 'index']);
        Route::post('/bonos', [PassController::class, 'store']);
        Route::delete('/bonos/{id}', [PassController::class, 'destroy']);

        Route::get('/sesiones', [BookingController::class, 'index']);
        Route::post('/sesiones', [BookingController::class, 'store']);
        Route::get('/sesiones/{id}', [BookingController::class, 'show']);
        Route::delete('/sesiones/{id}', [BookingController::class, 'destroy']);
    });
});
