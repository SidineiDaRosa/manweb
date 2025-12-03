<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funcionarios = Funcionario::orderBy('id', 'asc')->get();
        return view('app.funcionario.index', compact('funcionarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.funcionario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {
        // echo ($request);
        // Validação de todos os campos obrigatórios
        $request->validate([
            'primeiro_nome' => 'required|string|max:255',
            'ultimo_nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf',
            'rg' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'num_casa' => 'required|string|max:10',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'uf' => 'required|string|max:2',
            'funcao' => 'required|string|max:255',
            'user' => 'required|integer',
            'status' => 'required|string|max:10',
        ]);

        // Criar novo funcionário
        Funcionario::create($request->all());

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('app.funcionario.show', compact('funcionario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('app.funcionario.edit', compact('funcionario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        // Validação de todos os campos obrigatórios
        $request->validate([
            'primeiro_nome' => 'required|string|max:255',
            'ultimo_nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $id,
            'rg' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'num_casa' => 'required|string|max:10',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'uf' => 'required|string|max:2',
            'funcao' => 'required|string|max:255',
            'user' => 'required|integer',
            'status' => 'required|string|max:10',
        ]);

        // Atualizar funcionário
        $funcionario->update($request->all());

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->delete();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário excluído com sucesso!');
    }
}
