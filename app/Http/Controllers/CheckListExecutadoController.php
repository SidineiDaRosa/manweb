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
        if ($request->equipamento_id) {
            $check_list = CheckList::where('equipamento_id', $request->equipamento_id)
                ->where('natureza', $request->natureza)
                ->get();
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
     */ public function store(Request $request)
    {

        // Validação básica
        $validated = $request->validate([
            'check_list_id' => 'required|integer|exists:check_list,id',
            'equipamento_id' => 'required|exists:equipamentos,id',
            'gravidade' => 'required|integer|between:1,4',
            'observacao' => 'max:255',
            'temperatura' => 'max:255',
            'vibracao' => 'max:255',
            'funcionario' => 'max:255',
        ]);

        // Se gravidade é gravíssimo, valida e salva a imagem obrigatória
        $imagemPath = null;
        if ($request->gravidade == 4) {
            $request->validate([
                'imagem_checklist' => 'required|image|mimes:jpeg,png,jpg|max:10048',
            ]);

            if ($request->hasFile('imagem_checklist')) {
                $file = $request->file('imagem_checklist');
                $nomeArquivo = 'imagem_checklist_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/checklist_img'), $nomeArquivo);
                $imagemPath = 'images/checklist_img/' . $nomeArquivo;
            } else {
                return response()->json(['message' => 'Imagem obrigatória para gravidade Gravíssimo'], 422);
            }
        }
        if ($validated['gravidade'] > 1) {
            $status_checagem = 'Pendente';
        } else {
            $status_checagem = 'OK';
        }

        $checkListCheked = new CheckListExecutado();
        $checkListCheked->check_list_id = $validated['check_list_id'];
        $checkListCheked->equipamento_id = $validated['equipamento_id'];
        $checkListCheked->gravidade = $validated['gravidade'];
        $checkListCheked->observacao = $validated['observacao'] ?? null;
        $checkListCheked->temperatura = $validated['temperatura'] ?? null;
        $checkListCheked->vibracao = $validated['vibracao'] ?? null;
        $checkListCheked->funcionario = $validated['funcionario'] ?? null;
        $checkListCheked->imagem = $imagemPath; // Salva o caminho da imagem aqui
        $checkListCheked->data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString();
        $checkListCheked->hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString();
        $checkListCheked->status = $status_checagem;

        // ... seu restante de lógica para salvar, atualizar datas e retornar view

        // Exemplo simples:
        $checkListCheked->save();

        //-------------------------------------------------------------------------------------//
        // Atualiza a data da ultima verificação  diferente de gravissímo
        //
        $checkList = CheckList::find($request->check_list_id); // Encontra o registro pelo ID
        if ($checkList) {
            $checkList->data_verificacao = Carbon::now('America/Sao_Paulo')->toDateString();
            $checkList->hora_verificacao = Carbon::now('America/Sao_Paulo')->toTimeString();
            $checkList->save(); // Atualiza o registro existente no banco de dados
        }
        // Atualize a data/hora do checklist original se quiser...
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

        $dataInicioStr = $request->data_inicio; // Data para teste

        // Tentamos criar uma instância do Carbon com o formato 'Y-m-d'
        try {
            $dataInicio = Carbon::createFromFormat('Y-m-d', $dataInicioStr);

            // Verificamos se a data é válida
            if ($dataInicio->format('Y-m-d') === $dataInicioStr) {

                $check_list_executado = CheckListExecutado::where('equipamento_id', $request->equipamento_id)
                    ->whereBetween('data_verificacao', [$request->data_inicio, $request->data_fim])
                    ->where('gravidade', $request->natureza)
                    ->orderBy('data_verificacao', 'desc')->get();

                return view('app.check_list.check_list_executado', [
                    'equipamento' => $equipamento,
                    'check_list_executado' => $check_list_executado
                ]);
            } else {

                $check_list_executado = CheckListExecutado::where('equipamento_id', $request->equipamento_id)
                    ->orderBy('data_verificacao', 'desc')->get();
                return view('app.check_list.check_list_executado', [
                    'equipamento' => $equipamento,
                    'check_list_executado' => $check_list_executado
                ]);
            }
        } catch (\Exception $e) {
            //Caso a data não exitir busca todas com gravidade acima de 2
            $check_list_executado = CheckListExecutado::where('equipamento_id', $request->equipamento_id)
                ->where('gravidade', '>=', 2)
                ->orderBy('data_verificacao', 'desc')->get();
            return view('app.check_list.check_list_executado', [
                'equipamento' => $equipamento,
                'check_list_executado' => $check_list_executado
            ]);
        }
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
    public function checklist_executado(Request $request)
    {
        $query = CheckListExecutado::query();

        // 🔹 Filtro por descrição (na tabela check_lists)
        if ($request->filled('descricao')) {
            $query->whereHas('checkList', function ($q) use ($request) {
                $q->where('descricao', 'like', '%' . $request->descricao . '%');
            });
        } else {
            // Se não tiver descrição, traz só os últimos 20
            $query->latest()->take(20);
        }

        // 🔹 Filtro por data início
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_verificacao', '>=', $request->data_inicio);
        }

        // 🔹 Filtro por data fim
        if ($request->filled('data_fim')) {
            $query->whereDate('data_verificacao', '<=', $request->data_fim);
        }

        // 🔹 Filtro por gravidade
        if ($request->filled('natureza')) {
            $query->where('gravidade', $request->natureza);
        }

        // ✅ **AQUI ENTRA O FILTRO DE EQUIPAMENTO (o que você pediu)**
        if ($request->filled('equipamento')) {
            $query->where('equipamento_id', $request->equipamento);
        }

        $check_list_executado = $query
            ->with('checkList')
            ->latest()
            ->get();

        $equipamentos = Equipamento::all();

        return view('app.check_list.checklist_ok', [
            'check_list_executado' => $check_list_executado,
            'natureza' => $request->natureza,
            'equipamentos' => $equipamentos
        ]);
    }
}
