<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @foreach ($pedidos_compra as $pedido_compra)
    @endforeach
    <title>PC-{{$pedido_compra->id}}</title>

    <style>
        /* ===== VARIÁVEIS E CONFIGURAÇÕES ===== */
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        @page {
            margin: 10mm;
            size: A4 portrait;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: var(--dark);
            background: #ffffff;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
        }

        /* ===== HEADER MODERNO ===== */
        .modern-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2px;
            padding-bottom: 1px;
            border-bottom: 1px solid var(--primary);
            position: relative;
        }

        .modern-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100px;
            height: 3px;
            background: var(--primary);
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .brand-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 2px;
        }

        .brand-text .tagline {
            font-size: 12px;
            color: var(--secondary);
            font-weight: 400;
        }

        .document-badge {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            min-width: 140px;
            box-shadow: var(--shadow);
        }

        .badge-title {
            font-size: 11px;
            opacity: 0.9;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-number {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .badge-date {
            font-size: 11px;
            opacity: 0.9;
            margin-top: 3px;
        }

        /* ===== STATUS CARD ===== */
        .status-card {
            background: var(--light);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-info {
            display: flex;
            gap: 25px;
        }

        .status-item {
            display: flex;
            flex-direction: column;
        }

        .status-label {
            font-size: 11px;
            color: var(--secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .status-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
        }

        .priority-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .priority-alta {
            background: #fee2e2;
            color: var(--danger);
        }

        .priority-media {
            background: #fef3c7;
            color: var(--warning);
        }

        .priority-baixa {
            background: #d1fae5;
            color: var(--success);
        }

        /* ===== GRID DE INFORMAÇÕES ===== */
        .info-grid-modern {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 8px;
            margin-bottom: 20px;
        }

        .info-card-modern {
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 8px;
            transition: all 0.2s ease;
            height: auto;
            /* <-- Remove altura fixa */
            min-height: 55px;
            /* garante proporção mínima */
        }

        .info-card-modern:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow);
        }

        .card-icon {
            width: 24px;
            height: 24px;
            background: var(--light);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
            color: var(--primary);
            font-size: 14px;
        }

        .card-label {
            font-size: 10px;
            color: var(--secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }

        .card-value {
            font-size: 12px;
            font-weight: 500;
            color: var(--dark);
            line-height: 1.3;
        }

        /* ===== TABELA MODERNA ===== */
        .table-section {
            margin: 25px 0;
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-modern thead {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .table-modern th {
            color: white;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 12px;
            text-align: left;
            border: none;
        }

        .table-modern th:first-child {
            border-radius: 12px 0 0 0;
        }

        .table-modern th:last-child {
            border-radius: 0 12px 0 0;
        }

        .table-modern td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            vertical-align: top;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border);
        }

        .product-code {
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 11px;
            color: var(--secondary);
        }

        .quantity-badge {
            background: var(--primary);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        /* ===== OBSERVAÇÕES MODERNO ===== */
        .observations-modern {
            background: var(--light);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid var(--primary);
        }

        .obs-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .obs-text {
            font-size: 12px;
            line-height: 1.6;
            color: var(--secondary);
        }

        /* ===== ASSINATURAS MODERNO ===== */
        .signatures-modern {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px dashed var(--border);
        }

        .signature-box-modern {
            text-align: center;
        }

        .signature-line-modern {
            border-bottom: 2px solid var(--border);
            margin: 25px 0 8px;
            position: relative;
        }

        .signature-label-modern {
            font-size: 11px;
            font-weight: 600;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ===== FOOTER MODERNO ===== */
        .footer-modern {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 10px;
            color: var(--secondary);
        }

        .footer-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        /* ===== UTILITÁRIOS ===== */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-success {
            background: #d1fae5;
            color: var(--success);
        }

        .badge-warning {
            background: #fef3c7;
            color: var(--warning);
        }

        .badge-danger {
            background: #fee2e2;
            color: var(--danger);
        }

        /* ===== CONTROLES DE IMPRESSÃO ===== */
        @media print {
            .no-print {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: var(--shadow);
            z-index: 1000;
        }
    </style>
</head>

<body>
    <button class="print-btn no-print" onclick="window.print()">🖨️ Imprimir</button>

    <div class="container">
        <!-- HEADER MODERNO -->
        <div class="modern-header">
            <div class="brand-section">

                <div class="brand-text">
                    <h1>Pedido de Compra</h1>
                    <div class="tagline">Solicitação de aquisição • Fapolpa</div>
                    <p>Data de Impressão: {{ now()->format('d/m/Y H:i') }}</p>

                </div>
            </div>
            <div class="header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo da Empresa">
            </div>
            <style>
                .header {
                    text-align: center;
                    padding-bottom: 8px;
                    margin-bottom: 15px;
                }

                .header img {
                    width: 160px;
                    height: auto;
                    margin-bottom: 5px;
                }
            </style>
            <div class="document-badge">
                <div class="badge-title">Nº </div>
                <div class="badge-number">PC-{{ $pedido_compra->id}}</div>

            </div>
        </div>

        <!-- CARD DE STATUS -->
        <div class="status-card">
            <div class="status-info">
                <div class="status-item">
                    <div class="status-label">Situação</div>
                    <div class="status-value">
                        <span class="badge badge-warning">{{$pedido_compra->status}}</span>
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-label">Prioridade</div>
                    <div class="status-value">
                        <span class="priority-badge priority-alta">Alta</span>
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-label">Data Prevista</div>
                    <div class="status-value"> {{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/Y') }}
                        {{ $pedido_compra->hora_prevista }}
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-label">Valor Total</div>
                    <div class="status-value"></div>
                </div>
            </div>
        </div>

        <!-- GRID DE INFORMAÇÕES -->
        <div class="info-grid-modern">
            <div class="info-card-modern">
                <div class="card-icon">👤</div>
                <div class="card-label">Solicitante</div>
                <div class="card-value"> @php
                    $funcionario = $usuarios->firstWhere('id', $pedido_compra->funcionarios_id);
                    @endphp
                    {{ $funcionario->name ?? 'Funcionário não encontrado' }}
                </div>
            </div>

            <div class="info-card-modern">
                <div class="card-icon">🏢</div>
                <div class="card-label">Departamento</div>
                <div class="card-value">Manutenção</div>
            </div>

            <div class="info-card-modern">
                <div class="card-icon">⚡</div>
                <div class="card-label">Equipamento</div>
                <div class="card-value">{{ $pedido_compra->equipamento->nome }}</div>
            </div>

            <div class="info-card-modern">
                <div class="card-icon">📅</div>
                <div class="card-label">Data de Emissão</div>
                <div class="card-value"> {{ \Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/Y') }}
                    {{ $pedido_compra->hora_emissao }}
                </div>
            </div>

            <div class="info-card-modern">
                <div class="card-icon">📍</div>
                <div class="card-label">Localização</div>
                <div class="card-value">Palmas PR</div>
            </div>

            <div class="info-card-modern">
                <div class="card-icon">🎯</div>
                <div class="card-label">Projeto</div>
                <div class="card-value">Não se aplica</div>
            </div>
        </div>

        <!-- TABELA DE ITENS -->

        <div class="table-section">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 12%">Código</th>
                        <th style="width: 33%">Descrição</th>
                        <th style="width: 25%">Especificações</th>
                        <th style="width: 8%">Unidade</th>
                        <th style="width: 7%">Qtd</th>
                        <th style="width: 10%">Valor Unit.</th>
                        <th style="width: 5%">Imagem</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pedido_compra_lista as $pedido_compra_ls)
                    @php
                    $produto = $produtos->firstWhere('id', $pedido_compra_ls->produto_id);
                    $unidade = $unidadeMedida->firstWhere('id', $produto->unidade_medida_id ?? null);
                    @endphp
                    <tr>
                        <td>
                            <div class="product-code">{{ $produto->cod_fabricante ?? '-' }}</div>
                        </td>
                        <td>
                            <strong>{{ $produto->nome ?? 'Produto não encontrado' }}</strong><br>
                            <small>{{ $produto->descricao ?? '-' }}</small>
                        </td>
                        <td>
                            <small style="color: var(--secondary);"></small>
                        </td>
                        <td>{{ $unidade->nome ?? '-' }}</td>
                        <td>
                            <span class="quantity-badge">{{ $pedido_compra_ls->quantidade }}</span>
                        </td>
                        <td>
                            <strong>R$ 0,00</strong>
                        </td>
                        <td>
                            <div style="color: var(--secondary); font-size: 10px;">@if (!empty($produto->image))
                                <img src="/img/produtos/{{ $produto->image }}" alt="Imagem do Produto" class="preview-image">
                                @else
                                <small>Sem imagem</small>
                                @endif
                            </div>
                            <style>
                                .preview-image {
                                    width: 70px;
                                    height: 70px;
                                    object-fit: cover;
                                    border: 1px solid #ccc;
                                    border-radius: 2px;
                                }
                            </style>
                        </td>
                    </tr>


                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc;">
                        <td colspan="5" style="text-align: right; padding: 12px; font-weight: 600; border: none;">
                            TOTAL:
                        </td>
                        <td style="padding: 12px; font-weight: 700; font-size: 14px; color: var(--primary); border: none;">
                            R$ 0,00
                        </td>
                        <td style="border: none;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- OBSERVAÇÕES -->
        <div class="observations-modern">
            <div class="obs-label">Observações & Informações Adicionais</div>
            <div class="obs-text">
                {{$pedido_compra->descricao}}
            </div>
        </div>

        <!-- ASSINATURAS -->
        <div class="signatures-modern">
            <div class="signature-box-modern">
                <div class="signature-label-modern">Solicitante</div>
                <div class="signature-line-modern"></div>
                <div style="font-size: 10px; color: var(--secondary); margin-top: 5px;">Marcos Freitas</div>
            </div>

            <div class="signature-box-modern">
                <div class="signature-label-modern">Aprovação Técnica</div>
                <div class="signature-line-modern"></div>
                <div style="font-size: 10px; color: var(--secondary); margin-top: 5px;">Coord. De Manutenção</div>
            </div>

            <div class="signature-box-modern">
                <div class="signature-label-modern">Comprador</div>
                <div class="signature-line-modern"></div>
                <div style="font-size: 10px; color: var(--secondary); margin-top: 5px;">Departamento de Compras</div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer-modern">
            <div class="footer-info">
                <div>Gerado em:</div>
                <div>Página 1 de 1</div>
            </div>
            <div>Fapolpa</div>
        </div>
    </div>
</body>

</html>