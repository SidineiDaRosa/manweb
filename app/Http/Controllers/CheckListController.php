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
    public function index(Request $request)
    {

        $dataLimite = Carbon::now()->subDays(13);
        //
        $check_list = CheckList::where('id', 0)->get();
        $type = $request->type;


        // Obtém todos os equipamentos ordenados pelo nome
        $equipamentos = Equipamento::orderBy('nome', 'asc')->get();
        $equipamento = Equipamento::find(0);
        //-------------------------------------//
        //  Cont check-list group
        // Função para contar checklists atrasados por especialidade
        function contarAtrasadosPorEspecilidade($especialidade)
        {
            return CheckList::where('natureza', $especialidade)
                ->get()
                ->filter(function ($item) {
                    $ultimaVerificacao = Carbon::parse($item->data_verificacao . ' ' . $item->hora_verificacao);
                    $proxVerificacao = $ultimaVerificacao->addHours($item->intervalo);
                    return $proxVerificacao <= now();
                })
                ->count();
        }

        // Contagem por grupo
        $contChListMec = contarAtrasadosPorEspecilidade('Mecânico');
        $contChListElet = contarAtrasadosPorEspecilidade('Elétrico');
        $contChListCiv  = contarAtrasadosPorEspecilidade('Civíl');
        $contChListOpe  = contarAtrasadosPorEspecilidade('Operacional');
        $contChListSesmt = contarAtrasadosPorEspecilidade('SESMT');


        //Fim Contagem por grupo
        //---------------------------
        $checkLists = CheckList::all();
        $checkListExcAlerts = collect(); // Coleção vazia para armazenar os alertas

        foreach ($checkLists as $checkList) {
            $ultimoExecutado = CheckListExecutado::where('check_list_id', $checkList->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($ultimoExecutado && $ultimoExecutado->gravidade >= 2) {
                $checkListExcAlerts->push($ultimoExecutado);
            }
        }

        if ($type >= 1) {
            $checkListsOpen = CheckList::where('natureza', '=', $request->nat)->where('data_verificacao', '<=', $dataLimite)->get();
            return view('app.check_list.index', [
                'equipamentos' => $equipamentos,
                'check_list' => $check_list,
                'equipamento' => $equipamento,
                'check_lists_open' => $checkListsOpen,
                'contChListMec' =>  $contChListMec,
                'contChListElet' => $contChListElet,
                'contChListCiv' => $contChListCiv,
                'contChListOpe' => $contChListOpe,
                'checkListExcAlerts' => $checkListExcAlerts
            ]);
        } else {
            $checkListsStatus = CheckList::select('equipamento_id')
                ->selectRaw("
        SUM(
            CASE 
                WHEN TIMESTAMP(
                    COALESCE(data_verificacao, updated_at),
                    COALESCE(hora_verificacao, '00:00:00')
                ) + INTERVAL (intervalo * 0.99) HOUR <= NOW()
                THEN 1 ELSE 0
            END
        ) AS pendentes,
        SUM(
            CASE 
                WHEN TIMESTAMP(
                    COALESCE(data_verificacao, updated_at),
                    COALESCE(hora_verificacao, '00:00:00')
                ) + INTERVAL (intervalo * 0.99) HOUR > NOW()
                THEN 1 ELSE 0
            END
        ) AS executados
    ")
                ->with('equipamento')
                ->groupBy('equipamento_id')
                ->get()
                ->sortBy(fn($checkList) => $checkList->equipamento->nome);

            return view('app.check_list.index', [
                'equipamentos' => $equipamentos,
                'check_list' => $check_list,
                'equipamento' => $equipamento,
                'check_lists_status' => $checkListsStatus,
                'contChListMec' =>  $contChListMec,
                'contChListElet' => $contChListElet,
                'contChListCiv' => $contChListCiv,
                'contChListOpe' => $contChListOpe,
                'checkListExcAlerts' => $checkListExcAlerts
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
        //  Conta check list pendente e envia pra ToolBar
        $pendentes = CheckList::all()->filter(function ($check) {
            // Verifica se existe data e hora de verificação
            if ($check->data_verificacao && $check->hora_verificacao) {
                $ultimo_check = Carbon::parse($check->data_verificacao . ' ' . $check->hora_verificacao);
            } else {
                // fallback para updated_at se data/hora estiverem nulos
                $ultimo_check = Carbon::parse($check->updated_at);
            }

            // Aplica o fator 0.9 sobre o intervalo
            $vencimento = $ultimo_check->addHours($check->intervalo * 0.99);

            // Se a data de vencimento já passou, é pendente
            return $vencimento <= Carbon::now();
        })->count();

        return response()->json(['pendentes' => $pendentes]);
    }
}
