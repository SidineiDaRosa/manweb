<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Equipamento;
use App\Models\EstoqueProdutos;
use App\Models\OrdemServico;
use App\Models\Funcionario;
use App\Models\PedidoCompra;
use App\Models\Prduto;
use App\Models\Produto;
use App\Models\Projeto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Query\OrExpr;
use App\Models\Servicos_executado;
use Facade\FlareClient\View;

class DahboardStatusOsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo'); //define a data e hora DE SÃO PAULO
        $empresa = Empresas::all();

        $equipamentos = Equipamento::all();

        $id = $request->get("id");
        $printerOs = $request->get("printer");
        $tipo_consulta = $request->get("tipo_consulta");
        //Busca funcionários ativos
        $funcionarios = Funcionario::where('status', 'Ativo')->get();
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
        $today = $hoje; //formato en
        $dataFim_1 = date("Y-m-d", strtotime("+500 days")); //formato en
        $dataFutura_1_days = date("Y-m-d", strtotime("+1 days")); //formato en
        $dataFutura_5_days = date("Y-m-d", strtotime("+5 days")); //formato en

        $situacao = 'aberto';
        //Busca ordens do dia abertas conta
        $ordens_servicos_hoje = OrdemServico::where('situacao', 'aberto')
            ->where('data_inicio', ('>='), $today)
            //->where('data_fim', ('<='), $dataFim)
            ->where('empresa_id', ('='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->count();
        //Busca ordens do dia fehadas
        $ordens_servicos_hoje_fechado = OrdemServico::where('situacao', 'fechado')
            ->where('data_fim', ('='), $dataFim)
            ->where('empresa_id', ('<='), 2)
            ->orderby('data_inicio')->orderby('hora_inicio')->count();
        $ordens_servicos = OrdemServico::where('situacao', $situacao) //Ordens de serviços abertas futuras para gerar gráfico
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
        //--------------------------------------------------------//
        // Datas futuras
        $dataFutura_1_days = Carbon::now()->addDays(1)->format('Y-m-d');
        $dataFutura_5_days = Carbon::now()->addDays(5)->format('Y-m-d');

        // Busca as ordens de serviço que atendem aos critérios
        $ordens_servicos_futura = OrdemServico::where('situacao', 'Aberto')
            ->whereBetween('data_inicio', [$dataFutura_1_days, $dataFutura_5_days])
            ->where('empresa_id', 2)
            ->orderBy('data_inicio')
            ->orderBy('hora_inicio')
            ->get();

        // Calcula o valor GUT para cada ordem de serviço e armazena em uma coleção
        $ordens_servicos_futura = $ordens_servicos_futura->map(function ($ordem) {
            $ordem->valor_gut = $ordem->gravidade * $ordem->urgencia * $ordem->tendencia;
            return $ordem;
        });
        // Ordena a coleção pelo valor GUT em ordem decrescente
        $ordens_servicos_futura = $ordens_servicos_futura->sortByDesc('valor_gut')->values();
        //-------------------------------------------------------//
        // Busca ordens do dia e ordena de acordo com o GUT
        // Busca as ordens de serviço que atendem aos critérios
        $dataHoje = Carbon::now()->format('Y-m-d');

        // Busca as ordens de serviço abertas que esta no intervalo de excução e não venceu ainda
        $ordens_servicos_aberta_hoje = OrdemServico::where('situacao', 'Aberto')
            ->whereDate('data_inicio', '<=', $dataHoje)
            ->whereDate('data_fim', '>=', $dataHoje)
            ->where('empresa_id', 2)
            ->get();
        // Calcula o valor GUT para cada ordem de serviço e armazena em uma coleção
        $ordens_servicos_aberta_hoje = $ordens_servicos_aberta_hoje->map(function ($ordem) {
            $ordem->valor_gut = $ordem->gravidade * $ordem->urgencia * $ordem->tendencia;
            return $ordem;
        });

        // Ordena a coleção pelo valor GUT em ordem decrescente
        $ordens_servicos_aberta_hoje = $ordens_servicos_aberta_hoje->sortByDesc('valor_gut')->values();
        //----------------------------------------------------------------------//
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
        //-----------------------------------------------------------//
        // Função para obter as datas da semana atual (segunda a domingo)

        function getWeekDates()
        {
            $dates = [];

            // Define a data atual
            $currentDate = Carbon::now();

            // Encontra a última segunda-feira (ou a segunda-feira atual)
            $monday = $currentDate->copy()->startOfWeek(Carbon::MONDAY);

            // Adiciona cada dia da semana ao array de datas
            for ($i = 0; $i < 7; $i++) {
                $dates[] = $monday->copy()->addDays($i);
            }

            return $dates;
        }

        // Chama a função para obter as datas da semana atual
        $weekDates = getWeekDates();

        // Inicializa o array para armazenar as ordens de serviço por dia
        $ordensPorDia = [
            'Monday' => [],
            'Tuesday' => [],
            'Wednesday' => [],
            'Thursday' => [],
            'Friday' => [],
            'Saturday' => [],
            'Sunday' => [],
        ];

        // Exemplo de busca de ordens de serviço para a semana atual (segunda a domingo)
        $ordens_servicos_semana_atual = OrdemServico::whereBetween('data_inicio', [$weekDates[0]->format('Y-m-d'), $weekDates[6]->format('Y-m-d')])
            ->where('empresa_id', 2)
            ->orderBy('data_inicio')
            ->orderBy('hora_inicio')
            ->get();

        // Calcula o valor GUT para cada ordem de serviço e armazena em uma coleção
        $ordens_servicos_semana_atual = $ordens_servicos_semana_atual->map(function ($ordem) {
            $ordem->valor_gut = $ordem->gravidade * $ordem->urgencia * $ordem->tendencia;
            return $ordem;
        });

        // Organiza as ordens de serviço por dia da semana
        foreach ($ordens_servicos_semana_atual as $ordem) {
            $dayOfWeek = Carbon::parse($ordem->data_inicio)->format('l');
            $ordensPorDia[$dayOfWeek][] = $ordem;
        }
        //------------------------------------------------------------//
        // Função para obter os próximos 7 dias a partir da data atual

        function getNext7Days()
        {
            $dates = [];

            // Define a data atual
            $currentDate = Carbon::now();

            // Adiciona cada um dos próximos 7 dias ao array de datas
            for ($i = 0; $i < 7; $i++) {
                $dates[] = $currentDate->copy()->addDays($i);
            }

            return $dates;
        }

        // Função para gerar HTML com os dias da semana e as ordens de serviço

        // Chama a função para obter os próximos 7 dias
        $next7Days = getNext7Days();

        // Inicializa o array para armazenar as ordens de serviço por dia
        $ordensPorDia = [
            'Monday' => [],
            'Tuesday' => [],
            'Wednesday' => [],
            'Thursday' => [],
            'Friday' => [],
            'Saturday' => [],
            'Sunday' => [],
        ];

        // Exemplo de busca de ordens de serviço para os próximos 7 dias
        $ordens_servicos_proximos_dias = OrdemServico::whereBetween('data_inicio', [$next7Days[0]->format('Y-m-d'), $next7Days[6]->format('Y-m-d')])
            ->where('empresa_id', 2)
            ->orderBy('data_inicio')
            ->orderBy('hora_inicio')
            ->get();

        // Calcula o valor GUT para cada ordem de serviço e armazena em uma coleção
        $ordens_servicos_proximos_dias = $ordens_servicos_proximos_dias->map(function ($ordem) {
            $ordem->valor_gut = $ordem->gravidade * $ordem->urgencia * $ordem->tendencia;
            return $ordem;
        });

        // Organiza as ordens de serviço por dia da semana
        foreach ($ordens_servicos_proximos_dias as $ordem) {
            $dayOfWeek = Carbon::parse($ordem->data_inicio)->format('l');
            $ordensPorDia[$dayOfWeek][] = $ordem;
        }

        //------------------------------------------------------------//
        // Variáveis para armazenar a contagem das ordens de serviço para cada dia
        $today = Carbon::now()->startOfDay(); // Data de hoje, sem componentes de hora/minuto/segundo
        // Define o fuso horário para São Paulo
        $timezone = 'America/Sao_Paulo';
        $ordens_servicos_next_day = OrdemServico::whereDate('data_inicio', $today->copy()->addDays(1))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        // Calcula o valor GUT para cada ordem de serviço e armazena em uma coleção
        $ordens_servicos_next_day = $ordens_servicos_next_day->map(function ($ordem) {
            $ordem->valor_gut = $ordem->gravidade * $ordem->urgencia * $ordem->tendencia;
            return $ordem;
        });

        $ordens_servicos_second_day = OrdemServico::whereDate('data_inicio', $today->copy()->addDays(2))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();
        // Calcula o valor GUT para cada ordem de serviço e armazena em uma coleção
        $ordens_servicos_second_day =  $ordens_servicos_second_day->map(function ($ordem) {
            $ordem->valor_gut = $ordem->gravidade * $ordem->urgencia * $ordem->tendencia;
            return $ordem;
        });

        // Verificar resultados

        $ordens_servicos_third_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(3))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        $ordens_servicos_fourth_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(4))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        $ordens_servicos_fifth_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(5))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        $ordens_servicos_sixth_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(6))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        $ordens_servicos_seventh_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(7))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();
        $ordens_servicos_next = OrdemServico::where('data_inicio', '>', $today->copy()->addDays(3)) // Os após 3 dias a partir de hoje
            ->where('situacao', 'aberto') // Filtra pela situação "aberto"
            ->where('empresa_id', '<=', 2) // Filtra por empresa_id menor ou igual a 2
            ->get();
        $countOSAberto = OrdemServico::where('situacao', 'aberto')->where('empresa_id', ('<='), 2)->count();
        $countOSFechado = OrdemServico::where('situacao', 'fechado')->where('empresa_id', ('<='), 2)->count();
        $pedidosCompraAberto = PedidoCompra::where('status', 'aberto')->get();
        $countOSPendenteDeAprovacao = OrdemServico::where('situacao', 'aberto')->where('empresa_id', ('<='), 2)->count(); // busca os pendente de aprovação

        $produtos_estoque_critico = EstoqueProdutos::whereColumn('quantidade', '<=', 'estoque_minimo')
            ->where('criticidade', '>=', 1)
            ->orderByRaw('quantidade = 0 desc') // Garante que quantidade 0 apareça primeiro
            ->orderBy('criticidade', 'desc') // Criticidade decrescente
            ->orderBy('quantidade', 'asc') // Quantidade crescente para os demais itens
            ->get();

        $produtos = Produto::all();
        $assets = Equipamento::whereRaw('equipamento_pai = id')->get();
        //---------------------------------------------------//
        //  Pega as os da semana                       //
        //--------------------------------------------------//

        // Obtém o início da semana atual
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');

        // Variáveis para cada dia da semana
        $mondayOrders = $this->getOrdersForDay($startOfWeek);
        $tuesdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDay()->format('Y-m-d'));
        $wednesdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(2)->format('Y-m-d'));
        $thursdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(3)->format('Y-m-d'));
        $fridayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(4)->format('Y-m-d'));
        $saturdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(5)->format('Y-m-d'));
        $sundayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(6)->format('Y-m-d'));

        //---------------------------------------------------//
        //  envia dados para view                           //
        //--------------------------------------------------//
        return view('app.ordem_servico.dashboard_status_os', [
            'equipamentos' => $equipamentos,
            'ordens_servicos' => $ordens_servicos,
            'funcionarios' => $funcionarios,
            'empresa' => $empresa,
            'countos' => $countOS,
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
            'countos_fechado' => $countOSFechado,
            'total_aberto' => $countOSAberto,
            'total_fechado' => $countOSFechado,
            'ordens_servicos_hoje' => $ordens_servicos_hoje,
            'ordens_servicos_hoje_fechado' => $ordens_servicos_hoje_fechado,
            'ordens_servicos_emandamento' => $ordens_servicos_emandamento,
            'pedidos_compra' => $pedidosCompraAberto,
            'ordens_servicos_fech_hoje' => $ordens_servicos_fech_hoje,
            'ordens_servicos_futura' => $ordens_servicos_futura,
            'ordens_servicos_aberta_hoje' => $ordens_servicos_aberta_hoje,
            'ordens_servicos_abarta_vencidas' => $ordens_servicos_abarta_vencidas,
            'monday' => $ordensPorDia['Monday'],
            'tuesday' => $ordensPorDia['Tuesday'],
            'wednesday' => $ordensPorDia['Wednesday'],
            'thursday' => $ordensPorDia['Thursday'],
            'friday' => $ordensPorDia['Friday'],
            'saturday' => $ordensPorDia['Saturday'],
            'sunday' => $ordensPorDia['Sunday'],
            'ordens_servicos_next_day' => $ordens_servicos_next_day,
            'ordens_servicos_second_day' => $ordens_servicos_second_day,
            'ordens_servicos_third_day' => $ordens_servicos_third_day,
            'ordens_servicos_next' => $ordens_servicos_next,
            'assets' => $assets,
            'mondayOrders' => $mondayOrders,
            'tuesdayOrders' => $tuesdayOrders,
            'wednesdayOrders' => $wednesdayOrders,
            'thursdayOrders' => $thursdayOrders,
            'fridayOrders' => $fridayOrders,
            'saturdayOrders' => $saturdayOrders,
            'sundayOrders' => $sundayOrders
        ]);
    }
    private function getOrdersForDay($date)
    {
        $dayStart = $date . ' 00:00:00';
        $dayEnd = $date . ' 23:59:59';

        // Filtra ordens de serviço para o dia especificado
        return OrdemServico::whereBetween('data_inicio', [$dayStart, $dayEnd])
            ->where('situacao', 'aberto')
            ->get();
    }
    public function programer_os()
    {
        // Verificar resultados
        // Variáveis para armazenar a contagem das ordens de serviço para cada dia
        $today = Carbon::now()->startOfDay(); // Data de hoje, sem componentes de hora/minuto/segundo
        // Define o fuso horário para São Paulo
        $timezone = 'America/Sao_Paulo';
        $ordens_servicos_next_day = OrdemServico::whereDate('data_inicio', $today->copy()->addDays(1))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();
        $ordens_servicos_second_day = OrdemServico::whereDate('data_inicio', $today->copy()->addDays(2))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();
        $ordens_servicos_third_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(3))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        $ordens_servicos_fourth_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(4))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        $ordens_servicos_fifth_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(5))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();

        $ordens_servicos_sixth_day = OrdemServico::where('data_inicio', '=', $today->copy()->addDays(6))
            ->where('situacao', 'aberto')
            ->where('empresa_id', '<=', 2)
            ->get();
        //---------------------------------------------------//
        //  Pega as os da semana                       //
        //--------------------------------------------------//

        // Obtém o início da semana atual
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');

        // Variáveis para cada dia da semana
        $mondayOrders = $this->getOrdersForDay($startOfWeek);
        $tuesdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDay()->format('Y-m-d'));
        $wednesdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(2)->format('Y-m-d'));
        $thursdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(3)->format('Y-m-d'));
        $fridayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(4)->format('Y-m-d'));
        $saturdayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(5)->format('Y-m-d'));
        $sundayOrders = $this->getOrdersForDay(Carbon::parse($startOfWeek)->addDays(6)->format('Y-m-d'));
        // ordem para cada semana  em 52 semanas
        $ordens_servicos_por_semana = [];

        for ($week = 1; $week <= 52; $week++) {
            $ordens_servicos_por_semana[$week] = OrdemServico::whereRaw('WEEK(data_inicio, 1) = ?', [$week])
                ->where('situacao', 'aberto')
                ->where('empresa_id', '<=', 2)
                ->get();
        }
        $ordem_servico_gantt = OrdemServico::where('situacao', 'aberto')->get();
        // echo ($ordem_servico_gantt);
        $projetos = Projeto::all();
        return view('app.ordem_servico.programer_os', [
            'mondayOrders' => $mondayOrders,
            'tuesdayOrders' => $tuesdayOrders,
            'wednesdayOrders' => $wednesdayOrders,
            'thursdayOrders' => $thursdayOrders,
            'fridayOrders' => $fridayOrders,
            'saturdayOrders' => $saturdayOrders,
            'sundayOrders' => $sundayOrders,
            'ordens_servicos_por_semana' => $ordens_servicos_por_semana,
            'ordem_servico_gantt' => $ordem_servico_gantt,
            'projetos' => $projetos

        ]);
    }
    public function show_os()
    {
        $agora = Carbon::now(); // Data e hora atuais
        $hora_atual = $agora->format('H:i:s'); // Pega apenas a hora atual

        $equipamentos = Equipamento::all();

        $funcionarios = Funcionario::where('status', 'ativo')
            ->where(function ($q) {
                $q->where('funcao', 'mecanico')
                    ->orWhere('funcao', 'eletricista');
            })
            ->get();

        $ordens_servicos = OrdemServico::whereIn('situacao', ['aberto', 'em andamento', 'pausado'])
            ->where('data_inicio', '<=', $agora)
            ->where('hora_inicio', '<=', $hora_atual)  
            ->where('data_fim', '>=', $agora) // corrigido
            ->where('hora_fim', '>=', $hora_atual)     // se você tiver hora_fim separada
            ->where('hora_fim', '>=', $hora_atual)  
            ->orderByRaw("
            CASE 
                WHEN `check` = 1 THEN 2
                ELSE 1
            END
        ")
            ->orderBy('urgencia', 'desc')
            ->get();

        return view('app.ordem_servico.panel_os', [
            'ordens_servicos' => $ordens_servicos,
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios
        ]);
    }

    public function check_ordem_servico(Request $request)
    {
        $ordem_servico = OrdemServico::find($request->id_os);

        $ordem_servico->check = 1;
        $ordem_servico->save();
        $hoje = Carbon::today();
        $equipamentos = Equipamento::all();
        $funcionarios = Funcionario::all();
        $ordens_servicos = OrdemServico::whereIn('situacao', ['aberto', 'em andamento', 'pausado'])
            ->whereDate('data_inicio', '<=', $hoje)
            ->whereDate('data_fim', '>=', $hoje)
            ->orderByRaw("
        CASE 
            WHEN `check` = 1 THEN 2
            ELSE 1
        END
    ")
            ->orderBy('urgencia', 'desc')
            ->get();
        return View('app.ordem_servico.panel_os', [
            'ordens_servicos' => $ordens_servicos,
            'equipamentos' => $equipamentos,
            'funcionarios' => $funcionarios
        ]);
    }
}
