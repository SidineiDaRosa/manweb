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
                'imagem_checklist' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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

        // ... seu restante de lógica para salvar, atualizar datas e retornar view

        // Exemplo simples:
        $checkListCheked->save();

        // Atualize a data/hora do checklist original se quiser...

        // Retorne a view normalmente
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
}
