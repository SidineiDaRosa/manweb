<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\PedidoCompra;
use App\Models\UnidadeMedida;
use App\Models\PedidoCompraLista;
use App\Models\Produto;
use App\Models\User;
use App\Models\PedidoCompraEvento;
use App\Models\EstoqueProdutos;
use App\Models\EntradaProduto;
use Carbon\Carbon;

class PedidoCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $situacao = $request->get('situacao');
        $data_inicio = $request->get('data_inicio');
        $data_fim = $request->get('data_fim');
        $produto_id = $request->get('produto_id');
        // Busca os pedidos de compra cuja qual contem os produtos situação Aberto
        if (isset($produto_id)) {
            $pedidos_compra_produto = PedidoCompraLista::where('produto_id', $produto_id)->get();

            $pedido_ids = $pedidos_compra_produto->pluck('pedidos_compra_id')->toArray();

            $pedido_compra = PedidoCompra::where('status', $situacao)
                ->whereIn('id', $pedido_ids)
                ->get();

            $emissores = User::all();
            $equipamentos = Equipamento::all();
            $funcionarios = Funcionario::all();

            return view('app.pedido_compra.index', [
                'equipamentos' => $equipamentos,
                'funcionarios' => $funcionarios,
                'pedidos_compra' => $pedido_compra,
                'emissores' => $emissores
            ]);
        } else {
            $emissores = User::all();
            if (isset($situacao)) {
                $emissores = User::all();
                $equipamentos = Equipamento::all();
                $funcionarios = Funcionario::all();

                $query = PedidoCompra::query(); // inicializa a query
                $query->whereBetween('data_emissao', [$data_inicio, $data_fim]); // filtra período

                if (isset($situacao)) {
                    $termo = request('descricao'); // ou outro input text na view
                    switch ($situacao) {
                        case 'aberto':
                        case 'fechado':
                        case 'cancelado':
                        case 'indefinido':
                        case 'aceito':
                            $query->where('status', $situacao);
                            break;
                        case 'descricao':
                            if ($termo) {
                                $query->where(function ($q) use ($termo) {
                                    $q->where('descricao', 'like', "%{$termo}%")
                                        ->orWhereHas('equipamento', function ($sub) use ($termo) {
                                            $sub->where('nome', 'like', "%{$termo}%");
                                        });
                                });
                            }
                            $query->orderBy('descricao', 'asc');
                            break;
                        case 'all':
                        default:
                            // sem filtro adicional
                            break;
                    }
                }

                $pedidos_compra = $query->get();


                // Eventos no período
                $eventos = PedidoCompraEvento::whereBetween('created_at', [$data_inicio, $data_fim])->get();

                return view('app.pedido_compra.index', [
                    'equipamentos'   => $equipamentos,
                    'funcionarios'   => $funcionarios,
                    'pedidos_compra' => $pedidos_compra,
                    'emissores'      => $emissores,
                    'eventos'        => $eventos
                ]);
            } else {
                // A variável $situacao não está declarada
                // Faça alguma outra coisa aqui
                $equipamentos = Equipamento::all();
                $funcionarios = Funcionario::all();
                $pedidos_compra = PedidoCompra::where('status', '')->get();
                return view('app.pedido_compra.index', [
                    'equipamentos' => $equipamentos,
                    'funcionarios' => $funcionarios,
                    'pedidos_compra' => $pedidos_compra,
                    'emissores' => $emissores
                ]);
            }
        }
        //
    }
    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$patrimonio_id = $request->get('equipamento_id');
        $patrimonio_id = $request->get('equipamento_id');
        $funcionarios = Funcionario::all();
        $patrimonio_f = Equipamento::where('id', $patrimonio_id)->get();
        $patrimonio = Equipamento::find($patrimonio_id); // Utilize find() para encontrar um único registro
        $patrimonio_id = $patrimonio->id;
        $empresa_id = $patrimonio->empresa_id; // Acesse diretamente o atributo empresa_id do equipamento encontrado
        $empresa = Empresas::where('id', $empresa_id)->get();
        return view('app.pedido_compra.create', [
            'funcionarios' => $funcionarios,
            'patrimonio_id' => $patrimonio_id,
            'empresa' => $empresa,
            'patrimonio_f' => $patrimonio_f
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
        $pedidoCompra = PedidoCompra::where('hora_prevista', $request->hora_prevista)->first();

        if ($pedidoCompra) {
            return response()->json(['error' => 'Já existe um registro com essa hora prevista!']);
        }

        PedidoCompra::updateOrCreate(['id' => $request->id], $request->all());
        //eturn response()->json(['success' => 'Registro gravado com sucesso!']);

        // Resto do seu código para retornar a view com os dados atualizados
        $produto_id = $request->get('23');
        //$pedidoCompraId = $request->get('numpedidocompra');
        //$pedidoCompraId = $request->numpedidocompra;
        $pedidoCompra  = PedidoCompra::whereNotNull('created_at') // Garante que 'created_at' não seja nulo
            ->where('hora_prevista', $request->hora_prevista) // Filtra pela hora prevista fornecida
            ->latest() // Ordena pela data de criação em ordem decrescente
            ->first(); // Obtém o primeiro registro do resultado ordenado
        $pedidoCompraId = $pedidoCompra->id;
        // Resto do seu código para retornar a view com os dados atualizados
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $unidades_de_medida = UnidadeMedida::all();
        $pedidos_compra = PedidoCompra::where('id', $pedidoCompraId)->get();
        $produtos = Produto::all();
        $pedidoCompraLista = PedidoCompraLista::where('pedidos_compra_id', $pedidoCompraId)->get();
        $produto_rg = Produto::where('id', $produto_id)->get();
        $emissores = User::all();
        //$pedidoCompraLista = PedidoCompraLista::all();
        return view('app.pedido_compra.index_lista', [
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios,
            'pedidos_compra' => $pedidos_compra,
            'produto_id' =>  $produto_id,
            'pedido_compra_lista' => $pedidoCompraLista,
            'produtos' => $produtos,
            'unidades_de_medida' => $unidades_de_medida,
            'produto_rg' => $produto_rg,
            'emissores' => $emissores
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
     * @param App\Models\PedidoCompra $pedido_compra_id
     * @return \Illuminate\Http\Response
     */
    public function edit($pedido_compra_id)
    {
        $pedido_compra = PedidoCompra::find($pedido_compra_id);
        $patrimonio_id = $pedido_compra->equipamento_id;
        $patrimonio = Equipamento::find($patrimonio_id);
        $patrimonio_f = Equipamento::where('id', $patrimonio_id)->get();
        $funcionarios = Funcionario::all();
        $empresa = Empresas::where('id', $patrimonio->empresa_id)->get();
        return view('app.pedido_compra.edit', [
            'pedido_compra' => $pedido_compra,
            'funcionarios' => $funcionarios,
            'patrimonio_id' => $patrimonio_id,
            'empresa' => $empresa,
            'patrimonio_f' => $patrimonio_f
        ]);
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
        // 1. Recupera o pedido de compra
        $pedido_compra = PedidoCompra::findOrFail($id);

        // 2. Pega o status antigo antes de atualizar
        $status_antigo = $pedido_compra->status;
        $status_novo   = $request->status;

        // 3. Cria o evento primeiro, com status antigo e novo


        PedidoCompraEvento::create([
            'pedido_compra_id' => $pedido_compra->id,
            'status_anterior'  => $status_antigo,
            'status_novo'      => $status_novo,
            'usuario_id'       => auth()->id() ?? 1,
            'justificativa'    => $request->justificativa,
            'anexo'            => 'uploads/teste.pdf',
            'created_at'       => Carbon::now('America/Sao_Paulo'),
            'updated_at'       => Carbon::now('America/Sao_Paulo'),
        ]);
        // 4. Atualiza o pedido de compra
        $pedido_compra->update([
            'status'        => $status_novo,
            'descricao'     => $request->descricao,
            'data_prevista' => $request->data_prevista,
            'hora_prevista' => $request->hora_prevista,
        ]);

        // 5. Redireciona
        return redirect()->route('pedido-compra.index')
            ->with('success', 'Evento registrado e pedido de compra atualizado com sucesso!');
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
    public function open_po_id($id)
    {
        $emissores    = User::all();
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();

        // se quiser só um: findOrFail($id)
        // se quiser lista (coleção): get()
        if ($id >= 1) {


            $pedidos_compra = PedidoCompra::where('id', $id)->get();

            $eventos = PedidoCompraEvento::where('pedido_compra_id', $id)->get();

            return view('app.pedido_compra.index', [
                'equipamentos'   => $equipamentos,
                'funcionarios'   => $funcionarios,
                'pedidos_compra' => $pedidos_compra, // agora é Collection
                'emissores'      => $emissores,
                'eventos'        => $eventos
            ]);
        }
    }
    public function storeItem(Request $request)
    {


        // 1️⃣ Registrar a entrada no histórico
        EntradaProduto::create([
            'produto_id'    => $request->produto_id,
            'quantidade'    => $request->quantidade,
            'fornecedor_id' => 8,
            'empresa_id'    => 2,
            'valor'         => $request->valor ?? 0,
            'data'          => Carbon::now('America/Sao_Paulo')->format('Y-m-d'),
            'nota_fiscal'   => $request->nota_fiscal ?? null,
        ]);

        // 2️⃣ Atualizar ou criar o estoque existente
        $estoque = EstoqueProdutos::firstOrCreate(
            [
                'produto_id' => $request->produto_id,
                'empresa_id' => 2
            ],
            [
                'quantidade' => 0 // se não existir, inicia com 0
            ]
        );

        // Adicionar a quantidade da entrada
        $estoque->quantidade += $request->quantidade;
        $estoque->save();

        // 3️⃣ Retornar JSON com nova quantidade
        return response()->json([
            'success' => true,
            'mensagem' => 'Entrada registrada com sucesso!',
            'novo_estoque' => $estoque->quantidade,
        ]);
    }
}
