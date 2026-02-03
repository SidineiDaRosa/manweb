<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\SolicitacaoOsController;

Route::post('/solicitacao-os', [SolicitacaoOsController::class, 'store'])->name('solicitacao-os'); //Rota que cadastra a solictação

Route::get('/employees', [SolicitacaoOsController::class, 'get_employee']); //envia lista de funcionarios para app solictação os
Route::get('/solicitacoes-os-abertas', [SolicitacaoOsController::class, 'cont_request_os_open']); // cont os 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//------------------------------------------------------------//
//
//------------------------------------------------------------//

use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\OrdemServicoController;

Route::post('/update-horimetro', [EquipamentoController::class, 'update_hour_meter']);
Route::get(
    '/notificacao-status-os',
    [OrdemServicoController::class, 'notificacao_status_os']
);
