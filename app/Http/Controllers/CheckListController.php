<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckList;
use App\Models\Equipamento;
use App\Models\CheckListExecutado;

class CheckListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $check_list = CheckList::where('id', 0)->get();
        // $check_list = CheckList::all();

        $equipamentos = Equipamento::all();
        $equipamento = Equipamento::find(0);
        return view('app.check_list.index', [
            'equipamentos' => $equipamentos,
            'check_list' => $check_list,
            '$equipamento'=>$equipamento
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação dos dados do request
        $request->validate([
            'descricao' => 'required|string|max:255',
            'equipamento_id' => 'required|integer',
            'intervalo' => 'required|integer',
            'natureza' => 'required',
            //'data_verificacao' => 'required|date',
            //'hora_verificacao' => 'required|date_format:H:i',
        ]);

        // Criação do checklist
        $checkList = CheckList::create([
            'descricao' => $request->descricao,
            'equipamento_id' => $request->equipamento_id,
            'intervalo' => $request->intervalo,
            'natureza' => $request->natureza,
            // 'data_verificacao' => $request->data_verificacao,
            //  'hora_verificacao' => $request->hora_verificacao,
        ]);

        // Redirecionar ou retornar uma resposta
        // return redirect()->back()->with('success', 'Checklist criado com sucesso!');
        $equipamentos = Equipamento::all();
        $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->get();
        $equipamento = Equipamento::find($request->equipamento_id);
        
        return view(
            'app.check_list.index',
            [
                'equipamentos' => $equipamentos,
                'equipamento' => $equipamento,
                'check_list' => $check_list
            ]
        );
    }
    public function show(Request $request)
    {
        $equipamento_id = $request->get('equipamento_id');
        $equipamento = Equipamento::find($equipamento_id);

        // $id = $request->input('id'); // ou outro nome de campo do formulário

        // Buscar o recurso pelo ID
        // $checklist = CheckList::find($id);

        // if (!$checklist) {
        // return redirect()->back()->with('error', 'CheckList não encontrado.');
        // }
        $equipamentos = Equipamento::all();
        $check_list = CheckList::where('equipamento_id', $equipamento_id)->get();
        return view(
            'app.check_list.index',
            [
                'equipamentos' => $equipamentos,
                'equipamento' => $equipamento,
                'check_list' => $check_list
            ]
        );
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
