<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Empresas;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\Funcionario;
use App\Models\PedidoCompra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Query\OrExpr;
use App\Models\Servicos_executado;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $empresa = Empresas::all();
        $equipamento = Equipamento::all();
        $id = $request->get("id");
        $printerOs = $request->get("printer");
        $tipo_consulta = $request->get("tipo_consulta");

        $funcionarios = Funcionario::all();
        $ordens_servicos = OrdemServico::where('id', 0)->get();
        $valorTotal = 0;
        //
        //filtro ordem de serviço pelo data inicial e situação
        //  $prensa = onda_b_tmp_prensa0::where('TimeString', ('>'), '27/04/2023 14:08:08')->where('TimeString', ('<'), '27/04/2023 15:08:08')->get();
        $hoje = date("Y-m-d"); //data de hoje
        $data = date("Y-m-d", strtotime("-120 days")); //desconta dias para pegar a data inicial
        $dataAmanha = date("Y-m-d", strtotime("+1 days")); //desconta dias para pegar a data inicial
        //$dataInicio = '2023-01-01';
        $dataInicio = $data;
        $dataFim = $hoje; //formato en
        $dataFim_1 = date("Y-m-d", strtotime("+500 days")); //formato en
        $funcionarios = Funcionario::all();
        $situacao = 'aberto';
        //Busca ordens do dia abertas
        $ordens_servicos_hoje = OrdemServico::where('situacao', $situacao)
            ->where('data_inicio', ('='), $dataFim)
            ->where('empresa_id', ('<='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->count();
        //Busca ordens do dia fehadas
        $ordens_servicos_hoje_fechado = OrdemServico::where('situacao', 'fechado')
            ->where('data_fim', ('='), $dataFim)
            ->where('empresa_id', ('<='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->count();
            $ordens_servicos = OrdemServico::where('situacao', $situacao)//Ordens de serviços abertas futuras para gerar gráfico
            ->whereRaw('data_inicio > ? AND data_fim < ?', [$dataInicio, $dataFim_1])
            ->where('empresa_id', '<=', 2)
            ->orderBy('data_inicio')
            ->orderBy('hora_inicio')
            ->get();
        $ordens_servicos_emandamento = OrdemServico::where('situacao', 'em andamento') //Ordens de serviço em andamento
            //->where('data_inicio', ('>='), $dataInicio)
            //->where('data_fim', ('<='), $dataFim)
            ->where('empresa_id', ('<='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos_fech_hoje = OrdemServico::where('situacao', 'fechado') //Ordens de serviço fechadas hoje
            ->where('data_fim', ('='), $dataFim)
            ->where('empresa_id', ('<='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos_futura = OrdemServico::where('situacao', 'aberto') //Ordens de serviço futuras
            ->where('data_fim', ('>'), $dataFim)
            ->where('empresa_id', ('='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos_abarta_passada = OrdemServico::where('situacao', 'aberto') //Ordens de serviço futuras
            ->where('data_inicio', ('>='), $dataFim)
            ->where('data_inicio', ('<='), $dataAmanha)
            ->where('empresa_id', ('='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos_abarta_vencidas = OrdemServico::where('situacao', 'aberto') //Ordens de serviço vencidas
            ->where('data_fim', ('<'), $dataFim)
            ->where('empresa_id', ('='), 2)
            ->orderby('data_fim')->orderby('hora_fim')->get();
        $countOSFechado = OrdemServico::where('situacao', $situacao)
            ->where('data_inicio', ('>='), $dataInicio)
            ->where('data_fim', ('<='), $dataFim)->count();
        $countOS = OrdemServico::where('situacao', 'fechado')
            ->where('data_inicio', ('>='), $dataInicio)
            ->where('data_fim', ('<='), $dataFim)->count();
        $countOSAberto = OrdemServico::where('situacao', 'aberto')->where('empresa_id', ('<='), 2)->count();
        $countOSFechado = OrdemServico::where('situacao', 'fechado')->where('empresa_id', ('<='), 2)->count();
        $pedidosCompraAberto = PedidoCompra::where('status', 'aberto')->get();
        return view('app.layouts.dashboard', [
            'equipamento' => $equipamento, 'ordens_servicos' => $ordens_servicos, 'funcionarios' => $funcionarios,
            'empresa' => $empresa,
            'countos' => $countOS, 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'countos_fechado' => $countOSFechado,
            'total_aberto' => $countOSAberto, 'total_fechado' => $countOSFechado, 'ordens_servicos_hoje' => $ordens_servicos_hoje,
            'ordens_servicos_hoje_fechado' => $ordens_servicos_hoje_fechado,
            'ordens_servicos_emandamento' => $ordens_servicos_emandamento,
            'pedidos_compra' => $pedidosCompraAberto,
            'ordens_servicos_fech_hoje' => $ordens_servicos_fech_hoje,
            'ordens_servicos_futura' => $ordens_servicos_futura,
            'ordens_servicos_abarta_passada' => $ordens_servicos_abarta_passada,
            'ordens_servicos_abarta_vencidas' => $ordens_servicos_abarta_vencidas

        ]);
    }
}
