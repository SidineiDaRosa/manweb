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

Route::post('/solicitacao-os', [SolicitacaoOsController::class, 'store'])->name('solicitacao-os');//Rota que cadstra a solictação

Route::get('/employees', [SolicitacaoOsController::class, 'get_employee']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
