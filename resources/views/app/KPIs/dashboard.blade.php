@extends('app.layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>

<main class="content">

    <!-- Lista de Funcionários e Total de Horas -->
    @foreach($servicos_executados as $servicos_executados_f)
    <div hidden>
        <p>Funcionario ID: {{ $servicos_executados_f->funcionario->primeiro_nome }} - Total de horas trabalhadas: {{ number_format($servicos_executados_f->total_horas, 2) }} horas</p>
    </div>
    @endforeach

    <!-- Gráfico de Barras para Total de Horas por Funcionário -->
    <div id="bar-chart" style="width: 600px; height: 400px; margin-left: 20px; margin-top: 20px;"></div>

    <script>
        // Criando os dados para o gráfico a partir dos dados de PHP
        var funcionarios = @json($servicos_executados -> map(function($item) {
            return $item -> funcionario -> primeiro_nome;
        }));

        var totalHoras = @json($servicos_executados -> map(function($item) {
            return $item -> total_horas;
        }));

        // Inicializando o gráfico ECharts
        var myChart = echarts.init(document.getElementById('bar-chart'));

        // Configuração do gráfico
        var option = {
            title: {
                text: 'Total de Horas Trabalhadas por Funcionário em 90 dias',
                subtext: 'Gráfico de Barras Horizontal',
                left: 'center'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            xAxis: {
                type: 'value',
                name: 'Horas Trabalhadas',
                position: 'top'
            },
            yAxis: {
                type: 'category',
                data: funcionarios,
                name: 'Funcionário'
            },
            series: [{
                name: 'Horas',
                type: 'bar',
                data: totalHoras,
                itemStyle: {
                    color: '#4CAF50'
                }
            }]
        };

        // Usando a configuração para renderizar o gráfico
        myChart.setOption(option);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>

    <!-- Lista de Ordens de Serviço e Total de Horas -->
    @foreach($ordens_servico as $ordem_servico)
    @if($ordem_servico->total_horas > 0)
    <div hidden>
        <p>{{ $ordem_servico->equipamento->nome }} - Total de horas: {{ number_format($ordem_servico->total_horas, 2) }} hs</p>
    </div>
    @endif
    @endforeach

    <!-- Gráfico de Barras Horizontal para Ordens de Serviço -->
    <div id="bar-chart-asset" style="width: 1000px; height: 400px; margin-left: 200px; margin-top: 20px;"></div>
    <script>
        // Criando os dados para o gráfico a partir dos dados de PHP, considerando apenas as ordens com total_horas > 0
        var equipamentos = @json($ordens_servico -> filter(function($item) {
            return $item -> total_horas > 0.0; // Filtra as ordens com total_horas > 0
        }) -> map(function($item) {
            return $item -> equipamento -> nome; // Extrai o nome do equipamento
        }) -> values()); // .values() para garantir um array reindexado

        var totalHoras = @json($ordens_servico -> filter(function($item) {
            return $item -> total_horas > 0.0; // Filtra as ordens com total_horas > 0
        }) -> map(function($item) {
            return $item -> total_horas; // Extrai o total de horas
        }) -> values()); // .values() para garantir um array reindexado

        // Calcular a altura total do gráfico com base no número de equipamentos
        var alturaGrafico = equipamentos.length * 25; // 20px por barra

        // Ajusta a altura do gráfico dinamicamente
        document.getElementById('bar-chart-asset').style.height = alturaGrafico + 'px';

        // Inicializando o gráfico ECharts
        var myChart = echarts.init(document.getElementById('bar-chart-asset'));

        // Configuração do gráfico
        var option = {
            title: {
                text: 'Total de Horas por Ativo nos 90 dias',
                subtext: 'Gráfico de Barras Horizontal',
                left: 'center'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            xAxis: {
                type: 'value',
                name: 'Horas Trabalhadas',
                position: 'top'
            },
            yAxis: {
                type: 'category',
                data: equipamentos, // Equipamentos como categorias no eixo Y
                name: 'Equipamento',
                margin: 200 // Espaço extra entre o gráfico e as labels
            },
            series: [{
                name: 'Horas',
                type: 'bar',
                data: totalHoras, // Total de horas para cada equipamento
                itemStyle: {
                    color: '#4CAF50'
                }
            }]
        };

        // Usando a configuração para renderizar o gráfico
        myChart.setOption(option);
    </script>
</main>