<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>APR Nº {{ $apr->id }}</title>
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
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 10px;
        }

        .header {
            border: 1px solid #000;
            padding: 6px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            text-align: center;
            font-size: 14px;
        }

        .label {
            font-weight: bold;
            width: 18%;
            background: #f0f0f0;
        }

        h4 {
            margin: 8px 0 5px 0;
            font-size: 12px;
        }

        .tipo-risco {
            font-weight: bold;
            background: #ddd;
            font-size: 11px;
        }

        /* ==== PAGINAÇÃO ==== */
        @page {
            margin: 20px 20px 40px 20px;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            height: 20px;
            text-align: center;
            font-size: 9px;
            color: #333;
        }

        footer:after {
            content: "Página " counter(page) " de " counter(pages);
        }
    </style>
</head>

<body>

    <!-- Footer fixo para todas as páginas -->
    <footer></footer>

    <div class="header">
        <h2>ANÁLISE PRELIMINAR DE RISCOS (APR)</h2>

        <div class="label">
            APR Nº: {{ $apr->id }} |
            Emissão: {{ \Carbon\Carbon::parse($apr->created_at)->format('d/m/Y H:i') }} <br>
        </div>

        <div style="border: solid 1px">
            Status: {{ strtoupper($apr->status) }} <br>
            Ordem Serviço: {{ $apr->ordem_servico_id }} <br>
            Local de Trabalho: {{ $apr->localizacao->nome}} <br>
            Descrição da atividade: {{ $apr->descricao_atividade }} <br>
            Responsável: {{$apr->responsavel->primeiro_nome}} {{$apr->responsavel->ultimo_nome}}
        </div>

        <h4 style="margin-top:20px;">Análise de Riscos</h4>

        @foreach ($riscos as $tipo => $listaRiscos)
        <h4 style="background: #eee; padding: 5px; border: 1px solid #000; margin-bottom: 0;">
            {{ strtoupper($tipo) }}
        </h4>

        @foreach ($listaRiscos as $risco)
        @php
        $apr_risco_salvo = collect($apr_riscos)->first(function($r) use ($risco) {
        return $r->risco_id == $risco->id;
        });
        @endphp

        @if($apr_risco_salvo)
        <div style="display: block; width: 100%; border: 1px solid #000; margin-bottom: 10px; clear: both;">

            <div style="width: 60%; float: left; border-right: 1px solid #000; padding: 5px; min-height: 120px;">
                <div style="margin-bottom: 10px; border-bottom: 1px solid #eee;">
                    <strong>ID:</strong> {{ $risco->id }} |
                    <strong>Nome:</strong> {{ $risco->nome }} <br>
                    <strong>Descrição:</strong> {{ $risco->descricao }} <br>
                    <strong>Prob:</strong> {{ $apr_risco_salvo->probabilidade }} |
                    <strong>Sev:</strong> {{ $apr_risco_salvo->severidade }} |
                    <strong>Grau:</strong>
                    <span style="font-weight:bold;">{{ $apr_risco_salvo->grau }}</span>
                </div>
                <div style="padding:5px;">

                    <strong>Medidas de Controle:</strong><br>
                    @foreach($riscos_medidas_controle as $medida)
                    @if($medida->risco_id == $risco->id)
                    @php
                    $marcada = $apr_riscos_medidas
                    ->where('apr_risco_id', $apr_risco_salvo->id)
                    ->where('medida_id', $medida->id)
                    ->first();
                    @endphp
                    @if($marcada)
                    <small>
                        <input type="checkbox"> {{ $medida->descricao }}
                    </small><br>
                    @endif
                    @endif
                    @endforeach
                </div>

            </div>

            <div style="width: 35%; float: left; padding: 5px; min-height: 120px;">
                <strong>Materiais / EPIs:</strong><br>
                @foreach($materiais_risco as $material_risco)
                @if($material_risco->risco_id == $risco->id)
                <div style="margin-bottom: 5px;">
                    <input type="checkbox">
                    <span style="font-size: 9px;">
                        {{ $material_risco->material->nome ?? 'N/A' }}
                    </span><br>
                    <small style="color: #666;">
                        {{ $material_risco->observacoes }}
                    </small>
                </div>
                @endif
                @endforeach
            </div>

            <div style="clear: both;"></div>
        </div>
        @endif
        @endforeach
        @endforeach

    </div>
</body>

</html>