<?php

//-------------------------------------
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail;
use App\Models\CheckListExecutado;
use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\Funcionario;
use App\Models\PedidoSaida;
use App\Models\Projeto;
use App\Models\SaidaProduto;
use App\Models\APR;
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
        $empresa = Empresas::all();
        $equipamento = Equipamento::all();
        $id = $request->get("id");
        $tipo_consulta = $request->get("tipo_consulta");
        switch ($tipo_consulta) {

            // 1️⃣ Consulta por ID
            case 1:
                if ($id >= 1) {
                    $funcionarios = Funcionario::all();
                    $ordens_servicos = OrdemServico::where('id', $id)
                        ->orderBy('data_inicio', 'desc')
                        ->orderBy('hora_inicio', 'desc')
                        ->get();

                    $servicos_executado = Servicos_executado::where('ordem_servico_id', $id)->get();

                    return view('app.ordem_servico.index', compact(
                        'equipamento',
                        'ordens_servicos',
                        'funcionarios',
                        'empresa',
                        'servicos_executado'
                    ));
                }
                break;

            // 2️⃣ Consulta por data e situação
            case 2:
                $dataInicio = $request->get("data_inicio");
                $dataFim = $request->get("data_fim");
                $situacao = $request->get("situacao");

                if (!empty($dataInicio)) {
                    $funcionarios = Funcionario::all();
                    $equipamentos = Equipamento::all();

                    $ordens_servicos = OrdemServico::where('situacao', $situacao)
                        ->whereBetween('data_inicio', [$dataInicio, $dataFim])
                        ->orderBy('data_inicio', 'desc')
                        ->orderBy('hora_inicio', 'desc')
                        ->get();

                    $valorTotal = OrdemServico::where('situacao', $situacao)
                        ->where('data_inicio', '>=', $dataInicio)
                        ->sum('valor');

                    return view('app.ordem_servico.index', compact(
                        'equipamento',
                        'ordens_servicos',
                        'funcionarios',
                        'empresa',
                        'valorTotal',
                        'equipamentos'
                    ));
                }
                break;

            // 5️⃣ Consulta por Patrimônio
            case 5:
                $dataInicio = $request->input('data_inicio');
                $funcionarios = Funcionario::all();
                $dataFim = $request->get("data_fim");
                $patrimonio = $request->get("patrimonio_id");
                $situacao = $request->get("situacao");

                if (Carbon::hasFormat($dataInicio, 'Y-m-d')) {
                    $ordens_servicos = OrdemServico::whereBetween('data_inicio', [$dataInicio, $dataFim])
                        ->where('equipamento_id', $patrimonio)
                        ->where('situacao', $situacao)
                        ->orderBy('data_inicio', 'desc')
                        ->orderBy('hora_inicio', 'desc')
                        ->get();
                } else {
                    $ordens_servicos = OrdemServico::where('equipamento_id', $patrimonio)
                        ->where('situacao', 'fechado')
                        ->orderBy('data_fim', 'desc')
                        ->get();
                }

                $valorTotal = 0;
                return view('app.ordem_servico.index', compact(
                    'equipamento',
                    'ordens_servicos',
                    'funcionarios',
                    'empresa',
                    'valorTotal'
                ));

                // 6️⃣ Consulta por empresa
            case 6:
                $funcionarios = Funcionario::all();
                $dataInicio = $request->get("data_inicio");
                $dataFim = $request->get("data_fim");
                $empresa_id = $request->get("empresa_id");
                $situacao = $request->get("situacao");

                $ordens_servicos = OrdemServico::whereBetween('data_inicio', [$dataInicio, $dataFim])
                    ->where('empresa_id', $empresa_id)
                    ->where('situacao', $situacao)
                    ->orderBy('data_inicio', 'desc')
                    ->orderBy('hora_inicio', 'desc')
                    ->get();

                $valorTotal = 0;
                return view('app.ordem_servico.index', compact(
                    'equipamento',
                    'ordens_servicos',
                    'funcionarios',
                    'empresa',
                    'valorTotal'
                ));

                // 7️⃣ Impressão
            case 7:
                $empresa_id = $request->get("empresa_id");
                $empresa = Empresas::where('id', $empresa_id)->get();
                $situacao = $request->get("situacao");
                $dataInicio = $request->get("data_inicio");
                $dataFim = $request->get("data_fim");

                $ordens_servicos = OrdemServico::whereBetween('data_inicio', [$dataInicio, $dataFim])
                    ->where('empresa_id', $empresa_id)
                    ->where('situacao', $situacao)
                    ->orderBy('data_inicio', 'desc')
                    ->orderBy('hora_inicio', 'desc')
                    ->get();

                return view('app.ordem_servico.printer_list_os', compact('empresa', 'ordens_servicos'));

                // 8️⃣ Ordenação por ID (emissão)
            case 8:
                $funcionarios = Funcionario::all();
                $dataInicio = $request->get("data_inicio");
                $dataFim = $request->get("data_fim");
                $empresa_id = $request->get("empresa_id");
                $situacao = $request->get("situacao");

                $ordens_servicos = OrdemServico::whereBetween('data_emissao', [$dataInicio, $dataFim])
                    ->where('empresa_id', $empresa_id)
                    ->where('situacao', $situacao)
                    ->orderBy('data_emissao', 'desc')
                    ->get();

                $valorTotal = 0;
                return view('app.ordem_servico.index', compact(
                    'equipamento',
                    'ordens_servicos',
                    'funcionarios',
                    'empresa',
                    'valorTotal'
                ));

                // 9️⃣ Busca por descrição
            case 9:
                $funcionarios = Funcionario::all();
                $ordens_servicos = OrdemServico::where('descricao', 'like', '%' . $request->like . '%')
                    ->orderBy('data_inicio', 'desc')
                    ->orderBy('hora_inicio', 'desc')
                    ->get();

                $servicos_executado = Servicos_executado::where('ordem_servico_id', $id)->get();

                return view('app.ordem_servico.index', compact(
                    'equipamento',
                    'ordens_servicos',
                    'funcionarios',
                    'empresa',
                    'servicos_executado'
                ));

                // 🔟 Padrão — retorna vazio
            default:
                $funcionarios = Funcionario::all();
                $ordens_servicos = OrdemServico::where('id', 0)->get();
                $valorTotal = 0;
                return view('app.ordem_servico.index', compact(
                    'equipamento',
                    'ordens_servicos',
                    'funcionarios',
                    'empresa',
                    'valorTotal'
                ));
        }
    }


    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $empresa)
    {

        $projetos = Projeto::where('status', 'ativo')->get();
        $id = $empresa->get('empresa');
        $equipamento = $empresa->get('equipamento');
        $pre_descricao_os = $empresa->get('descricao');
        $ss_id = $empresa->get('ss_id');
        // Seleciona funcionários ativos
        $funcionarios = Funcionario::where('status', 'Ativo')->get();
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
            'ss_id' => $ss_id,
            'projetos' => $projetos

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
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Validação da imagem
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
            'ss_id' => $request->ss_id,
            'anexo' => $request->anexo, //Link anexado com algum documento
            'projeto_id' => $request->projeto_id,
            'check' => '0'

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

        $projeto = Projeto::find($ordem_servico_f->projeto_id);
        $servicos_executado = Servicos_executado::where('ordem_servico_id', $idLastOs)->get();
        $aprs = collect(); // collection vazia
        return view('app.ordem_servico.show', [
            'ordem_servico' => $ordem_servico_f,
            'servicos_executado' => $servicos_executado,
            'funcionarios' => $funcionarios,
            'total_hs_os' => $total_hs_os,
            'projeto' => $projeto,
            'aprs' => $aprs // envia a var aprs vazia
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

        // 2. Criar coleção vazia para acumular produtos
        $produtos = collect();

        // 3. Para cada pedido, buscar os produtos de saída correspondentes
        foreach ($pedidos_saida as $pedido) {
            $produtosPedido = SaidaProduto::where('pedidos_saida_id', $pedido->id)->get();

            // acumula na coleção principal
            $produtos = $produtos->merge($produtosPedido);
        }
        $projeto = Projeto::find($ordem_servico->projeto_id);
        $aprs = APR::where('ordem_servico_id', $ordem_servico->id)->get();
        $ped_saidas = PedidoSaida::where('ordem_servico_id', $ordem_servico->id)->get();
        return view('app.ordem_servico.show', [
            'ordem_servico'       => $ordem_servico,
            'servicos_executado'  => $servicos_executado,
            'funcionarios'        => $funcionarios,
            'total_hs_os'         => $total_hs_os,
            'equipamentos'        => $equipamentos,
            'produtos'            => $produtos,
            'projeto' => $projeto,
            'aprs' => $aprs,
            'ped_saidas' => $ped_saidas
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
        // Seleciona funcionários ativos
        $funcionarios = Funcionario::where('status', 'Ativo')->get();
        $empresas = Empresas::all();
        $projetos = Projeto::where('status', 'ativo')->get();

        return view(
            'app.ordem_servico.edit',
            [
                'ordem_servico' => $ordem_servico,
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'empresas' => $empresas,
                'projetos' => $projetos
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
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Validação da imagem
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
        $projeto = Projeto::find($ordem_servico->projeto_id);
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
            'signature_receptor' => $ordem_servico->signature_receptor, // Caminho da assinatura manual
            'anexo' => $request->anexo, // Caminho da assinatura manual
            'projeto_id' => $request->projeto_id // projeto id
        ]);

        // Recuperar dados atualizados para a view
        $ordem_servico->refresh(); // Recarrega o modelo para garantir que tem os dados atualizados
        $funcionarios = Funcionario::all();
        $servicos_executado = Servicos_executado::where('ordem_servico_id', $ordem_servico->id)->get();
        $total_hs_os = Servicos_executado::where('ordem_servico_id', $ordem_servico->id)->sum('subtotal');
        //Retorna as APRs
        $aprs = Apr::where('ordem_servico_id', $ordem_servico->id)->get();
        return view('app.ordem_servico.show', [
            'ordem_servico' => $ordem_servico,
            'servicos_executado' => $servicos_executado,
            'funcionarios' => $funcionarios,
            'total_hs_os' => $total_hs_os,
            'projeto' => $projeto,
            'aprs' => $aprs,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * * @param  \Illuminate\Http\Request  $request
     * 
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
    //==============================================//
    // Cria nova os apartir de um checklist
    //----------------------------------------------//
    public function new_os_check_list(Request $request)
    {
        // dd($id = $request->checagem_id);
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

        ]);
        $checagem = CheckListExecutado::find($request->checagem_id);
        $checagem->status = 'Verificado';
        $checagem->save();
        echo 'Criar nova OS a partir do checklist';
        // Para debug: dd($request->all());
        return back(); // Volta para a página anterior (onde estava o formulário)
    }
    public function update_os_interval(Request $request)
    {

        $inicio = $request->input('inicio');
        $horaInicio = $request->input('horaInicio');
        $fim = $request->input('fim');
        $horaFim = $request->input('horaFim');
        $id = $request->input('id');
        $status = $request->input('status');
        $situacao = $request->input('situacao_os');

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
        $os->hora_inicio = $horaInicio;
        $os->data_fim = $fim;
        $os->hora_fim = $horaFim;
        $os->status_servicos = $status;
        $os->situacao = $situacao;

        // Salva as alterações
        $os->save();

        return response()->json([
            'retorno' => "Ordem $id alterada comsucesso!"
        ]);
    }
    public function filter_os_timeline(Request $request)
    {

        $dataInicio = $request->input('data_inicio') ?: date('Y-m-01');
        $dataFim = $request->input('data_fim') ?: date('Y-m-t');

        $inicio = Carbon::parse($dataInicio);
        $fim = Carbon::parse($dataFim);

        $ordens = OrdemServico::where('situacao', 'Aberto')  // filtro global
            ->where(function ($q) use ($inicio, $fim) {
                $q->whereBetween('data_inicio', [$inicio, $fim])
                    ->orWhere(function ($q2) use ($inicio) {
                        $q2->where('data_inicio', '<', $inicio)
                            ->where('data_fim', '>=', $inicio);
                    });
            })
            ->orderBy('data_inicio')
            ->get();

        $tarefas = $ordens->map(function ($ordem) use ($inicio, $fim) {
            $dataInicioTarefa = Carbon::parse($ordem->data_inicio . ' ' . ($ordem->hora_inicio ?? '00:00:00'));
            $dataFimTarefa = Carbon::parse($ordem->data_fim . ' ' . ($ordem->hora_fim ?? '23:59:59'));

            if ($dataInicioTarefa < $inicio) {
                $dataInicioTarefa = $inicio;
            }
            if ($dataFimTarefa > $fim) {
                $dataFimTarefa = $fim;
            }

            $dia_inicio = $inicio->diffInDays($dataInicioTarefa);
            $duracao = $dataInicioTarefa->diffInHours($dataFimTarefa) / 24;

            return [
                'id' => $ordem->id,
                'responsavel' => $ordem->responsavel ?? 'N/A',
                'descricao' => $ordem->descricao ?? '',
                'dia_inicio' => $dia_inicio,
                'duracao_dias' => round($duracao, 2),
                // Adicione campos que precise no front, como equipamento, por exemplo
                'equipamento' => $ordem->equipamento ?? null,
                'data_inicio' => $dataInicioTarefa->toDateTimeString(),
                'data_fim' => $dataFimTarefa->toDateTimeString(),
            ];
        });

        $diasIntervalo = $inicio->diffInDays($fim) + 1;

        return view('app.ordem_servico.gantt_os', compact('tarefas', 'inicio', 'diasIntervalo', 'dataInicio', 'dataFim'));
    }
    //===============================================//
    // Gera gráfico de gantt
    //--------------------------------------------//
    public function gantt_timeline(Request $request)
    {
        $situacao = $request->query('situacao');
        $inicioFiltro = $request->query('inicio');
        $fimFiltro = $request->query('fim');
        $projeto = $request->projeto_id;
        // Validação da janela de tempo

        if (!$inicioFiltro || !$fimFiltro) {
            // Retorna uma view simples com mensagem de erro
            return redirect()->back()->with('erro', 'Data início não pode ser maior que data fim.');
        }

        $dtInicio = Carbon::parse($inicioFiltro);
        $dtFim = Carbon::parse($fimFiltro);

        if ($dtInicio->greaterThan($dtFim)) {
            return redirect()->back()->with('erro', 'Data início não pode ser maior que data fim.');
        }
        if ($projeto == 0) {
            $query = OrdemServico::query();
            // busca apenas pela data inicial
            $query->whereRaw("STR_TO_DATE(CONCAT(data_inicio, ' ', hora_inicio), '%Y-%m-%d %H:%i:%s') >= ?", [$dtInicio])
                //->whereRaw("STR_TO_DATE(CONCAT(data_fim, ' ', hora_fim), '%Y-%m-%d %H:%i:%s') <= ?", [$dtFim]);
                ->whereRaw("STR_TO_DATE(CONCAT(data_inicio, ' ', hora_inicio), '%Y-%m-%d %H:%i:%s') <= ?", [$dtFim]);

            if ($situacao) {
                if ($situacao === 'padrao') {
                    $query->whereIn('situacao', ['aberto', 'em andamento', 'pausado']);
                } else {
                    $query->whereRaw('LOWER(situacao) = LOWER(?)', [$situacao]);
                }
            }

            $ordens = $query->orderBy('data_inicio')
                ->orderBy('hora_inicio')
                ->get()->map(function ($o) {
                    return [
                        'id' => $o->id,
                        'responsavel' => $o->responsavel,
                        'inicio' => Carbon::parse($o->data_inicio . ' ' . $o->hora_inicio)->format('Y-m-d\TH:i'),
                        'fim' => Carbon::parse($o->data_fim . ' ' . $o->hora_fim)->format('Y-m-d\TH:i'),
                        'descricao' => $o->descricao,
                        'equipamento' => $o->equipamento,
                        'especialidade' => $o->especialidade_do_servico,
                        'status_servicos' => $o->status_servicos,
                        'situacao' => $o->situacao,
                        'gravidade' => $o->gravidade,
                        'urgencia' => $o->urgencia,
                        'tendencia' => $o->tendencia
                    ];
                });

            return view('app.ordem_servico.gantt_os', compact('ordens', 'inicioFiltro', 'fimFiltro'));
        } else {
            $query = OrdemServico::query();

            // busca apenas pela data inicial
            $query->whereRaw("STR_TO_DATE(CONCAT(data_inicio, ' ', hora_inicio), '%Y-%m-%d %H:%i:%s') >= ?", [$dtInicio])
                ->whereRaw("STR_TO_DATE(CONCAT(data_inicio, ' ', hora_inicio), '%Y-%m-%d %H:%i:%s') <= ?", [$dtFim]);

            // 🔹 filtra pelo projeto_id
            if (!empty($projeto)) {
                $query->where('projeto_id', $projeto);
            }

            if ($situacao) {
                if ($situacao === 'padrao') {
                    $query->whereIn('situacao', ['aberto', 'em andamento', 'pausado']);
                } else {
                    $query->whereRaw('LOWER(situacao) = LOWER(?)', [$situacao]);
                }
            }

            $ordens = $query->orderBy('data_inicio')
                ->orderBy('hora_inicio')
                ->get()->map(function ($o) {
                    return [
                        'id' => $o->id,
                        'responsavel' => $o->responsavel,
                        'inicio' => Carbon::parse($o->data_inicio . ' ' . $o->hora_inicio)->format('Y-m-d\TH:i'),
                        'fim' => Carbon::parse($o->data_fim . ' ' . $o->hora_fim)->format('Y-m-d\TH:i'),
                        'descricao' => $o->descricao,
                        'equipamento' => $o->equipamento,
                        'especialidade' => $o->especialidade_do_servico,
                        'status_servicos' => $o->status_servicos,
                        'situacao' => $o->situacao,
                        'gravidade' => $o->gravidade,
                        'urgencia' => $o->urgencia,
                        'tendencia' => $o->tendencia
                    ];
                });

            return view('app.ordem_servico.gantt_os', compact('ordens', 'inicioFiltro', 'fimFiltro'));
        }
    }

    public function storeFromModal(Request $request)

    {  //===========================================//
        //  Modal Atualiza tarefas apartir do Gannt
        //===========================================//
        // Validação simples (você pode ajustar)
        $request->validate([
            'data_emissao' => 'required|date',
            'hora_emissao' => 'required',
            'data_inicio' => 'required|date',
            'hora_inicio' => 'required',
            'data_fim' => 'required|date',
            'hora_fim' => 'required',
            'equipamento_id' => 'required|integer',
            'funcionario_id' => 'required|string',
            'descricao' => 'required|string',
            'especialidade_do_servico' => 'required|string',
            'natureza_do_servico' => 'required|string',
        ]);

        $ordemServico = OrdemServico::create([
            'data_emissao' => $request->data_emissao,
            'hora_emissao' => $request->hora_emissao,
            'data_inicio' => $request->data_inicio,
            'hora_inicio' => $request->hora_inicio,
            'data_fim' => $request->data_fim,
            'hora_fim' => $request->hora_fim,
            'equipamento_id' => $request->equipamento_id,
            'emissor' => 'Marcos',
            'responsavel' => $request->funcionario_id,
            'descricao' => $request->descricao,
            'status_servicos' => $request->status_servicos,
            'link_foto' => $request->link_foto, // pode ser ajustado para upload real
            'gravidade' => $request->gravidade,
            'urgencia' => $request->urgencia,
            'tendencia' => $request->tendencia,
            'empresa_id' => $request->empresa_id,
            'situacao' => $request->situacao,
            'natureza_do_servico' => $request->natureza_do_servico,
            'especialidade_do_servico' => $request->especialidade_do_servico,
            'ss_id' => $request->ss_id
        ]);

        return response()->json(['success' => true, 'id' => $ordemServico->id]);
    }
    // Start stop OS
    public function start_stop_os(Request $request, $id)
    {
        $os = OrdemServico::findOrFail($id);

        // Converte de padrão do front para padrão do banco
        $status = $request->status === 'em_andamento'
            ? 'em andamento'
            : $request->status;

        $os->update([
            'situacao' => $status,
            'observacao' => $request->observacao,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OS atualizada para: ' . $status
        ]);
    }
}
