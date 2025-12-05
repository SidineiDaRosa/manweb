<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;

class APRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
{
    // Dados fictícios de ordens de serviço
    $ordens = [
        (object)['id' => 1, 'titulo' => 'Manutenção preventiva do motor'],
        (object)['id' => 2, 'titulo' => 'Inspeção elétrica painel 01'],
        (object)['id' => 3, 'titulo' => 'Lubrificação máquina A'],
    ];

    // Dados fictícios de ativos
    $ativos = [
        (object)['id' => 1, 'nome' => 'Máquina A'],
        (object)['id' => 2, 'nome' => 'Painel elétrico 01'],
        (object)['id' => 3, 'nome' => 'Motor principal'],
    ];

    return view('app.SESMT.index', compact('ordens', 'ativos'));
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
        //
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
