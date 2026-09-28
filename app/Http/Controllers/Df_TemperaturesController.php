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
                ->reverse(); // Inverte para ordem cronológica no gráfico
        } else {
            // Se não definiu nada, pega os últimos 2000 mais recentes
            $df_temperatures = $query
                ->orderBy('data_hora', 'desc')
                ->take(2000)
                ->get()
                ->reverse(); // Inverte para ordem cronológica no gráfico
        }

        return view('app.df_temperature.index', compact('df_temperatures'));
    }
}
