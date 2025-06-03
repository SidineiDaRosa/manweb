<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\PedidoCompra; // Correto: namespace do modelo
use App\Models\PedidoCompraLista; // Correto: namespace do modelo
use Carbon\Carbon;

class PedidoCompraAutoGenerateController extends Controller
{
    public function pedido_compra_auto_generate(Request $request)
    {
        // Validação dos dados recebidos, se necessário
        $request->validate([
            'id' => 'required|integer', // Ajuste conforme sua necessidade
            'patrimonio_id' => 'required|integer', // Ajuste conforme sua necessidade
        ]);

        // Obtenha o ID dos dados enviados
        $patrimonio_id = $request->input('patrimonio_id');
        $produto_id = $request->input('id');
        $quantidade = $request->input('quantidade');

        // Aqui você pode adicionar a lógica para gerar o pedido de compra
        // Exemplo de lógica fictícia
        // Defina os dados manualmente
        // Adiciona 10 dias à data prevista
        // Data e hora atuais
        $data_emissao = now('America/Sao_Paulo')->toDateString();
        $hora_emissao = now('America/Sao_Paulo')->format('H:i');

        // Adiciona 10 dias à data atual
        $data_prevista = Carbon::now('America/Sao_Paulo')->addDays(10)->toDateString();

        // Hora prevista permanece a mesma
        $hora_prevista = '15:00';

        $pedidoData = [
            'data_emissao' => $data_emissao,
            'hora_emissao' => $hora_emissao,
            'data_prevista' => $data_prevista,
            'hora_prevista' => $hora_prevista,
            'equipamento_id' => $patrimonio_id,                      // ID do equipamento
            'funcionarios_id' => auth()->id(), // ID do funcionário usuário logado no momento
            'status' => 'aberto',                     // Status
            'descricao' => 'Descrição do pedido de compra gerado ', // Descrição
        ];
        // Log dos dados para depuração
        Log::info('Dados do pedido de compra:', $pedidoData);

        // Tente criar o pedido de compra
        try {
            // Cria um novo pedido de compra com os dados fornecidos
            $pedidoCompra = PedidoCompra::create($pedidoData);

            // Verifique se o objeto foi criado e salve seu ID, se necessário
            Log::info('Pedido de compra criado com sucesso:', ['id' => $pedidoCompra->id]);
            // Obtém o último pedido criado (o mesmo que $pedidoCompra, mas só se você não tiver outras inserções simultâneas)
            $ultimoPedido = PedidoCompra::latest('created_at')->first();
            //cria lista 
            // Crie o objeto e salve
            $pedidoCompraLista = new PedidoCompraLista([
                'pedidos_compra_id' => $ultimoPedido->id,
                'produto_id' => $produto_id,
                'quantidade' => $quantidade,
            ]);

            $pedidoCompraLista->save();

            // Retorne uma resposta, por exemplo:
            return response()->json([
                'message' => 'Item adicionado à lista de pedidos com sucesso!',
                'data' => $pedidoCompraLista,
            ]);
            // Retorna uma resposta com uma mensagem de sucesso
            return response()->json(['message' => 'Pedido de compra gerado com sucesso no controllador.'], 200);
        } catch (\Exception $e) {
            // Em caso de erro, responda com uma mensagem de erro
            return response()->json(['message' => 'Erro ao gerar pedido de compra, Atualize o formulário: ' . $e->getMessage()], 500);
        }
    }
}
