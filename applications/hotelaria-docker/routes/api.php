<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuartoController;
use App\Http\Controllers\RegistreController;
use App\Http\Controllers\ReservaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::post('quartos/novo', [QuartoController::class, 'criarQuarto']);
    Route::get('/quartos/disponivel', [QuartoController::class, 'listarDisponiveis']);
    Route::get('/quartos/ocupados', [ReservaController::class, 'OcupadosPorData']);
    Route::post('reservas/nova', [ReservaController::class, 'criarReserva']);
    Route::get('/reservas/{clienteId}', [ReservaController::class, 'reservasDoCliente']);
});



Route::post('/clientes/novo', [RegistreController::class, 'criarCliente']);
Route::post('/login', [AuthController::class, 'auth']);