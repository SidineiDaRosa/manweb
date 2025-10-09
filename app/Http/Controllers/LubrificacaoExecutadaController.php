<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LubrificacaoExecutada;
use App\Models\Lubrificacao;

class LubrificacaoExecutadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Pega todas as lubrificações executadas do banco de dados
        $lubrificacoes_executadas = LubrificacaoExecutada::all();

        // Retorna a view passando os dados
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
    public function executarView($id)
    {
        $lubrificacao = Lubrificacao::findOrFail($id);
        return view('app.lubrificacao.executar_lubrificacao', compact('lubrificacao'));
    }
}
