<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoCompraLista;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\PedidoCompra;
use App\Models\Produto;
use App\Models\UnidadeMedida;
use App\Models\User;

class PedidoCompraListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Resto do seu código para retornar a view com os dados atualizados
        $produto_id = $request->get('produto_id');
        $pedidoCompraId = $request->get('numpedidocompra');
        $data_inicio = $request->get('data_inicio');
        $data_fim = $request->get('data_fim');
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $unidades_de_medida = UnidadeMedida::all();
        $pedidos_compra = PedidoCompra::where('id', $pedidoCompraId)->get();
        $produtos = Produto::all();
        $emissores = User::all(); //Busca usuarios
        $pedidoCompraLista = PedidoCompraLista::where('pedidos_compra_id', $pedidoCompraId)->get();
        $produto_rg = Produto::where('id', $produto_id)->get();
        //$pedidoCompraLista = PedidoCompraLista::all();
        return view('app.pedido_compra.index_lista', [
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'pedidos_compra' => $pedidos_compra,
            'produto_id' =>  $produto_id,
            'pedido_compra_lista' => $pedidoCompraLista,
            'produtos' => $produtos,
            'unidades_de_medida' => $unidades_de_medida,
            'produto_rg' => $produto_rg,
            'emissores' => $emissores //Envia emissores para a view app.pedido_compra.index_lista
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printer(Request $request)
    {

        // Resto do seu código para retornar a view com os dados atualizados
        $produto_id = $request->get('produto_id');
        //$pedidoCompraId = $request->get('numpedidocompra');
        $pedidoCompraId = $request->numpedidocompra;
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $pedidos_compra = PedidoCompra::where('id', $pedidoCompraId)->get();
        $produtos = Produto::all();
        $unidadeMedida = UnidadeMedida::all();
        $pedidoCompraLista = PedidoCompraLista::where('pedidos_compra_id', $pedidoCompraId)->get();
        //$pedidoCompraLista = PedidoCompraLista::all();
        // Obtenha os dados dos usuários
        $usuarios = User::all();
        return view('app.pedido_compra.printer', [
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'pedidos_compra' => $pedidos_compra,
            'produto_id' =>  $produto_id,
            'pedido_compra_lista' => $pedidoCompraLista,
            'produtos' => $produtos,
            'unidadeMedida' => $unidadeMedida,
            'usuarios'=>$usuarios
        ]);
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
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $patrimonio = Equipamento::where('id', $patrimonio_id)->get();
        $emissores = User::all(); //Busca usuarios
        //$empresa_id=$patrimonio->empresa_id;
        return view('app.pedido_compra.create', [
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'patrimonio_id' => $patrimonio_id,
            'patrimonio' => $patrimonio,
            'emissores' => $emissores
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
        // Validação dos dados do novo item
        $request->validate([
            'pedidos_compra_id' => 'required',
            'produto_id' => 'required',
            'quantidade' => 'required|numeric',
        ]);

        // Verifica se já existe um registro com os mesmos dados
        $existingItem = PedidoCompraLista::where([
            'pedidos_compra_id' => $request->pedidos_compra_id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
        ])->first();

        // Se o registro já existir, retorna um erro
        if ($existingItem) {
            return redirect()->back()->with('error', 'Este registro já existe.');
        }

        // Cria o novo registro
        PedidoCompraLista::create($request->all());

        // Resto do seu código para retornar a view com os dados atualizados
        $pedidoCompraId = $request->get('pedidos_compra_id');
        $produto_id = 0;
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $produtos = Produto::all();
        $pedidoCompra = PedidoCompra::where('id', $pedidoCompraId)->get();
        $pedidoCompraLista = PedidoCompraLista::where('pedidos_compra_id', $pedidoCompraId)->get();
        $unidades_de_medida = UnidadeMedida::all();
        $emissores = User::all(); //Busca usuarios
        return view('app.pedido_compra.index_lista', [
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'pedidos_compra' =>  $pedidoCompra,
            'produto_id' => $produto_id,
            'pedido_compra_lista' => $pedidoCompraLista,
            'produtos' => $produtos,
            'unidades_de_medida' => $unidades_de_medida,
            'emissores' => $emissores

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        // Retorna a view para exibir um item específico
        return ('pedido de compra lista');
    }

    public function edit($id)
    {
        // Retorna a view para editar um item específico
    }

    public function update(Request $request, $id)
    {
        // Validação e atualização dos dados do item
    }

    public function destroy($id)
    {
        $item = PedidoCompraLista::find($id);
        //return response()->json(['message' => 'Item deletado com sucesso!'], 200);
        $pedidocompraItem = PedidoCompraLista::find($id);
        $prdidoCompra = $pedidocompraItem->pedidos_compra_id;
        echo ($prdidoCompra);
        if ($item) {
            $item->delete();
            $equipamentos = Produto::all();
            $equipamentos = Equipamento::all();
            $funcionarios = Funcionario::all();
            $produtos = Produto::all();
            $pedidoCompra = PedidoCompra::where('id', $prdidoCompra)->get();
            $pedidoCompraLista = PedidoCompraLista::where('pedidos_compra_id',  $prdidoCompra)->get();
            $unidades_de_medida = UnidadeMedida::all();
            $emissores = User::all(); //Busca usuarios
            return view('app.pedido_compra.index_lista', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'pedidos_compra' =>  $pedidoCompra,
                'produto_id' => '',
                'pedido_compra_lista' => $pedidoCompraLista,
                'produtos' => $produtos,
                'unidades_de_medida' => $unidades_de_medida,
                'emissores' => $emissores
            ]);
        }
        return response()->json(['message' => 'Item não encontrado!'], 404);
    }
}
