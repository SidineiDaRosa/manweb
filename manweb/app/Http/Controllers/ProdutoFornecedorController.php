<?php

namespace App\Http\Controllers;

use App\Models\ProdutoFornecedor;
use Illuminate\Http\Request;
use App\Models\Fornecedor;
use App\Models\Produto;
use Symfony\Component\Console\Input\Input;

class ProdutoFornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fornecedores = Fornecedor::all();
        $produtos = Produto::all();
        return view('app.produto_fornecedor.create', ['fornecedores' => $fornecedores, 'produtos' => $produtos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $fornecedor)
    {
        
        $fornecedores = Fornecedor::all();
        $produtos = Produto::all();
        $produtoFornecedor = new ProdutoFornecedor();
        $produtoFornecedor->produto_id = $request->input('produto_id');
        $produtoFornecedor->fornecedor_id = $fornecedor;

        //caso já exista o produto cadastrado executa o código abaixo
        $exists_produto = ProdutoFornecedor::where('produto_id', $produtoFornecedor->produto_id)
            ->where('fornecedor_id', $produtoFornecedor->fornecedor_id)->get()->first();
        if (isset($exists_produto->produto_id)) {
            $erro= 'Produto já existe';
            $produtos_fornecedor = ProdutoFornecedor::where('fornecedor_id', $fornecedor)->get();
            return view('app.produto_fornecedor.create', [
                'produtos_fornecedor' => $produtos_fornecedor,'fornecedores' => $fornecedores,
                 'produtos' => $produtos, 'fornecedor' => $fornecedor, 'erro'=>$erro
            ]);
        }

        $produtoFornecedor->save();
        $produtos_fornecedor = ProdutoFornecedor::where('fornecedor_id', $fornecedor)->get();

        return view('app.produto_fornecedor.create', [
            'produtos_fornecedor' => $produtos_fornecedor,
            'fornecedores' => $fornecedores, 'produtos' => $produtos, 'fornecedor' => $fornecedor
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdutoFornecedor  $produtoFornecedor
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(ProdutoFornecedor $produtoFornecedor, Request $request)
    {
        $fornecedor = $request->input('fornecedor_id');
        $produtos_fornecedor = ProdutoFornecedor::where('fornecedor_id', $fornecedor)->get();
        $fornecedores = Fornecedor::all();
        $produtos = Produto::all();

        return view('app.produto_fornecedor.create', [
            'produtos_fornecedor' => $produtos_fornecedor,
            'fornecedores' => $fornecedores, 'produtos' => $produtos, 'fornecedor' => $fornecedor
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdutoFornecedor  $produtoFornecedor
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdutoFornecedor $produtoFornecedor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdutoFornecedor  $produtoFornecedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdutoFornecedor $produtoFornecedor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdutoFornecedor  $produtoFornecedor
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(ProdutoFornecedor $produtoFornecedor, Request $request, $fornecedor)
    {
        $produtoFornecedor->delete();

        $produtos_fornecedor = ProdutoFornecedor::where('fornecedor_id', $fornecedor)->get();
        $fornecedores = Fornecedor::all();
        $produtos = Produto::all();

        return view('app.produto_fornecedor.create', [
            'produtos_fornecedor' => $produtos_fornecedor,
            'fornecedores' => $fornecedores, 'produtos' => $produtos, 'fornecedor' => $fornecedor
        ]);
    }
}
