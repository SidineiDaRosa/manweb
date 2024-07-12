<!DOCTYPE html>
<html>

<head>
    <title>Ordem de Serviço #{{ $ordemServico->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 1px;
            margin-bottom: 1px;
        }

        .header,
        .content {
            margin-bottom: 1px;
        }

        .header {
            text-align: center;
        }

        .content {
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .preview-image-logo {
            width: 350px;
            height: 150px;
            margin: 0 1px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo_fapolpa.jpeg') }}" alt="Imagem do Produto" class="preview-image-logo">
        <div style="text-align: center;margin-top:0%;">Ordem de Serviço #{{ $ordemServico->id }}</div>
        <hr>
        @php
        use Carbon\Carbon;
        @endphp
        <p>Emitida em: {{ Carbon::parse($ordemServico->data_emissao)->format('d/m/Y') }} às {{ $ordemServico->hora_emissao }}</p>
    </div>
    <div class="content">
        <table>
            <tr>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
            <tr>
                <td>Data Início</td>
                <td>{{ Carbon::parse($ordemServico->data_inicio)->format('d/m/Y') }} às {{ $ordemServico->hora_inicio }}</td>
            </tr>
            <tr>
                <td>Data Fim</td>
                <td>{{ Carbon::parse($ordemServico->data_fim)->format('d/m/Y') }} às {{ $ordemServico->hora_fim }}</td>
            </tr>
            <tr>
                <td>Equipamento ID</td>
                @foreach($equipamento as $equip)
                @endforeach
                <td>{{$equip->nome}}</td>
            </tr>
            <tr>
                <td>Emissor</td>
                <td>{{ $ordemServico->emissor }}</td>
            </tr>
            <tr>
                <td>Responsável</td>
                <td>{{ $ordemServico->responsavel }}</td>
            </tr>
            <tr>
                <td>Descrição</td>
                <td>{{ $ordemServico->descricao }}</td>
            </tr>
            <tr>
                <td>Status dos Serviços</td>
                <td>{{ $ordemServico->status_servicos }}</td>
            </tr>
            <tr>
                <td>Link da Foto</td>
                <td>{{ $ordemServico->link_foto }}</td>
            </tr>
            <tr>
                <td>Gravidade</td>
                <td>{{ $ordemServico->gravidade }}</td>
            </tr>
            <tr>
                <td>Urgência</td>
                <td>{{ $ordemServico->urgencia }}</td>
            </tr>
            <tr>
                <td>Tendência</td>
                <td>{{ $ordemServico->tendencia }}</td>
            </tr>
            <tr>
                <td>Empresa ID</td>
                <td>{{ $ordemServico->empresa_id }}</td>
            </tr>
            <tr>
                <td>Situação</td>
                <td>{{ $ordemServico->situacao }}</td>
            </tr>
            <tr>
                <td>Natureza do Serviço</td>
                <td>{{ $ordemServico->natureza_do_servico }}</td>
            </tr>
            <tr>
                <td>Especialidade do Serviço</td>
                <td>{{ $ordemServico->especialidade_do_servico }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
