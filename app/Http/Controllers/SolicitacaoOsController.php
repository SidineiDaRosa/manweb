<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;
use App\Models\SolicitacaoOs;
use App\Models\Funcionario;
use App\Models\OrdemServico;
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
        $solicitacoes = SolicitacaoOs::where('status', 'Em Espera')
            ->orWhere('status', 'Aberta')
            ->orderByRaw("FIELD(status, 'Aberta', 'Em Espera')")
            ->orderBy('created_at', 'desc') // Ordenar pela data mais recente
            ->get();
        $funcionarios = Funcionario::all();
        return view('app.solicitacao_os.solicitacao_os_show', [
            'solicitacoes' => $solicitacoes,
            'funcionarios' => $funcionarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $funcionarios = Funcionario::where('funcao', 'supervisor')->get();
        return view('app.solicitacao_os.solicitacao_create', ['funcionarios' => $funcionarios]);
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
            'datetime' => 'required|date',//aqui date e time
            'emissor' => 'nullable|exists:funcionarios,id',
            'descricao' => 'required|string|max:300',
        ]);

        // Define o valor padrão para 'status'
        $validated['status'] = 'Aberto'; // Define o valor padrão para o campo 'status'

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
            'Data Hora' => $validated['datetime'],
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
    public function cont()
    {
        // Conta as solicitações com status diferente de "aceita" (ou o status correspondente)
        $pendentes = SolicitacaoOs::where('status', '=', 'Aberta')->count();

        // Retorna a contagem como resposta JSON
        return response()->json(['pendentes' => $pendentes]);
    }
    public function aceitar($id)
    {
        $solicitacao = SolicitacaoOs::find($id);
        $solicitacao->status = 'Aceita'; // Status para "Aceita"
        $solicitacao->receptor = auth()->user()->name; // Grava o nome do usuário autenticado
        $solicitacao->save();
        $solicitacaoOs = SolicitacaoOs::find($id);
        $novaOs = $solicitacaoOs->descricao;
        $equipamentos = Equipamento::all();
        return view('app.solicitacao_os.nova_os', [
            'equipamentos' => $equipamentos,
            'novaOs' => $novaOs
        ]);
    }

    public function espera($id)
    {
        $solicitacao = SolicitacaoOs::find($id);
        $solicitacao->status = 'Em Espera'; // Status para "Em Espera"
        $solicitacao->save();

        return redirect()->back()->with('success', 'Solicitação colocada em espera!');
    }

    public function recusar($id)
    {
        $solicitacao = SolicitacaoOs::find($id);
        $solicitacao->status = 'Recusada'; // Status para "Recusada"
        $solicitacao->save();

        return redirect()->back()->with('success', 'Solicitação recusada com sucesso!');
    }
    public function solicitacoes(Request $request)
    {
        // Obtém o valor da data e hora do formulário
        $datetime = $request->input('datetime');
        $datetime_fim = $request->input('datetime_fim');
        $options = $request->get('options');
        echo($options );
        // Converte a data e hora para o formato DateTime, se necessário
        $date = \Carbon\Carbon::parse($datetime);
        $endDate = \Carbon\Carbon::parse($datetime_fim);

        // Faz a busca das solicitações com base na data e hora
        $solicitacoes = SolicitacaoOs::where('datetime', '>=', $date)
            ->where('datetime', '<=', $endDate)->where('status',$options)
            ->get();

        // Obtém todos os funcionários
        $funcionarios = Funcionario::all();

        // Retorna a view com os dados
        return view('app.solicitacao_os.solicitacao_os_show', [
            'solicitacoes' => $solicitacoes,
            'funcionarios' => $funcionarios
        ]);
    }
}
