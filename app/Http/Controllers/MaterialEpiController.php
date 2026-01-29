<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialEpi;
use App\Models\MaterialRisco;
use App\Models\Risco;


class MaterialEpiController extends Controller
{
    public function index()
    {
        $materiais = MaterialEpi::with('riscos')->get();
        $materiais_risco = MaterialRisco::all();
        return view('app.material_epi.index', compact('materiais', 'materiais_risco'));
    }


    public function create()
    {
        return view('app.material_epi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string',
            'ca' => 'nullable|string|max:100',
            'validade' => 'nullable|date',
            'quantidade_estoque' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ]);

        MaterialEpi::create($request->all());

        return redirect()->back()->with('success', 'Material/EPI cadastrado com sucesso!');
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

        $material->nome = $request->nome;
        $material->tipo = $request->tipo;
        $material->ca = $request->ca;
        $material->validade = $request->validade;
        $material->quantidade_estoque = $request->quantidade_estoque;
        $material->status = $request->status;
        $material->save();

        return redirect()->route('material_epis.index')->with('success', 'Material atualizado com sucesso!');
    }
    public function destroy($id)
    {
        $material = MaterialEpi::findOrFail($id);

        // Verifica se existem riscos vinculados
        if ($material->riscos()->count() > 0) {
            return redirect()->route('app.material_epi.index')
                ->with('error', 'Não é possível excluir este material/EPI pois existem riscos vinculados.');
        }

        $material->delete();

        return redirect()->route('app.material_epi.index')
            ->with('success', 'Material/EPI excluído com sucesso!');
    }
    public function epis_index($id)
    {
        echo ('epis');
        $risco = Risco::with('materiais.material')->findOrFail($id);
        $materiais_epis = MaterialEpi::all();

        return view('app.SESMT.epi.index', compact('risco', 'materiais_epis'));
    }
    public function store_epi(Request $request, $riscoId)
    {
        $request->validate([
            'material_id' => 'required|exists:materiais,id',
            'status' => 'required|boolean',
            'observacoes' => 'nullable|string',
        ]);

        MaterialRisco::create([
            'risco_id' => $riscoId,
            'material_id' => $request->material_id,
            'status' => $request->status,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()->back()->with('success', 'EPI vinculado com sucesso!');
    }
    public function update_material_risco(Request $request, $id)
    {
        $request->validate([
            'material_id' => 'required|exists:materiais,id',
            'status' => 'required|boolean',
            'observacoes' => 'nullable|string',
        ]);

        $vinculo = MaterialRisco::findOrFail($id);

        $vinculo->update([
            'material_id' => $request->material_id,
            'status' => $request->status,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()->back()->with('success', 'EPI do risco atualizado com sucesso!');
    }
}
