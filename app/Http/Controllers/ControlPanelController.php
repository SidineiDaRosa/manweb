<?php

namespace App\Http\Controllers;

use App\Models\ParadaEquipamento;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\OrdemProducao;
use App\Models\RecursosProducao;
use App\Models\PecasEquipamentos;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Importa a facade Log
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
        $categoria = $request->get('categoria');
        $equipamentos = Equipamento::all();
        $produtos = Produto::all();
        $dataAtual = Carbon::now('America/Sao_Paulo');
        // Processa registros em lotes
        PecasEquipamentos::chunk(1000, function ($pecas) {
            foreach ($pecas as $numRegistroPecaEquip) {
                if (!empty($numRegistroPecaEquip)) {
                    // Pega a data da última substituição e o intervalo de manutenção
                    $dataSubstituicao = $numRegistroPecaEquip->data_substituicao;
                    $intervaloManutencao = $numRegistroPecaEquip->intervalo_manutencao; // Em horas corridas
                    // Verifica se a data e o intervalo estão definidos e são válidos
                    if ($dataSubstituicao && $intervaloManutencao && is_numeric($intervaloManutencao)) {
                        try {

                            // Supondo que $dataSubstituicao seja uma string ou um objeto de data
                            $dataSubstituicao = Carbon::parse($dataSubstituicao);

                            // Obtém a data e hora atual
                            $dataAtual = Carbon::now();

                            // Calcula a diferença em horas
                            $diferencaHoras = $dataAtual->diffInHours($dataSubstituicao);
                            // Atualiza o campo horas_proxima_manutencao
                            $numRegistroPecaEquip->horas_proxima_manutencao = $intervaloManutencao - $diferencaHoras;

                            $numRegistroPecaEquip->save();
                        } catch (\Exception $e) {
                            // Captura exceções e exibe mensagem de erro
                            echo 'Erro: ' . $e->getMessage() . '<br>';
                        }
                    }
                }
            }
        });
        $ordens_servicos = PecasEquipamentos::where('horas_proxima_manutencao', '<=', 72)->get();

        return view('site.control_panel', ['ordens_servicos' =>  $ordens_servicos, 'equipamentos' => $equipamentos, 'produtos' => $produtos]);
    }
    public function users_management()
    {
      
        // Retorna view com dados e links de configuração
       return view('site.users_management');
    
    }
}
