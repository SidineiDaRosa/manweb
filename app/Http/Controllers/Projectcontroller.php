<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projetos = Projeto::with('responsavel')->orderBy('id', 'desc')->get();
        return view('app.projetos.index', compact('projetos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $funcionarios = Funcionario::all();
        return view('app.projetos.create', compact('funcionarios'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'status' => 'required|in:ativo,concluido,cancelado',
            'responsavel_id' => 'nullable|exists:funcionarios,id',
        ]);

        Projeto::create($validated);

        // Corrigido: rota sem 'app.'
        return redirect()->route('projetos.index')->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $projeto = Projeto::with('responsavel')->findOrFail($id);
        return view('app.projetos.show', compact('projeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $projeto = Projeto::findOrFail($id);
        $funcionarios = Funcionario::all();
        return view('app.projetos.edit', compact('projeto', 'funcionarios'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $projeto = Projeto::findOrFail($id);

    $validated = $request->validate([
        'nome' => 'required|string|max:100',
        'descricao' => 'nullable|string',
        'data_inicio' => 'nullable|date',
        'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        'status' => 'required|in:ativo,concluido,cancelado',
        'responsavel_id' => 'nullable|exists:funcionarios,id',
    ]);

    $projeto->update($validated);

    // Se quiser redirecionar para a view 'show':
    return redirect()->route('projetos.show', $projeto->id)
                     ->with('success', 'Projeto atualizado com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $projeto = Projeto::findOrFail($id);
        $projeto->delete();

        return redirect()->route('app.projetos.index')->with('success', 'Projeto excluído com sucesso!');
    }
}
