<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busca = $request->input('empresa1');

        $empresas = Empresas::query()
            ->when($busca, function ($query) use ($busca) {
                $query->where('nome1', 'like', "%{$busca}%")
                    ->orWhere('nome2', 'like', "%{$busca}%")
                    ->orWhere('cnpj', 'like', "%{$busca}%"); // documento
            })
            ->orderBy('nome1')
            ->get();

        return view('app.empresa.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.empresa.create'); // não precisa buscar todas
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação básica
        $request->validate([
            'tipo' => 'required|in:F,J',
            'nome1' => 'required|string|max:150',
            'nome2' => 'nullable|string|max:150',
            'cnpj' => 'required|string|max:20', // CPF ou CNPJ
            'cidade' => 'required|string|max:191',
            'estado' => 'required|string|max:50',
        ]);

        Empresas::create($request->all());

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresas $empresa)
    {
        return view('app.empresa.show', ['empresa' => $empresa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresas $empresa)
    {
        return view('app.empresa.edit', ['empresa' => $empresa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empresa = Empresas::findOrFail($id);

        // Validação básica
        $request->validate([
            'nome1' => 'required|string|max:150',
            'nome2' => 'nullable|string|max:150',
            'cidade' => 'required|string|max:191',
            'estado' => 'required|string|max:50',
        ]);

        // Campos que NÃO podem ser alterados
        $dados = $request->except([
            'tipo',    // tipo de pessoa não altera
            'cnpj',    // CPF/CNPJ não altera
            '_token',
            '_method',
        ]);

        $empresa->update($dados);

        return redirect()
            ->route('empresas.show', $empresa->id)
            ->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empresa = Empresas::findOrFail($id);
        $empresa->delete();

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa removida com sucesso!');
    }
}
