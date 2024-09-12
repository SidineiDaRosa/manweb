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
use App\Models\PecasEquipamentos;
use App\Models\Produto;
use App\Models\UnidadeMedida;
use App\Models\User;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

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
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'pedidos_saida' => $pedidos_saida,
                'emissores' => $emissores
            ]);
        }
        if ($tipoFiltro == 2) {
            $pedidos_saida = PedidoSaida::where('status', $situacao)->get();

            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'pedidos_saida' => $pedidos_saida,
                'emissores' => $emissores
            ]);
        }
        if ($tipoFiltro == 4) {

            $pedidos_saida = PedidoSaida::where('ordem_servico_id', $ordem_servico)->get();
            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'pedidos_saida' => $pedidos_saida,
                'emissores' => $emissores
            ]);
        }
        if ((empty($tipoFiltro))) {
            $pedidos_saida = PedidoSaida::where('id', 2)->get();
            return view('app.pedido_saida.index', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'pedidos_saida' => $pedidos_saida,
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
        $patrimonio_id = $requ->get('equipamento_id');
        if ($ordem_servico_id == 0) {
            //  Cria um pedido de saída sem necessidade de uma OS
            $pedidos_saida = PedidoSaida::all();
            $equipamentos = Equipamento::orderBy('nome')->get();
            $funcionarios = Funcionario::all();
            $empresa = Empresas::find(2);
            $fornecedores = Fornecedor::all();
            return view('app.pedido_saida.create', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'fornecedores' => $fornecedores,
                'empresa' => $empresa
            ]);
        } else {
            //--------------------------------------------------------//
            //   Cria um pedido de sáida apartir do numero da o.s.
            //-------------------------------------------------------//
            $ordem_servico = OrdemServico::where('id', $ordem_servico_id)->get();
            $pedidos_saida = PedidoSaida::all();
            $equipamentos = Equipamento::all();
            $funcionarios = Funcionario::all();
            $empresas = Empresas::all();
            $fornecedores = Fornecedor::all();
            $os = OrdemServico::find($ordem_servico_id);
            $pecas_equipamento = PecasEquipamentos::where('equipamento', $os->equipamento_id)->where('tipo_componente', 'Componente')
                ->where('status', 'ativado')->get();

            $patrimonio = Equipamento::where('id', $os->equipamento_id)->get();
            return view('app.pedido_saida.create_os', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'pedidos_saida' => $pedidos_saida,
                'ordem_servico' => $ordem_servico,
                'fornecedores' => $fornecedores,
                'patrimonio' => $patrimonio,
                'pecas_equipamento' => $pecas_equipamento
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
        $equipamentos = Equipamento::all(); // Busca todos os equipamentos
        $funcionarios = Funcionario::all(); // Busca todos os funcionários
        $emissores = User::all();
        if ($ordem_servico >= 1) {
            $categorias = Categoria::all();
            $Unidades_de_Medida = UnidadeMedida::all();
            $pedido_saida_id = PedidoSaida::where('ordem_servico_id', $ordem_servico)->latest()->first();
            $saidas_produto = SaidaProduto::where('pedidos_saida_id', $pedido_saida_id)->get();
            $pedidos_saida = PedidoSaida::where('id', $pedido_saida_id->id)->get();
            // Realize a busca com com produto 0
            $produtos = Produto::where('id', 0)->get();
            $pecas_equipamento = PecasEquipamentos::where('equipamento', $pedido_saida_id->equipamento_id)->where('tipo_componente', 'Componente')
                ->where('status', 'ativado')->get();
            $patrimonio = Equipamento::where('id', $pedido_saida_id->equipamento_id)->get();
            return view('app.pedido_saida_lista.index', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'saidas_produto' => $saidas_produto,
                'pedidos_saida' =>  $pedidos_saida,
                'Unidades_de_Medida' => $Unidades_de_Medida,
                'patrimonio' => $patrimonio,
                'pecas_equipamento' => $pecas_equipamento,
                'produtos' => $produtos,
                'categorias' => $categorias
            ]);
        } else {
            // 
            //   Cria um pedido sem adição da os
            $categorias = Categoria::all();
            $ultimo_pedido_saida = PedidoSaida::where('ordem_servico_id', $ordem_servico)->latest()->first();
            $pedido_saida = PedidoSaida::where('ordem_servico_id', $ordem_servico)->get();
            $produtos = Produto::orderBy('nome')->get();
            $equipamentos = Equipamento::all();
            return view('app.pedido_saida.show', [
                'pedido_saida' => $ultimo_pedido_saida,
                'categorias' => $categorias,
                'produtos' => $produtos,
                'equipamentos' => $equipamentos
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
        $equipamentos = Equipamento::all();
        return view('app.pedido_saida.show', [ // abre o pedido sem a O.S.
            'pedido_saida' => $pedido_saida,
            'categorias' => $categorias,
            'produtos' => $produtos,
            'saidas_produtos' => $saidas_produtos,
            'equipamentos' => $equipamentos
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
            'equipamentos' => $equipamentos,
            'emissor' => $emissor,
            'pedidos_saida' => $pedidoSaida,
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
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'pedidos_saida' => $pedidos_saida,
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
        
            $pedido = PedidoSaida::findOrFail($id);
            $pedido->delete();
    
            return back()->with('success', 'Pedido de saída deletado com sucesso!');
       
    }
}
