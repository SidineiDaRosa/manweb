<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;

class LocalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locais = Local::orderBy('nome')->get();
        return view('app.local.index', compact('locais'));
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
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Local::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            // 'ativo' => $request->has('ativo'),
        ]);

        return redirect()->back()->with('success', 'Local cadastrado com sucesso!');
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
        // Validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        // Busca o registro
        $local = Local::findOrFail($id);

        // Atualiza os dados
        $local->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            //'ativo' => $request->has('ativo') ? 1 : 0,
        ]);

        // Retorno
        return redirect()
            ->route('locais.index')
            ->with('success', 'Local atualizado com sucesso!');
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
    }
}
