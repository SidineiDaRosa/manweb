<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;
use App\Models\SolicitacaoOs;
use App\Models\Funcionario;
use App\Models\OrdemServico;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
            'datetime' => 'required|date',
            'emissor' => 'nullable|exists:funcionarios,id',
            'descricao' => 'required|string|max:300',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Validação da imagem com 10MB
        ]);

        // Define o valor padrão para 'status'
        $validated['status'] = 'Aberta'; // Define o valor padrão para o campo 'status'

        // Cria a nova solicitação com os dados validados e o status padrão
        $solicitacao = SolicitacaoOs::create($validated);

        // Obtém o funcionário se o emissor estiver presente
        $funcionario = $validated['emissor'] ? Funcionario::find($validated['emissor']) : null;

        // Manipula o upload da imagem
        if ($request->hasFile('imagem')) {
            // Obtém o arquivo
            $imagem = $request->file('imagem');

            // Verifica se o arquivo foi enviado e é válido
            if ($imagem->isValid()) {
                // Gera o nome da imagem com o número da solicitação anexado
                $numeroSolicitacao = $solicitacao->id; // Usa o ID da solicitação criada
                $imagemNome = $numeroSolicitacao . '_' . md5($imagem->getClientOriginalName() . strtotime("now")) . "." . $imagem->extension();

                // Move a imagem para o diretório público com o nome gerado
                $imagem->move(public_path('img/request_os'), $imagemNome);

                // Atualiza o nome da imagem na solicitação
                $solicitacao->imagem = $imagemNome;
                $solicitacao->save();
            }
        }

        // Formata a data e hora
        $dataHora = Carbon::parse($validated['datetime'])->format('d/m/Y H:i');

        $response = [
            'status' => 'Solicitação salva com sucesso!',
            'ID' => $solicitacao->id,
            'Data Hora' => $dataHora,
            'Emissor' => $funcionario ? $funcionario->primeiro_nome : 'Não especificado',
            'Descrição' => $validated['descricao']
        ];

        // Gera o HTML para exibição
        $html = "
<div style='width: 100%; word-wrap: break-word; font-size: 20px;font-family:Arial,sanserif;'>
    <h3>Detalhes da Solicitação</h3>
    <p><strong>Status:</strong> {$response['status']}</p>
    <p><strong>ID:</strong> {$response['ID']}</p>
    <p><strong>Data e Hora:</strong> {$response['Data Hora']}</p>
    <p><strong>Emissor:</strong> {$response['Emissor']}</p>
    <p style='word-wrap: break-word;'><strong>Descrição:</strong> {$response['Descrição']}</p>";

        // Se houver uma imagem, adiciona ao HTML
        if (!empty($solicitacao->imagem)) {
            $imagemUrl = asset('img/request_os/' . $solicitacao->imagem);
            $html .= "
    <p><strong>Imagem:</strong></p>
    <img src='{$imagemUrl}' alt='Imagem da Solicitação' style='max-width: 500px;'>";
        }

        $html .= "</div>";

        // Retorna o HTML gerado
        return $html;
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
        $solicitacaoOs_id = $solicitacaoOs->id;
        $novaOs = $solicitacaoOs->descricao;
        $equipamentos = Equipamento::all();
        return view('app.solicitacao_os.nova_os', [
            'equipamentos' => $equipamentos,
            'novaOs' => $novaOs,
            'solicitacaoOs_id' => $solicitacaoOs_id
        ]);
    }

    public function espera($id)
    {
        $solicitacao = SolicitacaoOs::find($id);
        $solicitacao->status = 'Em Espera'; // Status para "Em Espera"
        $solicitacao->receptor = auth()->user()->name; // Grava o nome do usuário autenticado
        $solicitacao->save();

        return redirect()->back()->with('success', 'Solicitação colocada em espera!');
    }

    public function recusar($id)
    {
        $solicitacao = SolicitacaoOs::find($id);
        $solicitacao->status = 'Recusada'; // Status para "Recusada"
        $solicitacao->receptor = auth()->user()->name; // Grava o nome do usuário autenticado
        $solicitacao->save();

        return redirect()->back()->with('success', 'Solicitação recusada com sucesso!');
    }
    public function solicitacoes(Request $request)
    {
        $id = $request->id;
        if (isset($id)) {

            // Faz a busca das solicitações com base na data e hora
            $solicitacoes = SolicitacaoOs::where('id',$id)->get();
            // Obtém todos os funcionários
            $funcionarios = Funcionario::all();

            // Retorna a view com os dados
            return view('app.solicitacao_os.solicitacao_os_show', [
                'solicitacoes' => $solicitacoes,
                'funcionarios' => $funcionarios
            ]);
        } else {
            // Obtém o valor da data e hora do formulário
            $datetime = $request->input('datetime');
            $datetime_fim = $request->input('datetime_fim');
            $options = $request->get('options');
            // Converte a data e hora para o formato DateTime, se necessário
            $date = \Carbon\Carbon::parse($datetime);
            $endDate = \Carbon\Carbon::parse($datetime_fim);

            // Faz a busca das solicitações com base na data e hora
            $solicitacoes = SolicitacaoOs::where('datetime', '>=', $date)
                ->where('datetime', '<=', $endDate)->where('status', $options)->orderBy('datetime', 'desc')
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
    public function get_employee()
    {
        $employee = Funcionario::where('funcao', 'supervisor')->get(); // Certifique-se de que o modelo Funcionario está correto
        return response()->json($employee);
        echo ($employee);
    }
    public function cont_request_os_open()
    {
        // Conta as solicitações com status "Aberta"
        $pendentes = SolicitacaoOs::where('status', '=', 'Aberta')->count();
        // Retorna a contagem como resposta JSON
        return response()->json(['pendentes' => $pendentes]);
    }
}
