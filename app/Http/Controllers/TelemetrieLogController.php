<?php

namespace App\Http\Controllers;

use App\Models\TelemetrieLog;
use Illuminate\Http\Request;

class TelemetrieLogController extends Controller
{
    /**
     * Exibe a listagem de todas as falhas registradas.
     */
    public function index()
    {
        // Busca os logs de falha ordenados pelo mais recente e pagina de 15 em 15
        $logs = TelemetrieLog::orderBy('created_at', 'desc')->paginate(15);

        // Retorna para uma view (que você pode criar em resources/views/logs/index.blade.php)
        return view('logs.index', compact('logs'));
    }

    /**
     * API opcional para o seu painel (Dashboard) ler as falhas em tempo real via AJAX/Fetch.
     */
    public function obterFalhasRecentes()
    {
        $falhas = TelemetrieLog::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json($falhas);
    }

    /**
     * Limpa logs antigos para proteger o armazenamento do servidor.
     */
    public function limparLogsAntigos()
    {
        // Deleta registros com mais de 30 dias
        $deletados = TelemetrieLog::where('created_at', '<', now()->subDays(30))->delete();

        return response()->json([
            'status' => 'OK',
            'mensagem' => $deletados . ' registros antigos foram limpos do banco.'
        ]);
    }
}
