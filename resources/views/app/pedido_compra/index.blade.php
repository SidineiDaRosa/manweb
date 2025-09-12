@extends('app.layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos de Compra</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: #f5f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding-top: 10px;

        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 0 15px;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 600;
            margin: 0;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
            background-color: white;
        }

        .card-header-template {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 20px;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-body {
            padding: 0;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: end;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #555;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-new {
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-new:hover {
            background-color: #1a252f;
        }

        /* Estilos para a estrutura baseada em divs */
        .div-table {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .div-table-header {
            display: flex;
            background-color: #f8f9fa;
            color: var(--primary-color);
            font-weight: 600;
            padding: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .div-table-row {
            display: flex;
            padding: 15px;
            border-top: 1px solid #f1f1f1;
            align-items: center;
        }

        .div-table-row:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        .div-table-col {
            flex: 1;
            padding: 0 10px;
        }

        /* Ajustes específicos para as colunas */
        .col-id {
            flex: 0.5;
        }

        .col-data {
            flex: 1.2;
        }

        .col-equipamento {
            flex: 1.5;
        }

        .col-emissor {
            flex: 1.2;
        }

        .col-status {
            flex: 1;
        }

        .col-operacoes {
            flex: 0.8;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-aberto {
            background-color: rgba(46, 204, 113, 0.15);
            color: #27ae60;
        }

        .status-fechado {
            background-color: rgba(52, 152, 219, 0.15);
            color: #2980b9;
        }

        .status-cancelado {
            background-color: rgba(231, 76, 60, 0.15);
            color: #c0392b;
        }

        .status-andamento {
            background-color: rgba(241, 196, 15, 0.15);
            color: #d35400;
        }

        .status-indefinido {
            background-color: rgba(149, 165, 166, 0.15);
            color: #7f8c8d;
        }

        .btn-group-actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm-template {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: white;
            color: #555;
            transition: all 0.2s;
        }

        .btn-sm-template:hover {
            background-color: #f8f9fa;
            color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .pagination-container {
            padding: 20px;
            display: flex;
            justify-content: center;
            border-top: 1px solid #f1f1f1;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #bdc3c7;
        }

        .results-count {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* NOVOS ESTILOS PARA HISTÓRICO DE EVENTOS */
        .event-history {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-top: 10px;
            border: 1px solid rgba(135, 140, 145, 0.3);
        }

        .event-header {
            padding: 12px 16px;
            background: #f8f9fa;
            color: var(--primary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: background 0.3s;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .event-header:hover {
            background: #e9ecef;
        }

        .event-header h3 {
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            font-weight: 600;
        }

        .event-header i {
            transition: transform 0.4s ease;
            font-size: 1.2rem;
        }

        .event-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }

        .event-list {
            padding: 0;
            margin: 0;
        }

        .event-item {
            padding: 16px;
            border-bottom: 1px solid #f1f1f1;
            position: relative;
            padding-left: 70px;
        }

        .event-item:last-child {
            border-bottom: none;
        }

        .event-date {
            position: absolute;
            left: 16px;
            top: 16px;
            background: #f0f5ff;
            padding: 6px 10px;
            border-radius: 6px;
            font-weight: 600;
            color: #4a6491;
            min-width: 110px;
            text-align: center;
            font-size: 0.85rem;
        }

        .event-status {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .status-change {
            background: #e8f5e9;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
            color: #2e7d32;
            font-size: 0.9rem;
        }

        .status-arrow {
            color: #78909c;
        }

        .event-justification {
            margin: 8px 0;
            padding: 10px;
            background: #f9f9f9;
            border-left: 3px solid #4a6491;
            border-radius: 0 4px 4px 0;
            font-size: 0.95rem;
        }

        .event-anexo {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: #4a6491;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background 0.3s;
            margin-top: 6px;
            font-size: 0.9rem;
        }

        .event-anexo:hover {
            background: #3a547e;
            color: white;
        }

        .no-events {
            padding: 20px;
            text-align: center;
            color: #78909c;
            font-style: italic;
        }

        .expanded .event-content {
            max-height: 2000px;
        }

        .expanded .event-header i {
            transform: rotate(180deg);
        }

        .event-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4a6491;
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .form-group {
                min-width: 100%;
            }

            .btn-filter {
                width: 100%;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .btn-group-actions {
                flex-direction: column;
            }

            /* Responsividade para a estrutura de divs */
            .div-table-header {
                display: none;
            }

            .div-table-row {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
                margin-bottom: 15px;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            }

            .div-table-col {
                width: 100%;
                padding: 8px 0;
                display: flex;
                justify-content: space-between;
                border-bottom: 1px solid #f5f5f5;
            }

            .div-table-col:last-child {
                border-bottom: none;
            }

            .div-table-col::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--primary-color);
                margin-right: 10px;
                flex: 1;
            }

            .div-table-col>div {
                flex: 2;
                text-align: right;
            }

            .col-operacoes {
                justify-content: center !important;
                padding-top: 15px;
                border-top: 1px dashed #e0e0e0;
                margin-top: 10px;
            }

            .col-operacoes::before {
                display: none;
            }

            /* Responsividade para eventos */
            .event-item {
                padding-left: 16px;
                padding-top: 60px;
            }

            .event-date {
                top: 12px;
                left: 16px;
                right: 16px;
                min-width: auto;
            }
        }
    </style>
</head>

<body style="margin-left: 50px;">
    <div class="container-fluid" style="margin-top:58px;">
        <div class="page-header">
            <h6 class="page-title">Pedidos de Compra</h6>
            <a href="{{ route('pedido-compra.create') }}" class="btn btn-new">
                <i class="bi bi-plus-circle"></i> Novo Pedido
            </a>
          <a class="nav-btn" href="{{ route('app.home') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
        </div>

        <div class="card">
            <div class="card-header-template">
                <form class="filter-form" action="{{ route('pedido-compra.index') }}" method="GET">
                    <div class="form-group">
                        <label for="situacao">Situação</label>
                        <select class="form-control" name="situacao" id="situacao">
                            <option value="all">Todas as situações</option>
                            <option value="aberto" {{ request('situacao') == 'aberto' ? 'selected' : '' }}>Aberto</option>
                            <option value="fechado" {{ request('situacao') == 'fechado' ? 'selected' : '' }}>Fechado</option>
                            <option value="cancelado" {{ request('situacao') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            <option value="indefinido" {{ request('situacao') == 'indefinido' ? 'selected' : '' }}>Indefinido</option>
                            <option value="aceito" {{ request('situacao') == 'indefinido' ? 'selected' : '' }}>Aceito</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="data_inicio">Data inicial</label>
                        <input type="date" class="form-control" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}">
                    </div>

                    <div class="form-group">
                        <label for="data_fim">Data final</label>
                        <input type="date" class="form-control" name="data_fim" id="data_fim" value="{{ request('data_fim') }}">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-filter">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('pedido-compra.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Limpar
                        </a>
                    </div>
                </form>
            </div>

            <div class="card-body">
                @if($pedidos_compra->count() > 0)
                <div class="results-count">
                    Total de registros: <strong>{{ $pedidos_compra->count() }}</strong>
                </div>
                @endif

                <div class="div-table">
                    <!-- Cabeçalho -->
                    <div class="div-table-header">
                        <div class="div-table-col col-id">ID</div>
                        <div class="div-table-col col-data">Data Emissão</div>
                        <div class="div-table-col col-data">Data Prevista</div>
                        <div class="div-table-col col-data">Data Fechamento</div>
                        <div class="div-table-col col-equipamento">Equipamento</div>
                        <div class="div-table-col col-emissor">Emissor</div>
                        <div class="div-table-col col-status">Status</div>
                        <div class="div-table-col col-operacoes">Operações</div>
                    </div>

                    <!-- Corpo -->
                    @if($pedidos_compra->count() > 0)
                    @foreach ($pedidos_compra as $pedido_compra)
                    <div class="div-table-row">
                        <div class="div-table-col col-id" data-label="ID">{{ $pedido_compra->id }}</div>
                        <div class="div-table-col col-data" data-label="Data Emissão">{{ \Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/Y') }} {{ $pedido_compra->hora_emissao }}</div>
                        <div class="div-table-col col-data" data-label="Data Prevista">{{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/Y') }} {{ $pedido_compra->hora_prevista}}</div>
                        <div class="div-table-col col-data" data-label="Data Fechamento">{{ $pedido_compra->data_fechamento ? \Carbon\Carbon::parse($pedido_compra->data_fechamento)->format('d/m/Y') : '-' }}</div>
                        <div class="div-table-col col-equipamento" data-label="Equipamento">{{ $pedido_compra->equipamento->nome}}</div>
                        <div class="div-table-col col-emissor" data-label="Emissor">{{ $pedido_compra->funcionarios->nome ?? $pedido_compra->funcionarios->id}}</div>
                        <div class="div-table-col col-status" data-label="Status">
                            @php
                            $statusClass = 'status-indefinido';
                            if ($pedido_compra->status == 'aberto') $statusClass = 'status-aberto';
                            elseif ($pedido_compra->status == 'fechado') $statusClass = 'status-fechado';
                            elseif ($pedido_compra->status == 'cancelado') $statusClass = 'status-cancelado';
                            elseif ($pedido_compra->status == 'aceito' || $pedido_compra->status == 'em andamento') $statusClass = 'status-andamento';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($pedido_compra->status) }}</span>
                        </div>
                        <div class="div-table-col col-operacoes" data-label="Operações">
                            <div class="btn-group-actions">
                                <a class="btn-sm-template btn-outline-primary" href="{{ route('pedido-compra-lista.index', ['numpedidocompra' => $pedido_compra->id]) }}" title="Visualizar">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a class="btn-sm-template btn-outline-primary" href="{{ route('pedido-compra.edit', ['pedido_compra' => $pedido_compra->id]) }}" title="Editar">
                                    <i class="bi bi-pencil"></i>

                                </a>
                            </div>
                        </div>
                    </div>

                    <!---------------------------------------------------->
                    <!--  Nova Div Eventos Estilizada -------------------->
                    <div class="event-history">
                        <div class="event-header" onclick="toggleEventHistory(this)">
                            <h3>
                                <div class="event-icon"><i class="fas fa-history"></i></div> Histórico de Eventos
                            </h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <div class="event-content">
                            @php
                            // Filtra apenas os eventos deste pedido
                            $eventosPedido = $eventos->where('pedido_compra_id', $pedido_compra->id);
                            @endphp

                            @if($eventosPedido->count() > 0)
                            <ul class="event-list">
                                @foreach($eventosPedido as $evento)
                                <li class="event-item">
                                    <div class="event-date">{{ \Carbon\Carbon::parse($evento->created_at)->format('d/m/Y H:i') }}</div>
                                    <div class="event-status">
                                        <span class="status-change">{{ $evento->status_anterior ?? 'Nenhum' }}</span>
                                        <span class="status-arrow"><i class="fas fa-arrow-right"></i></span>
                                        <span class="status-change">{{ $evento->status_novo ?? 'Nenhum' }}</span>
                                        <span class="status-change">{{ $evento->usuario->name ?? 'Nenhum' }}</span>
                                    </div>
                                    <div class="event-justification">
                                        {{ $evento->justificativa }}
                                    </div>
                                    @if($evento->anexo)
                                    <a href="{{ asset($evento->anexo) }}" target="_blank" class="event-anexo">
                                        <i class="fas fa-paperclip"></i> Ver Anexo
                                    </a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <div class="no-events">
                                <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                                <p>Nenhum evento registrado.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Fim da Nova Div Eventos Estilizada -------------->
                    @endforeach
                    @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h4>Nenhum pedido encontrado</h4>
                        <p>Não foram encontrados pedidos de compra com os filtros selecionados.</p>
                        <a href="{{ route('pedido-compra.index') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-arrow-clockwise"></i> Limpar Filtros
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para melhorar a experiência do usuário
        document.addEventListener('DOMContentLoaded', function() {
            // Adicionar comportamento aos botões de ação
            document.querySelectorAll('.btn-sm-template').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Manter os valores dos filtros após submit
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('data_inicio') || urlParams.has('data_fim')) {
                // Os valores já estão preenchidos via Blade
            } else {
                // Preencher com datas padrão (últimos 30 dias)
                const today = new Date();
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(today.getDate() - 30);

                document.getElementById('data_inicio').valueAsDate = thirtyDaysAgo;
                document.getElementById('data_fim').valueAsDate = today;
            }

            // Adicionar confirmação para exclusão
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Tem certeza que deseja excluir este pedido?')) {
                        e.preventDefault();
                    }
                });
            });

            // Expandir o primeiro evento por padrão
            document.querySelectorAll('.event-history').forEach(history => {
                history.classList.add('expanded');
            });
        });

        // Função para alternar a visibilidade do histórico de eventos
        function toggleEventHistory(element) {
            const container = element.parentElement;
            container.classList.toggle('expanded');
        }
    </script>
</body>

</html>