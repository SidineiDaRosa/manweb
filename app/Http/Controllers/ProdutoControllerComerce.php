<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Produto;
use App\Models\Marca;
use App\Models\UnidadeMedida;
use App\Models\Categoria;
use BaconQrCode\Renderer\Path\Move;

class ProdutoControllerComerce extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        $tipoFiltro = $request->get('tipofiltro');
        $nome_produto_like = $request->get('produto');
        $categoria_id = $request->get('categoria_id');
        //$nome_produto_like='DIE';
        //$produtos=Produto::all();
        $unidades = UnidadeMedida::all();
        $categorias = Categoria::all();
        if ($tipoFiltro >= 1) {
            if ($tipoFiltro == 1) {
                $produtos = Produto::where('id', $nome_produto_like)->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {

                    //return QrCode::size(300)->generate('$nome_produto_like');
                    return view('app.produto.SearchingProdutosVenda', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
                }
            }
            if ($tipoFiltro == 2) {
                $produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    return view('app.produto.SearchingProdutosVenda', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
                }
                //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            }
            if ($tipoFiltro == 3) {
                $produtos = Produto::where('cod_fabricante', 'like', $nome_produto_like . '%')->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    return view('app.produto.SearchingProdutosVenda', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
                }
                //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            }
            if ($tipoFiltro == 4) {
                $produtos = Produto::where('categoria_id', $categoria_id)->get();
                //if (isset($_POST['id'])) {

                // if (!empty($nome_produto_like)) {
                return view('app.produto.SearchingProdutosVenda', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            }
            //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            // }
        } else {
            $produtos = Produto::where('id',)->get();
            return view('app.produto.SearchingProdutosVenda', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
        };
        //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);

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
    public function show(Request $request)
    {
        //echo ($request);
        $idProduto = $request->get('idProduto');
        
        $produto = Produto::where('id',$idProduto)->get();
         return view('app.produto.showProdutoVenda', ['produto' => $produto]);
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
