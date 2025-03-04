<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\BonoController;
use App\Http\Controllers\SesionController;

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
        Route::get('/perfil', [ClienteController::class, 'showProfile']);
        Route::put('/perfil', [ClienteController::class, 'updateProfile']);

        Route::get('/mis-bonos', [BonoController::class, 'index']);
        Route::post('/comprar-bono', [BonoController::class, 'store']);

        Route::get('/mis-sesiones', [SesionController::class, 'index']);
        Route::post('/reservar-sesion', [SesionController::class, 'store']);
    });

    // Rutas para ADMINISTRADORES
    Route::middleware('role:admin')->group(function () {
        Route::get('/clientes', [ClienteController::class, 'index']);
        Route::get('/clientes/{id}', [ClienteController::class, 'show']);
        Route::post('/clientes', [ClienteController::class, 'store']);
        Route::put('/clientes/{id}', [ClienteController::class, 'update']);
        Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

        Route::get('/bonos', [BonoController::class, 'index']);
        Route::post('/bonos', [BonoController::class, 'store']);
        Route::get('/bonos/{id}', [BonoController::class, 'show']);
        Route::delete('/bonos/{id}', [BonoController::class, 'destroy']);

        Route::get('/sesiones', [SesionController::class, 'index']);
        Route::post('/sesiones', [SesionController::class, 'store']);
        Route::get('/sesiones/{id}', [SesionController::class, 'show']);
        Route::delete('/sesiones/{id}', [SesionController::class, 'destroy']);
    });
});
