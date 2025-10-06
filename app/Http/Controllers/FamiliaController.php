<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familia;
use App\Models\Categoria;

class FamiliaController extends Controller
{
    // Lista todas as famílias
    public function index()
    {
        $familias = Familia::with('categoria')->get(); // já traz a categoria relacionada
        return view('app.familia.index', compact('familias'));
    }

    // Formulário de criação
    public function create(Request $request)
    {
        $categoria_id = $request->categoria_id; // opcional, se vier da categoria
        return view('app.familia.create', compact('categoria_id'));
    }

    // Salvar nova família
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:300',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Familia::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('categoria.show', $request->categoria_id)
                         ->with('success', 'Família criada com sucesso!');
    }

    // Formulário de edição
    public function edit($id)
    {
        $familia = Familia::findOrFail($id);
        return view('app.familia.edit', compact('familia'));
    }

    // Atualizar família
    public function update(Request $request, $id)
    {
        $familia = Familia::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:300',
        ]);

        $familia->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('categoria.show', $familia->categoria_id)
                         ->with('success', 'Família atualizada com sucesso!');
    }

    // Excluir família
    public function destroy($id)
    {
        $familia = Familia::findOrFail($id);
        $categoria_id = $familia->categoria_id;
        $familia->delete();

        return redirect()->route('categoria.show', $categoria_id)
                         ->with('success', 'Família excluída com sucesso!');
    }
}
