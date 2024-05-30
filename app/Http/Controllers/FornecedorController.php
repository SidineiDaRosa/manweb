<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fornecedores=Fornecedor::all();
        return view('app.fornecedor.index', ['fornecedores'=>$fornecedores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fornecedores=Fornecedor::all();
        return view('app.fornecedor.create', ['fornecedores'=>$fornecedores]);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Fornecedor::create($request->all());
        return redirect()->route('fornecedor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fornecedor $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function show(Fornecedor $fornecedor)
    {
        return view('app.fornecedor.show', ['fornecedor'=>$fornecedor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fornecedor $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Fornecedor $fornecedor)
    {
        return view('app.fornecedor.edit', ['fornecedor'=>$fornecedor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Fornecedor $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $fornecedor->update($request->all());
        return redirect()->route('fornecedor.show', ['fornecedor'=>$fornecedor]);
    }

   
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();
        return redirect()->route('fornecedor.index');
    }
}
