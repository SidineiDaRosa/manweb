<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\PedidoCompra;

class PedidoCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $situacao = $request->get('situacao');
        if (isset($situacao)) {
            // A variável $situacao está declarada
            // Faça alguma coisa aqui
            $equipamentos = Equipamento::all();
            $funcionarios = Funcionario::all();
            $pedidos_compra = PedidoCompra::where('status',$situacao)->get();
            return view('app.pedido_compra.index', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_compra' => $pedidos_compra
            ]);
        } else {
            // A variável $situacao não está declarada
            // Faça alguma outra coisa aqui
            $equipamentos = Equipamento::all();
            $funcionarios = Funcionario::all();
            $pedidos_compra = PedidoCompra::where('status','')->get();
            return view('app.pedido_compra.index', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_compra' => $pedidos_compra
            ]);
        }
        //
    }
    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$patrimonio_id = $request->get('equipamento_id');
        $patrimonio_id = $request->get('equipamento_id');
        $funcionarios = Funcionario::all();
        $patrimonio_f = Equipamento::where('id', $patrimonio_id)->get();
        $patrimonio = Equipamento::find($patrimonio_id); // Utilize find() para encontrar um único registro
        $patrimonio_id = $patrimonio->id;
        $empresa_id = $patrimonio->empresa_id; // Acesse diretamente o atributo empresa_id do equipamento encontrado
        $empresa = Empresas::where('id', $empresa_id)->get();
        return view('app.pedido_compra.create', [
            'funcionarios' => $funcionarios,
            'patrimonio_id' => $patrimonio_id,
            'empresa' => $empresa,
            'patrimonio_f' => $patrimonio_f
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedidoCompra = PedidoCompra::where('hora_prevista', $request->hora_prevista)->first();

        if ($pedidoCompra) {
            return response()->json(['error' => 'Já existe um registro com essa hora prevista!']);
        }

        PedidoCompra::updateOrCreate(['id' => $request->id], $request->all());
        return response()->json(['success' => 'Registro gravado com sucesso!']);
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
     * @param App\Models\PedidoCompra $pedido_compra_id
     * @return \Illuminate\Http\Response
     */
    public function edit($pedido_compra_id)
    {
        $pedido_compra = PedidoCompra::find($pedido_compra_id);
        dd($pedido_compra);
        die(); // Garante que a execução pare aqui
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
