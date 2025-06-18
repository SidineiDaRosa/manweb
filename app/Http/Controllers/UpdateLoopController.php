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


        // Retorna o resultado em JSON
        return response()->json(['pendentes' => $count]);
    }
    // ----- Página com o formulário -----
    public function form()
{
    $estado = Cache::get('update_loop_active', false); // pega estado do loop no cache
    return response()->json(['loopAtivo' => $estado]);
}
}
