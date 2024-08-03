<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
use App\Models\Categoria;

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
        $produto_id = $Request->get('produto_id');
        $data_inicio = $Request->get('data_inicio');
        $peca_equipamento_id = $Request->get('peca_equipamento_id');
        $peca_equipamento = PecasEquipamentos::where('id', $peca_equipamento_id)->get();
        $estoque_produtos = EstoqueProdutos::where('empresa_id', $empresa_id)->where('produto_id', $produtoId)->get();
        foreach ($estoque_produtos as $estoque_qnt) {
        }

        if ($estoque_qnt->quantidade <= 0) {
            echo '<div class="message" style="background-color:orange; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação Negada! Estoque Zerado.</div>';
        } else {

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
                    'peca_equipamento' => $peca_equipamento
                ]);
            } else {
                echo ('<div id="Alert">Não foi encontrado o produto no estoque!</div><Style>#Alert{background_color:Red;}</Style>');
            }
            //
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ordem_servico_id = $request->get('ordem_servico_id');
        // Define o fuso horário para São Paulo
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = $request->get('data');

        if ($ordem_servico_id >= 1) {
            //-------------------------------------------//
            //     Entra neste laço caso OS >=1          //
            //-------------------------------------------//
            $pedido_saida_id = $request->get('pedidos_saida_id');
            $data_proxima_manutencao = $request->get('data_proxima_manutencao');
            $pedido_saida = PedidoSaida::where('id', $pedido_saida_id)->get();
            $saidas_produtos = SaidaProduto::all();
            $estoque = EstoqueProdutos::find($request->input('estoque_id')); //busca o registro do produto com o id da entrada do produto
            //      comparador de estoque               //
            if ($request->quantidade > $estoque->quantidade) {
                echo '<div class="message" style="background-color:red; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação negada!
        Quantidade de saída:' . $request->quantidade . ', Estoque:' . $estoque->quantidade . '
        </div>';
            } else {
                echo($request);
               // SaidaProduto::create($request->all());// Salva a sáida do produto
                $estoque->quantidade = $estoque->quantidade - $request->input('quantidade'); // soma estoque antigo com a entrada de produto
                $estoque->save(); // Salva atualização do estoque
                //-------------------------------------
                $pecaEquipamento = PecasEquipamentos::find($request->input('peca_equipamento_id')); //busca o registro do produto com o id da entrada do produto
                $pecaEquipamento->data_substituicao = $dataAtual; // soma estoque antigo com a entrada de produto
                $pecaEquipamento->save();
                $pecaEquipamento = PecasEquipamentos::find($request->input('peca_equipamento_id')); //busca o registro do produto com o id da entrada do produto
                $pecaEquipamento->data_proxima_manutencao = $data_proxima_manutencao; // soma estoque antigo com a entrada de produto
                $pecaEquipamento->save();
                $equipamentos = Equipamento::all();
                $produtos = Produto::all();
                $categorias = Marca::all();
                $unidades = Empresas::all();
                echo '<div class="message" style="background-color:green; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação realizada com sucesso!</div>';
            }
        } else {
            //----------------------------------------------------------//
            //  Adiciona item de produto ao pedido de saída  sem a Os   //
            //----------------------------------------------------------//
            $pedido_saida_id = $request->get('pedido_id');// pega o numero do pedido
            $produto_id = $request->get('produto_id');
            $quantidade = $request->get('quantidade');
            $equipamento_id = $request->get('equipamento_id');
            $pedido_saida = PedidoSaida::find($pedido_saida_id);
            $produto = Produto::find($produto_id);
            $estoque = EstoqueProdutos::where('produto_id', $produto_id)->first(); //busca o registro do produto com o id da entrada do produto

            if ($request->quantidade > $estoque->quantidade) {
                echo '<div class="message" style="background-color:red; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação negada!
            Quantidade de saída:' . $request->quantidade . ', Estoque:' . $estoque->quantidade . '
            </div>';
            } else {
                //-----------------------------------------//
                // Dados de exemplo
                // Define a data atual
                $now = Carbon::now()->toDateTimeString(); // Formato: YYYY-MM-DD HH:MM:SS
                $dados = [
                    'pedidos_saida_id' => $pedido_saida_id,
                    'produto_id' => $produto_id,
                    'unidade_medida' => 'pç',
                    'quantidade' => $quantidade,
                    'valor' => 0,
                    'subtotal' => 0,
                    'data' => $now,
                    'equipamento_id' => $equipamento_id
                ];

                // Criação do objeto SaidaProduto
                $saida_produto = new SaidaProduto();
                $saida_produto->pedidos_saida_id = $dados['pedidos_saida_id'];
                $saida_produto->produto_id = $dados['produto_id'];
                $saida_produto->unidade_medida = $dados['unidade_medida'];
                $saida_produto->quantidade = $dados['quantidade'];
                $saida_produto->valor = $dados['valor'];
                $saida_produto->subtotal = $dados['subtotal'];
                $saida_produto->data = $dados['data'];
                $saida_produto->equipamento_id = $dados['equipamento_id'];

                // Salvando o objeto no banco de dados
                $saida_produto->save();
                //-----------------------------------------//
                $estoque->quantidade = $estoque->quantidade - $quantidade; // soma estoque antigo com a entrada de produto
                $estoque->save();

                // echo '<div class="message" style="background-color:green; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação realizada com sucesso!</div>';
            }
            //-------------------------------------------//
            //    Redireciona para a view
            $categorias = Categoria::all();
            $produtos = Produto::orderBy('nome')->get();
            $saidas_produtos = SaidaProduto::where('pedidos_saida_id', $pedido_saida_id)->get();
            $equipamentos = Equipamento::all();
            ///
            return view('app.pedido_saida.show', [
                'pedido_saida' => $pedido_saida,
                'categorias' => $categorias,
                'produtos' => $produtos,
                'saidas_produtos' => $saidas_produtos,
                'equipamentos' => $equipamentos
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
        // Recuperar o item de saída de produto
        $saida_produto = SaidaProduto::findOrFail($id);

        // Recuperar a quantidade do item de saída de produto
        $quantidade = $saida_produto->quantidade;
        // Recuperar a quantidade do item de saída de produto
        $pedidos_saida_id = $saida_produto->pedidos_saida_id;

        // Atualizar o estoque
        $estoque = EstoqueProdutos::where('produto_id', $saida_produto->produto_id)->first();
        //$estoque = PedidoSaida::where('pedidos_saida_id', $saida_produto->produto_id)->first();
        if ($estoque) {
            $estoque->quantidade += $quantidade; // Adiciona a quantidade de volta ao estoque
            $estoque->save();
        } else {
            // Opcional: lidar com o caso onde o estoque não é encontrado
            // Pode logar um aviso ou notificar o usuário
        }

        // Excluir o item da SaidaProduto
        $saida_produto->delete();
        //    Redireciona para a view
        $categorias = Categoria::all();
        $produtos = Produto::orderBy('nome')->get();
        $saidas_produtos = SaidaProduto::where('pedidos_saida_id',  $pedidos_saida_id)->get();
        $pedido_saida = SaidaProduto::find($pedidos_saida_id);
        ///
        return view('app.pedido_saida.show', [
            'pedido_saida' => $pedido_saida,
            'categorias' => $categorias,
            'produtos' => $produtos,
            'saidas_produtos' => $saidas_produtos
        ]);
    }
}
