<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecursosProducao;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\OrdemProducao;
use App\Models\ParadaEquipamento;

class RecursosProducaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function HorimetroInicial( Request $request){
        dd($request->all());
        

    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, OrdemProducao $ordem_producao)
    {
        $produtos = Produto::all();
        $equipamentos = Equipamento::all();
        $paradas_equipamento = ParadaEquipamento::where('ordem_producao_id', $ordem_producao->id)->get();
        //$ordem_producao= OrdemProducao::find($ordem_producao);
        $recurso_producao = new RecursosProducao();
        $recurso_producao->ordem_producao_id = $ordem_producao->id;
        $recurso_producao->equipamento_id = $request->input('equipamento_id');

        $exists_recurso_producao = RecursosProducao::where('ordem_producao_id', $ordem_producao->id)->
        where('equipamento_id', $recurso_producao->equipamento_id)->get()->first();

        if(isset($exists_recurso_producao)){//verifica re o recurso já existe na ordem se já, não deixa cadastrar.
            $recursos_producao = RecursosProducao::where('ordem_producao_id', $ordem_producao->id)->get();
            return view('app.ordem_producao.create', [
                'produtos' => $produtos, 
                'equipamentos' => $equipamentos,
                'ordem_producao' => $ordem_producao,
                 'recursos_producao' => $recursos_producao,
                 'paradas_equipamento'=>$paradas_equipamento
            ]);
            //se já existe o recurso na ordem-> faz a consulta novamente e sai do função,não executa o codigo abaixo
            
        }
        $recurso_producao->produto_id = $request->input('produto_id');
        $recurso_producao->quantidade = $request->input('quantidade');
        $recurso_producao->horimetro_inicial = $request->input('horimetro_inicial');
        $recurso_producao->horimetro_final = $request->input('horimetro_final');
        $recurso_producao->data_inicio = $request->input('data_inicio');
        $recurso_producao->data_fim = $request->input('data_fim');
        $recurso_producao->hora_inicio = $request->input('hora_inicio');
        $recurso_producao->hora_fim = $request->input('hora_fim');
        $recurso_producao->save();

        $recursos_producao = RecursosProducao::where('ordem_producao_id', $ordem_producao->id)->get();

        return view('app.ordem_producao.create', 
        [
            'produtos' => $produtos, 
            'equipamentos' => $equipamentos,
            'ordem_producao' => $ordem_producao, 
            'recursos_producao' => $recursos_producao,
            'paradas_equipamento'=>$paradas_equipamento
        ]);
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
}
