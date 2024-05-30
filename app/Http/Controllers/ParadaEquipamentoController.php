<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParadaEquipamento;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\OrdemProducao;
use App\Models\RecursosProducao;

class ParadaEquipamentoController extends Controller
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, OrdemProducao $ordem_producao)
    {
        $parada_equipamento= new ParadaEquipamento();
        $parada_equipamento->ordem_producao_id=$ordem_producao->id;
        $parada_equipamento->data=$request->input('data');
        $parada_equipamento->hora_inicio=$request->input('hora_inicio');
        $parada_equipamento->hora_fim=$request->input('hora_fim');
        $parada_equipamento->descricao=$request->input('descricao');
        $parada_equipamento->save();

        $paradas_equipamento = ParadaEquipamento::where('ordem_producao_id', $ordem_producao->id)->get();
        $produtos = Produto::all();
        $equipamentos = Equipamento::all();
        $recursos_producao = RecursosProducao::where('ordem_producao_id', $ordem_producao->id)->get();

        //dd($parada_equipamento);
        return view(
            'app.ordem_producao.create',
            [
                'produtos' => $produtos,
                'equipamentos' => $equipamentos,
                'ordem_producao' => $ordem_producao,
                'recursos_producao' => $recursos_producao,
                'paradas_equipamento' => $paradas_equipamento
            ]
        );
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
