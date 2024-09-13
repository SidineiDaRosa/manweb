<!DOCTYPE html>
<html>

<head>
    <title>Ordem de Serviço #{{ $ordemServico->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 1px;
            margin-bottom: 1px;
            border: 1px solid #000;
            /* Cor da borda preta e largura de 1px */
            padding: 5px;
            /* Espaçamento interno da div */
            margin: 5px;
            /* Espaçamento externo da div */
        }

        .header,
        .content {
            margin-bottom: 1px;
        }

        .header {
            text-align: center;
        }

        .preview-image-logo {
            width: 200px;
            height: 90px;
            margin-top: -2px;
            margin-bottom: -30px;
        }

        .div-conteudo {
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
        }

        .linha-pontilhada {
            border: none;
            border-top: 1px dotted #000;
            /* Cor preta, estilo pontilhado, largura de 1px */
            margin: 1px 0;
            /* Espaçamento acima e abaixo */
        }

        .linha-pontilhada-txt {
            border: none;
            border-top: 1px dotted #000;
            /* Cor preta, estilo pontilhado, largura de 1px */
            margin: 20px 0;
            /* Espaçamento acima e abaixo */
        }

        .linha-solida {
            border: none;
            border-top: 1px;
            /* Cor preta, estilo pontilhado, largura de 1px */
            margin: 0px 0;
            /* Espaçamento acima e abaixo */
        }

        .div-container {
            width: 100%;
            /* A div-container ocupa 100% da largura do contêiner pai */
            display: flex;
            /* Define a container como um contêiner flexível */
            flex-wrap: wrap;
            /* Permite que os itens dentro da container quebrem para a linha seguinte, se necessário */
        }

        .div-50 {
            width: 50%;
            /* Define que cada div-50 ocupa 50% da largura da div-container */
            height: auto;
            /* Ajusta a altura da div-50 automaticamente com base no conteúdo */
            box-sizing: border-box;
            /* Inclui o padding e borda na largura total do elemento */
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo_fapolpa.jpeg') }}" alt="Imagem do Produto" class="preview-image-logo">
        <div style="text-align: center;margin-top:0%;">Ordem de Serviço #{{ $ordemServico->id }}</div>
        @foreach($empresa as $empresa_f)
        @endforeach
        {{$empresa_f->razao_social}} <br>
        @php
        use Carbon\Carbon;
        @endphp
    </div>
    <hr class="linha-pontilhada">
    <div class="div-container">
        <div class="div-50">Emitida em: {{ Carbon::parse($ordemServico->data_emissao)->format('d/m/Y') }} às {{ $ordemServico->hora_emissao }}</div>
        <div>Emissor:{{ $ordemServico->emissor }}</div>
    </div>
    <hr class="linha-pontilhada">
    Equipamento:
    @foreach($equipamento as $equip)
    @endforeach
    {{$equip->nome}}
    <hr>
    <span>Previsão para início:
        {{ Carbon::parse($ordemServico->data_inicio)->format('d/m/Y') }} às {{ $ordemServico->hora_inicio }}-
        Previsão Para finalização:
        {{ Carbon::parse($ordemServico->data_fim)->format('d/m/Y') }} às {{ $ordemServico->hora_fim }}
    </span>
    <br>
    <span>Responsável:{{ $ordemServico->responsavel }}</span>
    <hr class="linha-pontilhada">
    Situação: {{ $ordemServico->situacao }} <br>
    <hr class="linha-pontilhada">
    Natureza do serviço: {{ $ordemServico->natureza_do_servico }} <br>
    <hr class="linha-pontilhada">
    Especialidade do Serviço: {{ $ordemServico->especialidade_do_servico }}
    <hr>
    Descrição dos serviços a serem executados:
    <hr class="linha-pontilhada">
    {{ $ordemServico->descricao }}
    <hr>
    Descrição dos serviços executados:
    <hr class="linha-pontilhada">
    @if(count($servicos_executado) > 0)
    <table>
        <thead>
            <tr>
                <th>Início</th>
                <th>fim</th>
                <th>Funcionário</th>
                <th>Descrição</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicos_executado as $servico)
            <tr>
                <td>{{ \Carbon\Carbon::parse($servico->data_inicio)->format('d/m/Y') }} às {{ $servico->hora_inicio }}</td>
                <td>{{ \Carbon\Carbon::parse($servico->data_fim)->format('d/m/Y') }} às {{ $servico->hora_fim }}</td>
                <td>
                    @foreach($funcionarios as $funcionario)
                    @if($funcionario->id == $servico->funcionario_id)
                    {{ $funcionario->primeiro_nome }}
                    @endif
                    @endforeach
                </td>
                <td>{{ $servico->descricao }}</td>
                <td>{{ number_format($servico->subtotal, 2, ',', '.') }}hs</td>
            </tr>
            <hr class="linha-pontilhada">
            @endforeach
        </tbody>
    </table>
    @else
    <div class="message">
        <hr>
        Serviços executados:
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt ">
        <hr class="linha-pontilhada-txt">
    </div>
    @endif
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10px;
                /* Ajuste de fonte */
                table-layout: auto;
                /* Ajuste o layout da tabela */
            }

            th,
            td {
                padding: 2px;
                /* Reduz padding para compactação */
                border: 0.5px solid #000;
                /* Borda fina */
                text-align: left;
                white-space: nowrap;
                /* Evita quebra de linha */
            }

            th {
                background-color: #f4f4f4;
                font-weight: bold;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            /* Ajuste o tamanho da tabela se necessário */
            .table-container {
                overflow-x: auto;
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
    <div class="container">
        <img src="/{{$ordemServico->link_foto}}" alt="Imagem" id="imagem">
    </div>
</body>

</html>