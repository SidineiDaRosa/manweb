@extends('app.layouts.app')

@section('titulo', 'Produtos')
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestão de Almoxarifado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #2ecc71;
            --warning: #f39c12;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: var(--primary);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 5px;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link.active {
            background-color: var(--secondary);
            color: white;
        }

        .main-content {
            margin-left: 150px;
            padding: 20px;
        }

        .card-dashboard {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
        }

        .metric-value {
            font-size: 2rem;
            font-weight: bold;
        }

        .metric-icon {
            font-size: 2.5rem;
            color: var(--secondary);
        }

        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        .low-stock {
            background-color: rgba(231, 76, 60, 0.1) !important;
        }

        .medium-stock {
            background-color: rgba(243, 156, 18, 0.1) !important;
        }

        .high-stock {
            background-color: rgba(46, 204, 113, 0.1) !important;
        }

        .search-container {
            position: relative;
        }

        .search-container .form-control {
            padding-right: 40px;
        }

        .search-container .bi-search {
            position: absolute;
            right: 15px;
            top: 12px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-md-block">
                <div class="text-center mb-4">
                    <h4>Almoxarifado</h4>
                    <p class="text-muted">Dashboard de Gestão</p>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Visão Geral
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-box-seam me-2"></i>
                            Itens em Estoque
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-arrow-down-circle me-2"></i>
                            Entradas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-arrow-up-circle me-2"></i>
                            Saídas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-clipboard-data me-2"></i>
                            Relatórios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-people me-2"></i>
                            Fornecedores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear me-2"></i>
                            Configurações
                        </a>
                    </li>
                </ul>

                <div class="mt-5 px-3">
                    <div class="card bg-dark text-white">
                        <div class="card-body text-center py-3">
                            <p class="mb-1">Última atualização</p>
                            <h6 class="mb-0" id="last-update">20/05/2023 14:30</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Dashboard de Estoque</h2>
                    <div class="d-flex">
                        <div class="search-container me-2">
                            <input type="text" class="form-control" placeholder="Buscar item...">
                            <i class="bi bi-search"></i>
                        </div>
                        <button class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Novo Item
                        </button>
                    </div>
                </div>

                <!-- Alertas -->
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>

                        {{$criticalItemsFault}} itens com estoque crítico. <a href="#" class="alert-link">Verificar agora</a>
                    </div>
                </div>

                <!-- Métricas -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Total de Itens</h6>
                                        <h3 class="metric-value text-primary">{{$totalItems}}</h3>
                                        <p class="card-text"><small class="text-success"><i class="bi bi-arrow-up"></i> 2.5% desde o mês passado</small></p>
                                    </div>
                                    <div class="metric-icon">
                                        <i class="bi bi-boxes"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Valor Total</h6>
                                        <h3 class="metric-value text-success">{{$totalValue}}</h3>
                                        <p class="card-text"><small class="text-success"><i class="bi bi-arrow-up"></i> 4.1% desde o mês passado</small></p>
                                    </div>
                                    <div class="metric-icon">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Itens Críticos</h6>
                                        <h3 class="metric-value text-danger">{{$criticalItems}}</h3>
                                        <p class="card-text"><small class="text-danger"><i class="bi bi-arrow-up"></i> 3 desde a semana passada</small></p>
                                    </div>
                                    <div class="metric-icon">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted">Movimentação</h6>
                                        <h3 class="metric-value text-warning">{{$movementsThisMonth}}</h3>
                                        <p class="card-text"><small class="text-muted">itens este mês</small></p>
                                    </div>
                                    <div class="metric-icon">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row mb-4">
                    <div class="col-md-8 mb-3">
                        <div class="card card-dashboard">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Movimentação de Estoque (Últimos 6 Meses)</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="movementChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card card-dashboard">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Categorias de Itens</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="categoryChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Tabela de Itens com Estoque Baixo -->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-dashboard">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Itens com Estoque Crítico</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-filter me-1"></i> Filtrar
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Todos os itens</a></li>
                                        <li><a class="dropdown-item" href="#">Estoque crítico</a></li>
                                        <li><a class="dropdown-item" href="#">Estoque baixo</a></li>
                                        <li><a class="dropdown-item" href="#">Estoque adequado</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Item</th>
                                                <th>Categoria</th>
                                                <th>Estoque Atual</th>
                                                <th>Estoque Mínimo</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stok_level as $produto)
                                            @php
                                            if ($produto->quantidade <= 0 || $produto->quantidade < $produto->estoque_minimo) {
                                                    $status = 'Crítico';
                                                    $badge = 'bg-danger';
                                                    } elseif ($produto->quantidade < $produto->estoque_minimo * 1.5) {
                                                        $status = 'Atenção';
                                                        $badge = 'bg-warning';
                                                        } else {
                                                        $status = 'Adequado';
                                                        $badge = 'bg-success';
                                                        }
                                                        @endphp
                                                        <tr>
                                                            <td>MAT-{{ str_pad($produto->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                            <td>{{ $produto->produto->nome ?? '---' }}</td>
                                                            <td>{{ $produto->produto->categoria->nome ?? '---' }}</td>
                                                            <td>{{ $produto->quantidade }}</td>
                                                            <td>{{ $produto->estoque_minimo }}</td>
                                                            <td><span class="badge {{ $badge }}">{{ $status }}</span></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-cart-plus"></i></button>
                                                                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                //
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Atualizar data e hora da última atualização
        function updateLastUpdate() {
            const now = new Date();
            const options = {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.getElementById('last-update').textContent = now.toLocaleDateString('pt-BR', options);
        }

        updateLastUpdate();

        // Gráfico de Movimentação
        const movementCtx = document.getElementById('movementChart').getContext('2d');
        const movementChart = new Chart(movementCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                        label: 'Entradas',
                        data: [120, 150, 180, 90, 130, 160],
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Saídas',
                        data: [80, 100, 120, 140, 110, 130],
                        borderColor: '#e74c3c',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Gráfico de Categorias
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Ferramentas', 'Fixadores', 'Elétrica', 'EPI', 'Hidráulica', 'Outros'],
                datasets: [{
                    data: [25, 18, 15, 22, 12, 8],
                    backgroundColor: [
                        '#3498db',
                        '#2ecc71',
                        '#e74c3c',
                        '#f39c12',
                        '#9b59b6',
                        '#34495e'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    </script>
</body>

</html>