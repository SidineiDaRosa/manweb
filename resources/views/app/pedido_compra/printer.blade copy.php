<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido de Compra</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* ===== CABEÇALHO ===== */
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .header img {
            width: 160px;
            height: auto;
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 2px 0 0;
            font-size: 11px;
            color: #555;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        h3 {
            font-size: 15px;
            margin: 10px 0;
            font-weight: bold;
            text-align: center;
        }

        fieldset {
            border: 1px solid #000;
            border-radius: 4px;
            padding: 5px 8px;
            margin: 4px;
            display: inline-block;
            vertical-align: top;
            background: #fff;
        }

        legend {
            font-weight: bold;
            font-size: 11px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
            margin-bottom: 8px;
        }

        .filed-data {
            width: 140px;
        }

        .filed-data-long {
            width: 260px;
        }

        .filed-data-long-text {
            width: 520px;
        }

        /* ===== TABELA ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #e0e0e0;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 11px;
        }

        td.descricao {
            text-align: left;
        }

        .preview-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 2px;
        }

        /* ===== BOTÃO ===== */
        .btn-print {
            margin: 20px auto;
            display: block;
            padding: 8px 18px;
            background-color: #444;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-print:hover {
            background-color: #000;
        }

        /* ===== IMPRESSÃO ===== */
        @media print {
            .btn-print {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Força o cabeçalho na primeira página apenas */
            .header {
                border-bottom: 1px solid #000;
                page-break-after: avoid;
            }

            h3 {
                page-break-after: avoid;
            }
        }
    </style>
</head>

<body>
    <!-- ===== CABEÇALHO ===== -->
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo da Empresa">
        <h2>Pedido de Compra</h2>
        <p>Data de Impressão: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <div class="container">

        @foreach ($pedidos_compra as $pedido_compra)
        <div class="pedido">

            <!-- Título do Pedido -->
            <div class="pedido-header">
                <h3>Pedido nº {{ $pedido_compra->id }}</h3>
            </div>

            <!-- Primeira linha: datas e equipamento -->
            <div class="pedido-linha">
                <div class="campo curto">
                    <span class="rotulo">Emissão:</span>
                    <span class="valor">
                        {{ \Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/Y') }}
                        {{ $pedido_compra->hora_emissao }}
                    </span>
                </div>

                <div class="campo curto">
                    <span class="rotulo">Previsão de Uso:</span>
                    <span class="valor">
                        {{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/Y') }}
                        {{ $pedido_compra->hora_prevista }}
                    </span>
                </div>

                <div class="campo longo">
                    <span class="rotulo">Equipamento:</span>
                    <span class="valor">{{ $pedido_compra->equipamento->nome }}</span>
                </div>
            </div>

            <!-- Segunda linha: emissor -->
            <div class="pedido-linha">
                <div class="campo longo">
                    <span class="rotulo">Emissor:</span>
                    <span class="valor">
                        @php
                        $funcionario = $usuarios->firstWhere('id', $pedido_compra->funcionarios_id);
                        @endphp
                        {{ $funcionario->name ?? 'Funcionário não encontrado' }}
                    </span>
                </div>
            </div>

            <!-- Terceira linha: situação e descrição -->
            <div class="pedido-linha">
                <div class="campo curto">
                    <span class="rotulo">Situação:</span>
                    <span class="valor">{{ ucfirst($pedido_compra->status) }}</span>
                </div>

                <div class="campo texto-longo">
                    <span class="rotulo">Descrição:</span>
                    <span class="valor">{{ $pedido_compra->descricao }}</span>
                </div>
            </div>

        </div>
        @endforeach


        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Cód. Fabricante</th>
                    <th style="width: 45%;">Descrição</th>
                    <th style="width: 10%;">Unidade</th>
                    <th style="width: 10%;">Qtd.</th>
                    <th style="width: 20%;">Imagem</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido_compra_lista as $pedido_compra_ls)
                @php
                $produto = $produtos->firstWhere('id', $pedido_compra_ls->produto_id);
                $unidade = $unidadeMedida->firstWhere('id', $produto->unidade_medida_id ?? null);
                @endphp
                <tr>
                    <td>{{ $produto->cod_fabricante ?? '-' }}</td>
                    <td class="descricao">
                        <strong>{{ $produto->nome ?? 'Produto não encontrado' }}</strong><br>
                        <small>{{ $produto->descricao ?? '-' }}</small>
                    </td>
                    <td>{{ $unidade->nome ?? '-' }}</td>
                    <td>{{ $pedido_compra_ls->quantidade }}</td>
                    <td>
                        @if (!empty($produto->image))
                        <img src="/img/produtos/{{ $produto->image }}" alt="Imagem do Produto" class="preview-image">
                        @else
                        <small>Sem imagem</small>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn-print" onclick="window.print()">🖨️ Imprimir</button>
    </div>
</body>
<style>
    .pedido {
        border: 1px solid #000;
        border-radius: 6px;
        padding: 10px;
        margin-bottom: 20px;
        page-break-inside: avoid;
    }

    .pedido-header h3 {
        text-align: left;
        margin: 0 0 10px;
        border-bottom: 1px solid #000;
        padding-bottom: 4px;
    }

    .pedido-linha {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 6px;
    }

    .campo {
        border: 1px solid #000;
        border-radius: 4px;
        padding: 6px;
        margin-right: 8px;
        margin-bottom: 8px;
        display: flex;
        flex-direction: column;
    }

    .campo.curto {
        flex: 1;
        min-width: 60px;
        width:60px;
    }

    .campo.longo {
        flex: 2;
    }

    .campo.texto-longo {
        flex: 3;
    }

    .rotulo {
        font-weight: bold;
        font-size: 11px;
        margin-bottom: 3px;
    }

    .valor {
        font-size: 12px;
    }

    @media print {
        .pedido {
            page-break-inside: avoid;
        }
    }
</style>

</html>