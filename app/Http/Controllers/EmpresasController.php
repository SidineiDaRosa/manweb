<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ public function index(Request $request)
    {
        $busca = $request->input('empresa1');

        $empresas = Empresas::query()
            ->when($busca, function ($query) use ($busca) {
                $query->where('razao_social', 'like', "%{$busca}%")
                    ->orWhere('nome_fantasia', 'like', "%{$busca}%")
                    ->orWhere('cnpj', 'like', "%{$busca}%");
            })
            ->orderBy('razao_social')
            ->get();

        return view('app.empresa.index', compact('empresas'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa = Empresas::all();
        return view('app.empresa.create', ['empresa' => $empresa]); //

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
        Empresas::create($request->all());
        return redirect()->route('empresas.index');
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\Empresas  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresas $empresa)
    {

        //
        //dd($empresa);
        return view('app.empresa.show', ['empresa' => $empresa]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresas $empresa)
    {
        $cadastro_empresa = Empresas::find($empresa->id);
        return view('app.empresa.edit', ['empresa' => $cadastro_empresa]);
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
        //
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
