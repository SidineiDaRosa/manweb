<?php

namespace App\Http\Controllers;

use App\Models\ParadaEquipamento;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\OrdemProducao;
use App\Models\RecursosProducao;
use App\Models\PecasEquipamentos;
use DateTime;
use Illuminate\Http\Request;

/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */

class ControlPanelController extends Controller
{

    public function index(Request $request)

    {
        $horas_proxima_manutencao = $request->get('horas_proxima_manutencao');
        echo ($horas_proxima_manutencao);
        $equipamentos = Equipamento::all();
        $produtos = Produto::all();

        $tipo_atualizacao = 0;
        // $dataAtual=Date('now',$timezone);
        $diaAtual = date('d');
        $mesAtual = date('m');
        $anoAatual = date('y');
        // $timezone = new DateTimeZone('America/Sao_Paulo');
        $totalDiasAtual = ($diaAtual + ($mesAtual * 31) + ($anoAatual * 365)) - 30;
        $totHorasAtual = $totalDiasAtual * 24;
        $totRegPecEquip = PecasEquipamentos::select('id')->max('id');
        $x = 1;
        while ($x <= $totRegPecEquip) {

            $numRegistroPecaEquip = PecasEquipamentos::find($x); //busca o registro do produto com o id da entrada do produto

            if (!empty($numRegistroPecaEquip)) { //verifica se exite este registro
                $dataProximaManutencao = $numRegistroPecaEquip->data_proxima_manutencao; //Pega a data da proxima manutenção
                // $dataFutura = $numRegistroPecaEquip->horas_proxima_manutencao - 10; // soma estoque antigo com a entrada de produto

                $dataProximaManutencao_impld = implode("/", array_reverse(explode("-", $dataProximaManutencao))); //converte uma data para formato brasileiro trazido do banco mysql
                $ontem = DateTime::createFromFormat('d/m/Y',  $dataProximaManutencao_impld); //formata a data       
                $totDiasFuturo = ($ontem->format('d') + ($ontem->format('m')  * 31) + ($ontem->format('y') * 365)) - 30;
                $totHorasFuturo =  $totDiasFuturo * 24;
                $horasRestante = $totHorasFuturo - $totHorasAtual;
                $numRegistroPecaEquip->horas_proxima_manutencao = $horasRestante;
                $numRegistroPecaEquip->save();
                if ($horasRestante <= 72) {
                }
            }
            $x += 1;
        }
        if ($x = $totRegPecEquip) {
            echo ('total de peças equipamento ok');
            if (isset($horas_proxima_manutencao)) {
                echo ('a varial exite');
                if (!empty($horas_proxima_manutencao)) { //verifica se exite este registro

                    $ordens_servicos = PecasEquipamentos::where('horas_proxima_manutencao', ('>='), -4000)
                        ->where('horas_proxima_manutencao', ('<='), $horas_proxima_manutencao)->get();
                    $x = 0;
                    $totRegPecEquip = 0;
                    return view('site.control_panel', ['ordens_servicos' =>  $ordens_servicos, 'equipamentos' => $equipamentos, 'produtos' => $produtos]);
                }
            } else {
                echo ('total de peças equipamento não ok');
                $ordens_servicos = PecasEquipamentos::where('horas_proxima_manutencao', ('>='), 1)
                    ->where('horas_proxima_manutencao', ('<='),400)->get();
                $x = 0;
                $totRegPecEquip = 0;
                return view('site.control_panel', ['ordens_servicos' =>  $ordens_servicos, 'equipamentos' => $equipamentos, 'produtos' => $produtos]);
            }
        }
        if ($tipo_atualizacao >= 1) {

            $numRegistroPecaEquip = PecasEquipamentos::find(13); //busca o registro do produto com o id da entrada do produto
            $dataFutura = $numRegistroPecaEquip->data_proxima_manutencao;
            //$dataFuturaFormat = DateTime::createFromFormat('d/m/Y',$dataFutura);
            $data = implode("/", array_reverse(explode("-", $dataFutura))); //converte uma data para formato brasileiro trazido do banco mysql
            //$data = implode("-",array_reverse(explode("/",$data))); enviando para o banco----https://www.l9web.com.br/blog/?cat=3
            $data_final = $data;
            // $ontem = DateTime::createFromFormat('d/m/Y', $data_final)->modify('-1 day');
            $ontem = DateTime::createFromFormat('d/m/Y', $data_final);

            echo ('A data trazida do banco é=' . $ontem->format('d/m/Y') . '<hr></>');
            echo ('Dia=' . $ontem->format('d') . '<hr></>');
            echo ('Mes=' . $ontem->format('m') . '<hr></>');
            echo ('Ano=' . $ontem->format('y') . '<hr></>');
            $totDiasFuturo = ($ontem->format('d') + ($ontem->format('m')  * 31) + ($ontem->format('y') * 365)) - 30;
            $totHorasFuturo =  $totDiasFuturo * 24;
            echo ('Dias futuro=' . $totDiasFuturo . '<hr></>');
            echo ('Horas futuro=' . $totHorasFuturo . '<hr></>');
            echo ('Diferença de horas entre datas=' . ($totHorasFuturo - $totHorasAtual) . '<hr></>');
        }
    }
}
