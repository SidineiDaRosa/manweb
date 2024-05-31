<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\UnidadeMedida;
use App\Models\Categoria;
use App\Models\EstoqueProdutos; //Include estoque produtos
use App\Models\Empresas;
use BaconQrCode\Renderer\Path\Move;
use Illuminate\Support\Facades\File; // Importa a classe File
//use phpDocumentor\Reflection\Types\This;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $numPedido = $request->get('num_pedido');
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
                    return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias,
                    'num_pedido' => $numPedido
                ]);
                }
            }
            if ($tipoFiltro == 2) {
                $produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    return view('app.produto.index', [
                        'produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias,
                        'num_pedido' => $numPedido
                    ]);
                }
                //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            }
            if ($tipoFiltro == 3) {
                $produtos = Produto::where('cod_fabricante', 'like', $nome_produto_like . '%')->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    return view('app.produto.index', [
                        'produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias,
                        'num_pedido' => $numPedido
                    ]);
                }
                //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            }
            if ($tipoFiltro == 4) {
                $produtos = Produto::where('categoria_id', $categoria_id)->get();
                //if (isset($_POST['id'])) {

                // if (!empty($nome_produto_like)) {
                return view('app.produto.index', [
                    'produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias,
                    'num_pedido' => $numPedido
                ]);
            }
            if ($tipoFiltro == 5) { //filtra pelo esoque minimo
                $empresas = Empresas::all();
                $produtos = Produto::all();
                $categorias = Categoria::all();
                $estoque_produtos = EstoqueProdutos::where('quantidade', '<=', 0)->get();
                return view('app.estoque_produto.index', [
                    'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos, 'categorias' => $categorias,
                    'num_pedido' => $numPedido
                ]);
            }
            if ($tipoFiltro == 6) { //filtra pelo esoque minimo
                $produtos = Produto::where('id', 0)->get();
                return view('app.produto.index', [
                    'produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias,
                    'num_pedido' => $numPedido
                ]);
            }
            //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            // }
        } else {
            $produtos = Produto::where('id', 0)->get();
            return view('app.produto.index', [
                'produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias,
                'num_pedido' => $numPedido
            ]);
        };
        //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);

    }
    /**
     * Show the form for creating a new resource.
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = Marca::all();
        $unidades = UnidadeMedida::all();
        $categorias = Categoria::all();
        return view('app.produto.create', ['marcas' => $marcas, 'unidades' => $unidades, 'categorias' => $categorias]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Image Upload
        $produto = new Produto;
        //criando um objeto
        $produto->cod_fabricante = $request->cod_fabricante;
        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->marca_id = $request->marca_id;
        $produto->unidade_medida_id = $request->unidade_medida_id;
        $produto->categoria_id = $request->categoria_id;
        $produto->link_peca = $request->link_peca;
        $produto->image = $request->image;
        $produto->image2 = $request->image2;
        $produto->image3 = $request->image3;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $request->image->Move(public_path('img/produtos'), $imageName);
            $produto->image = $imageName;
        };
        if ($request->hasFile('image2') && $request->file('image2')->isValid()) {
            $requestImage = $request->image2;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $request->image2->Move(public_path('img/produtos'), $imageName);
            $produto->image2 = $imageName;
        };
        if ($request->hasFile('image3') && $request->file('image3')->isValid()) {
            $requestImage = $request->image3;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $request->image3->Move(public_path('img/produtos'), $imageName);
            $produto->image3 = $imageName;
        };
        $produto->save();
        return redirect()->route('produto.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
       
        $produtoId = $produto->id; //pega o id do produto.
        $estoque_produtos = EstoqueProdutos::where('produto_id', $produtoId)->get();
        $estoque_produtos_sum = EstoqueProdutos::where('produto_id', $produtoId)->sum('quantidade');
        $estoque_produtos_sum_v = EstoqueProdutos::where('produto_id', $produtoId)->sum('quantidade');
        $estoque_produtos_sum_valor = $estoque_produtos_sum_v * $estoque_produtos_sum;
        return view('app.produto.show', [
            'produto' => $produto, 'estoque_produtos' => $estoque_produtos, 'estoque_produtos_sum' => $estoque_produtos_sum,
            'estoque_produtos_sum_valor' => $estoque_produtos_sum_valor
        ]);
        // return view('app.estoque_produto.index', [
        //'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos, 'categorias' => $categorias
        // ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        $unidades = UnidadeMedida::all();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('app.produto.edit', ['produto' => $produto, 'marcas' => $marcas, 'unidades' => $unidades, 'categorias' => $categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Produto $produto)
    {

        $id = $produto->id; //pega o código do produto
        $produto = Produto::findOrFail($id);
        $produto->cod_fabricante = $request->cod_fabricante;
        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->marca_id = $request->marca_id;
        $produto->unidade_medida_id = $request->unidade_medida_id;
        $produto->categoria_id = $request->categoria_id;
        $produto->link_peca = $request->link_peca;

        // Verifica se uma nova imagem foi enviada para image e a salva
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->uploadImage($request->file('image'), 'image', $produto);
        }

        // Verifica se uma nova imagem foi enviada para image2 e a salva
        if ($request->hasFile('image2') && $request->file('image2')->isValid()) {
            $this->uploadImage($request->file('image2'), 'image2', $produto);
        }

        // Verifica se uma nova imagem foi enviada para image3 e a salva
        if ($request->hasFile('image3') && $request->file('image3')->isValid()) {
            $this->uploadImage($request->file('image3'), 'image3', $produto);
        }

        $produto->save();
        return redirect()->route('produto.index');
    }

    private function uploadImage($imageFile, $fieldName, $produto)
    {
        // Deleta a imagem antiga se existir
        if (File::exists(public_path('img/produtos/' . $produto->{$fieldName}))) {
            File::delete(public_path('img/produtos/' . $produto->{$fieldName}));
        }

        // Salva a nova imagem
        $extension = $imageFile->extension();
        $imageName = md5($imageFile->getClientOriginalName() . strtotime("now")) . "." . $extension;
        $imageFile->move(public_path('img/produtos'), $imageName);
        $produto->{$fieldName} = $imageName;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {

        $produto->delete();
        return redirect()->route('produto.index');
    }
}
