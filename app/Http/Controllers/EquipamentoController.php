<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Equipamento;
use App\Models\PecasEquipamentos;
use App\Models\OrdemServico;
use Illuminate\Support\Arr;
use Picqer\Barcode\BarcodeGeneratorHTML;
//para busca de produtos em um formlário que adiciona os produtos ao equipamentos
use App\Models\Produto;
use App\Models\UnidadeMedida;
use App\Models\Categoria;
use App\Models\EstoqueProdutos; //Include estoque produtos
class EquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //--------------------------------------
        $id = $request->get('empresa');
        if ($request->has('searching')) {
            $searching = $request->get('searching');
            $empresas = Empresas::all();
            $equipamentos = Equipamento::where('empresa_id', $id)->orderby('nome', 'asc')->where('nome', 'like', $searching . '%')->get();
            return view('app.equipamento.index', [
                'equipamentos' => $equipamentos,
                'empresas' => $empresas,
                'empresa_id' => $id
            ]);
        } else {
            //neste caso filtra pelo formulário empresa
            $empresas = Empresas::all();
            $equipamentos = Equipamento::where('empresa_id', $id)->orderby('nome', 'asc')->get();
            return view('app.equipamento.index', [
                'equipamentos' => $equipamentos,
                'empresas' => $empresas,
                'empresa_id' => $id
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $marcas = Marca::all();
        $equipamentos = Equipamento::all();
        $empresas = Empresas::all();
        return view('app.equipamento.create', [
            'marcas' => $marcas, 'equipamentos' => $equipamentos,
            'empresas' => $empresas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $id = $request->get("empresa_id");
        //$nome = $request->get("nome");
        //echo( $id.$nome);

        Equipamento::create($request->all());
        
        $equipamento = Equipamento::orderBy('id', 'desc')->first();
        $equipamento_id = $equipamento->id;
        $pecasEquip = PecasEquipamentos::where('equipamento',  $equipamento_id)->where('status', 'ativado')->where('horas_proxima_manutencao', 72)->orderby('horas_proxima_manutencao')->get();
        $ordens_servicos = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos_1 = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'em andamento')->orderby('data_inicio')->orderby('hora_inicio')->get();
        return view('app.equipamento.show', [
            'equipamento' => $equipamento, 'pecas_equipamento' => $pecasEquip, 'ordens_servicos' => $ordens_servicos,
            'ordens_servicos_1' => $ordens_servicos_1
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function show(Equipamento $equipamento, Request $Request)
    {
        date_default_timezone_set('America/Sao_Paulo'); //define a data e hora DE SÃO PAULO
        $today = date("Y-m-d"); //data de hoje
        $timeNew = date('H:i:s');
        $data_inicio = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        //---------------------------------//
        $todas = $Request->get('todas');
        $equipamento_id = $equipamento->id;
        if ($todas == 1) {
            $pecasEquip = PecasEquipamentos::where('equipamento',  $equipamento_id)->orderby('horas_proxima_manutencao')->get();
            $ordens_servicos = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
            $ordens_servicos_1 = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'em andamento')->orderby('data_inicio')->orderby('hora_inicio')->get();
            return view('app.equipamento.show', [
                'equipamento' => $equipamento, 'pecas_equipamento' => $pecasEquip, 'ordens_servicos' => $ordens_servicos,
                'ordens_servicos_1' => $ordens_servicos_1
            ]);
        } else {
            $pecasEquip = PecasEquipamentos::where('equipamento',  $equipamento_id)->where('status', 'ativado')->where('horas_proxima_manutencao', 72)->orderby('horas_proxima_manutencao')->get();
            $ordens_servicos = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
            $ordens_servicos_1 = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'em andamento')->orderby('data_inicio')->orderby('hora_inicio')->get();
            return view('app.equipamento.show', [
                'equipamento' => $equipamento, 'pecas_equipamento' => $pecasEquip, 'ordens_servicos' => $ordens_servicos,
                'ordens_servicos_1' => $ordens_servicos_1
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipamento $equipamento)
    {
        $marcas = Marca::all();
        $equipamentos = Equipamento::all();
        $empresas = Empresas::all();
        return view('app.equipamento.edit', [
            'equipamento' => $equipamento,
            'equipamentos' => $equipamentos, 'marcas' => $marcas,
            'empresas' => $empresas

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipamento $equipamento)
    {
        $equipamento->update($request->all());
        $equipamento_id = $request->get('id');
        $pecasEquip = PecasEquipamentos::where('equipamento', $equipamento_id)->where('status', 'ativado')->orderby('horas_proxima_manutencao')->get();
        //$ordens_servicos = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
        //$ordens_servicos = OrdemServico::where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos_1 = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'em andamento')->orderby('data_inicio')->orderby('hora_inicio')->get();
        return view('app.equipamento.show', [
            'equipamento' => $equipamento, 'pecas_equipamento' => $pecasEquip, 'ordens_servicos' => $ordens_servicos,
            'ordens_servicos_1' => $ordens_servicos_1
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();
        return redirect()->route('equipamento.index');
    }
}
