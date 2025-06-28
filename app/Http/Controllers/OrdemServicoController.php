<?php

//-------------------------------------
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail;
use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\Funcionario;
use App\Models\PedidoSaida;
use App\Models\SaidaProduto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Query\OrExpr;
use App\Models\Servicos_executado;
use PhpParser\Node\Expr\BinaryOp\Equal;

class OrdemServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function index(Request $request)
    public function index(Request $request)
    {
        echo ($request->tipo_consulta);
        //Mail::to('sidineidarosa201@gmail.com')->send(new ExampleMail());

        // return "Email enviado com sucesso!";
        // echo ($request);
        // date_default_timezone_set('America/Sao_Paulo');
        //$today = date("Y-m-d"); //data de hoje
        //$timeNew =date('H:i:s');
        $empresa = Empresas::all();
        $equipamento = Equipamento::all();
        $id = $request->get("id");
        $printerOs = $request->get("printer");

        $tipo_consulta = $request->get("tipo_consulta");

        if ($tipo_consulta == 1 && $id >= 1) {
            //filtro ordem de serviço pelo Id
            $funcionarios = Funcionario::all();
            $ordens_servicos = OrdemServico::where('id', $id)->orderby('data_inicio')->orderby('hora_inicio')->get();
            $servicos_executado = Servicos_executado::where('ordem_servico_id', $id)->get();
            //dd($servicos_executado );
            return view('app.ordem_servico.index', [
                'equipamento' => $equipamento,
                'ordens_servicos' => $ordens_servicos,
                'funcionarios' => $funcionarios,
                'empresa' => $empresa,
                'servicos_executado' => $servicos_executado
            ]);
        }

        //if (isset($_POST['id'])) {//antigo pelo id
        //if (!empty($id)) {
        if ($tipo_consulta == 2) {
            //filtro ordem de serviço pelo data inicial e situação
            if (isset($_POST['data_inicio'])) {
                $dataInicio = $request->get("data_inicio");
                $dataFim = $request->get("data_fim");
                if (!empty($dataInicio)) {
                    $funcionarios = Funcionario::all();
                    $dataInicio = $request->get("data_inicio");
                    $situacao = $request->get("situacao");
                    $equipamentos = Equipamento::all();
                    $ordens_servicos = OrdemServico::where('situacao', $situacao)
                        ->where('data_inicio', ('>='), $dataInicio)
                        ->where('data_inicio', ('<='), $dataFim)
                        ->orderby('data_inicio')->orderby('hora_inicio')->get();
                    //somando valor
                    $valorTotal = OrdemServico::where('situacao', $situacao)->where('data_inicio', ('>='), $dataInicio)->sum('valor');

                    return view('app.ordem_servico.index', [
                        'equipamento' => $equipamento,
                        'ordens_servicos' => $ordens_servicos,
                        'funcionarios' => $funcionarios,
                        'empresa' => $empresa,
                        'valorTotal' => $valorTotal,
                        'equipamentos' => $equipamentos
                    ]);
                }
            }
        }
        //Patrimonio
        if ($tipo_consulta == 5) {

            $dataInicio = $request->input('data_inicio');

            if (Carbon::hasFormat($dataInicio, 'Y-m-d')) {
                // A data é válida, execute sua ação aqui
                // Adicione seu código aqui para quando a data for válida

                //filtro ordem de serviço pelo data inicial e situação e patrimonio
                $funcionarios = Funcionario::all();
                $dataInicio = $request->get("data_inicio");
                $dataFim = $request->get("data_fim");
                // $empresa_id = $request->get("empresa_id");
                $patrimonio = $request->get("patrimonio_id");
                $situacao = $request->get("situacao");
                $ordens_servicos = OrdemServico::where('data_inicio', ('>='), $dataInicio)
                    ->where('data_inicio', ('<='), $dataFim)
                    ->where('equipamento_id', $patrimonio)->where('situacao', $situacao)->orderby('data_inicio')->orderby('hora_inicio')->get();

                $valorTotal = 0;
                return view('app.ordem_servico.index', [
                    'equipamento' => $equipamento,
                    'ordens_servicos' => $ordens_servicos,
                    'funcionarios' => $funcionarios,
                    'empresa' => $empresa,
                    'valorTotal' => $valorTotal
                ]);
            } else {
                // A data não é válida, não faça nada

                //filtro ordem de serviço pelo data inicial e situação e patrimonio
                $funcionarios = Funcionario::all();
                $dataInicio = $request->get("data_inicio");
                $dataFim = $request->get("data_fim");
                // $empresa_id = $request->get("empresa_id");
                $patrimonio = $request->get("patrimonio_id");
                $ordens_servicos = OrdemServico::where('equipamento_id', $patrimonio)->where('situacao', 'fechado')->orderby('data_fim', 'desc')->get();
                $valorTotal = 0;
                return view('app.ordem_servico.index', [
                    'equipamento' => $equipamento,
                    'ordens_servicos' => $ordens_servicos,
                    'funcionarios' => $funcionarios,
                    'empresa' => $empresa,
                    'valorTotal' => $valorTotal
                ]);
            }
        }
        if ($tipo_consulta == 6) {
            //filtro ordem de serviço pelo data inicial e situação e empresa
            $funcionarios = Funcionario::all();
            $dataInicio = $request->get("data_inicio");
            $dataFim = $request->get("data_fim");
            $empresa_id = $request->get("empresa_id");
            $situacao = $request->get("situacao");
            $ordens_servicos = OrdemServico::where('data_inicio', ('>='), $dataInicio)
                ->where('data_inicio', ('<='), $dataFim)
                ->where('empresa_id', $empresa_id)->where('situacao', $situacao)->orderby('data_inicio')->orderby('hora_inicio')->get();

            $valorTotal = 0;
            return view('app.ordem_servico.index', [
                'equipamento' => $equipamento,
                'ordens_servicos' => $ordens_servicos,
                'funcionarios' => $funcionarios,
                'empresa' => $empresa,
                'valorTotal' => $valorTotal
            ]);
        }

        //Ipressão
        if ($tipo_consulta == 7) {
            $empresa_id = $request->get("empresa_id");
            $empresa = Empresas::where('id', $empresa_id)->get();
            $situacao = $request->get("situacao");
            $dataInicio = $request->get("data_inicio");
            $dataFim = $request->get("data_fim");
            // $ordens_servicos = OrdemServico::where('empresa_id', $empresa_id )->where('situacao', $situacao)->get();

            $valorTotal = 0;
            $ordens_servicos = OrdemServico::where('data_inicio', ('>='), $dataInicio)
                ->where('data_inicio', ('<='), $dataFim)
                ->where('empresa_id', $empresa_id)->where('situacao', $situacao)->orderby('data_inicio')->orderby('hora_inicio')->get();
            return view(
                'app.ordem_servico.printer_list_os',
                ['empresa' => $empresa, 'ordens_servicos' => $ordens_servicos]

            );
        }
        // ordennado pelo id asc
        if ($tipo_consulta == 8) {
            //filtro ordem de serviço pelo data inicial e situação e empresa
            $funcionarios = Funcionario::all();
            $dataInicio = $request->get("data_inicio");
            $dataFim = $request->get("data_fim");
            $empresa_id = $request->get("empresa_id");
            $situacao = $request->get("situacao");
            $ordens_servicos = OrdemServico::where('data_emissao', ('>='), $dataInicio)
                ->where('data_emissao', ('<='), $dataFim)
                ->where('empresa_id', $empresa_id)->where('situacao', $situacao)->orderby('data_emissao')->get();

            $valorTotal = 0;
            return view('app.ordem_servico.index', [
                'equipamento' => $equipamento,
                'ordens_servicos' => $ordens_servicos,
                'funcionarios' => $funcionarios,
                'empresa' => $empresa,
                'valorTotal' => $valorTotal
            ]);
        }
        if (('teste')) {
            $funcionarios = Funcionario::all();
            $ordens_servicos = OrdemServico::where('id', 0)->get();
            $valorTotal = 0;
            return view('app.ordem_servico.index', [
                'equipamento' => $equipamento,
                'ordens_servicos' => $ordens_servicos,
                'funcionarios' => $funcionarios,
                'empresa' => $empresa,
                'valorTotal' => $valorTotal
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $empresa)
    {
        //---------------------------------------------------------//
        $id = $empresa->get('empresa');
        $equipamento = $empresa->get('equipamento');
        $pre_descricao_os = $empresa->get('descricao');
        $ss_id = $empresa->get('ss_id');
        // $funcionarios=Funcionario::all();
        $funcionarios = Funcionario::all(); //Busca todos os funcionários
        $equipamentos = Equipamento::where('empresa_id', $id)->get();
        $ordem_servico = OrdemServico::all();
        $empresa = Empresas::where('id', $id)->get();

        return view('app.ordem_servico.create', [
            'ordem_servico' =>  $ordem_servico,
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'empresa' => $empresa,
            'equipamento' => $equipamento,
            'pre_descricao_os' => $pre_descricao_os,
            'ss_id' => $ss_id

        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { // Validação dos campos
        $request->validate([
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
            // outros campos de validação, se necessário
        ]);
        // Verificar duplicidade
        $duplicateOS = OrdemServico::where('data_emissao', $request->data_emissao)
            ->where('hora_emissao', $request->hora_emissao)
            ->where('equipamento_id', $request->equipamento_id)
            ->where('emissor', $request->emissor)
            ->where('responsavel', $request->responsavel)
            ->first();

        if ($duplicateOS) {
            return redirect()->back()->withErrors('Ordem de serviço já existente.');
        }

        // Upload da imagem
        $imagemNome = null;
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $imagemNome = md5($request->imagem->getClientOriginalName() . strtotime("now")) . "." . $request->imagem->extension();
            $request->imagem->move(public_path('img/ordem_servico'), $imagemNome);
        }

        // Criação da ordem de serviço
        $ordemServico = OrdemServico::create([
            'data_emissao' => $request->data_emissao,
            'hora_emissao' => $request->hora_emissao,
            'data_inicio' => $request->data_inicio,
            'hora_inicio' => $request->hora_inicio,
            'data_fim' => $request->data_fim,
            'hora_fim' => $request->hora_fim,
            'equipamento_id' => $request->equipamento_id,
            'emissor' => $request->emissor,
            'responsavel' => $request->responsavel,
            'descricao' => $request->descricao,
            'status_servicos' => $request->status_servicos,
            'link_foto' => 'img/ordem_servico/' . $imagemNome, // Caminho da imagem
            'gravidade' => $request->gravidade,
            'urgencia' => $request->urgencia,
            'tendencia' => $request->tendencia,
            'empresa_id' => $request->empresa_id,
            'situacao' => $request->situacao,
            'natureza_do_servico' => $request->natureza_do_servico,
            'especialidade_do_servico' => $request->especialidade_do_servico,
            'ss_id' => $request->ss_id


        ]);
        //------------------------------------------------------------//
        $equipamentos = Equipamento::all();
        //OrdemServico::create($request->all());
        //--------------------------------------------------------------//
        //---------------retrorna para a view

        $idLastOs = OrdemServico::select('id')->max('id');
        $ordem_servico = OrdemServico::where('id', $idLastOs)->get();
        $funcionarios = Funcionario::all();
        $total_hs_os = Servicos_executado::where('ordem_servico_id', $ordem_servico)->sum('subtotal');
        foreach ($ordem_servico as $ordem_servico_f) {
        }
        //return response()->json($ordem_servico->toJson()); // Converte o objeto para JSON e retorna como resposta
        //return response()->json($ordem_servico->toArray()); // Converte o objeto para um array e retorna como resposta
        $servicos_executado = Servicos_executado::where('ordem_servico_id', $idLastOs)->get();
        return view('app.ordem_servico.show', [
            'ordem_servico' => $ordem_servico_f,
            'servicos_executado' => $servicos_executado,
            'funcionarios' => $funcionarios,
            'total_hs_os' => $total_hs_os
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrdemServico  $ordem_servico
     * @return \Illuminate\Http\Response
     */
    public function show(OrdemServico $ordem_servico)
    {
        $funcionarios = Funcionario::all();
        $id = $ordem_servico->id;
        $servicos_executado = Servicos_executado::where('ordem_servico_id', $id)->get();
        $total_hs_os = Servicos_executado::where('ordem_servico_id', $id)->sum('subtotal');
        $equipamentos = Equipamento::all();
        // 1. Obter os pedidos com base na 'ordem_servico_id'
        $pedidos_saida = PedidoSaida::where('ordem_servico_id', $id)->get();

        // 2. Para cada pedido, buscar os produtos de saída correspondentes
        foreach ($pedidos_saida as $pedido) {
            // Supondo que a tabela SaidaProduto tem uma coluna 'pedido_saida_id' que referencia 'id' de PedidoSaida
            $produtos = SaidaProduto::where('pedidos_saida_id', $pedido->id)->get();

            // Exibir ou processar cada produto associado ao pedido
            foreach ($produtos as $produto) {
                // Aqui você pode processar ou exibir os dados do produto
                echo "Pedido ID: " . $pedido->id . "<br>";
                echo "Produto ID: " . $produto->produto->id . "<br>";
                echo "Nome do Produto: " . $produto->produto->nome . "<br>";
                echo "Quantidade: " . $produto->quantidade . "<br>";
                echo "Unidade de Medida: " . $produto->unidade_medida . "<br>";
                echo "<br>"; // Adicionar um espaço entre os produtos
            }
        }
        //$saidas_produto=SaidaProduto::where('')
        //$total_hs_os=23;

        return view('app.ordem_servico.show', [
            'ordem_servico' => $ordem_servico,
            'servicos_executado' => $servicos_executado,
            'funcionarios' => $funcionarios,
            'total_hs_os' => $total_hs_os,
            'equipamentos' => $equipamentos,
            //'produtos'=>$produtos
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\OrdemServico $ordem_servico
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdemServico $ordem_servico)
    {
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $empresas = Empresas::all();


        return view(
            'app.ordem_servico.edit',
            [
                'ordem_servico' => $ordem_servico,
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'empresas' => $empresas

            ]
        );
        return view('app.ordem_servico.show', ['ordem_servico' => $ordem_servico,]);
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrdemServico $ordem_servico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdemServico $ordem_servico)
    {
        // Verificar se a ordem de serviço já foi assinada
        if (!is_null($ordem_servico->signature_receptor)) {
            return redirect()->back()->withErrors('Não é possível alterar uma ordem de serviço que já foi assinada.');
        }

        // Validação dos campos
        $request->validate([
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
            // outras validações, se necessário
        ]);

        // Verificar e processar a nova imagem, se houver
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            // Apagar a imagem antiga se existir
            if ($ordem_servico->link_foto) {
                $imagemCaminho = public_path($ordem_servico->link_foto);
                if (file_exists($imagemCaminho) && is_file($imagemCaminho)) {
                    unlink($imagemCaminho);
                }
            }

            // Salvar a nova imagem
            $imagemNome = md5($request->imagem->getClientOriginalName() . '_' . time()) . '.' . $request->imagem->extension();
            $request->imagem->move(public_path('img/ordem_servico'), $imagemNome);
            $ordem_servico->link_foto = 'img/ordem_servico/' . $imagemNome;
        }

        // Processar a imagem da assinatura manual, se houver
        if ($request->has('signature_receptor') && $request->input('signature_receptor') !== 'null') {
            $imagemData = $request->input('signature_receptor');
            $imagemData = str_replace('data:image/png;base64,', '', $imagemData);
            $imagemData = str_replace(' ', '+', $imagemData);
            $dadosImagemAssinatura = base64_decode($imagemData);

            // Verificar se já existe uma assinatura manual associada
            if (!$ordem_servico->signature_receptor) {
                // Salvar a assinatura manual apenas se não existir uma já associada
                $assinaturaNome = 'assinatura_' . time() . '.png'; // Nome do arquivo de assinatura
                file_put_contents(public_path('img/assinaturas/') . $assinaturaNome, $dadosImagemAssinatura);
                $ordem_servico->signature_receptor = 'img/assinaturas/' . $assinaturaNome;
            }
        }

        // Atualizar os outros campos da ordem de serviço
        $ordem_servico->update([
            'data_emissao' => $request->data_emissao,
            'hora_emissao' => $request->hora_emissao,
            'data_inicio' => $request->data_inicio,
            'hora_inicio' => $request->hora_inicio,
            'data_fim' => $request->data_fim,
            'hora_fim' => $request->hora_fim,
            'equipamento_id' => $request->equipamento_id, // ajuste conforme seus campos
            'emissor' => $request->emissor,
            'responsavel' => $request->responsavel,
            'descricao' => $request->descricao,
            'status_servicos' => $request->status_servicos,
            'especialidade_do_servico' => $request->especialidade_do_servico,
            'natureza_do_servico' => $request->natureza_do_servico,
            'gravidade' => $request->gravidade,
            'urgencia' => $request->urgencia,
            'tendencia' => $request->tendencia,
            'situacao' => $request->situacao,
            'link_foto' => $ordem_servico->link_foto, // Caminho da imagem
            'signature_receptor' => $ordem_servico->signature_receptor // Caminho da assinatura manual
        ]);

        // Recuperar dados atualizados para a view
        $ordem_servico->refresh(); // Recarrega o modelo para garantir que tem os dados atualizados
        $funcionarios = Funcionario::all();
        $servicos_executado = Servicos_executado::where('ordem_servico_id', $ordem_servico->id)->get();
        $total_hs_os = Servicos_executado::where('ordem_servico_id', $ordem_servico->id)->sum('subtotal');

        return view('app.ordem_servico.show', [
            'ordem_servico' => $ordem_servico,
            'servicos_executado' => $servicos_executado,
            'funcionarios' => $funcionarios,
            'total_hs_os' => $total_hs_os
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrdemServico  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $ordem_servico)
    {
        //
        $ordem_servico_id = $ordem_servico->get('id_os');
        // Encontrar a ordem de serviço pelo ID
        $ordem_servico = OrdemServico::find($ordem_servico_id);

        if ($ordem_servico) {
            // Deletar a ordem de serviço
            $ordem_servico->delete();

            // Exibir mensagem de sucesso estilizada
            echo "<div style='color: green; font-weight: bold;'>Ordem de serviço ID {$ordem_servico_id} deletada com sucesso.</div>";
        } else {
            // Exibir mensagem de erro estilizada
            echo "<div style='color: red; font-weight: bold;'>Erro: Ordem de serviço ID {$ordem_servico_id} não encontrada.</div>";
        }

        // Parar a execução para garantir que a mensagem seja exibida
        exit;
    }
    public function new_os_check_list(Request $request)
    {
        // Define o fuso horário de São Paulo
        $dataHoraAtual = Carbon::now('America/Sao_Paulo');

        // Formata data e hora separadamente, se quiser

        $dataFormatada = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        $horaAtual = $dataHoraAtual->format('H:i:s');
        $dataHoraMaisUma = Carbon::now('America/Sao_Paulo')->addHour();
        // Criação da ordem de serviço
        $ordemServico = OrdemServico::create([
            'data_emissao' =>  $dataFormatada,
            'hora_emissao' => $horaAtual,
            'data_inicio' => $request->data_inicio,
            'hora_inicio' => $horaAtual,
            'data_fim' => $request->data_fim,
            'hora_fim' =>  $dataHoraMaisUma,
            'equipamento_id' => $request->equipamento_id,
            'emissor' => 'Manutencao',
            'responsavel' => 'Manutencao',
            'descricao' => $request->descricao,
            'status_servicos' => 1,
            'gravidade' => 3,
            'urgencia' => 3,
            'tendencia' => 3,
            'empresa_id' => 2,
            'situacao' => 'Aberto',
            'natureza_do_servico' => 'Preventiva',
            'especialidade_do_servico' => $request->natureza,
            //'ss_id' => $request->ss_id


        ]);
        echo 'Criar nova OS a partir do checklist';
        // Para debug: dd($request->all());
        return back(); // Volta para a página anterior (onde estava o formulário)
    }
    public function update_ajax(Request $request)
    {
        // Validação dos dados recebidos via AJAX
        $request->validate([
            'id_os' => 'required|integer',          // id_os obrigatório e inteiro
            'inicio' => 'required|date',             // inicio obrigatório e formato data válido
            'fim' => 'required|date|after_or_equal:inicio', // fim obrigatório, data válida e >= inicio
        ]);

        // Busca a ordem de serviço pelo ID (passa o valor, não a string)
        $ordem = OrdemServico::findOrFail($request->id_os);

        // Atualiza os campos
        $ordem->inicio = $request->inicio;
        $ordem->fim = $request->fim;

        // Salva as alterações no banco
        $ordem->save();

        // Retorna resposta JSON para o frontend
        return response()->json(['message' => 'Ordem de Serviço atualizada com sucesso!']);
    }
    public function update_os_interval(Request $request)
    {
        $nome = $request->input('nome');
        $inicio = $request->input('inicio');
        $fim = $request->input('fim');
        $id = $request->input('id');

        // Verifica se a data de início é menor ou igual à data de fim
        if (strtotime($inicio) > strtotime($fim)) {
            return response()->json([
                'retorno' => "Erro: a data de início não pode ser maior que a data final."
            ], 400); // Código 400 = erro de requisição
        }

        // Busca a ordem de serviço pelo ID correto
        // Se o id é passado corretamente, prefira usar ele em vez de nome
        $os = OrdemServico::findOrFail($id);

        // Atualiza os campos
        $os->data_inicio = $inicio;
        $os->data_fim = $fim;

        // Salva as alterações
        $os->save();

        return response()->json([
            'retorno' => "Ordem alterada!"
        ]);
    }
}
