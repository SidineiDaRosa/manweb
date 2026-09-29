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

    // 1. Filtros de data opcionais do seu formulário
    if ($request->filled('data_inicio')) {
        $query->where('data_hora', '>=', $request->data_inicio);
    }
    if ($request->filled('data_fim')) {
        $query->where('data_hora', '<=', $request->data_fim);
    }

    // Define o limite dinamicamente baseado na presença dos filtros (Idêntico ao seu original)
    if ($request->filled('data_inicio') || $request->filled('data_fim')) {
        $df_temperatures = $query
            ->orderBy('data_hora', 'desc')
            ->take(5000)
            ->get()
            ->reverse(); 
    } else {
        // Se não definiu nada, pega as últimas 2000 linhas gerais do banco (Garante que sempre haverá dados na tela)
        $df_temperatures = $query
            ->orderBy('data_hora', 'desc')
            ->take(2000)
            ->get()
            ->reverse(); 
    }

    // Se o banco estiver totalmente vazio, evita erros na página
    if ($df_temperatures->isEmpty()) {
        return view('app.df_temperature.index', [
            'labels' => [], 'ponto1' => [], 'ponto2' => [], 'ponto3' => [], 'df_temperatures' => collect()
        ]);
    }

    // =========================================================================
    // O SEGREDO DO ALINHAMENTO DINÂMICO
    // =========================================================================

    // 2. Extraímos todos os horários únicos que vieram nessa listagem do banco e ordenamos cronologicamente.
    // Assim, se o último dado gravado foi há 3 dias, a linha do tempo mestre vai terminar exatamente no horário desse último dado!
    $horariosUnicos = $df_temperatures->pluck('data_hora')
        ->unique()
        ->sort()
        ->values();

    // 3. Agrupamos por equipamento usando a data_hora como chave de busca rápida
    $dadosAgrupados = $df_temperatures->groupBy('equipamento')->map(function ($itens) {
        return $itens->keyBy('data_hora');
    });

    $ponto1 = [];
    $ponto2 = [];
    $ponto3 = [];
    $labels = [];

    // 4. Montamos as colunas de dados indexadas lado a lado
    foreach ($horariosUnicos as $dh) {
        // Se o sensor tem dado naquele exato instante, joga o valor. Se falhou (não tem a chave), joga null.
        $ponto1[] = isset($dadosAgrupados['ponto_1'][$dh]) ? (float)$dadosAgrupados['ponto_1'][$dh]->temperatura : null;
        $ponto2[] = isset($dadosAgrupados['ponto_2'][$dh]) ? (float)$dadosAgrupados['ponto_2'][$dh]->temperatura : null;
        $ponto3[] = isset($dadosAgrupados['ponto_3'][$dh]) ? (float)$dadosAgrupados['ponto_3'][$dh]->temperatura : null;

        // Formata a exibição legível do eixo X (Ex: "28/09 14:30")
        $dataIso = substr($dh, 0, 10);
        $horaMinuto = substr($dh, 11, 5);
        [$ano, $mes, $dia] = explode('-', $dataIso);
        $labels[] = "{$dia}/{$mes} {$horaMinuto}";
    }

    // Retorna os dados prontos para a View
    return view('app.df_temperature.index', compact('df_temperatures', 'labels', 'ponto1', 'ponto2', 'ponto3'));
}

}
