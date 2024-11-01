<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Custos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Inclua seu CSS -->
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script> <!-- Biblioteca ECharts -->
</head>

<body>
    <div class="container mt-5" style="width: 50%;">
       
        <h2>Custos por Equipamento</h2>
        <table class="table" >
            <thead>
                <tr>
                    <th>ID do Equipamento</th>
                    <th>Nome do Equipamento</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Agrupar dados por equipamento_id
                    $totaisPorEquipamento = [];
                    foreach ($saidas_produtos as $saida) {
                        $equipamentoId = $saida->equipamento_id; // Supondo que equipamento_id exista
                        if (!isset($totaisPorEquipamento[$equipamentoId])) {
                            $totaisPorEquipamento[$equipamentoId] = [
                                'nome' => $saida->equipamento->nome ?? 'Nome não disponível',
                                'total' => 0,
                                'detalhes' => [],
                            ];
                        }
                        $totaisPorEquipamento[$equipamentoId]['total'] += $saida->subtotal;
                        $totaisPorEquipamento[$equipamentoId]['detalhes'][] = $saida;
                    }
                @endphp

                @foreach ($totaisPorEquipamento as $equipamentoId => $dados)
                    <tr>
                        <td>{{ $equipamentoId }}</td>
                        <td><span style="font-size: 20px;font-weight:bold;">{{ $dados['nome'] }}</span></td>
                        <td>R$ {{ number_format($dados['total'], 2, ',', '.') }}</td>
                    </tr>
                    @foreach ($dados['detalhes'] as $saidaDetalhe)
                        <tr>
                            <td colspan="1"></td>
                            <td>Saída ID: {{ $saidaDetalhe->id }}</td>
                            <td>R$ {{ number_format($saidaDetalhe->subtotal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Total por Equipamento:</strong></td>
                        <td><strong>R$ {{ number_format($dados['total'], 2, ',', '.') }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                    $totalGeral = array_sum(array_column($totaisPorEquipamento, 'total'));
                @endphp
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>Total Geral:</strong></td>
                    <td><strong>R$ {{ number_format($totalGeral, 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="container mt-5">
        <h2>Gráfico de Custos Totais por Equipamento</h2>
        <div id="chart" style="width: 100%; height: 1000px; margin-top: 20px;"></div> <!-- Altura ajustada -->
    </div>

    <script>
        var data = [
            @foreach($totaisPorEquipamento as $equipamentoId => $dados)
                { name: '{{ $dados['nome'] }}', total: {{ $dados['total'] }} },
            @endforeach
        ];

        var chart = echarts.init(document.getElementById('chart'));

        var option = {
            title: {
                text: 'Custos Totais por Equipamento'
            },
            tooltip: {
                trigger: 'axis',
                formatter: function(params) {
                    return params[0].name + ': R$ ' + params[0].value.toFixed(2).replace('.', ',');
                }
            },
            xAxis: {
                type: 'value',
                name: 'Total (R$)',
                axisLabel: {
                    formatter: 'R$ {value}'
                }
            },
            yAxis: {
                type: 'category',
                data: data.map(item => item.name),
                name: 'Equipamento'
            },
            series: [{
                type: 'bar',
                data: data.map(item => item.total),
                itemStyle: {
                    color: '#65B581'
                },
                label: {
                    show: true,
                    position: 'right',
                    formatter: 'R$ {c}',
                }
            }]
        };

        chart.setOption(option);
    </script>

    <script src="{{ asset('js/app.js') }}"></script> <!-- Inclua seu JS -->
</body>

</html>
