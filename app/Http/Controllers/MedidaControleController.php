<?php

namespace App\Http\Controllers;

use App\Models\Risco;
use App\Models\RiscoMedida;
use App\Models\RiscoMedidaControle;
use Illuminate\Http\Request;

class MedidaControleController extends Controller
{


    public function index($id)
    {
        $risco = Risco::with('medidas')->findOrFail($id);
        return view('app.SESMT.medida_controle.index', compact('risco'));
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string',
        ]);

        RiscoMedidaControle::create([
            'risco_id' => $id,
            'descricao' => $request->descricao
        ]);

        return redirect()->back()->with('success', 'Medida cadastrada com sucesso!');
    }
}
