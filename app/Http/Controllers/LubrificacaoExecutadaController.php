<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use App\Models\LubrificacaoExecutada;
use App\Models\Lubrificacao;
use App\Models\Equipamento;

class LubrificacaoExecutadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lubrificacoes_executadas = LubrificacaoExecutada::all(); // mesma variável da view
        return view('app.lubrificacao.executadas', compact('lubrificacoes_executadas'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function executar(Request $request, $id)
    {
        // Busca a lubrificação
        $lubrificacao = Lubrificacao::findOrFail($id);

        // Cria um registro na tabela lubrificacoes_executadas
        $executada = new LubrificacaoExecutada();
        $executada->lubrificacao_id = $lubrificacao->id;
        $executada->observacoes = $request->observacoes ?? null;
        $executada->executante = auth()->user()->name ?? 'Operador externo'; // se não tiver login
        $executada->save();

        // Atualiza a data da última execução na lubrificação
        $lubrificacao->atualizado_em = now();

        // Atualiza observações da lubrificação (opcional)
        if ($request->filled('observacoes')) {
            $lubrificacao->observacoes = $request->observacoes;
        }

        $lubrificacao->save();

        // Retorna com mensagem
        return redirect()->back()->with('success', 'Lubrificação executada e registrada com sucesso!');
    }

    public function executar_lub($equipamento_id)
    {
        $equipamento = \App\Models\Equipamento::findOrFail($equipamento_id);

        // Busca todas as lubrificações relacionadas a este equipamento
        $lubrificacoes = \App\Models\Lubrificacao::where('equipamento_id', $equipamento_id)->get();
        $funcionarios = Funcionario::whereIn('funcao', ['mecânico', 'eletricista'])->get();
        return view('app.lubrificacao.executar', compact('equipamento', 'lubrificacoes', 'funcionarios'));
    }
    public function executar_open(Request $request)
    {

        // Busca equipamento no banco
        $equipamento = Equipamento::findOrFail($request->equipamento_id);

        // Busca lubrificações relacionadas
        $lubrificacoes = Lubrificacao::where('equipamento_id', $request->equipamento_id)->get();

        // Se for um único funcionário pelo ID
        $funcionario = Funcionario::find($request->funcionario_id);


        return view('app.lubrificacao.executar_lubrificacao_list', compact('equipamento', 'lubrificacoes', 'funcionario'));
    }

    public function executarAcao(Request $request, $id)
    {
        $lubrificacao = Lubrificacao::findOrFail($id);

        $executada = new LubrificacaoExecutada();
        $executada->lubrificacao_id = $lubrificacao->id;
        $executada->observacoes = $request->observacoes ?? null;
        $executada->executante = $request->executante_nome ?? 'Operador externo';
        $executada->save();

        $lubrificacao->atualizado_em = now();

        if ($request->filled('observacoes')) {
            //$lubrificacao->observacoes = $request->observacoes;
        }

        $lubrificacao->save();

        return response()->json(['message' => 'Lubrificação executada e registrada com sucesso!']);
    }
}
