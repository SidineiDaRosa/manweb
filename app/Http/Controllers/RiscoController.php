<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risco;

class RiscoController extends Controller
{
    public function index()
    {
        $riscos = Risco::orderBy('id')->get();
        return view('app.SESMT.risco.risco', compact('riscos'));
    }
    public function update(Request $request, $id)
    {
        $risco = Risco::findOrFail($id);

        $risco->update($request->all());

        return redirect()->back()->with('success', 'Risco atualizado com sucesso!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo_risco' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ativo' => 'required|boolean',
        ]);

        Risco::create($request->all());

        return redirect()->back()->with('success', 'Risco cadastrado com sucesso!');
    }
}
