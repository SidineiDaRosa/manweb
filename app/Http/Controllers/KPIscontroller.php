<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckList;
use App\Models\Equipamento;
use App\Models\CheckListExecutado;
use App\Models\Servicos_executado;
use App\Models\OrdemServico;
use Carbon\Carbon; // Certifique-se de importar a classe Carbon
use Illuminate\Support\Facades\DB;

class KPIscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Calculando a soma das horas de trabalho dos funcionários

        $servicos_executados = Servicos_executado::select(
            'funcionario_id',
            DB::raw('SUM(TIMESTAMPDIFF(SECOND, CONCAT(data_inicio, " ", hora_inicio), CONCAT(data_fim, " ", hora_fim)))/3600 AS total_horas')
        )
            ->where('data_inicio', '>=', Carbon::now()->subDays(90)) // Filtra os serviços dos últimos 30 dias
            ->groupBy('funcionario_id')
            ->OrderBy('total_horas','asc')
            ->get();
        $ordens_servico = OrdemServico::select(
            'equipamento_id',
            DB::raw('SUM(TIMESTAMPDIFF(SECOND, CONCAT(data_inicio, " ", hora_inicio), CONCAT(data_fim, " ", hora_fim)))/3600 AS total_horas')
        )
            ->where('data_inicio', '>=', Carbon::now()->subDays(90)) // Filtra os serviços dos últimos 90 dias
            ->groupBy('equipamento_id')
            ->OrderBy('total_horas','asc')
            ->get();
        // Retorna a view com os dados de serviços executados
        return view('app.KPIs.dashboard', [
            'servicos_executados' => $servicos_executados,
            'ordens_servico' => $ordens_servico
        ]);
    }
}
