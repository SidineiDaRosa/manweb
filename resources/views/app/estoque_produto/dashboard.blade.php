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
                    <h3 class="h3-gray">Dashboard de Estoque</h3>
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
                                                <th>Estoque Máximo</th>
                                                <th>Criticidade</th>
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
                                                            <td class="btn-inf btn-inf-sm btn-inf-red">{{ $produto->quantidade }}</td>
                                                            <td>{{ $produto->estoque_minimo }}</td>
                                                            <td>{{ $produto->estoque_maximo }}</td>
                                                            <td>{{ $produto->criticidade }}</td>
                                                            <td>
                                                                <a class="btn-inf btn-inf-sm btn-inf-blue-dark"
                                                                    href="{{ route('produto.show', ['produto' => $produto->id]) }}">
                                                                    <i class="icofont-eye-alt"></i>
                                                                </a>
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
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <div class="col-md-4 mb-3">
                        <div class="card card-dashboard">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Criticidade de Itens

                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Gráfico de Criticidade -->
                                <canvas id="categoryChart" height="250"></canvas>

                            </div>
                        </div>
                    </div>
                </div>

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
        const element = document.getElementById('last-update');
        if (element) {
            element.textContent = now.toLocaleDateString('pt-BR', options);
        }
    }

    updateLastUpdate();

    // Gráfico de Movimentação (Adaptado para o total acumulado enviado pelo Controller)
    const movementCtx = document.getElementById('movementChart').getContext('2d');
    const movementChart = new Chart(movementCtx, {
        type: 'bar', // Alterado para barra pois são dois valores únicos consolidados
        data: {
            labels: ['Total (Últimos 360 dias)'],
            datasets: [
                {
                    label: 'Entradas',
                    data: [@json($movementsInputProcucts)],
                    backgroundColor: '#2ecc71',
                    borderColor: '#27ae60',
                    borderWidth: 1
                },
                {
                    label: 'Saídas',
                    data: [@json($movementsouputProcucts)],
                    backgroundColor: '#e74c3c',
                    borderColor: '#c0392b',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Criticidade
    // Injeta com segurança a array associativa ou objeto do PHP
    const criticidadeData = @json($criticidadeCounts);

    // Mapeia as chaves (0 a 9) e os valores dinamicamente do banco de dados
    const labelsCriticidade = Object.keys(criticidadeData);
    const valoresCriticidade = Object.values(criticidadeData);

    const ctx = document.getElementById('categoryChart').getContext('2d');
    const criticidadeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsCriticidade, // Mostra dinamicamente apenas os níveis que existem no banco
            datasets: [{
                label: 'Quantidade de Itens por Criticidade',
                data: valoresCriticidade,
                backgroundColor: [
                    '#e74c3c', '#e67e22', '#f39c12', '#f1c40f',
                    '#2ecc71', '#27ae60', '#3498db', '#2980b9', '#9b59b6', '#34495e'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantidade'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Nível de Criticidade'
                    }
                }
            }
        }
    });
</script>

</html>