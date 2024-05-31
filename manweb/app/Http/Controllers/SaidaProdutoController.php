<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\EntradaProduto;
use App\Models\SaidaProduto;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\Equipamento;
use App\Models\Marca;
use App\Models\PedidoSaida;
use App\Models\UnidadeMedida;
use App\Models\EstoqueProdutos;
use App\Models\PecasEquipamentos;

class SaidaProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $equipamentos = Equipamento::all();
        $produtos = Produto::all();
        $categorias = Marca::all();
        $unidades = Empresas::all();
        //echo('controller saidas de produtos');
        return view('app.produto.index', ['produtos' => $produtos, 'unidades' => $unidades, 'categorias' => $categorias]);
    }
    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $Request)
    {
        $empresa_id = $Request->get('empresa');
        $produtoId = $Request->get('produto');
        $peca_equipamento_id = $Request->get('peca_equipamento_id');
        $peca_equipamento=PecasEquipamentos::where('id',$peca_equipamento_id)->get();
        $estoque_produtos = EstoqueProdutos::where('empresa_id', $empresa_id)->where('produto_id', $produtoId)->get();
        if (!empty($estoque_produtos)) {
            $equipamento_id =  $Request->get('equipamento_id');
            $unidade_medida = UnidadeMedida::all();
            $estoque_id = $Request->get('estoque_id');
            $pedido = $Request->get('pedido');
            $pedido_saida_produtos = PedidoSaida::where('id', $pedido)->get();
            $produtos = Produto::where('id', $produtoId)->get();
            $produtos = EntradaProduto::where('produto_id', $produtoId)->get();
            // $pedido = PedidoSaida::where('id', $pedidoId)->get();
            $estoque  = EstoqueProdutos::where('id', $estoque_id)->get();
            return view('app.saida_produto.create', [
                'produtos' => $produtos, 'equipamento_id' =>  $equipamento_id,
                'unidade_medida' => $unidade_medida,
                'pedido' => $pedido,
                'estoque' => $estoque,
                'pedido_saida_produtos' => $pedido_saida_produtos,
                'estoque_produtos' => $estoque_produtos,
                'peca_equipamento_id' => $peca_equipamento_id,
                'peca_equipamento'=>$peca_equipamento
            ]);
        } else {
            echo ('<div id="Alert">Não foi encontrado o produto no estoque!</div><Style>#Alert{background_color:Red;}</Style>');
        }
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
        $pedido_saida_id = $request->get('pedidos_saida_id');
        $dataAtual = $request->get('data');
        $data_proxima_manutencao= $request->get('data_proxima_manutencao');
        $pedido_saida = PedidoSaida::where('id', $pedido_saida_id)->get();
        SaidaProduto::create($request->all());
        $saidas_produtos = SaidaProduto::all();
        $estoque = EstoqueProdutos::find($request->input('estoque_id')); //busca o registro do produto com o id da entrada do produto
        $estoque->quantidade = $estoque->quantidade - $request->input('quantidade'); // soma estoque antigo com a entrada de produto
        $estoque->save();
        //-------------------------------------
        //$dataAtual = date('y/m/d');
        //echo($dataAtual );
        $pecaEquipamento = PecasEquipamentos::find($request->input('peca_equipamento_id')); //busca o registro do produto com o id da entrada do produto
        $pecaEquipamento->data_substituicao=$dataAtual; // soma estoque antigo com a entrada de produto
        $pecaEquipamento->save();
        $pecaEquipamento = PecasEquipamentos::find($request->input('peca_equipamento_id')); //busca o registro do produto com o id da entrada do produto
        $pecaEquipamento->data_proxima_manutencao=$data_proxima_manutencao; // soma estoque antigo com a entrada de produto
        $pecaEquipamento->save();
        $equipamentos = Equipamento::all();
        $produtos = Produto::all();
        $categorias = Marca::all();
        $unidades = Empresas::all();
        //echo('controller saidas de produtos');
        echo ('retornar');
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
