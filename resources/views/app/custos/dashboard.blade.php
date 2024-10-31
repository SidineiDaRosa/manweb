<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Custos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Inclua seu CSS -->
</head>

<body>
    <div class="container mt-5">
        <h2>Custos por Equipamento</h2>
        <table class="table">
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
                'nome' => $saida->equipamento->nome, // Armazena o nome do equipamento
                'total' => 0,
                ];
                }
                $totaisPorEquipamento[$equipamentoId]['total'] += $saida->subtotal;
                }
                @endphp

                @foreach ($totaisPorEquipamento as $equipamentoId => $dados)
                <tr>
                    <td>{{ $equipamentoId }}</td>
                    <td>{{ $dados['nome'] }}</td>
                    <td>R$ {{ number_format($dados['total'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                // Calcular o total geral
                $totalGeral = array_sum(array_column($totaisPorEquipamento, 'total'));
                @endphp
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>Total Geral:</strong></td>
                    <td><strong>R$ {{ number_format($totalGeral, 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
        <h2>Custos por Equipamento</h2>
        <table class="table">
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
                'nome' => $saida->equipamento->nome, // Armazena o nome do equipamento
                'total' => 0,
                'detalhes' => [], // Array para armazenar detalhes de cada saída
                ];
                }
                $totaisPorEquipamento[$equipamentoId]['total'] += $saida->subtotal;
                $totaisPorEquipamento[$equipamentoId]['detalhes'][] = $saida; // Adiciona a saída para detalhes
                }
                @endphp

                @foreach ($totaisPorEquipamento as $equipamentoId => $dados)
                <tr>
                    <td>{{ $equipamentoId }}</td>
                    <td>{{ $dados['nome'] }}</td>
                    <td>R$ {{ number_format($dados['total'], 2, ',', '.') }}</td>
                </tr>
                @foreach ($dados['detalhes'] as $saidaDetalhe)
                <tr>
                    <td colspan="1"></td> <!-- Célula vazia para indentação -->
                    <td>Saída ID: {{ $saidaDetalhe->id }}</td>
                    <td>R$ {{ number_format($saidaDetalhe->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
                <!-- Soma Total por Equipamento -->
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>Total por Equipamento:</strong></td>
                    <td><strong>R$ {{ number_format($dados['total'], 2, ',', '.') }}</strong></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                // Calcular o total geral
                $totalGeral = array_sum(array_column($totaisPorEquipamento, 'total'));
                @endphp
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>Total Geral:</strong></td>
                    <td><strong>R$ {{ number_format($totalGeral, 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="{{ asset('js/app.js') }}"></script> <!-- Inclua seu JS -->
</body>

</html>