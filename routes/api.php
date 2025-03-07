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

    // Perfil del usuario autenticado
    Route::prefix('perfil')->group(function () {
        Route::get('/', [UserController::class, 'showProfile']);
        Route::put('/', [UserController::class, 'updateProfile']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas para CLIENTES
    Route::middleware('role:client')->group(function () {
        Route::get('/mis-bonos', [PassController::class, 'getUserPasses']);
        Route::post('/adquirir-bono', [PassController::class, 'store']);
        Route::delete('/bonos/{id}', [PassController::class, 'destroy']);

        Route::get('/mis-sesiones', [BookingController::class, 'getUserBookings']);
        Route::post('/reservar-sesion', [BookingController::class, 'store']);
        Route::delete('/sesiones/{id}', [BookingController::class, 'destroy']);
    });

    // Rutas para ADMINISTRADORES
    Route::middleware('role:admin')->group(function () {
        Route::prefix('clientes')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
        });

        Route::prefix('clientes')->group(function () {
            Route::get('/', [UserController::class, 'show']);
            Route::put('/', [UserController::class, 'update']);
            Route::delete('/', [UserController::class, 'destroy']);
            Route::get('/bonos', [PassController::class, 'getUserPassesAdmin']);
            Route::get('/sesiones', [BookingController::class, 'getUserBookingsAdmin']);
        });

        Route::prefix('bonos')->group(function () {
            Route::get('/', [PassController::class, 'index']);
            Route::post('/', [PassController::class, 'store']);
            Route::delete('/{id}', [PassController::class, 'destroy']);
        });

        Route::prefix('sesiones')->group(function () {
            Route::get('/', [BookingController::class, 'index']);
            Route::post('/', [BookingController::class, 'store']);
            Route::delete('/{id}', [BookingController::class, 'destroy']);
        });
    });
});
