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
        $dataLimite = Carbon::now()->subDays(13);
        //
        $check_list = CheckList::where('id', 0)->get();
        // Busca check lists status
        $checkListsStatus = CheckList::selectRaw("
        equipamento_id,
        SUM(CASE WHEN data_verificacao <= ? OR data_verificacao IS NULL THEN 1 ELSE 0 END) AS pendentes,
        SUM(CASE WHEN data_verificacao > ? THEN 1 ELSE 0 END) AS executados
    ", [$dataLimite, $dataLimite])
            ->with('equipamento') // Carregar equipamento
            ->groupBy('equipamento_id')
            ->get();
        // Ordena os checkListsStatus pelo nome do equipamento
        $checkListsStatus = $checkListsStatus->sortBy(function ($checkList) {
            return $checkList->equipamento->nome; // Acessa o nome do equipamento relacionado
        });
        //dd($checkListsStatus->all());
        // Obtém todos os equipamentos ordenados pelo nome
        $equipamentos = Equipamento::orderBy('nome', 'asc')->get();
        $equipamento = Equipamento::find(0);
        return view('app.check_list.index', [
            'equipamentos' => $equipamentos,
            'check_list' => $check_list,
            '$equipamento' => $equipamento,
            'check_lists_status' => $checkListsStatus
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
            //'data_verificacao' =>$data_verificacao,
            //'hora_verificacao' => $hora_verificacao

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
        //
        $dataLimite = Carbon::now()->subDays(13);

        $equipamentos = Equipamento::all();
        $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->get();
        // dd($check_lists_pendentes->all());
        return view(
            'app.check_list.index',
            [
                'equipamentos' => $equipamentos,
                'equipamento' => $equipamento,
                'check_list' => $check_list,

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
    public function cont()
    {

        // Define a data limite como 4 dias antes da data atual
        $dataLimite = Carbon::now()->subDays(13);

        // Conta os registros onde data_verificacao é anterior ou igual à data limite ou está nulo
        $pendentes = CheckList::where('data_verificacao', '<=', $dataLimite)
            ->orWhereNull('data_verificacao')
            ->count();

        // Retorna a contagem como resposta JSON
        return response()->json(['pendentes' => $pendentes]);
    }
}
