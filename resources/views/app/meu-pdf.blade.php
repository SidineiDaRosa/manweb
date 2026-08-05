<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço #{{ $ordemServico->id }}</title>

    <!-- Favicon -->
    <!--
<link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
-->
    <link href="{{ asset('images/logo.png') }}" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 0px;
            margin-bottom: px;
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

        .div-100-2x {
            display: flex;
            flex-direction: row;
            /* Deixa as divs lado a lado */
            background-color: blueviolet;
            height: 200px;
        }

        .child {
            flex: 1;
            /* Divide igualmente o espaço entre as duas divs */
            background-color: lightgray;
            margin: 10px;
        }
    </style>
</head>
<!--  CSS pra criar 2 colunas em no pdf-->
<style>
    .linha {
        width: 100%;
        clear: both;
        height: 150px;
        ;
        margin-bottom: -50px;


    }

    .coluna {
        float: left;
        width: 49%;
        padding: 10px;
        box-sizing: border-box;
        margin-right: 1%;

    }

    .coluna:last-child {
        margin-right: 0;
    }
</style>

<table>
    <tr>
        <td style="width: 100px; text-align: center; vertical-align: middle;">
            <!-- O DOMPDF renderiza melhor se a imagem for um caminho físico ou base64 -->
            <img src="{{ public_path('img/logo_fapolpa.png') }}" style="width: 90px; height: auto;">
        </td>
        <td style="text-align: right; font-size: 12px; line-height: 1.3; vertical-align: middle;">
            <strong>Fapolpa Industria de Papel e Embalagens LTDA</strong><br>
            CNPJ: 82.653.700/0001-20<br>
            Rua Ema Mazalotti Cardoso, 170, Palmas - PR
        </td>
    </tr>
</table>
<div class="coluna">
    @foreach($empresa as $empresa_f)
    @endforeach
    {{$empresa_f->razao_social}}
    @php
    use Carbon\Carbon;
    @endphp
</div>

<div style="text-align: center;margin-top:0%;font-weight:800;font-family:'Poppins', sans-serif; font-size:25px;">Ordem de Serviço #{{ $ordemServico->id }}</div>
<hr class="linha-pontilhada">
<div class="div-container">
    <div class="div-50">Emitida em: {{ Carbon::parse($ordemServico->data_emissao)->format('d/m/Y') }} às {{ $ordemServico->hora_emissao }}</div>
    <div>Emissor: <b>{{strtoupper( $ordemServico->emissor )}}</b> </div>
</div>
<hr class="linha-pontilhada">
Equipamento:
@foreach($equipamento as $equip)
@endforeach
<b> {{strtoupper( $equip->nome)}}</b>
<hr>
<span>Previsão para início:
    {{ Carbon::parse($ordemServico->data_inicio)->format('d/m/Y') }} às {{ $ordemServico->hora_inicio }}-
    Previsão Para finalização:
    {{ Carbon::parse($ordemServico->data_fim)->format('d/m/Y') }} às {{ $ordemServico->hora_fim }}
</span>
<br>
<span>Responsável:</span>
<hr class="linha-pontilhada">
Situação: <b>{{ strtoupper($ordemServico->situacao) }}</b> <br>
<hr class="linha-pontilhada">
Natureza do serviço: <b> {{strtoupper( $ordemServico->natureza_do_servico )}} </b><br>
<hr class="linha-pontilhada">
Especialidade do Serviço: <b>{{ strtoupper($ordemServico->especialidade_do_servico) }}</b>
<hr>
Descrição dos serviços a serem executados:
<hr class="linha-pontilhada">
<span style="color: blue;">{{ $ordemServico->descricao }}</span> <br>
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
    Início: __/__/__,__:__, Fim: __/__/__,__:__, Início: __/__/__,__:__, Fim: __/__/__,__:__
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
    Materiais utilizados:
    <hr class="linha-pontilhada-txt">
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

<style>
    .img-ajustada {
        width: 150px;
        height: 150px;
    }
</style>
<?php
// ===== IMAGEM DA SOLICITAÇÃO =====
if (!empty($solicitacao_os->imagem)) {

    $caminhoReq = public_path('img/request_os/' . $solicitacao_os->imagem);

    if (file_exists($caminhoReq)) {
        $tipoReq = pathinfo($caminhoReq, PATHINFO_EXTENSION);
        $imgReqBase64 = base64_encode(file_get_contents($caminhoReq));

        echo '<img src="data:image/' . $tipoReq . ';base64,' . $imgReqBase64 . '" class="img-ajustada">';
    } else {
        echo '<p style="color:red">Imagem da solicitação não encontrada.</p>';
    }
}



// ===== IMAGEM DA OS =====
if (!empty($ordemServico->link_foto)) {

    $caminho = public_path($ordemServico->link_foto);

    if (file_exists($caminho) && is_file($caminho)) {

        $tipo = pathinfo($caminho, PATHINFO_EXTENSION);
        $imagemBase64 = base64_encode(file_get_contents($caminho));

        echo '<img src="data:image/' . $tipo . ';base64,' . $imagemBase64 . '" class="img-ajustada">';
    }
    // Se não existir a imagem da OS, não mostra nada
}
?>

<style>
    @page {
        size: A4;
        margin: 8mm 8mm 8mm 8mm;
        /* Margens reduzidas para maximizar espaço */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 4px;
        text-align: left;
        vertical-align: top;
    }

    th {
        background-color: #eee;
        font-weight: bold;
        font-size: 10px;
        text-align: center;
    }

    .titulo-central {
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        padding: 5px;
        background-color: #f4f4f4;
    }

    .checkbox-item {
        margin-bottom: 3px;
        display: block;
        font-size: 8.5px;
    }
</style>

<!-- ESSA LINHA FORÇA A QUEBRA PARA A PÁGINA 2 -->
<div style="page-break-before: always;"></div>

<!-- 1. CABEÇALHO DA EMPRESA -->
<p></p>

<table>
    <tr>
        <td style="width: 100px; text-align: center; vertical-align: middle;">
            <!-- O DOMPDF renderiza melhor se a imagem for um caminho físico ou base64 -->
            <img src="{{ public_path('img/logo_fapolpa.png') }}" style="width: 90px; height: auto;">
        </td>
        <td style="text-align: right; font-size: 12px; line-height: 1.3; vertical-align: middle;">
            <strong>Fapolpa Industria de Papel e Embalagens LTDA</strong><br>
            CNPJ: 82.653.700/0001-20<br>
            Rua Ema Mazalotti Cardoso, 170, Palmas - PR
        </td>
    </tr>
</table><!-- FORÇA O CONTEÚDO ABAIXO A COMEÇAR EM UMA NOVA PÁGINA LIMPA -->


<style>
    .pt-container {
        font-family: Arial, sans-serif;
        font-size: 15px;
        /* Fonte compacta para caber em uma página */
        line-height: 1.2;
        color: #000;
    }

    .pt-titulo-central {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 5px;
    }

    /* Estrutura de Linhas e Colunas compatível com PDF */
    .pt-row {
        width: 100%;
        clear: both;
    }

    .pt-col-30 {
        width: 30%;
        float: left;
    }

    .pt-col-40 {
        width: 40%;
        float: left;
    }

    .pt-col-50 {
        width: 50%;
        float: left;
    }

    .pt-block {
        border: 1px solid #000;
        padding: 4px;
        margin-bottom: 5px;
    }

    .pt-bg-header {
        background: #f4f4f4;
        font-weight: bold;
        text-align: center;
        padding: 2px;
        border-bottom: 1px solid #000;
    }

    .pt-clear {
        clear: both;
    }

    .pt-hr {
        border: none;
        border-top: 1px solid #000;
        margin: 4px 0;
    }

    .pt-checkbox-group {
        margin-left: 10px;
        margin-bottom: 3px;
        font-size: 15px;
    }
</style>

<div class="pt-container">

    <!-- TÍTULO -->
    <div class="pt-titulo-central">
        PERMISSÃO DE TRABALHO (PT)
    </div>

    <!-- DADOS GERAIS -->
    <div class="pt-block">
        <div class="pt-row">
            <div class="pt-col-30">
                <strong>PT Nº:</strong> PT{{ $ordemServico->id }}
            </div>
            <div class="pt-col-40">
                <strong>OS:</strong> {{ $ordemServico->id }}
            </div>
            <div class="pt-col-30">
                <strong>Data:</strong> ____/____/________
            </div>
            <div class="pt-clear"></div>
        </div>

        <div class="pt-hr"></div>

        <div class="pt-row">
            <strong>Local de Trabalho:</strong> _______________________________________________
        </div>

        <div class="pt-hr"></div>

        <div class="pt-row">
            <strong>Status:</strong> &nbsp;&nbsp; [ ] Aberto &nbsp;&nbsp;&nbsp;&nbsp; [ ] Em Execução &nbsp;&nbsp;&nbsp;&nbsp; [ ] Encerrado
        </div>

        <div class="pt-hr"></div>

        <div class="pt-row">
            <strong>Descrição da Atividade:</strong> {{ $ordemServico->descricao }}
        </div>

        <div class="pt-hr"></div>

        <div class="pt-row">
            <strong>Responsável pela Execução:</strong> _______________________________________________
        </div>
    </div>

    <!-- RISCOS E MEDIDAS DE CONTROLE -->
    <div class="pt-block" style="padding: 0;">
        <div class="pt-bg-header">RISCOS IDENTIFICADOS E MEDIDAS DE CONTROLE</div>

        <div style="padding: 4px;">
            <!-- Risco 1 e 2 Lado a Lado para economizar espaço vertical -->
            <div class="pt-row">
                <div class="pt-col-50">
                    <strong>[ ] Queda de Nível Diferente</strong> (Altura/Escadas)
                    <div class="pt-checkbox-group">
                        [ ] Uso de cinto paraquedista<br>
                        [ ] Inspeção do andaime/escada<br>
                        [ ] Isolamento da área
                    </div>
                </div>

                <div class="pt-col-50">
                    <strong>[ ] Choque Elétrico</strong> (Painéis/Circuitos)
                    <div class="pt-checkbox-group">
                        [ ] LOTO realizado (Bloqueio)<br>
                        [ ] Ferramentas isoladas<br>
                        [ ] Teste de ausência de tensão
                    </div>
                </div>
                <div class="pt-clear"></div>
            </div>

            <div class="pt-hr"></div>

            <!-- Risco 3 -->
            <div class="pt-row">
                <strong>[ ] Projeção de Partículas / Cortes</strong> (Esmerilhadeira/Corte/Solda)
                <div class="pt-checkbox-group">
                    [ ] Óculos de proteção &nbsp;&nbsp;&nbsp;&nbsp; [ ] Luvas adequadas &nbsp;&nbsp;&nbsp;&nbsp; [ ] Verificar as proteções das ferramentas
                </div>
            </div>
        </div>
    </div>

    <!-- EPIs OBRIGATÓRIOS -->
    <div class="pt-block">
        <div class="pt-bg-header" style="border: none; background: transparent; padding: 0; margin-bottom: 3px;">EPIs OBRIGATÓRIOS</div>
        <div class="pt-row" style="text-align: center;">
            [ ] Capacete &nbsp;&nbsp; [ ] Óculos &nbsp;&nbsp; [ ] Luvas &nbsp;&nbsp; [ ] Botina &nbsp;&nbsp; [ ] Protetor Auricular &nbsp;&nbsp; [ ] Máscara &nbsp;&nbsp; [ ] Cinto
        </div>
    </div>

    <!-- DECLARAÇÃO DA EQUIPE -->
    <div class="pt-block">
        <div style="font-weight: bold; text-align: center; margin-bottom: 2px;">DECLARAÇÃO DA EQUIPE</div>
        <div style="font-size: 9px; text-align: justify; line-height: 1.1;">
            Declaramos que fomos orientados sobre os riscos existentes na execução desta atividade e sobre as medidas de controle e segurança que deverão ser adotadas durante a execução do serviço.
        </div>
    </div>

    <!-- ASSINATURAS -->
    <div class="pt-row" style="margin-top: 25px;">
        <!-- Primeira Linha -->
        <div class="pt-col-50" style="text-align: center; margin-bottom: 25px;">
            ______________________________________<br>
            <strong>SESMT</strong>
        </div>

        <div class="pt-col-50" style="text-align: center; margin-bottom: 25px;">
            ______________________________________<br>
            <strong>Responsável da Área</strong>
        </div>
    </div>
    <div class="pt-row" style="margin-top: 25px;">
        <!-- Segunda Linha -->
        <div class="pt-col-50" style="text-align: center;">
            ______________________________________<br>
            <strong>Supervisor de Manutenção</strong>
        </div>

        <div class="pt-col-50" style="text-align: center;">
            ______________________________________<br>
            <strong>Gerente de Produção</strong>
        </div>

        <div class="pt-clear"></div>
    </div>


</div>

</body>

</html>