<?php

namespace App\Http\Controllers;

use App\Models\MensagemPainel;
use Illuminate\Http\Request;

class MensagemPainelController extends Controller
{
    //-------------------------------------------------------------
    // Lista todas as mensagens (Admin)
    //-------------------------------------------------------------
    public function index()
    {
        $mensagens = MensagemPainel::orderBy('ordem')->get();
        return view('app.mensagem_painel.index', compact('mensagens'));
    }

    //-------------------------------------------------------------
    // Formulário para criar nova mensagem
    //-------------------------------------------------------------
    public function create()
    {
        return view('app.mensagem_painel.create');
    }

    //-------------------------------------------------------------
    // Salva nova mensagem no banco
    //-------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string',
            'tipo'     => 'required|in:info,alerta,urgente',
            'ativo'    => 'required|boolean',
            'inicio'   => 'nullable|date',
            'fim'      => 'nullable|date|after_or_equal:inicio',
            'ordem'    => 'nullable|integer',
        ]);

        MensagemPainel::create($request->all());

        return redirect()
            ->route('mensagens.index') // Aqui é o nome da rota Resource
            ->with('success', 'Mensagem criada com sucesso');
    }

    //-------------------------------------------------------------
    // Formulário para editar mensagem existente
    //-------------------------------------------------------------
    public function edit(MensagemPainel $mensagem)
    {
        return view('app.mensagem_painel.edit', compact('mensagem'));
    }

    //-------------------------------------------------------------
    // Atualiza mensagem existente
    //-------------------------------------------------------------
    public function update(Request $request, MensagemPainel $mensagem)
    {
        $request->validate([
            'mensagem' => 'required|string',
            'tipo'     => 'required|in:info,alerta,urgente',
            'ativo'    => 'required|boolean',
            'inicio'   => 'nullable|date',
            'fim'      => 'nullable|date|after_or_equal:inicio',
            'ordem'    => 'nullable|integer',
        ]);

        $mensagem->update($request->all());

        return redirect()
            ->route('mensagens.index')
            ->with('success', 'Mensagem atualizada com sucesso');
    }

    //-------------------------------------------------------------
    // Remove mensagem
    //-------------------------------------------------------------
    public function destroy(MensagemPainel $mensagem)
    {
        $mensagem->delete();

        return redirect()
            ->route('mensagens.index')
            ->with('success', 'Mensagem removida com sucesso');
    }

    //-------------------------------------------------------------
    // Mensagens ativas para exibição no painel (somente dentro do período)
    //-------------------------------------------------------------
    public function mensagensAtivas()
    {
        // Pega apenas mensagens ativas
        $mensagens = MensagemPainel::where('ativo', 1)
            ->orderBy('ordem')
            ->get();

        // Retorna como JSON
        return response()->json($mensagens);
    }
}
