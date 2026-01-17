<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialEpi;
use App\Models\MaterialRisco;

class MaterialEpiController extends Controller
{
    public function index()
    {
        $materiais = MaterialEpi::with('riscos')->get();
        $materiais_risco=MaterialRisco::all();
        return view('app.material_epi.index', compact('materiais','materiais_risco'));
    }


    public function create()
    {
        return view('app.material_epi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:100',
            'ca' => 'nullable|string|max:50',
            'validade' => 'nullable|date',
            'quantidade_estoque' => 'nullable|integer|min:0',
        ]);

        MaterialEpi::create($request->all());

        return redirect()->route('app.material_epi.index')->with('success', 'Material/EPI cadastrado com sucesso!');
    }

    public function show($id)
    {
        $material = MaterialEpi::findOrFail($id);
        return view('app.material_epi.show', compact('material'));
    }

    public function edit($id)
    {
        $material = MaterialEpi::findOrFail($id);
        return view('app.material_epi.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = MaterialEpi::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:100',
            'ca' => 'nullable|string|max:50',
            'validade' => 'nullable|date',
            'quantidade_estoque' => 'nullable|integer|min:0',
        ]);

        $material->update($request->all());

        return redirect()->route('app.material_epi.index')->with('success', 'Material/EPI atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $material = MaterialEpi::findOrFail($id);
        $material->delete();

        return redirect()->route('app.material_epi.index')->with('success', 'Material/EPI excluído com sucesso!');
    }
}
