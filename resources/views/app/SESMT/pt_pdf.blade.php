<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    
    <title>PT - Permissão de Trabalho Nº {{ $pt->id ?? '____' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 5px 10px 10px 10px;
            /* topo menor */
        }

        .header {
            border: 1px solid #000;
            padding: 1px;
            margin-top: 0;
            margin-bottom: 8px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            text-align: center;
            font-size: 14px;
        }

        .label {
            font-weight: bold;
            background: #f0f0f0;
            padding: 2px 5px;
            display: inline-block;
            margin-bottom: 5px;
        }

        h4 {
            margin: 8px 0 5px 0;
            font-size: 12px;
        }

        .risco-box {
            border: 1px solid #000;
            padding: 5px;
            margin-bottom: 5px;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
        }

        footer:after {
            content: "Página " counter(page) " de " counter(pages);
        }

        .assinaturas {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .assinatura-box {
            text-align: center;
            width: 30%;
        }

        .assinatura-box span {
            display: block;
            margin-top: 60px;
            border-top: 1px solid #000;
        }

        .observacoes-box {
            margin-top: 10px;
            border: 1px solid #000;
            padding: 5px;
            min-height: 50px;
        }
    </style>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <!-- Coluna 1: Logo -->
            <td style="width:130px; vertical-align:top;">
                <img src="{{ public_path('img/logo_fapolpa.png') }}" style="width:120px; height:auto;">
            </td>

            <!-- Coluna 2: Dados da empresa -->
            <td style="text-align:right; vertical-align:top;">
                <strong>Fapolpa Industria de Papel e Embalagens LTDA</strong><br>
                CNPJ: 82.653.700/0001-40<br>
                Endereço: Rua Ema Mazalotti Cardoso, 170, Palmas - PR, 85.692-210.- Palmas/PR<br>
            </td>
        </tr>
    </table>





</head>

<body>

    <footer></footer>

    <div class="header">
        <h2>PERMISSÃO DE TRABALHO (PT) </h2>

        <div class="label">PT Nº: {{ $pt->id ?? '____' }}</div>
        <div class="label">APR Nº: {{ $apr->id }}</div>
        <div class="label">Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>

        <div style="border: solid 1px; padding:5px; margin-top:5px;">
            <strong>Serviço a ser executado:</strong> {{ $apr->descricao_atividade }} <br>
            <strong>Local:</strong> {{ $apr->localizacao->nome}} <br>
            <strong>Responsável pelo serviço:</strong> {{$apr->responsavel->primeiro_nome}} {{$apr->responsavel->ultimo_nome}} <br>
            <strong>Status APR:</strong> {{ strtoupper($apr->status) }}
        </div>

        <h4>Riscos / Medidas verificadas</h4>

        @foreach ($riscos as $tipo => $listaRiscos)
        @foreach ($listaRiscos as $risco)
        @php
        $apr_risco_salvo = collect($apr_riscos)->first(fn($r) => $r->risco_id == $risco->id);
        @endphp

        @if($apr_risco_salvo)
        @php
        $medidas_selecionadas = $riscos_medidas_controle
        ->where('risco_id', $risco->id)
        ->filter(fn($m) => $apr_riscos_medidas
        ->where('apr_risco_id', $apr_risco_salvo->id)
        ->where('medida_id', $m->id)
        ->first()
        );
        @endphp

        @if($medidas_selecionadas->count())
        <div class="risco-box">
            <strong>{{ $risco->nome }}:</strong><br>
            @foreach($medidas_selecionadas as $medida)
            <small>☑ {{ $medida->descricao }}</small><br>
            @endforeach
        </div>
        @endif
        @endif
        @endforeach
        @endforeach
        <h4>Materiais que serão usados</h4>

        @if($materiais_selecionados->count())
        <ul>
            @foreach($materiais_selecionados as $material)
            <li>{{ $material->nome }} @if($material->observacoes)- {{ $material->observacoes }}@endif</li>
            @endforeach
        </ul>
        @else
        <p>Nenhum material selecionado para os riscos cadastrados.</p>
        @endif

        <div style="margin-top:10px;">
            <strong>Data/Hora de Início:</strong> __________________________<br>
            <strong>Data/Hora de Término:</strong> ________________________<br>
            <strong>Observações / Procedimentos especiais:</strong>
            <div class="observacoes-box"></div>
        </div>

        <div class="assinaturas">
            <div class="assinatura-box">
                Solicitante:
                <span>{{ $pt->solicitante ?? '________________' }}</span>
            </div>
            <div class="assinatura-box">
                Responsável Técnico:
                <span>{{ $pt->responsavel_tecnico ?? '________________' }}</span>
            </div>
            <div class="assinatura-box">
                Liberação do Trabalho:
                <span>{{ $pt->liberacao ?? '________________' }}</span>
            </div>
        </div>

    </div>
</body>

</html>