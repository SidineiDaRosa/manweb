<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckListExecutado;
use App\Models\Equipamento;
use Illuminate\Support\Facades\Validator;
use App\Models\CheckList;
use Carbon\Carbon; // Certifique-se de importar a classe Carbon

class CheckListExecutadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $equipamentos = Equipamento::all();
        $equipamento = Equipamento::find($request->equipamento_id);
        $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->get();
        return view('app.check_list.check_list_open', [
            'equipamentos' => $equipamentos,
            'equipamento' => $equipamento,
            'check_list' => $check_list
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
        //dd($request->all()); // Verifique se check_list_id é um número
        // Validação dos dados do formulário
        $validated = $request->validate([
            'check_list_id' => 'required|integer|exists:check_list,id', // Verifica se o check_list_id existe na tabela check_list
            'equipamento_id' => 'required|exists:equipamentos,id', // Verifica se o equipamento_id existe na tabela equipamentos
            'gravidade' => 'required|integer|between:1,4', // Verifica se a gravidade é um número inteiro entre 1 e 4
            'observacao' => 'max:255', // Verifica se a descrição é uma string e tem um máximo de 255 caracteres
            'temperatura' => 'max:255', // Verifica se a descrição é uma string e tem um máximo de 255 caracteres
            'vibracao' => 'max:255', // Verifica se a descrição é uma string e tem um máximo de 255 caracteres
            // 'data_verificacao' e 'hora_verificacao' não precisam ser validados, pois serão definidos automaticamente
        ]);

        // Cria um novo registro no banco de dados
        $checkListCheked = new CheckListExecutado();
        $checkListCheked->check_list_id = $validated['check_list_id'];
        $checkListCheked->equipamento_id = $validated['equipamento_id']; // Salva o equipamento_id
        $checkListCheked->gravidade = $validated['gravidade']; // Salva a gravidade
        $checkListCheked->observacao = $validated['observacao'];
        $checkListCheked->temperatura= $validated['temperatura'];
        $checkListCheked->vibracao = $validated['vibracao'];

        // Define a data e hora de verificação como a data/hora atual de São Paulo
        $checkListCheked->data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString(); // Obtém apenas a data
        $checkListCheked->hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString(); // Obtém apenas a hora
        // Salva os dados da verificação
        $checkListCheked->save();
        // Atualiza os dados da verificação
        $checkList = CheckList::find($request->check_list_id); // Encontra o registro pelo ID
        if ($checkList) {
            $checkList->data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString();
            $checkList->hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString();
            $checkList->save(); // Atualiza o registro existente no banco de dados
        }
        // dd($request->all()); // Isso mostrará todos os dados recebidos
        // Retorna uma resposta, pode ser um redirecionamento ou uma resposta JSON
        return redirect()->back()->with('success', 'Checklist executado salvo com sucesso!');
        // ou
        // return response()->json(['message' => 'Checklist executado salvo com sucesso!'], 201);
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function executado(Request $request)
    {
        $equipamento = Equipamento::find($request->equipamento_id);
        $check_list_executado = CheckListExecutado::where('equipamento_id', $request->equipamento_id)->get();
        return view('app.check_list.check_list_executado', [
            'equipamento' => $equipamento,
            'check_list_executado' => $check_list_executado
        ]);
    }
}
