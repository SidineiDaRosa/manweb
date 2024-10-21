<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckList;
use App\Models\Equipamento;
use App\Models\CheckListExecutado;
use Carbon\Carbon; // Certifique-se de importar a classe Carbon

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
            '$equipamento' => $equipamento
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
        $data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString(); // Obtém apenas a data
        $hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString(); // Obtém apenas a hora
        // Criação do checklist
        $checkList = CheckList::create([
            'descricao' => $request->descricao,
            'equipamento_id' => $request->equipamento_id,
            'intervalo' => $request->intervalo,
            'natureza' => $request->natureza,
            'data_verificacao' =>$data_verificacao,
            'hora_verificacao' => $hora_verificacao
            
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
        $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->get();
        dd($check_list->all());
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
    public function edit(Request $request)
    {
        //
        $check_list = CheckList::find($request->check_list);
        //dd($check_list)::all();
        $equipamento = $check_list->equipamento_id;
        return view('app.check_list.check_list_edit', [
            'check_list' => $check_list,
            'equipamento' => $equipamento
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    { // Validação dos dados recebidos
        $request->validate([
            'id' => 'required|integer|exists:check_list,id',
            'descricao' => 'required|string|max:255',
            'intervalo' => 'required|integer',
            'natureza' => 'required|string'
        ]);

        // Atualizando o check-list
        $checkList = CheckList::find($request->id);
        $checkList->descricao = $request->descricao;
        $checkList->intervalo = $request->intervalo;
        $checkList->natureza = $request->natureza;
        $checkList->save();

        // Redirecionando de volta com uma mensagem de sucesso
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($check_list_id)
    {
        $checklist = CheckList::find($check_list_id);

        if ($checklist) {
            $checklist->delete();
            return response()->json(['message' => 'Checklist deletado com sucesso.'], 200);
        }

        return response()->json(['message' => 'Checklist não encontrado.'], 404);
    }
}
