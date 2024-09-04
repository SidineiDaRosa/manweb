<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitacaoOs;
use App\Models\Funcionario;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class SolicitacaoOsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $solicitacoes=SolicitacaoOs::all();
      echo($solicitacoes);
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
        // Valida os dados recebidos da requisição
        $validated = $request->validate([
            'datatime' => 'required|date',
            'emissor' => 'nullable|exists:funcionarios,id',
            'descricao' => 'required|string|max:300',
        ]);
    
        // Define o valor padrão para 'status'
        $validated['status'] = 1; // Define o valor padrão para o campo 'status'
    
        // Cria a nova solicitação com os dados validados e o status padrão
        $solicitacao = SolicitacaoOs::create($validated);
    
        // Obtém o funcionário se o emissor estiver presente
        $funcionario = $validated['emissor'] ? Funcionario::find($validated['emissor']) : null;
    
        // Obtém o último registro gravado
        $ultimoRegistro = SolicitacaoOs::latest()->first();
    
        // Retorna uma resposta JSON com a mensagem de sucesso
        return response()->json([
            'status' => 'Solicitação salva com sucesso!',
            'ID' => $ultimoRegistro->id,
            'Data Hora' => $validated['datatime'],
            'Emissor' => $funcionario ? $funcionario->primeiro_nome : 'Não especificado',
            'Descrição' => $validated['descricao']
        ], 200);
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
    public function cont(){
  //

    // Conta as solicitações com status diferente de "aceita" (ou o status correspondente)
    $pendentes = SolicitacaoOs::where('status', '=', '1')->count();
    
    // Retorna a contagem como resposta JSON
    return response()->json(['pendentes' => $pendentes]);
    }
}
