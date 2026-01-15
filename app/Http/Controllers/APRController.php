<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Ativo;
use App\Models\APR;
use App\Models\APRItem;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\User;
use App\Models\Risco;
use App\Models\AprRisco;
use App\Models\RiscoMedidaControle;
use App\Models\AprRiscoMedidaControle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class APRController extends Controller
{
    /**
     * Tela de listagem ou painel SESMT
     */
    public function index()
    {
        $ordens = OrdemServico::orderBy('id', 'desc')->get();
        $ativos = Equipamento::orderBy('nome')->get();

        return view('app.SESMT.index', compact('ordens', 'ativos'));
    }

    /**
     * Tela de criar APR vinculada à OS
     */
    public function create($os_id)
    {
        $ordem = OrdemServico::findOrFail($os_id);
        $ativos = Equipamento::orderBy('nome')->get();
        $funcionarios = Funcionario::where('status', 'Ativo')->get();
        return view('app.SESMT.apr_create', compact('ordem', 'ativos', 'funcionarios'));
    }

    /**
     * Salvar APR
     */ public function store(Request $request)
    {
        // dd($request);
        // 1. Validação dos dados
        $request->validate([
            'ordem_servico_id'      => 'required|exists:ordens_servicos,id',
            'responsavel'           => 'required|string|max:255',
            'local_trabalho'        => 'nullable|string|max:255',
            'descricao_atividade'   => 'required|string',
            'riscos_identificados'  => 'nullable|string',
            'medidas_controle'      => 'nullable|string',
            'epi_obrigatorio'       => 'nullable|string',
            'status'                => 'nullable|in:Aberta',
        ]);

        // 2. Criar registro da APR
        $apr = APR::create([
            'ordem_servico_id'       => $request->ordem_servico_id,
            'responsavel'            => $request->responsavel,
            'local_trabalho'         => $request->local_trabalho ?? 'Não informado',
            'descricao_atividade'    => $request->descricao_atividade,
            'riscos_identificados'   => $request->riscos_identificados,
            'medidas_controle'       => $request->medidas_controle,
            'epi_obrigatorio'        => $request->epi_obrigatorio,
            'status'                 => $request->status ?? 'aberta',
        ]);
        // Busca o último registro inserido na tabela aprs
        $apr = APR::latest('id')->first();

        if (!$apr) {
            abort(404, 'Nenhuma APR encontrada.');
        }

        return view('app.SESMT.show', compact('apr'));
    }


    /**
     * Exibir APR salva
     */
    public function show($id)
    {
        $apr = APR::findOrFail($id);

        $riscos = Risco::where('ativo', 1)
            ->orderBy('tipo_risco')
            ->orderBy('nome')
            ->get()
            ->groupBy('tipo_risco');
        $riscos_medidas_controle = RiscoMedidaControle::all();
        return view('app.SESMT.show', compact('apr', 'riscos', 'riscos_medidas_controle'));
    }
    public function dashboard()
    {
        $aprs = APR::all();
        return view('app.SESMT.dashboard', ['aprs' => $aprs]);
    }
    public function risco_store(Request $request)
    {
        // Validação
        $request->validate([
            'apr_id'       => 'required|exists:aprs,id',
            'risco_id'     => 'required|exists:riscos,id',
            'status'       => 'required|string|max:255',
            'probabilidade' => 'required|string|max:50',
            'severidade'   => 'required|string|max:50',
            'grau'         => 'required|integer|min:1'
        ]);

        // Verifica se o risco já foi identificado para essa APR
        $existe = AprRisco::where('apr_id', $request->apr_id)
            ->where('risco_id', $request->risco_id)
            ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Risco já identificado.'
            ]);
        }

        // Cria o registro no banco
        AprRisco::create([
            'apr_id'       => $request->apr_id,
            'risco_id'     => $request->risco_id,
            'status'       => $request->status,
            'probabilidade' => $request->probabilidade,
            'severidade'   => $request->severidade,
            'grau'         => $request->grau,
            'status'         => 1
        ]);
        $apr = APR::findOrFail($request->apr_id);

        $riscos = Risco::where('ativo', 1)
            ->orderBy('tipo_risco')
            ->orderBy('nome')
            ->get()
            ->groupBy('tipo_risco');
        $riscos_medidas_controle = RiscoMedidaControle::all();
        return view('app.SESMT.show', compact('apr', 'riscos', 'riscos_medidas_controle'));
    }
    public function toggleMedida(Request $request)
    {
        if ($request->acao === 'add') {
            AprRiscoMedidaControle::firstOrCreate([
                'apr_risco_id' => $request->apr_risco_id,
                'medida_id' => $request->medida_id
            ]);
        } else {
            AprRiscoMedidaControle::where([
                'apr_risco_id' => $request->apr_risco_id,
                'medida_id' => $request->medida_id
            ])->delete();
        }

        return response()->json(['success' => true]);
    }
}
