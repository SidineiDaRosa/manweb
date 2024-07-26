<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\PedidoCompra;
use App\Models\Empresas;
use App\Models\PedidoSaida;
use App\Models\SaidaProduto;
use App\Models\Fornecedor;
use App\Models\OrdemServico;
use App\Models\Produto;
use App\Models\User;

class PedidosSaidaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ordem_servico = $request->get('ordem_servico');

        $tipoFiltro = $request->get('tipofiltro');
        $situacao = $request->get('status');
        $produto = $request->get('produto');
        $data_inicio = $request->get('data_inicio');
        $data_fim = $request->get('data_fim');
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $empresas = Empresas::all();
        $emissores = User::all();
        if ($tipoFiltro == 1) {
            $pedidos_saida = PedidoSaida::where('status', $situacao)->whereBetween('data_emissao', [$data_inicio, $data_fim])->get();
            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_saida' => $pedidos_saida,
                'emissores' => $emissores
            ]);
        }
        if ($tipoFiltro == 2) {
            $pedidos_saida = PedidoSaida::where('status', $situacao)->get();

            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_saida' => $pedidos_saida,
                'emissores' => $emissores
            ]);
        }
        if ($tipoFiltro == 4) {

            $pedidos_saida = PedidoSaida::where('ordem_servico_id', $ordem_servico)->get();
            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_saida' => $pedidos_saida,
                'emissores' => $emissores
            ]);
        }
        if ((empty($tipoFiltro))) {
            $pedidos_saida = PedidoSaida::where('id', 2)->get();
            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_saida' => $pedidos_saida,
                'emissores' => $emissores
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $requ)
    {
        //
        $ordem_servico_id = $requ->get('ordem_servico');
        if ($ordem_servico_id == 0) {
            //  Cria um pedido de saída sem nescidade de uma OS
            $pedidos_saida = PedidoSaida::all();
            $equipamentos = Equipamento::orderBy('nome')->get();
            $funcionarios = Funcionario::all();
            $empresa= Empresas::find(2);
            $fornecedores = Fornecedor::all();
            return view('app.pedido_saida.create', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios,
                'fornecedores' => $fornecedores,
                'empresa'=>$empresa
            ]);
        } else {
            $ordem_servico = OrdemServico::where('id', $ordem_servico_id)->get();
            $pedidos_saida = PedidoSaida::all();
            $equipamentos = Equipamento::all();
            $funcionarios = Funcionario::all();
            $empresas = Empresas::all();
            $fornecedores = Fornecedor::all();
            echo ($ordem_servico_id);
            return view('app.pedido_saida.create_os', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios,
                'pedidos_saida' => $pedidos_saida, 'ordem_servico' => $ordem_servico,
                'fornecedores' => $fornecedores
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //
        $ordem_servico = $req->get('ordem_servico_id');
        PedidoSaida::create($req->all());
        $pedido_saida = PedidoSaida::where('ordem_servico_id', $ordem_servico)->get();
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $emissores = User::all();
        if ($ordem_servico >= 1) {
            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_saida' => $pedido_saida,
                'emissores' => $emissores
            ]);
        } else {
            // 
            //   Cria um pedido sem adição da os
            $categorias = Categoria::all();
            $ultimo_pedido_saida = PedidoSaida::where('ordem_servico_id', $ordem_servico)->latest()->first();
            $pedido_saida = PedidoSaida::where('ordem_servico_id', $ordem_servico)->get();
            $produtos = Produto::orderBy('nome')->get();
            return view('app.pedido_saida.show', [
                'pedido_saida' => $ultimo_pedido_saida,
                'categorias' => $categorias,
                'produtos' => $produtos
            ]);
        }
    }
    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $id)
    {
        $os = $request->get('os');
       
            $categorias = Categoria::all();
            $pedido_saida = PedidoSaida::find($id);
            $produtos = Produto::orderBy('nome')->get();

        $saidas_produtos = SaidaProduto::where('pedidos_saida_id', $id)->get();
           return view('app.pedido_saida.show', [
            'pedido_saida' => $pedido_saida,
             'categorias' => $categorias,
                'produtos' => $produtos,
                'saidas_produtos'=>$saidas_produtos
         ]);
    }
    /**
     * Show the form for editing the specified resource.
     * @param  \App\PedidoSaida  $PedidoSaida
     * @return \Illuminate\Http\Response
     */

    public function edit(PedidoSaida $pedidoSaida)
    {
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $empresa = Empresas::find($pedidoSaida->empresa_id);
        $fornecedores = Fornecedor::all();
        $emissor = User::find($pedidoSaida->funcionarios_id);
        return view('app.pedido_saida.edit', [
            'equipamentos' => $equipamentos, 'emissor' => $emissor, 'pedidos_saida' => $pedidoSaida,
            'empresa' => $empresa,
            'fornecedores' => $fornecedores,
        ]);
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
        $pedidoSaida = PedidoSaida::findOrFail($id);

        $pedidoSaida->data_prevista = $request->input('data_prevista');
        $pedidoSaida->hora_prevista = $request->input('hora_prevista');
        $pedidoSaida->descricao = $request->input('descricao');
        $pedidoSaida->status = $request->input('status');
        // Adicione outras atualizações de campo conforme necessário

        $pedidoSaida->save();

        $pedidosSaida = PedidoSaida::where('id', $pedidoSaida->empresa_id)->get();
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $empresa = Empresas::find(2);
        $pedidos_saida = PedidoSaida::where('id', $id)->get();
        $emissores = User::all();
        return view('app.pedido_saida.index', [
            'equipamentos' => $equipamentos, 'funcionarios' => $funcionarios, 'pedidos_saida' => $pedidos_saida,
            'emissores' => $emissores
        ]);
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
