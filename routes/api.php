<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PassController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas para CLIENTES
    Route::middleware('role:client')->group(function () {
        Route::get('/perfil', [UserController::class, 'showProfile']);
        Route::put('/perfil', [UserController::class, 'updateProfile']);

        Route::get('/mis-bonos', [PassController::class, 'index']);
        Route::post('/comprar-bono', [PassController::class, 'store']);

        Route::get('/mis-sesiones', [BookingController::class, 'index']);
        Route::post('/reservar-sesion', [BookingController::class, 'store']);
    });

    // Rutas para ADMINISTRADORES
    Route::middleware('role:admin')->group(function () {
        Route::get('/clientes', [UserController::class, 'index']);
        Route::get('/clientes/{id}', [UserController::class, 'show']);
        Route::post('/clientes', [UserController::class, 'store']);
        Route::put('/clientes/{id}', [UserController::class, 'update']);
        Route::delete('/clientes/{id}', [UserController::class, 'destroy']);

        Route::get('/bonos', [PassController::class, 'index']);
        Route::post('/bonos', [PassController::class, 'store']);
        Route::get('/bonos/{id}', [PassController::class, 'show']);
        Route::delete('/bonos/{id}', [PassController::class, 'destroy']);

        Route::get('/sesiones', [BookingController::class, 'index']);
        Route::post('/sesiones', [BookingController::class, 'store']);
        Route::get('/sesiones/{id}', [BookingController::class, 'show']);
        Route::delete('/sesiones/{id}', [BookingController::class, 'destroy']);
    });
});
