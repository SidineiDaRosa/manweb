<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\Equipamento;
use App\Models\TelemetrieLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DispositivoController extends Controller
{
    /**
     * GET /dispositivos
     * Página de listagem
     */
    public function index()
    {
        $equipamentos = Equipamento::whereNull('data_desativacao')
            ->orderBy('nome')
            ->get();

        $dispositivos = Dispositivo::all();


        // 🟢 CORRIGIDO: Busca as falhas ligadas ao dispositivo ID 1 e ordena pelas mais recentes
        $telemetrie_logs = TelemetrieLog::where('dispositivo_id', 1)
            ->orderBy('created_at', 'desc')
            ->take(10) // Limita nas últimas 10 para não travar a tela
            ->get();

        // 🟢 CORRIGIDO: Adicionado 'telemetrie_logs' no compact para a View ter acesso aos dados
        return view('app.dispositivo.index', compact(
            'equipamentos',
            'dispositivos',
            'telemetrie_logs'
        ));
    }

    /**
     * GET /api/dispositivos
     * Listar dispositivos (para DataTables)
     */
    public function list(Request $request)
    {
        $query = Dispositivo::with('equipamento');

        if ($request->has('equipamento_id')) {
            $query->where('equipamento_id', $request->equipamento_id);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('device_id', 'LIKE', "%{$request->search}%")
                    ->orWhere('nome', 'LIKE', "%{$request->search}%");
            });
        }

        $dispositivos = $query->orderBy('id', 'desc')->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $dispositivos
        ]);
    }

    /**
     * POST /api/dispositivos
     * Cadastrar dispositivo
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equipamento_id' => 'required|exists:equipamentos,id',
            'device_id' => 'nullable|string|max:50|unique:dispositivos,device_id',
            'nome' => 'nullable|string|max:100',
            'firmware_versao' => 'nullable|string|max:20',
            'ativo' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $dispositivo = Dispositivo::create($request->all());

            Log::info('📡 Dispositivo cadastrado', [
                'id' => $dispositivo->id,
                'device_id' => $dispositivo->device_id,
                'equipamento_id' => $dispositivo->equipamento_id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Dispositivo cadastrado com sucesso!',
                'data' => [
                    'id' => $dispositivo->id,
                    'device_id' => $dispositivo->device_id,
                    'api_key' => $dispositivo->api_key,
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('❌ Erro ao cadastrar dispositivo', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao cadastrar dispositivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/dispositivos/{id}
     * Exibir dispositivo
     */
    public function show($id)
    {
        $dispositivo = Dispositivo::with('equipamento')->find($id);

        if (!$dispositivo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dispositivo não encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $dispositivo
        ]);
    }

    /**
     * PUT /api/dispositivos/{id}
     * Atualizar dispositivo
     */
    public function update(Request $request, Dispositivo $dispositivo)
    {

        // Validação dos dados que vêm do formulário (usando os 'name' dos inputs)
        $request->validate([
            'equipamento_id'  => 'required',
            'device_id'       => 'required',
            'api_key'         => 'required',
            'nome'            => 'nullable|string|max:255',
            'mac_address'     => 'nullable|string',
            'modelo'          => 'nullable|string',
            'firmware_versao' => 'nullable|string',
            'intervalo_envio' => 'nullable|integer',
            'ativo'           => 'required|boolean',
        ]);

        // Atualiza o objeto diretamente
        $dispositivo->update($request->all());

        // Redireciona de volta para a listagem com mensagem de sucesso
        return redirect()->route('dispositivos.index')
            ->with('success', 'Dispositivo atualizado com sucesso!');
    }

    /**
     * DELETE /api/dispositivos/{id}
     * Deletar dispositivo
     */
    public function destroy($id)
    {
        $dispositivo = Dispositivo::find($id);

        if (!$dispositivo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dispositivo não encontrado'
            ], 404);
        }

        try {
            $nome = $dispositivo->nome ?? $dispositivo->device_id;
            $dispositivo->delete();

            return response()->json([
                'status' => 'success',
                'message' => "Dispositivo '{$nome}' deletado com sucesso!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao deletar dispositivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/dispositivos/{id}/regenerate-api-key
     * Gerar nova API Key
     */
    public function regenerateApiKey($id)
    {
        $dispositivo = Dispositivo::find($id);

        if (!$dispositivo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dispositivo não encontrado'
            ], 404);
        }

        try {
            $novaApiKey = $dispositivo->gerarNovaApiKey();

            return response()->json([
                'status' => 'success',
                'message' => 'Nova API Key gerada com sucesso!',
                'data' => [
                    'device_id' => $dispositivo->device_id,
                    'api_key' => $novaApiKey
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao gerar nova API Key: ' . $e->getMessage()
            ], 500);
        }
    }
    public function monitorar(Dispositivo $dispositivo)
    {
        // O Laravel já preencheu a variável $dispositivo automaticamente!

        // Busca os logs específicos deste dispositivo dinâmico
        $telemetrie_logs = TelemetrieLog::where('dispositivo_id', $dispositivo->device_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        //echo ($telemetrie_logs);
        return view('app.dispositivo.monitor', compact('dispositivo', 'telemetrie_logs'));
    }
    //=============================================
    // Gravação dos dados pelo esp32 (Fluxo Misto)
    //=============================================
    public function dispositivo_online(Request $request)
    {
        // 🟢 AJUSTE 1: Mudar de 'vibracao' para 'vibracao_rms' para pegar o valor do ESP32 (ex: 5.27)
        $vibracaoEnviada = $request->input('vibracao_rms', 0.0);
        $deviceIdEnviado = $request->input('device_id');

        // 1 & 2. Busca e atualiza o dispositivo na tabela principal (Se ele existir)
        $dispositivo = \App\Models\Dispositivo::where('device_id', $deviceIdEnviado)->first();

        if ($dispositivo) {
            $dispositivo->update([
                'ultimo_ip'      => $request->input('ip'),
                'status_online'  => $request->status_online,
                'ultima_conexao' => \Carbon\Carbon::now('America/Sao_Paulo')
            ]);
        }

        // 3. Verificação de excesso: Se a vibração passar do limite, grava o registro bruto
        $limiteVibracaoAlerta = 2.0;

        if ($vibracaoEnviada > $limiteVibracaoAlerta) {

            // 🟢 GRAVAÇÃO SEM VALIDAÇÃO: Se tiver excesso, joga direto na tabela telemetrie_logs
            \App\Models\TelemetrieLog::create([
                // 🟢 AJUSTE 2: Como o banco é numérico (bigint) e o ESP envia o texto "ESP32_LINHA1",
                // removemos as letras para salvar apenas o número 1, evitando erro de gravação SQL
                'dispositivo_id'   => $request->input('device_id'),
                'temperatura'      => $request->input('temperatura'),
                'horimetro'        => $request->input('horimetro'),

                // Captura usando a chave exata do seu ESP32: vibracao_rms
                'vibracao'         => $vibracaoEnviada,

                'status_leitura'   => 0, // 0 = Falha/Alerta
                'codigo_erro'      => 'VIBRACAO_ALTA',
                'mensagem_erro'    => 'Vibracao acima do limite! Valor coletado: ' . $vibracaoEnviada . ' RMS.',
                'rssi'             => $request->input('rssi', null),
                'voltagem_bateria' => $request->input('voltagem_bateria', null),
                'created_at'       => \Carbon\Carbon::now('America/Sao_Paulo')
            ]);

            // Retorna alerta para o ESP32 indicando que o excesso foi registrado
            return response()->json([
                'status'  => 'ALERTA',
                'message' => 'Status processado e excesso gravado sem restricoes.'
            ]);
        }

        // Retorno padrão caso a máquina esteja operando em níveis seguros (Abaixo de 2.0 RMS)
        return response()->json([
            'status'  => 'OK',
            'message' => 'Status processado. Sem excessos detectados.'
        ]);
    }
}
