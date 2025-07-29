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
        //-------------------------------------//
        // ✅ Lista completa para filtrar manualmente
        $checklists = CheckList::with('equipamento')->get();

        // ✅ Contadores por natureza com base no vencimento real (updated_at + intervalo)
        $contChListMec = $checklists->filter(function ($c) {
            return $c->natureza === 'Mecânico' && $this->isChecklistVencido($c);
        })->count();

        $contChListElet = $checklists->filter(function ($c) {
            return $c->natureza === 'Elétrico' && $this->isChecklistVencido($c);
        })->count();

        $contChListCiv = $checklists->filter(function ($c) {
            return $c->natureza === 'Civíl' && $this->isChecklistVencido($c);
        })->count();

        $contChListOpe = $checklists->filter(function ($c) {
            return $c->natureza === 'Operacional' && $this->isChecklistVencido($c);
        })->count();
        // Notificações de inregularidades encontradas nas checagens

        // ✅ Irregularidades nos últimos 15 dias
        $quinzeDiasAtras = Carbon::now()->subDays(15);
        $checkListExcAlerts = CheckListExecutado::where('gravidade', '>=', 2)
            ->whereNotNull('data_verificacao')
            ->where('data_verificacao', '>=', $quinzeDiasAtras)
            ->get();

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
                'contChListOpe' => $contChListOpe
            ]);
        } else {
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
    private function isChecklistVencido($check)
    {
        if (is_null($check->updated_at)) return true;

        $prazo = $check->updated_at->copy()->addMinutes($check->intervalo ?? 0);
        return $prazo->lessThanOrEqualTo(now());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ public function store(Request $request)
    {

        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'descricao' => 'required|string|max:255',
            'equipamento_id' => 'required|integer|exists:equipamentos,id',
            'intervalo' => 'required|integer|min:1',
            'natureza' => 'required|string',
        ]);

        // Criação do checklist com os dados validados
        $checkList = CheckList::create($validatedData);

        // Consulta dos dados para a view
        $equipamentos = Equipamento::all();
        $equipamento = Equipamento::with('checkLists')->find($validatedData['equipamento_id']);
        $check_list = $equipamento?->checkLists ?? collect();

        $equipamentos = Equipamento::all();
        $check_list = CheckList::where('equipamento_id', $request->equipamento_id)->get();
        $equipamento = Equipamento::find($request->equipamento_id);

        return view('app.check_list.index', [
            'equipamentos' => $equipamentos,
            'equipamento' => $equipamento,
            'check_list' => $check_list,
        ]);
    }

    public function show(Request $request)
    {
        $equipamento_id = $request->get('equipamento_id');
        $equipamento = Equipamento::find($equipamento_id);

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
        // Executado por um ajax no ToolBar reader para mostrar as notificações
        $pendentes = CheckList::all()->filter(function ($check) {
            // Se nunca foi verificado (ambos nulos)
            if (is_null($check->data_verificacao) || is_null($check->hora_verificacao)) {
                return true;
            }

            // Junta data + hora numa instância Carbon
            $verificacao = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $check->data_verificacao . ' ' . $check->hora_verificacao);

            // Adiciona o intervalo
            $prazo = $verificacao->copy()->addMinutes($check->intervalo ?? 0);

            // Se o prazo já passou, está pendente/atrasado
            return $prazo->lessThanOrEqualTo(now());
        });

        return response()->json(['pendentes' => $pendentes->count()]);
    }
}
