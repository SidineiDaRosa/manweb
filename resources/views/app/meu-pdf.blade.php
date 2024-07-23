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

        .preview-image-logo {
            width: 350px;
            height: 150px;
            margin: 0 1px;
        }

        .div-conteudo {
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/logo_fapolpa.jpeg') }}" alt="Imagem do Produto" class="preview-image-logo">
        <div style="text-align: center;margin-top:0%;">Ordem de Serviço #{{ $ordemServico->id }}</div>

        @foreach($empresa as $empresa_f)
        @endforeach
        Empresa:{{$empresa_f->razao_social}} <br>
        @php
        use Carbon\Carbon;
        @endphp
        <p>Emitida em: {{ Carbon::parse($ordemServico->data_emissao)->format('d/m/Y') }} às {{ $ordemServico->hora_emissao }}</p>
    </div>
    <span style="font-size: 20px;
            font-family: 'roboto';
            font-weight:100;">Previsão para início:</span>
    {{ Carbon::parse($ordemServico->data_inicio)->format('d/m/Y') }} às {{ $ordemServico->hora_inicio }} <br>
    Preisão Para finalização:
    {{ Carbon::parse($ordemServico->data_fim)->format('d/m/Y') }} às {{ $ordemServico->hora_fim }} <br>
    Equipamento:
    @foreach($equipamento as $equip)
    @endforeach
    {{$equip->nome}} <br>
    Emissor:
    {{ $ordemServico->emissor }}
    <br>
    <span>Responsável:</span>
   
    Situação: {{ $ordemServico->situacao }} <br>
    Natureza do serviço: {{ $ordemServico->natureza_do_servico }} <br>
    Especialidade do Serviço: {{ $ordemServico->especialidade_do_servico }} <br>
    Descrição dos serviços a serem executados: {{ $ordemServico->descricao }} <br>
    Serviços executados:
    <div class="container">
        <img src="/{{$ordemServico->link_foto}}" alt="Imagem" id="imagem">
    </div>
    <div class="content">
        <table>

        </table>
    </div>
</body>

</html>