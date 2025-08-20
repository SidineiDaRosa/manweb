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
        // Retorna a view com os dados de serviços executados

        return view('app.KPIs.index', []);
    }
    public function dashboard(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Lógica para filtrar Servicos_executado
        $servicos_query = Servicos_executado::select(
            'funcionario_id',
            DB::raw('SUM(TIMESTAMPDIFF(SECOND, CONCAT(data_inicio, " ", hora_inicio), CONCAT(data_fim, " ", hora_fim)))/3600 AS total_horas')
        );

        if ($startDate) {
            $servicos_query->where('data_inicio', '>=', $startDate);
        }
        if ($endDate) {
            $servicos_query->where('data_fim', '<=', $endDate);
        }

        // Se nenhuma data for fornecida, mantém o filtro padrão
        if (!$startDate && !$endDate) {
            $servicos_query->where('data_inicio', '>=', Carbon::now()->subDays(30));
        }

        $servicos_executados = $servicos_query->groupBy('funcionario_id')
            ->orderBy('total_horas', 'asc')
            ->get();

        // Lógica para filtrar Ordens de Serviço
        $ordens_query = OrdemServico::select(
            'equipamento_id',
            DB::raw('SUM(TIMESTAMPDIFF(SECOND, CONCAT(data_inicio, " ", hora_inicio), CONCAT(data_fim, " ", hora_fim)))/3600 AS total_horas')
        );

        if ($startDate) {
            $ordens_query->where('data_inicio', '>=', $startDate);
        }
        if ($endDate) {
            $ordens_query->where('data_fim', '<=', $endDate);
        }

        // Se nenhuma data for fornecida, mantém o filtro padrão
        if (!$startDate && !$endDate) {
            $ordens_query->where('data_inicio', '>=', Carbon::now()->subDays(90));
        }

        $ordens_servico = $ordens_query->groupBy('equipamento_id')
            ->orderBy('total_horas', 'asc')
            ->get();

        // Retorna a view com os dados
        return view('app.KPIs.dashboard', [
            'servicos_executados' => $servicos_executados,
            'ordens_servico' => $ordens_servico
        ]);
    }
}
