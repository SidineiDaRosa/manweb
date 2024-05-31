<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Marca;
use App\Models\UnidadeMedida;
use App\Models\Categoria;
use App\Models\PedidoSaida;

class ItemProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $pedido_saida_id = $request->get('pedido');
        $pedido_saida = PedidoSaida::where('id', $pedido_saida_id)->get();
        $nome_produto_like = $request->get('produto');
        //$nome_produto_like='DIE';
        //$produtos=Produto::all();
        //$unidades = UnidadeMedida::all();
       // $categorias = Categoria::all();
        //$produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
        //if (isset($_POST['id'])) {

       // if (!empty($nome_produto_like)) {
           // return view('app.item_produto.add_item', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias, 'pedido_saida' => $pedido_saida]);
       // } else {
           // $produtos = Produto::where('id', 0)->get();
            //return view('app.item_produto.add_item', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias, 'pedido_saida' => $pedido_saida]);
        //};
        //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
        //return view('app.item_produto.add_item');
        //-------------------------------------------------------------------------------------------------
        $pedido_saida_id = $request->get('pedido');
        $pedido_saida = PedidoSaida::where('id', $pedido_saida_id)->get();
        $tipoFiltro = $request->get('tipofiltro');
        $nome_produto_like = $request->get('produto');
        //$nome_produto_like='DIE';
        //$produtos=Produto::all();
        $unidades = UnidadeMedida::all();
        $categorias = Categoria::all();
        if ($tipoFiltro >= 1 ) {
            if ($tipoFiltro == 1) {
                $produtos = Produto::where('id', $nome_produto_like)->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    
                       return view('app.item_produto.add_item', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias, 'pedido_saida' => $pedido_saida]);
                }
            }
            if ($tipoFiltro == 2) {
                $produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    return view('app.item_produto.add_item', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias, 'pedido_saida' => $pedido_saida]);
                }
            }
            if ($tipoFiltro == 3) {
                $produtos = Produto::where('cod_fabricante', 'like', $nome_produto_like . '%')->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    return view('app.item_produto.add_item', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias, 'pedido_saida' => $pedido_saida]);
                }
            }
            if ($tipoFiltro == 4) {
                $produtos = Produto::where('categoria_id', $nome_produto_like . '%')->get();

                if (!empty($nome_produto_like)) {
                    return view('app.item_produto.add_item', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias, 'pedido_saida' => $pedido_saida]);
                }
            }
        } else {
            $produtos = Produto::where('id', 0)->get();
            return view('app.item_produto.add_item', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias, 'pedido_saida' => $pedido_saida]);
        };
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
