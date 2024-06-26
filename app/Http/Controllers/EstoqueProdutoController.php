<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use App\Models\EstoqueProdutos;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\Empresas;
use App\Models\PedidoSaida;
use App\Models\UnidadeMedida;
use App\Models\Categoria;
use Illuminate\Foundation\Auth\RedirectsUsers;

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
        // Obtém o produto_id do request
        $produtoId = $request->get('produto_id');

        // Verifica se já existe um registro com empresa_id = 2 e produto_id igual ao do request
        $estoque_existente = EstoqueProdutos::where('empresa_id', 2)
            ->where('produto_id', $produtoId)
            ->first();

        if ($estoque_existente) {
            // Registro já existe, redireciona de volta com uma mensagem de erro

            // return Redirect::back()->withErrors(['message' => 'Já existe um registro para este produto nesta empresa.']); // Delay de 3 segundos
            echo ('<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <div style="padding: 100px; background-color: #f44336; color: white; border-radius: 4px; border: 1px solid #f44336; width: fit-content;font-size:25px;">
                Já existe um registro para este produto nesta empresa.
            </div>
        </div>');
        } else {
            // Cria um novo registro de EstoqueProdutos
            EstoqueProdutos::create($request->all());

            // Recarrega os dados para a view após a criação do novo registro
            $empresas = Empresas::all();
            $produtos = Produto::all();
            $categorias = Categoria::all();
            $estoque_produtos = EstoqueProdutos::where('empresa_id', 2)
                ->where('produto_id', $produtoId)
                ->get();
            // Retorna a view com os dados carregados
            return view('app.estoque_produto.index', [
                'estoque_produtos' => $estoque_produtos,
                'empresas' => $empresas,
                'produtos' => $produtos,
                'categorias' => $categorias
            ]);
        }
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
