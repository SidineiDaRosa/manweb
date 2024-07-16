<?php

namespace App\Http\Controllers;

use App\Models\OrdemProducao;
use App\Models\RecursosProducao;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\PedidoCompra;
use Illuminate\Http\Request;
use App\Models\Servicos_executado;
use App\Models\PecasEquipamentos;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\DB; // Importa a classe DB
use Exception; // Importa a classe Exception

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
    //------------------------------------------------------//
    public function startos(Request $request)
    {
        //--------------------------------------------//
        //--init uma ordem de serviço---------------//
        // Encontre o registro pelo ID
        $id_os = $request->input('valor');
        $ordem_servico = OrdemServico::find($id_os); //procura o registro da ordem
        // Atualize o campo 'nome' com o valor enviado na requisição
        date_default_timezone_set('America/Sao_Paulo'); //define a data e hora DE SÃO PAULO
        $today = date("Y-m-d"); //data de hoje
        $timeNew = date('H:i:s');
        $ordem_servico->data_inicio = $today;
        $ordem_servico->hora_inicio =  $timeNew;
        $ordem_servico->situacao = 'em andamento'; //fecha a situação
        $ordem_servico->status_servicos = 50; //coloca o status em 100%
        $ordem_servico->save(); //salva a atleração da ordem
        return response()->json(['mensagem' => 'ordem atualizada para em andamento']);
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
        $pedido_compra->data_fechamento = $today;
        //$pedido_compra->hora_fim =  $timeNew;
        $pedido_compra->status = 'fechado'; //fecha a situação
        // $pedido_compra->status_servicos = 100; //coloca o status em 100%
        $pedido_compra->save(); //salva a atleração do pedido
        return response()->json(['mensagem' => 'Pedido atualizado para fechado']);
    }
    public function update_chek_list(Request $request)
    {
        // Encontre o registro pelo ID que sta em valor
        $id = $request->input('valor');
        // Atualize o campo 'nome' com o valor enviado na requisição
        date_default_timezone_set('America/Sao_Paulo'); //define a data e hora DE SÃO PAULO
        $today = date("Y-m-d"); //data de hoje
        $timeNew = date('H:i:s');
        $pecaEquipamento = PecasEquipamentos::find($request->input('valor')); //busca o registro do produto com o id da entrada do produto
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
        // $diferenca_horas = ($diferenca->days * 24) + $diferenca->h + ($diferenca->i / 60) + ($diferenca->s / 3600);
        $diferenca_horas = intval(($diferenca->days * 24) + $diferenca->h + ($diferenca->i / 60) + ($diferenca->s / 3600));

        //------------------------------------------------//
        $id_os = $request->input('id_os');
        $tipo_de_servico = $request->input('tipo_de_servico');
        $estado = $request->input('estado');
        // Define os dados manualmente
        //$data_inicio = date('Y-m-d H:i:s', strtotime('-10 minutes'));

        $data_inicio = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $time_now = $timeNew;
        $hora_inicio = $time_now = date('H:i:s', strtotime('-12 minutes'));
        $ordemServico = OrdemServico::where('id', $id_os)->where('situacao', 'em andamento')->first(); //Busca a ordem de serviço correspondente e verifica se é válido
        if (isset($ordemServico) && is_numeric($id_os) && $id_os > 0) {
            $data = [
                'ordem_servico_id' => $id_os,
                'data_inicio' => $today,
                'hora_inicio' => $hora_inicio,
                'data_fim' => $today,
                'hora_fim' => $timeNew,
                'funcionario_id' => 2,
                'descricao' =>  $pecaEquipamento->descricao,
                'subtotal' => '0.15',
                'tipo_de_servico' => $tipo_de_servico,
                'estado' => $estado,
            ];
            // Cria um novo objeto Servicos_executado com os dados definidos manualmente
            $servico_executado = new Servicos_executado();
            $servico_executado->ordem_servico_id = $data['ordem_servico_id'];
            $servico_executado->data_inicio = $data['data_inicio'];
            $servico_executado->hora_inicio = $data['hora_inicio'];
            $servico_executado->data_fim = $data['data_fim'];
            $servico_executado->hora_fim = $data['hora_fim'];
            $servico_executado->funcionario_id = $data['funcionario_id'];
            $servico_executado->descricao = $data['descricao'];
            $servico_executado->subtotal = $data['subtotal'];
            $servico_executado->tipo_de_servico = $data['tipo_de_servico'];
            $servico_executado->estado = $data['estado'];
            // Salva o registro no banco de dados
            $servico_executado->save();
            //---------------------------------------------------//
            //   salva alteração em  peças equipamentos          //
            $pecaEquipamento->data_substituicao = $today; // soma estoque antigo com a entrada de produto
            $pecaEquipamento->data_proxima_manutencao = $data_proxima_manutencao; // soma estoque antigo com a entrada de produto
            $pecaEquipamento->horas_proxima_manutencao = $diferenca_horas;
            $pecaEquipamento->save();//salva alteração em  peças equipamentos
        } else {
            return response()->json(['mensagem' => 'ID da ordem de serviço inválido.'], 400);
        };

        return response()->json(['mensagem' => 'Checklist de número:', 'id' => $id, 'intervalo' => $diferenca_horas]);
    }
    public function search(Request $request)
    {
        $search = $request->get('query');
        $results = Equipamento::where('empresa_id', 'LIKE', "%{$search}%")->get(['id', 'nome']); // Certifique-se que 'nome' é um campo existente

        return response()->json($results);
    }
}
