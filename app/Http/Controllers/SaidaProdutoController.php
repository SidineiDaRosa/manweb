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
use DateTime;
use DateInterval;

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
                    'produtos' => $produtos,
                    'equipamento_id' =>  $equipamento_id,
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
        // Define o fuso horário para São Paulo
        date_default_timezone_set('America/Sao_Paulo'); // seta hora para são paulo
        $dataAtual = $request->get('data');
        $now = Carbon::now()->toDateTimeString(); // Formato: YYYY-MM-DD HH:MM:SS  Data atual
        //-----------------------------------------//
        // Pega dados da Request
        //-----------------------------------------//
        $pedido_saida_id = $request->get('pedido_id'); // pega o númeor do pedido
        $pedido_saida = PedidoSaida::find($pedido_saida_id); // 
        $produto_id = $request->get('produto_id'); //pega o ID do do produto
        $quantidade = $request->get('quantidade'); //Pega a quantidade
        $equipamento_id = $request->get('equipamento_id'); //Pega o Id do equipamento
        $componente_id = $request->get('componente_id'); //Pega o Id componente com intervalo de manutenção
        // Verifica se $pedido_saida existe e se possui um id
        if ($pedido_saida && $pedido_saida->id) {
            $ordem_servico_id = $pedido_saida->ordem_servico_id;
        } else {
            $ordem_servico_id = null;
        }
        if ($ordem_servico_id >= 1) {
            //-------------------------------------------//
            //     Entra neste laço caso OS >=1          //
            //-------------------------------------------//
            //..$data_proxima_manutencao = $request->get('data_proxima_manutencao');
            $saidas_produtos = SaidaProduto::all();
            //$estoque = EstoqueProdutos::find($request->input('estoque_id')); //busca o registro do produto com o id da entrada do produto
            $estoque = EstoqueProdutos::where('produto_id', $produto_id)->first(); //busca o registro do produto com o id da entrada do produto
            //      comparador de estoque               //
            if ($request->quantidade > $estoque->quantidade) {
                echo '<div class="message" style="background-color:red; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação negada para saída de produto com O.S.!
        Quantidade de saída:' . $request->quantidade . ', Estoque:' . $estoque->quantidade . '
        </div>';
            } else {
                //-----------------------------------------//
                // Cria um objeto para gravar a sáida
                //----------------------------------------//
                $dados = [
                    'pedidos_saida_id' => $pedido_saida_id,
                    'produto_id' => $produto_id,
                    'unidade_medida' => 'pç',
                    'quantidade' => $quantidade,
                    'valor' => 0,
                    'subtotal' => 0,
                    'data' => $now,
                    'equipamento_id' => $pedido_saida->equipamento_id
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
                //-----------------------------------------//
                //   Atualiza hora intervalod e manutenção
                //   do registro
                //-----------------------------------------//
                $today = date("Y-m-d"); //data de hoje
                $pecaEquipamento = PecasEquipamentos::find($request->input('componente_id')); //busca o registro do produto com o id da entrada do produto
                $intervalo_horas = $pecaEquipamento->intervalo_manutencao; // Obtém o intervalo de horas do objeto
                //--------------------------------------------------//
                // Defina a data da última manutenção
                $data_ultima_manutencao = new DateTime(); // Cria um objeto DateTime com a data e hora atuais

                // Converte o intervalo de horas para dias inteiros
                $intervalo_horas_d = intval($intervalo_horas / 24);

                // Clona a data da última manutenção para definir a próxima manutenção
                $data_proxima_manutencao = clone $data_ultima_manutencao;

                // Adiciona o intervalo de dias à data da próxima manutenção
                $data_proxima_manutencao->add(new DateInterval('P' . $intervalo_horas_d . 'D'));

                // Adiciona as horas restantes (não múltiplos de 24) à data da próxima manutenção
                $horas_restantes = $intervalo_horas % 24;
                $data_proxima_manutencao->add(new DateInterval('PT' . $horas_restantes . 'H'));

                // Calcula a diferença entre as datas
                $diferenca = $data_ultima_manutencao->diff($data_proxima_manutencao);

                // Converte a diferença em dias e horas
                $diferenca_horas = intval(($diferenca->days * 24) + $diferenca->h + ($diferenca->i / 60) + ($diferenca->s / 3600));
                //---------------------------------------------------//
                //   salva alteração em  peças equipamentos          //
                $pecaEquipamento->data_substituicao = $today; // soma estoque antigo com a entrada de produto
                $pecaEquipamento->data_proxima_manutencao = $data_proxima_manutencao; // soma estoque antigo com a entrada de produto
                $pecaEquipamento->horas_proxima_manutencao = $diferenca_horas;
                $pecaEquipamento->save(); //salva alteração em  peças equipamentos

                echo '<div class="message" style="background-color:green; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação realizada com sucesso!</div>';
            }
        } else {
            //----------------------------------------------------------//
            //  Adiciona item de produto ao pedido de saída  sem a O.s.   //
            //----------------------------------------------------------//
            $estoque = EstoqueProdutos::where('produto_id', $produto_id)->first(); //busca o registro do produto com o id da entrada do produto

            if ($request->quantidade > $estoque->quantidade) {
                echo '<div class="message" style="background-color:red; color: white; padding: 15px; border-radius: 5px; font-size: 16px; text-align: center; margin: 20px;">Operação negada!
            Quantidade de saída:' . $request->quantidade . ', Estoque:' . $estoque->quantidade . '
            </div>';
            } else {
                //-----------------------------------------//
                // Cria um objeto para gravar a sáida
                //----------------------------------------//
                $dados = [
                    'pedidos_saida_id' => $pedido_saida_id,
                    'produto_id' => $produto_id,
                    'unidade_medida' => 'pç',
                    'quantidade' => $quantidade,
                    'valor' => 0,
                    'subtotal' => 0,
                    'data' => $now,
                    'equipamento_id' => $pedido_saida->equipamento_id
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
        $pedidos_saida_id = $saida_produto->pedidos_saida_id;
        // Recuperar o pedido de saída correspondente
        $pedido_saida = PedidoSaida::find($pedidos_saida_id);
        // Atualizar o estoque
        $estoque = EstoqueProdutos::where('produto_id', $saida_produto->produto_id)->first();
        if ($estoque) {
            $estoque->quantidade += $quantidade; // Adiciona a quantidade de volta ao estoque
            $estoque->save();
        } else {
            // Opcional: lidar com o caso onde o estoque não é encontrado
            // Pode logar um aviso ou notificar o usuário
        }

        // Excluir o item da SaidaProduto
        $saida_produto->delete();

        // Recuperar dados necessários para a view
        $categorias = Categoria::all();
        $produtos = Produto::orderBy('nome')->get();
        $saidas_produtos = SaidaProduto::where('pedidos_saida_id', $pedidos_saida_id)->get();
        $equipamentos = Equipamento::all();

        // Redirecionar para a view com as variáveis necessárias
        return view('app.pedido_saida.show', [
            'pedido_saida' => $pedido_saida,
            'categorias' => $categorias,
            'produtos' => $produtos,
            'saidas_produtos' => $saidas_produtos,
            'equipamentos' => $equipamentos
        ]);
    }
}
