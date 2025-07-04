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
use App\Models\Equipamento;
use App\Models\PecasEquipamentos;
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
                    return view('app.produto.index', [
                        'produtos' => $produtos,
                        'unidades' => $unidades,
                        'categorias' => $categorias,
                        'num_pedido' => $numPedido
                    ]);
                }
            }
            if ($tipoFiltro == 2) {
                $produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
                //if (isset($_POST['id'])) {

                if (!empty($nome_produto_like)) {
                    return view('app.produto.index', [
                        'produtos' => $produtos,
                        'unidades' => $unidades,
                        'categorias' => $categorias,
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
                        'produtos' => $produtos,
                        'unidades' => $unidades,
                        'categorias' => $categorias,
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
                    'produtos' => $produtos,
                    'unidades' => $unidades,
                    'categorias' => $categorias,
                    'num_pedido' => $numPedido
                ]);
            }
            if ($tipoFiltro == 5) { //filtra pelo esoque minimo
                $empresas = Empresas::all();
                $produtos = Produto::all();
                $categorias = Categoria::all();
                $estoque_produtos = EstoqueProdutos::where('quantidade', '<=', 0)->get();
                return view('app.estoque_produto.index', [
                    'estoque_produtos' => $estoque_produtos,
                    'empresas' => $empresas,
                    'produtos' => $produtos,
                    'categorias' => $categorias,
                    'num_pedido' => $numPedido
                ]);
            }
            if ($tipoFiltro == 6) { //filtra pelo esoque minimo
                $produtos = Produto::where('id', 0)->get();
                return view('app.produto.index', [
                    'produtos' => $produtos,
                    'unidades' => $unidades,
                    'categorias' => $categorias,
                    'num_pedido' => $numPedido
                ]);
            }
            //return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
            // }
            if ($tipoFiltro == 10) { //filtra pelo esoque minimo
                $produto_aplicacao = PecasEquipamentos::where('produto_id', $nome_produto_like)->get();
                $produtos = Produto::all();
                $equipamentos = Equipamento::all();
                return view('app.produto.produto_aplicacao', [
                    'produto_aplicacao' => $produto_aplicacao,
                    'produtos' => $produtos,
                    'equipamentos' => $equipamentos
                ]);
            }
        } else {
            $produtos = Produto::where('id', 0)->get();
            return view('app.produto.index', [
                'produtos' => $produtos,
                'unidades' => $unidades,
                'categorias' => $categorias,
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
        $marcas = Marca::orderBy('nome', 'asc')->get();
        $unidades = UnidadeMedida::orderBy('nome', 'asc')->get();
        $categorias = Categoria::orderBy('nome', 'asc')->get();

        return view('app.produto.create', compact('marcas', 'unidades', 'categorias'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ public function store(Request $request)
    {
        // ✅ Validação
        $request->validate([
            'cod_fabricante' => 'required',
            'nome' => 'required',
            'descricao' => 'nullable',
            'marca_id' => 'required',
            'unidade_medida_id' => 'required',
            'categoria_id' => 'required',
            'link_peca' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // imagem obrigatória
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // opcional
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // opcional
        ]);

        // Criação do produto
        $produto = new Produto;
        $produto->cod_fabricante = $request->cod_fabricante;
        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->marca_id = $request->marca_id;
        $produto->unidade_medida_id = $request->unidade_medida_id;
        $produto->categoria_id = $request->categoria_id;
        $produto->link_peca = $request->link_peca;

        // 🖼 Upload da imagem principal
        if ($request->hasFile('image')) {
            $requestImage = $request->file('image');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/produtos'), $imageName);
            $produto->image = $imageName;
        }

        // 🖼 Upload da imagem 2 (opcional)
        if ($request->hasFile('image2')) {
            $requestImage2 = $request->file('image2');
            $extension2 = $requestImage2->extension();
            $imageName2 = md5($requestImage2->getClientOriginalName() . strtotime("now")) . "." . $extension2;
            $requestImage2->move(public_path('img/produtos'), $imageName2);
            $produto->image2 = $imageName2;
        }

        // 🖼 Upload da imagem 3 (opcional)
        if ($request->hasFile('image3')) {
            $requestImage3 = $request->file('image3');
            $extension3 = $requestImage3->extension();
            $imageName3 = md5($requestImage3->getClientOriginalName() . strtotime("now")) . "." . $extension3;
            $requestImage3->move(public_path('img/produtos'), $imageName3);
            $produto->image3 = $imageName3;
        }

        $produto->save();

        // Recupera o último produto para exibir na view
        $ultimoProduto = Produto::latest('created_at')->first();
        $estoque_produtos = EstoqueProdutos::where('produto_id', $ultimoProduto->id)->get();
        $estoque_produtos_sum = EstoqueProdutos::where('produto_id', $ultimoProduto->id)->sum('quantidade');
        $estoque_produtos_sum_valor = $estoque_produtos_sum * $estoque_produtos_sum; // Verifique esse cálculo se está correto!

        return view('app.produto.show', [
            'produto' =>  $ultimoProduto,
            'estoque_produtos' => $estoque_produtos,
            'estoque_produtos_sum' => $estoque_produtos_sum,
            'estoque_produtos_sum_valor' => $estoque_produtos_sum_valor
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

        $produtoId = $produto->id; //pega o id do produto.
        $estoque_produtos = EstoqueProdutos::where('produto_id', $produtoId)->get();
        $estoque_produtos_sum = EstoqueProdutos::where('produto_id', $produtoId)->sum('quantidade');
        $estoque_produtos_sum_v = EstoqueProdutos::where('produto_id', $produtoId)->sum('quantidade');
        $estoque_produtos_sum_valor = $estoque_produtos_sum_v * $estoque_produtos_sum;
        $equipamentos = Equipamento::all();
        return view('app.produto.show', [
            'produto' => $produto,
            'estoque_produtos' => $estoque_produtos,
            'estoque_produtos_sum' => $estoque_produtos_sum,
            'estoque_produtos_sum_valor' => $estoque_produtos_sum_valor,
            'equipamentos' => $equipamentos
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
        $unidades = UnidadeMedida::orderBy('nome', 'asc')->get();
        $categorias = Categoria::orderBy('nome', 'asc')->get();
        $marcas = Marca::orderBy('nome', 'asc')->get();
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

        ///
        $ultimoProduto = Produto::find($id);
        $estoque_produtos = EstoqueProdutos::where('produto_id',  $ultimoProduto->id)->get();
        $estoque_produtos_sum = EstoqueProdutos::where('produto_id', $ultimoProduto->id)->sum('quantidade');
        $estoque_produtos_sum_v = EstoqueProdutos::where('produto_id', $ultimoProduto->id)->sum('quantidade');
        $estoque_produtos_sum_valor = $estoque_produtos_sum_v * $estoque_produtos_sum;
        return view('app.produto.show', [
            'produto' =>  $ultimoProduto,
            'estoque_produtos' => $estoque_produtos,
            'estoque_produtos_sum' => $estoque_produtos_sum,
            'estoque_produtos_sum_valor' => $estoque_produtos_sum_valor
        ]);
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
    public function aplicacao_produto(Request $request) {}
}
