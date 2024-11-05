<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckListExecutado;
use App\Models\Equipamento;
use Illuminate\Support\Facades\Validator;
use App\Models\CheckList;
use App\Models\Funcionario;
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
        $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->where('natureza', $request->natureza)->get();
        $funcionarios = Funcionario::whereIn('funcao', ['eletricista', 'mecanico'])->get();
        $funcionario = $request->funcionario;
        //dd($check_list->all());
        return view('app.check_list.check_list_open', [
            'equipamentos' => $equipamentos,
            'equipamento' => $equipamento,
            'check_list' => $check_list,
            'funcionario' => $funcionario,
            'natureza' => $request->natureza
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
            'funcionario' => 'max:255', // Verifica se a descrição é uma string e tem um máximo de 255 caracteres
            // 'data_verificacao' e 'hora_verificacao' não precisam ser validados, pois serão definidos automaticamente
        ]);

        // Cria um novo registro no banco de dados
        $checkListCheked = new CheckListExecutado();
        $checkListCheked->check_list_id = $validated['check_list_id'];
        $checkListCheked->equipamento_id = $validated['equipamento_id']; // Salva o equipamento_id
        $checkListCheked->gravidade = $validated['gravidade']; // Salva a gravidade
        $checkListCheked->observacao = $validated['observacao'];
        $checkListCheked->temperatura = $validated['temperatura'];
        $checkListCheked->vibracao = $validated['vibracao'];
        $checkListCheked->funcionario = $validated['funcionario'];

        // Define a data e hora de verificação como a data/hora atual de São Paulo
        $checkListCheked->data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString(); // Obtém apenas a data
        $checkListCheked->hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString(); // Obtém apenas a hora
        // Salva os dados da verificação se ==4  gravissimo
        if ($request->input('gravidade') == 4) {
            // Verifica se a observação é 'normal' e tem mais de 20 caracteres
            $observacao = $request->input('observacao');
            // Lógica quando a gravidade é 4 e a observação é 'normal' com mais de 15 caracteres
            if (strlen($observacao) > 15) {
                //-------------------------------------------------------------------------------//
                // Atualiza a data da ultima verificação
                $checkList = CheckList::find($request->check_list_id); // Encontra o registro pelo ID
                if ($checkList) {
                    $checkList->data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString();
                    $checkList->hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString();
                    $checkList->save(); // Atualiza o registro existente no banco de dados
                }
                //-------------------------------------------------------------------------------------//
                // Salva a execução do check-list atendenedo os critérios se Gravissímo for selecionado
                //
                $checkListCheked->save();
                $equipamentos = Equipamento::all();
                $equipamento = Equipamento::find($request->equipamento_id);
                // $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->get();
                $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->where('natureza', $request->natureza)->get();
                $funcionario = $request->funcionario;
                return view('app.check_list.check_list_open', [
                    'equipamentos' => $equipamentos,
                    'equipamento' => $equipamento,
                    'check_list' => $check_list,
                    'funcionario' => $funcionario,
                    'natureza' => $request->natureza
                ]);
            } else {
                return response()->json(['message' => 'Checklist ' . $checkListCheked->check_list_id . ' não salvo, verifique os dados!'], 201);
            }
        } else {
            //-------------------------------------------------------------------------------------//
            // Atualiza a data da ultima verificação  diferente de gravissímo
            //
            $checkList = CheckList::find($request->check_list_id); // Encontra o registro pelo ID
            if ($checkList) {
                $checkList->data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString();
                $checkList->hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString();
                $checkList->save(); // Atualiza o registro existente no banco de dados
            }
            // Salva a execução do check-list
            $checkListCheked->save();
            // dd($request->all()); // Isso mostrará todos os dados recebidos
            $equipamentos = Equipamento::all();
            $equipamento = Equipamento::find($request->equipamento_id);
            // $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->get();
            $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->where('natureza', $request->natureza)->get();
            $funcionario = $request->funcionario;
            return view('app.check_list.check_list_open', [
                'equipamentos' => $equipamentos,
                'equipamento' => $equipamento,
                'check_list' => $check_list,
                'funcionario' => $funcionario,
                'natureza' => $request->natureza
            ]);
        }
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
        $checkListExecutado = CheckListExecutado::findOrFail($id);
        $checkListExecutado->delete();
        return response()->json(['message' => 'Registro deletado com sucesso!']);
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function funcionario(Request $request)
    {
        //dd($request->all()); // Verifique se check_list_id é um número
        $funcionarios = Funcionario::whereIn('funcao', ['eletricista', 'mecanico'])->get();
        $equipamento = Equipamento::find($request->equipamento_id);

        return view('app.check_list.check_list_funcionario', [
            'funcionarios' =>  $funcionarios,
            'equipamento' => $equipamento
        ]);
    }
}
