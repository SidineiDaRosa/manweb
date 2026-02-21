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
            ['failures' => $failures,
            'failuresSubcategories'=> $failuresSubcategories 
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
}
