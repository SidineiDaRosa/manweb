<?php

namespace App\Http\Controllers;

use App\Models\PecasEquipamentos;
use App\Models\Equipamento;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class UpdateLoopController extends Controller
{
    public function ativar()
    {
        Cache::put('update_loop_active', true);
        return redirect()->back()->with('success', 'Loop ativado!');
    }

    public function desativar()
    {
        Cache::put('update_loop_active', false);
        return redirect()->back()->with('success', 'Loop desativado!');
    }
    public function alarms_count()
    {

        // Passo 1: Buscar todos os registros com status 'Ativado'
        $componentes = PecasEquipamentos::where('status', 'Ativado')
            ->where('criticidade', '!=', 'baixa')
            ->get();

        $count = 0; // Contador de manutenções vencidas ou pendentes
        $agora = Carbon::now();
        $count  = PecasEquipamentos::where('status', 'Ativado')
            ->where('criticidade', '!=', 'baixa')
            ->where('horas_proxima_manutencao','<=',0)
            ->count();

        // Passo 2: Percorrer cada componente
        //foreach ($componentes as $componente) {
        // if ($componente->data_proxima_manutencao && $componente->horas_proxima_manutencao) {
        // Calcular a data/hora da próxima manutenção
        // $dataProxima = Carbon::parse($componente->data_proxima_manutencao);
        // $horasProxima = (int)$componente->horas_proxima_manutencao;

        // $proximaManutencao = $dataProxima->copy()->addHours($horasProxima);

        // Calcular a diferença em horas
        //$diferencaHoras = $agora->diffInHours($proximaManutencao, false); // negativo se já venceu

        //if ($diferencaHoras < 0) {
        //$count++; // Incrementa se a manutenção está vencida
        //}
        //}
        // }

        // Retorna o resultado em JSON
        return response()->json(['pendentes' => $count]);
    }
}
