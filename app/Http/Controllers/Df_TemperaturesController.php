<?php

namespace App\Http\Controllers;

use App\Models\df_temperatures; // <-- Importa o seu Model aqui
use Illuminate\Http\Request;

class Df_TemperaturesController extends Controller
{
    /**
     * Recebe os dados de telemetria do ESP32 via HTTP POST
     */
    public function store(Request $request)
    {
        // 1. Captura todo o JSON enviado pelo ESP32
        $dados = $request->json()->all();

        // 2. Valida se o corpo da requisição não veio vazio
        if (empty($dados)) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Nenhum dado ou JSON inválido recebido.'
            ], 400);
        }

        // 3. Percorre o JSON
        foreach ($dados as $equipamento => $temperatura) {

            // Se passar de 200, grava 200
            $temperatura = min((int)$temperatura, 200);

            df_temperatures::create([
                'equipamento' => $equipamento,
                'temperatura' => $temperatura
            ]);
        }

        // 4. Retorna resposta de sucesso
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Leituras gravadas com sucesso!'
        ], 201);
    }
    public function index(Request $request)
{
    $query = df_temperatures::query();

    // Se informou data inicial
    if ($request->filled('data_inicio')) {
        $query->where('data_hora', '>=', $request->data_inicio);
    }

    // Se informou data final
    if ($request->filled('data_fim')) {
        $query->where('data_hora', '<=', $request->data_fim);
    }

    // Define o limite dinamicamente baseado na presença dos filtros
    if ($request->filled('data_inicio') || $request->filled('data_fim')) {
        // Se definiu alguma data, pega os últimos 5000 mais recentes do período
        $df_temperatures = $query
            ->orderBy('data_hora', 'desc')
            ->take(5000)
            ->get()
            ->reverse(); // Inverte para ordem cronológica
    } else {
        // Se não definiu nada, pega os últimos 2000 mais recentes
        $df_temperatures = $query
            ->orderBy('data_hora', 'desc')
            ->take(2000)
            ->get()
            ->reverse(); // Inverte para ordem cronológica
    }

    // =========================================================================
    // CORREÇÃO: ORGANIZANDO OS DADOS POR DATA ANTES DE ENVIAR PARA A VIEW
    // =========================================================================
    
    if ($df_temperatures->isEmpty()) {
        return view('app.df_temperature.index', [
            'labels' => [], 'ponto1' => [], 'ponto2' => [], 'ponto3' => [], 'df_temperatures' => collect()
        ]);
    }

    // 1. Identifica todos os horários únicos gravados no banco para criar a linha do tempo mestre
    $horariosUnicos = $df_temperatures->pluck('data_hora')->unique()->sort()->values();

    // 2. Agrupa os registros por equipamento e indexa pela data_hora para busca rápida por chave
    $dadosAgrupados = $df_temperatures->groupBy('equipamento')->map(function ($itens) {
        return $itens->keyBy('data_hora');
    });

    $ponto1 = [];
    $ponto2 = [];
    $ponto3 = [];
    $labels = [];

    // 3. Alinha os dados preenchendo as falhas com null
    foreach ($horariosUnicos as $dh) {
        // Garante que o índice X de todos os arrays corresponda exatamente ao mesmo momento ($dh)
        $ponto1[] = isset($dadosAgrupados['ponto_1'][$dh]) ? (float)$dadosAgrupados['ponto_1'][$dh]->temperatura : null;
        $ponto2[] = isset($dadosAgrupados['ponto_2'][$dh]) ? (float)$dadosAgrupados['ponto_2'][$dh]->temperatura : null;
        $ponto3[] = isset($dadosAgrupados['ponto_3'][$dh]) ? (float)$dadosAgrupados['ponto_3'][$dh]->temperatura : null;

        // Formata a string de exibição para a label do gráfico (Exemplo: 28/09 14:30)
        $dataIso = substr($dh, 0, 10);
        $horaMinuto = substr($dh, 11, 5);
        [$ano, $mes, $dia] = explode('-', $dataIso);
        $labels[] = "{$dia}/{$mes} {$horaMinuto}";
    }

    // Retorna as novas variáveis estruturadas (Mantive compact('df_temperatures') por segurança caso use em tabelas na mesma página)
    return view('app.df_temperature.index', compact('df_temperatures', 'labels', 'ponto1', 'ponto2', 'ponto3'));
}

}
