<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Ativo;
use App\Models\APR;
use App\Models\APRItem;
use App\Models\Equipamento;
use App\Models\Funcionario;
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
        return view('app.SESMT.apr_create', compact('ordem', 'ativos','funcionarios'));
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
        $apr = APR::with('itens')->findOrFail($id);

        return view('app.SESMT.show', compact('apr'));
    }
}
