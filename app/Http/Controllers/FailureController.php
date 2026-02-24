<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineFailure;
use App\Models\MachineFailureSubcategory;

class FailureController extends Controller
{
    public function index()
    {
        $failures = MachineFailure::orderBy('id', 'desc')->get();
        $failuresSubcategories = MachineFailureSubcategory::orderBy('id', 'desc')->get();
        return view(
            'app.paradas_de_maquinas.failures',
            [
                'failures' => $failures,
                'failuresSubcategories' => $failuresSubcategories
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable'
        ]);

        MachineFailure::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()
            ->route('failures.index')
            ->with('success', 'Falha cadastrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable'
        ]);

        $failure = MachineFailure::findOrFail($id);

        $failure->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()
            ->route('failures.index')
            ->with('success', 'Falha atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $failure = MachineFailure::findOrFail($id);
        $failure->delete();

        return redirect()
            ->route('failures.index')
            ->with('success', 'Falha excluída com sucesso!');
    }

    public function subcategoriesUpdate(Request $request, $id)
    {
        // Validação
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Buscar subcategoria
        $subcategory = MachineFailureSubcategory::findOrFail($id);

        // Atualizar dados
        $subcategory->name = $request->name;
        $subcategory->description = $request->description;
        $subcategory->save();

        // Redirecionar
        return redirect()
            ->route('failures.index')
            ->with('success', 'Subcategoria atualizada com sucesso!');
    }
    public function  subcategoriesstore(Request $request)
    {

        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'failure_id' => 'required|exists:machine_failures,id'
            ]);

            MachineFailureSubcategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'machine_failure_id' => $request->failure_id,
                'active' =>1,
            ]);

            return back()->with('success', 'Subcategoria criada com sucesso!');
        } catch (\Exception $e) {

            return back()->with('error', 'Erro ao criar subcategoria.');
        }
    }
}
