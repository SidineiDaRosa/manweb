<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Events\DadoTesteRecebido;
use Symfony\Component\HttpFoundation\StreamedResponse; // ADICIONADO

class TelemetrieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.equipamento.teste');
    }

    /**
     * Recebe o POST do ESP32, dispara o WebSocket e salva no Cache
     */
    public function testeWebsocket(Request $request): JsonResponse
    {
        $dadoQualquer = $request->input('dado');

        // Salva o dado na memória RAM temporária por 10 segundos
        Cache::put('ultimo_dado_esp32', $dadoQualquer, 10);

        // Mantém o seu disparo do WebSocket original ativo
        broadcast(new DadoTesteRecebido($dadoQualquer));

        return response()->json([
            'status' => 'sucesso', 
            'mensagem' => 'Dado de telemetria transmitido: ' . $dadoQualquer
        ], 200);
    }

    /**
     * ATUALIZADO: Cria um canal contínuo (Túnel) para empurrar os dados para a View
     */
    public function transmitirDados(): StreamedResponse
    {
        $response = new StreamedResponse(function () {
            $ultimoValorExibido = null;

            // Loop infinito para manter a conexão aberta em tempo real
            while (true) {
                $dadoAtual = Cache::get('ultimo_dado_esp32');

                // Se o ESP32 atualizou o Cache, empurra o dado para o navegador na mesma hora
                if ($dadoAtual !== null && $dadoAtual !== $ultimoValorExibido) {
                    echo "data: " . json_encode(['dado' => $dadoAtual]) . "\n\n";
                    ob_flush();
                    flush();
                    $ultimoValorExibido = $dadoAtual;
                }
                
                // Espera 0.1 segundo antes de checar a memória novamente (ultra leve)
                usleep(100000); 
            }
        });

        // Configura os cabeçalhos para o navegador manter o canal aberto continuamente
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no'); // Evita travas no servidor

        return $response;
    }
}
