<?php

namespace App\Http\Controllers;

use App\Models\OrdemProducao;
use App\Models\RecursosProducao;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\PedidoCompra;
use Illuminate\Http\Request;
use App\Models\Servicos_executado;

class UtilsController extends Controller
{
    public function getHorimetroInicial(Request $request)
    {
        $equipamento_id = $request->get('equipamento_id');
        $horimetro_inicial = OrdemProducao::where('equipamento_id', $equipamento_id)->orderBy('id', 'desc')->first();
        $horimetro_inicial = $horimetro_inicial->horimetro_final;
        echo json_encode($horimetro_inicial);
    }
    public function getContOsEquip(Request $request)
    {
        $dataInicio = $request->get('parametro1');
        $dataFim = $request->get('parametro2');
        $equipamento_id = $request->get('parametro3');
        $situacao = 'aberto';
        //$equipamento_id = $request->get('equipamento_id');
        //$contOsEquip = OrdemServico::where('equipamento_id', $equipamento_id)->count();
        $osEquipCount = OrdemServico::where('situacao', $situacao)
            ->where('data_inicio', ('>='), $dataInicio)
            ->where('data_inicio', ('<='), $dataFim)
            ->orderby('data_inicio')->orderby('hora_inicio')->count();
        echo json_encode($osEquipCount);
    }

    public function getHorimetroInicialRecursos(Request $request)
    {
        $equipamento_id = $request->get('equipamento_id');
        $horimetro_inicial = RecursosProducao::where('equipamento_id', $equipamento_id)->orderBy('id', 'desc')->first();
        $horimetro_inicial = $horimetro_inicial->horimetro_final;
        echo json_encode($horimetro_inicial);
    }
    //pega a ultima os e adiciona 1
    public function getLastIdOs(Request $request)
    {
        $id_os = $request->get('id_os');

        $id_os = OrdemServico::select('id')->max('id');

        echo json_encode($id_os);
    }

    public function getTodasOs()
    {
        $equipamento = Equipamento::all();
        $ordens_servicos = OrdemServico::all();
        return view('app.ordem_servico.index', ['produtos' => $equipamento, 'ordens_servicos' => $ordens_servicos]);
    }
    public function autocomplete(Request $request)
    {
        $query = $request->input('query');

        //$items = Equipamento::where('nome', 'like', '%' . $query . '%')->get(); // Supondo que você queira buscar itens pelo nome
        $items = Equipamento::where('empresa_id', $query)->get(); // Supondo que você queira buscar itens pelo nome

        return response()->json($items);
    }
    public function updateos(Request $request)
    {
        //--------------------------------------------//
        //--Fecha uma ordem de serviço---------------//
        // Encontre o registro pelo ID
        $id_os = $request->input('valor');
        $ordem_servico = OrdemServico::find($id_os); //procura o registro da ordem

        // Atualize o campo 'nome' com o valor enviado na requisição
        date_default_timezone_set('America/Sao_Paulo'); //define a data e hora DE SÃO PAULO
        $today = date("Y-m-d"); //data de hoje
        $timeNew = date('H:i:s');
        $ordem_servico->data_fim = $today;
        $ordem_servico->hora_fim =  $timeNew;
        $ordem_servico->situacao = 'fechado'; //fecha a situação
        $ordem_servico->status_servicos = 100; //coloca o status em 100%
        $ordem_servico->save(); //salva a atleração da ordem
        return response()->json(['mensagem' => 'ordem atualizada para fechado1']);
    }
    public function validarDataHoraTermino(Request $request)
    {
        //---------------------------------------//
        //--VALIDAÇÃO DE DATA E HORA DE INICIO DE SERVIÇO-//
        $dataInicio = $request->input('data_inicio');
        $horaInicio = $request->input('hora_inicio');
        $dataFim = $request->input('data_fim');
        $horaFim = $request->input('hora_fim');
        $funcionarioId = $request->input('executante');
        $existeServicoExecutado = Servicos_Executado::where('funcionario_id', $funcionarioId)
            ->where(function ($query) use ($dataInicio, $dataFim, $horaInicio, $horaFim) {
                $query->where(function ($query) use ($dataInicio, $dataFim, $horaInicio, $horaFim) {
                    $query->where('data_inicio', '>=', $dataInicio)
                        ->where('data_inicio', '<=', $dataFim)
                        ->where('hora_inicio', '>=', $horaInicio)
                        ->where('hora_inicio', '<=', $horaFim);
                })
                    ->orWhere(function ($query) use ($dataInicio, $dataFim, $horaInicio, $horaFim) {
                        $query->where('data_fim', '>=', $dataInicio)
                            ->where('data_fim', '<=', $dataFim)
                            ->where('hora_fim', '>=', $horaInicio)
                            ->where('hora_fim', '<=', $horaFim);
                    });
            })
            ->exists();

        return response()->json(['valid' => !$existeServicoExecutado]);
    }

    public function updatepedidocompra(Request $request)
    {
        //--------------------------------------------//
        //--altera status pedido de compra---------------//
        // Encontre o registro pelo ID
        $pedido_compra_id = $request->input('valor');
        $pedido_compra = PedidoCompra::find($pedido_compra_id); //procura o registro da ordem

        // Atualize o campo 'nome' com o valor enviado na requisição
        date_default_timezone_set('America/Sao_Paulo'); //define a data e hora DE SÃO PAULO
        $today = date("Y-m-d"); //data de hoje
        $timeNew = date('H:i:s');
        $pedido_compra->data_fechamento= $today;
        //$pedido_compra->hora_fim =  $timeNew;
        $pedido_compra->status = 'fechado'; //fecha a situação
       // $pedido_compra->status_servicos = 100; //coloca o status em 100%
        $pedido_compra->save(); //salva a atleração do pedido
        return response()->json(['mensagem' => 'Pedido atualizado para fechado']);
    }
}
