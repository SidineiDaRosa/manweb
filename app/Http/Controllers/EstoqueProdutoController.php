<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstoqueProdutos;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\Empresas;
use App\Models\PedidoSaida;
use App\Models\UnidadeMedida;
use App\Models\Categoria;

class EstoqueProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $empresa_id = $request->get('empresa_id');
        $tipoFiltro = $request->get('tipofiltro');
        $categoria_id = $request->get('categoria_id');
        $nome_produto_like = $request->get('produto');
        $estoque_produtos = EstoqueProdutos::all();
        $empresas = Empresas::all();
        $produtos = Produto::all();
        $categorias = Categoria::all();

        if ($empresa_id >= 1) {
            if ($tipoFiltro == 1) {

                $estoque_produtos = EstoqueProdutos::where('empresa_id', $empresa_id)->where('produto_id', $nome_produto_like)->get();
                //dd($estoque_produtos);
                return view('app.estoque_produto.index', [
                    'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos, 'categorias' => $categorias
                ]);
            }

            if ($tipoFiltro == 2) {
                $estoque_produtos = EstoqueProdutos::where('empresa_id', $empresa_id)->get();
                return view('app.estoque_produto.index', [
                    'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos, 'categorias' => $categorias
                ]);
            }
            // if ($tipoFiltro == 10) {
            // $estoque_produtos = EstoqueProdutos::where('empresa_id', $empresa_id)->get();
            //return view('app.estoque_produto.index', [
            // 'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos
            //]);
            //}

        } else {
            $estoque_produtos = EstoqueProdutos::where('empresa_id', 0)->get();
            return view('app.estoque_produto.index', [
                'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos, 'categorias' => $categorias
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Request $produto_id)
    {
        $produtoId = $produto_id->get('produto');
        $fornecedores = Fornecedor::all();
        $empresa = Empresas::all();
        $unidades = UnidadeMedida::all();
        $produtos = Produto::where('id', $produtoId)->get();
        return view('app.estoque_produto.create', [
            'produtos' => $produtos,
            'fornecedores' => $fornecedores,
            'empresa' => $empresa,
            'unidades' => $unidades
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
        //
        EstoqueProdutos::create($request->all());
        $empresas = Empresas::all();
        $produtos = Produto::all();
        $categorias = Categoria::all();
        $produtoId = $request->get('produto_id');
        $estoque_produtos = EstoqueProdutos::where('empresa_id',2)->where('produto_id',$produtoId)->get();

        return view('app.estoque_produto.index', [
            'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos, 'categorias' => $categorias
        ]);
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
