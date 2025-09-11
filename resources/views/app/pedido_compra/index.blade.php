<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos de Compra</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
            padding-top: 20px;
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
        .col-id { flex: 0.5; }
        .col-data { flex: 1.2; }
        .col-equipamento { flex: 1.5; }
        .col-emissor { flex: 1.2; }
        .col-status { flex: 1; }
        .col-operacoes { flex: 0.8; }

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
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
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
            
            .div-table-col > div {
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
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="page-header">
            <h6 class="page-title">Pedidos de Compra</h6>
            <a href="{{ route('pedido-compra.create') }}" class="btn btn-new">
                <i class="bi bi-plus-circle"></i> Novo Pedido
            </a>
        </div>

        <div class="card">
            <div class="card-header-template">
                <form class="filter-form" action="{{ route('pedido-compra.index') }}" method="GET">
                    <div class="form-group">
                        <label for="situacao">Situação</label>
                        <select class="form-control" name="situacao" id="situacao">
                            <option value="">Todas as situações</option>
                            <option value="aberto" {{ request('situacao') == 'aberto' ? 'selected' : '' }}>Aberto</option>
                            <option value="fechado" {{ request('situacao') == 'fechado' ? 'selected' : '' }}>Fechado</option>
                            <option value="andamento" {{ request('situacao') == 'andamento' ? 'selected' : '' }}>Em andamento</option>
                            <option value="cancelado" {{ request('situacao') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            <option value="indefinido" {{ request('situacao') == 'indefinido' ? 'selected' : '' }}>Indefinido</option>
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
        });
    </script>
</body>

</html>