<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ExameController;
use App\Http\Controllers\PacoteController;
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

Route::apiResource('exames', ExameController::class);
Route::apiResource('pacotes', PacoteController::class);


Route::get('/examesAvulsos', [ExameController::class, 'examesAvulsos']);


// Relacionamento: Associar exame a pacote
Route::post('/pacotes/remove-exame', [PacoteController::class, 'removePacoteExame']);
Route::post('/pacotes/{pacote}/attach-exame', [PacoteController::class, 'attachExame']);
Route::post('/storePacoteExameAvulso', [PacoteController::class, 'storePacoteExameAvulso']);


Route::post('/pacotes/{pacote}', [PacoteController::class, 'show']);

Route::get('/printpacote/{id}', [PacoteController::class, 'printPacote']);

