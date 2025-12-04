<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\PedidoCompra;
use App\Models\Empresas;
use App\Models\PedidoCompraLista;
use App\Models\PedidoSaida;
use App\Models\SaidaProduto;
use App\Models\UnidadeMedida;
use App\Models\Produto;
use App\Models\OrdemServico;
use App\Models\PecasEquipamentos;

class PedidoSaidaListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $pedido_saida)
    {
        //
        $pedido_saida_id_1 = $pedido_saida->get('pedido_saida');
        $produto_id = $pedido_saida->get('produto_id');
        $data_inicio = $pedido_saida->get('data_inicio');
        $data_fim = $pedido_saida->get('data_fim');
        $categorias = Categoria::all(); // busca categorias
        if ($produto_id >= 1) {
            $saidas_do_produto = SaidaProduto::where('produto_id', $produto_id)->get();
            $produto = Produto::where('id', $produto_id)->get();
            $equipamentos = Equipamento::all();
            // $produtos = Produto::where('id', '=>',1)->get(); // busca o id 0 para enviar para o pedio de saida com os.
            $produtos = Produto::all();
            return view('app.pedido_saida_lista.saida_de_produto', [
                'saidas_do_produto' => $saidas_do_produto,
                'produto' => $produto,
                'equipamentos' => $equipamentos,
                'produtos' => $produtos,
                'categorias' => $categorias
            ]);
        } else {

            //--------------------------------------------//
            // Envia para pedido de saída com os anexada
            //--------------------------------------------//

            $equipamentos = Equipamento::all();
            $funcionarios = Funcionario::all();
            $saidas_produto = SaidaProduto::where('pedidos_saida_id', $pedido_saida_id_1)->get();
            $pedidos_saida = PedidoSaida::where('id', $pedido_saida_id_1)->get();
            $ped_said = PedidoSaida::find($pedido_saida_id_1);
            $Unidades_de_Medida = UnidadeMedida::all();

            $produtos = Produto::where('id', 0)->get(); // busca o id 0 para enviar para o pedio de saida com os.
            $pecas_equipamento = PecasEquipamentos::where('equipamento', $ped_said->equipamento_id)
                ->where('status', 'ativado')->get();
            $patrimonio = Equipamento::where('id', $ped_said->equipamento_id)->get();
            if ($ped_said->ordem_servico_id >= 1) {
                return view('app.pedido_saida_lista.index', [
                    'equipamentos' => $equipamentos,
                    'funcionarios' => $funcionarios,
                    'saidas_produto' => $saidas_produto,
                    'pedidos_saida' =>  $pedidos_saida,
                    //'Unidades_de_Medida' => $Unidades_de_Medida
                    'patrimonio' => $patrimonio,
                    'pecas_equipamento' => $pecas_equipamento,
                    'produtos' => $produtos,
                    'categorias' => $categorias
                ]);
            } else {


                $categorias = Categoria::all();
                $pedido_saida = PedidoSaida::find($pedido_saida_id_1);
                $produtos = Produto::orderBy('nome')->get();

                $saidas_produtos = SaidaProduto::where('pedidos_saida_id', $pedido_saida_id_1)->get();
                $equipamentos = Equipamento::all();
                return view('app.pedido_saida.show', [ // abre o pedido sem a O.S.
                    'pedido_saida' => $pedido_saida,
                    'categorias' => $categorias,
                    'produtos' => $produtos,
                    'saidas_produtos' => $saidas_produtos,
                    'equipamentos' => $equipamentos
                ]);
            }
        }
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
     * @param  \App\PedidoCompraLista  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($numpedidocompra)
    {
        echo ('excluir produto da lista');
        // Encontrar o pedido de compra pelo ID
        // $pedidocompralista = PedidoCompraLista::findOrFail($numpedidocompra);

        // Verificar se o usuário autenticado tem permissão para excluir o pedido de compra
        // Exemplo: if (!Auth::user()->can('delete', $pedidocompralista)) { ... }

        // Excluir o pedido de compra
        // $pedidocompralista->delete();

        // Redirecionar ou retornar uma resposta adequada
        //return redirect()->back()->with('status', 'Pedido de compra excluído com sucesso');
    }
    //Filtra produtos apartir do pedido de sáida com os
    public function searching_products(Request $request)
    {
        $categorias = Categoria::all();
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $pedido_saida_id = $request->get('pedido_saida_id');
        $saidas_produto = SaidaProduto::where('pedidos_saida_id', $pedido_saida_id)->get();
        $pedidos_saida = PedidoSaida::where('id', $pedido_saida_id)->get();
        $ped_said = PedidoSaida::find($pedido_saida_id);
        $Unidades_de_Medida = UnidadeMedida::all();

        $tipofiltro = $request->get('tipofiltro');
        $query_like_producto_name = $request->get('query_like_producto_name', '%');
        $categoria_id = $request->get('categoria_id');

        // Query base
        $produtos = Produto::query();

        switch ($tipofiltro) {
            case 1: // Busca pelo ID
                if (!empty($query_like_producto_name)) {
                    $produtos->where('id', $query_like_producto_name);
                }
                break;

            case 2: // Busca pelas iniciais do nome
                if (!empty($query_like_producto_name)) {
                    $produtos->where('nome', 'LIKE', $query_like_producto_name . '%');
                }
                break;

            case 3: // Busca pelo código do fabricante
                if (!empty($query_like_producto_name)) {
                    $produtos->where('codigo_fabricante', 'LIKE', '%' . $query_like_producto_name . '%');
                }
                break;

            case 4: // Busca por categoria
                if (!empty($categoria_id)) {
                    $produtos->where('categoria_id', $categoria_id);
                }
                break;

            default:
                // Caso nenhum filtro seja selecionado, traz todos os produtos
                $produtos->where('nome', 'LIKE', "%{$query_like_producto_name}%");
                break;
        }

        $produtos = $produtos->get();

        $pecas_equipamento = PecasEquipamentos::where('equipamento', $ped_said->equipamento_id)
            ->where('tipo_componente', 'Componente')
            ->where('status', 'ativado')
            ->get();

        $patrimonio = Equipamento::where('id', $ped_said->equipamento_id)->get();

        return view('app.pedido_saida_lista.index', [
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'saidas_produto' => $saidas_produto,
            'pedidos_saida' =>  $pedidos_saida,
            'Unidades_de_Medida' => $Unidades_de_Medida,
            'patrimonio' => $patrimonio,
            'pecas_equipamento' => $pecas_equipamento,
            'produtos' => $produtos,
            'categorias' => $categorias
        ]);
    }
}
