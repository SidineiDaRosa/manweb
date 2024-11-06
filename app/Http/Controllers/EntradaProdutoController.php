<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\EntradaProduto;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\EntradaProdutos;
use App\Models\Empresas;
use App\Models\EstoqueProdutos;

class EntradaProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //----------------------------------------------//
        //    Entradas de produtos 
        //----------------------------------------------//
        $tipoFiltro = $request->get('tipofiltro');
        $nome_produto_like = $request->get('produto');
        $empresa_id = $request->get('empresa_id');
        $data_inicio = $request->get('data_inicio');
        $data_fim = $request->get('data_fim');
        $empresa = Empresas::all();
        // Verifica o tipo de filtro aplicado se >=1
        if ($tipoFiltro >= 1) {
            // Se = 1  busca pela empresa e nome
            if ($tipoFiltro == 1) {
                //$entradas_produtos = EntradaProduto::where('nome', 'like', $nome_produto_like . '%')->get();
                $entradas_produtos = EntradaProduto::where('produto_id', $nome_produto_like)->where('empresa_id', $empresa_id)->get();
                if (!empty($entradas_produtos)) {
                    return view('app.entrada_produto.index', [
                        'entradas_produtos' => $entradas_produtos,
                        'empresa' => $empresa
                    ]);
                }
            }
            // Se = 2  busca pelo ID
            if ($tipoFiltro == 2) {
                
                $entradas_produtos = EntradaProduto::where('produto_id',$request->produto_id)->where('empresa_id', 2)->get();
                echo($entradas_produtos);
                if (!empty($entradas_produtos)) {
                    return view('app.entrada_produto.index', [
                        'entradas_produtos' => $entradas_produtos,
                        'empresa' => $empresa
                    ]);
                }
            }
            // Se = 5  busca pela data de inicio
            if ($tipoFiltro == 5) {
                $entradas_produtos = EntradaProduto::where('empresa_id', $empresa_id)
                    ->whereBetween('data', [$data_inicio, $data_fim])
                    ->get();
                //$valorTotal = OrdemServico::where('data_inicio', ('>='), $dataFim)->where('empresa_id', $empresa_id)->where('situacao', $situacao)->sum('valor');
                if (!empty($entradas_produtos)) {
                    return view('app.entrada_produto.index', [
                        'entradas_produtos' => $entradas_produtos,
                        'empresa' => $empresa
                    ]);
                }
            }
        } else {
            $entradas_produtos  = Produto::where('id', 0)->get();
            return view('app.entrada_produto.index', [
                'entradas_produtos' => $entradas_produtos,
                'empresa' => $empresa
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
        $estoque_id = $produto_id->get('estoque_id');
        $fornecedores = Fornecedor::all();
        $empresa = Empresas::all();
        $estoque  = EstoqueProdutos::where('id', $estoque_id)->get();
        $produtos  = Produto::where('id', $produtoId)->get();

        return view('app.entrada_produto.create', [
            'produtos' => $produtos,
            'fornecedores' => $fornecedores,
            'empresa' => $empresa,
            'estoque' => $estoque

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
        EntradaProduto::create($request->all());
        $estoque = EstoqueProdutos::find($request->input('estoque_id')); //busca o registro do produto com o id da entrada do produto
        $estoque->quantidade = $estoque->quantidade + $request->input('quantidade'); // soma estoque antigo com a entrada de produto
        $estoque->save();
        $produto_id = $estoque->produto_id;
        $empresa = Empresas::all();
        $entradas_produtos = EntradaProduto::where('produto_id', $produto_id)->where('empresa_id', 2)->where('empresa_id', 2)->get();
        $produto = EstoqueProdutos::where('empresa_id', 2)->where('produto_id', $estoque->produto_id)->get();
        $estoque_produtos = EstoqueProdutos::where('empresa_id', 2)->where('produto_id', $estoque->produto_id)->get();
        $categorias = Categoria::all();
        //dd($estoque_produtos);
        return view('app.estoque_produto.index', [
            'estoque_produtos' => $estoque_produtos,
            'empresas' => $empresa,
            'produtos' => $produto,
            'categorias' => $categorias
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
     * @param  \App\Models\EntradaProduto $equipamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntradaProduto $entrada_produto)
    {
        $entrada_produto->delete();
        return redirect()->route('entrada-produto.index');
    }
}
