<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\Funcionario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Query\OrExpr;
use App\Models\Servicos_executado;

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
                'equipamento' => $equipamento, 'ordens_servicos' => $ordens_servicos, 'funcionarios' => $funcionarios,
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
                    $ordens_servicos = OrdemServico::where('situacao', $situacao)
                        ->where('data_inicio', ('>='), $dataInicio)
                        ->where('data_inicio', ('<='), $dataFim)
                        ->orderby('data_inicio')->orderby('hora_inicio')->get();
                    //somando valor
                    $valorTotal = OrdemServico::where('situacao', $situacao)->where('data_inicio', ('>='), $dataInicio)->sum('valor');

                    return view('app.ordem_servico.index', [
                        'equipamento' => $equipamento, 'ordens_servicos' => $ordens_servicos, 'funcionarios' => $funcionarios,
                        'empresa' => $empresa,
                        'valorTotal' => $valorTotal
                    ]);
                }
            }
        }
        //Patrimonio
        if ($tipo_consulta == 5) {
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
                'equipamento' => $equipamento, 'ordens_servicos' => $ordens_servicos, 'funcionarios' => $funcionarios,
                'empresa' => $empresa, 'valorTotal' => $valorTotal
            ]);
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
                'equipamento' => $equipamento, 'ordens_servicos' => $ordens_servicos, 'funcionarios' => $funcionarios,
                'empresa' => $empresa, 'valorTotal' => $valorTotal
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
        if (('teste')) {
            $funcionarios = Funcionario::all();
            $ordens_servicos = OrdemServico::where('id', 0)->get();
            $valorTotal = 0;
            return view('app.ordem_servico.index', [
                'equipamento' => $equipamento, 'ordens_servicos' => $ordens_servicos, 'funcionarios' => $funcionarios,
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
        // $funcionarios=Funcionario::all();
        $funcionarios = Funcionario::where('funcao', 'supervisor')->get();
        $equipamentos = Equipamento::where('empresa_id', $id)->get();
        $ordem_servico = OrdemServico::all();
        $empresa = Empresas::where('id', $id)->get();
        return view('app.ordem_servico.create', [
            'ordem_servico' =>  $ordem_servico, 'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios,
            'empresa' => $empresa,
            'equipamento' => $equipamento

        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(Request $request)
    { // Validação dos campos
        $request->validate([
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
            // outros campos de validação, se necessário
        ]);

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
            'situacao' => $request->situacao
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
            'ordem_servico' => $ordem_servico_f, 'servicos_executado' => $servicos_executado,
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
        //$total_hs_os=23;
        return view('app.ordem_servico.show', [
            'ordem_servico' => $ordem_servico, 'servicos_executado' => $servicos_executado,
            'funcionarios' => $funcionarios,
            'total_hs_os' => $total_hs_os
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
     * @param  \App\OrdemServico $ordem_sevico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdemServico $ordem_servico)
    {
        $ordem_servico->update($request->all()); //
        return redirect()->route('ordem-servico.index');
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
        echo ($ordem_servico_id);
        //$ordem_servico->delete();
        //return redirect()->route('marca.index');
    }
}
