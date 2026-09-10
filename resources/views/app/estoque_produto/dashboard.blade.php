@extends('app.layouts.app')

@section('titulo', 'Produtos')

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

        .card-responsive {
            max-height: 600px;
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

        .produto-imagem {
            height: 55px;
            width: 55px;
        }

        /* Correção da tag para img e preenchimento da propriedade object-fit */
        .produto-imagem img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Faz a imagem preencher o espaço sem distorcer */
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
    <main class="content">
        <div>
            <div>
                <!-- Main Content -->
                <div>

                    <!-- Alertas Flutuantes -->
                    <div class="position-fixed top-1 end-0 p-3" style="z-index: 1080; margin-top: -2rem;">
                        <!-- Adicionada a classe alert-dismissible e fade show para a animação -->
                        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center shadow" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div class="pe-4"> <!-- Adicionado um espaçamento na direita para o texto não bater no botão X -->
                                {{$criticalItemsFault}} itens com estoque crítico.
                                <a href="#" class="alert-link">Verificar agora</a>
                            </div>
                            <!-- Botão de fechar nativo do Bootstrap 5 -->
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <!-- Métricas -->

                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card card-dashboard">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title text-muted">Pedidos de compras Pendentes</h6>
                                            <h3 class="metric-value text-primary">{{$pedidos_compra->count() }}
                                                <a href="#pedidos-compra" class="btn-inf btn-inf-red"><i class="icofont-arrow-down"></i></a>
                                            </h3>
                                        </div>
                                        <div class="metric-icon">
                                            <i class="icofont-ui-cart"></i>
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
                    <div class="card-responsive">
                        <!-- 1. Topo: Título e Filtro -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0 fw-bold">Itens com Estoque Crítico</h5>
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

                        <!-- 2. Cabeçalho da Lista (Apenas Visível no Computador) -->
                        <div class="row px-3 mb-2 d-none d-md-flex align-items-center text-muted small fw-bold">
                            <div class="col-md-1">Código</div>
                            <div class="col-md-3">Item / Categoria</div>
                            <div class="col-md-2 text-center">Estoque Atual</div>
                            <div class="col-md-2 text-center">Mín / Máx</div>
                            <div class="col-md-2 text-center">Criticidade</div>
                            <div class="col-md-2 text-end">Ações</div>
                        </div>

                        <!-- 3. Lista de Itens (Linhas em Divs) -->
                        <div class="d-flex flex-column gap-2">
                            @foreach($stok_level as $produto)
                            @php
                            $qtd = (int) $produto->quantidade;
                            $min = (int) $produto->estoque_minimo;

                            if ($qtd <= 0) {
                                $border_classe='border-start border-danger border-4' ;
                                $badge_classe='bg-danger text-white' ;
                                } elseif ($qtd> 0 && $qtd <= $min) {
                                    $border_classe='border-start border-warning border-4' ;
                                    $badge_classe='bg-warning text-dark' ;
                                    } else {
                                    $border_classe='border-start border-secondary border-4' ;
                                    $badge_classe='bg-secondary text-white' ;
                                    }
                                    @endphp

                                    <!-- Linha do Produto -->
                                    <div class="card shadow-sm {{ $border_classe }} border-top-0 border-end-0 border-bottom-0">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center g-3">

                                                <!-- Código -->
                                                <div class="col-6 col-md-1">
                                                    <span class="text-muted d-block d-md-none small fw-bold">Código</span>
                                                    <span class="fw-mono text-dark small">MAT-{{ str_pad($produto->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </div>

                                                <!-- Imagem e Nome -->
                                                <div class="col-12 col-md-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="produto-imagem me-3 flex-shrink-0" style="width: 40px; height: 40px; overflow: hidden; border-radius: 6px; background-color: #f8f9fa;">
                                                            <img src="/img/produtos/{{ $produto->produto->image ?? 'default.png' }}" alt="{{ $produto->produto->nome ?? 'Imagem' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </div>
                                                        <div class="overflow-hidden">
                                                            <h6 class="text-truncate mb-0 fw-bold" title="{{ $produto->produto->nome ?? '---' }}">
                                                                {{ $produto->produto->nome ?? '---' }}
                                                            </h6>
                                                            <small class="text-muted text-truncate d-block">{{ $produto->produto->categoria->nome ?? '---' }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Estoque Atual -->
                                                <div class="col-6 col-md-2 text-md-center">
                                                    <div>
                                                        Estoque Atual:<span class="badge {{ $badge_classe }}">{{ $produto->quantidade }}</span>
                                                    </div>
                                                    
                                                </div>

                                                <!-- Mínimo / Máximo -->
                                                <div class="col-6 col-md-2 text-md-center">
                                                    <span class="text-muted d-block d-md-none small fw-bold">Mín / Máx</span>
                                                    <span class="text-secondary small">
                                                      Qnt. Máximo:  <strong class="text-dark">{{ $produto->estoque_minimo }}</strong> | Qnt Minimo {{ $produto->estoque_maximo }}
                                                    </span>
                                                </div>

                                                <!-- Criticidade -->
                                                <div class="col-6 col-md-2 text-md-center">
                                                    <span class="text-muted d-block d-md-none small fw-bold">Criticidade</span>
                                                    <span class="small fw-semibold text-capitalize text-secondary">{{ $produto->criticidade ?? '---' }}</span>
                                                </div>

                                                <!-- Ações -->
                                                <div class="col-6 col-md-2 text-end">
                                                    @if(isset($produto->produto->id))
                                                    <a class="btn-inf btn-inf-md btn-inf-orange" href="{{ route('produto.show', ['produto' => $produto->produto->id]) }}">
                                                        <i class="icofont-eye-alt me-1"></i> Detalhes
                                                    </a>
                                                    @else
                                                    <span class="text-muted small">---</span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                        </div>
                    </div>

                    <hr id="pedidos-compra" style="height:20px;">
                    <!-- Tabela de Pedidos de Compra --><!-- Tabela de Pedidos de Compra -->
                    <div class="card card-dashboard mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Pedidos de Compra</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="ps-3">ID</th>
                                            <th scope="col">Emissão</th>
                                            <th scope="col">Previsão</th>
                                            <th scope="col">Destino</th>
                                            <th scope="col">Fornecedor</th>
                                            <th scope="col">Funcionário</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col" class="text-end pe-3">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pedidos_compra as $pedido)
                                        @php
                                        // Combina a data e hora previstas do banco em um objeto Carbon
                                        $dataPrevisao = \Carbon\Carbon::parse($pedido->data_prevista . ' ' . $pedido->hora_prevista);

                                        // Define se está atrasado (passou do prazo atual E não está concluído/cancelado)
                                        $estaAtrasado = $dataPrevisao->isPast() && !in_array(strtolower($pedido->status), ['fechado', 'concluido', 'cancelado', 'aprovado']);
                                        @endphp

                                        <tr>
                                            <!-- ID -->
                                            <td class="ps-3 fw-bold">#{{ $pedido->id }}</td>

                                            <!-- Emissão -->
                                            <td>
                                                {{ \Carbon\Carbon::parse($pedido->data_emissao)->format('d/m/Y') }}
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($pedido->hora_emissao)->format('H:i') }}</small>
                                            </td>

                                            <!-- Previsão com o visual do primeiro exemplo -->
                                            <td>
                                                <div class="{{ $estaAtrasado ? 'text-danger fw-bold' : '' }}">
                                                    {{ \Carbon\Carbon::parse($pedido->data_prevista)->format('d/m/Y') }}
                                                    <small class="{{ $estaAtrasado ? 'text-danger' : 'text-muted' }}">
                                                        {{ \Carbon\Carbon::parse($pedido->hora_prevista)->format('H:i') }}
                                                    </small>

                                                    @if($estaAtrasado)
                                                    <span class="d-block text-danger fw-normal" style="font-size: 0.75rem;">
                                                        Atrasado
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $pedido->equipamento->nome }}</td>

                                            <!-- Fornecedor -->
                                            <td>{{ $pedido->fornecedor->nome ?? 'Não informado' }}</td>

                                            <!-- Funcionário -->
                                            <td>{{ $pedido->funcionario->nome ?? 'Não informado' }}</td>

                                            <!-- Status com Badges dinâmicos -->
                                            <td>
                                                @if($estaAtrasado)
                                                <span class="badge bg-danger">Atrasado</span>
                                                @else
                                                @switch(strtolower($pedido->status))
                                                @case('pendente')
                                                @case('aberto')
                                                <span class="badge bg-warning text-dark">Pendente</span>
                                                @break
                                                @case('aprovado')
                                                @case('fechado')
                                                @case('concluido')
                                                <span class="badge bg-success">Concluído</span>
                                                @break
                                                @case('cancelado')
                                                <span class="badge bg-danger">Cancelado</span>
                                                @break
                                                @default
                                                <span class="badge bg-secondary">{{ $pedido->status }}</span>
                                                @endswitch
                                                @endif
                                            </td>

                                            <!-- Descrição -->
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $pedido->descricao }}">
                                                    {{ $pedido->descricao }}
                                                </span>
                                            </td>

                                            <!-- Botão de Ação -->
                                            <td >
                                                <a href="{{ route('pedido-compra-lista.index', ['numpedidocompra' => $pedido->id]) }}" class="btn-inf btn-inf-md btn-inf-green"><i class="icofont-eye"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                Nenhum pedido de compra encontrado.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @php
        use Carbon\Carbon;

        $labels = [];
        $dataInputProducts = [];
        $dataOutputProducts = [];
        $dataInputPurchase = [];
        $dataOutputPurchase = [];

        // Arrays para guardar os IDs de cada mês para o JavaScript ler
        $idsInputProducts = [];
        $idsOutputProducts = [];
        $idsInputPurchase = [];
        $idsOutputPurchase = [];

        for ($i = 11; $i >= 0; $i--) {
        $mesAnoKey = Carbon::now()->subMonths($i)->format('Y-m');
        $labels[] = Carbon::parse($mesAnoKey . '-01')->translatedFormat('M/y');

        // 1. Filtrar registros do mês
        $filteredInputProd = $movementsInputProcucts->filter(fn($item) => Carbon::parse($item->created_at)->format('Y-m') === $mesAnoKey);
        $filteredOutputProd = $movementsOuputProcucts->filter(fn($item) => Carbon::parse($item->created_at)->format('Y-m') === $mesAnoKey);
        $filteredInputPurch = $movementInputPurchase->filter(fn($item) => Carbon::parse($item->created_at)->format('Y-m') === $mesAnoKey);
        $filteredOutputPurch = $movementOutputPurchase->filter(fn($item) => Carbon::parse($item->created_at)->format('Y-m') === $mesAnoKey);

        // 2. Salvar os totais para as linhas do gráfico
        $dataInputProducts[] = $filteredInputProd->count();
        $dataOutputProducts[] = $filteredOutputProd->count();
        $dataInputPurchase[] = $filteredInputPurch->count();
        $dataOutputPurchase[] = $filteredOutputPurch->count();

        // 3. Mapear os IDs/Documentos (se não houver ID, exibe o ID do produto)
        $idsInputProducts[] = $filteredInputProd->map(fn($item) => 'ID ' . ($item->id ?? $item->produto_id))->values()->toArray();
        $idsOutputProducts[] = $filteredOutputProd->map(fn($item) => 'ID ' . ($item->id ?? $item->produto_id))->values()->toArray();
        $idsInputPurchase[] = $filteredInputPurch->map(fn($item) => 'Ped. ' . ($item->id ?? 'N/A'))->values()->toArray();
        $idsOutputPurchase[] = $filteredOutputPurch->map(fn($item) => 'Ped. ' . ($item->id ?? 'N/A'))->values()->toArray();
        }
        @endphp

        <div class="card card-dashboard bg-white p-4 mb-4">
            <h5 class="card-title text-dark mb-3">
                <i class="bi bi-graph-up shadow-sm me-2 text-primary p-2 rounded bg-light"></i>
                Histórico de Movimentações (Rastreável)
            </h5>
            <div class="position-relative" style="height: 350px; width: 100%;">
                <canvas id="canvasGraficoMovimentacoes"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('canvasGraficoMovimentacoes').getContext('2d');

                // Passando as listas de IDs geradas no PHP para matrizes JavaScript
                const docIds = {
                    0: @json($idsInputProducts),
                    1: @json($idsOutputProducts),
                    2: @json($idsInputPurchase),
                    3: @json($idsOutputPurchase)
                };

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                                label: 'Entrada de Produtos',
                                data: @json($dataInputProducts),
                                borderColor: '#3498db',
                                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                                tension: 0.3,
                                borderWidth: 2,
                                fill: true
                            },
                            {
                                label: 'Saída de Produtos',
                                data: @json($dataOutputProducts),
                                borderColor: '#2ecc71',
                                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                                tension: 0.3,
                                borderWidth: 2,
                                fill: true
                            },
                            {
                                label: 'Pedidos de Compra',
                                data: @json($dataInputPurchase),
                                borderColor: '#f39c12',
                                backgroundColor: 'rgba(243, 156, 18, 0.1)',
                                tension: 0.3,
                                borderWidth: 2,
                                fill: true
                            },
                            {
                                label: 'Pedidos de Saída',
                                data: @json($dataOutputPurchase),
                                borderColor: '#e74c3c',
                                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                                tension: 0.3,
                                borderWidth: 2,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            // Configuração customizada do balão de informação
                            tooltip: {
                                callbacks: {
                                    footer: function(tooltipItems) {
                                        const item = tooltipItems[0];
                                        const datasetIndex = item.datasetIndex; // Qual linha é
                                        const dataIndex = item.dataIndex; // Qual mês é

                                        // Busca a lista de IDs correspondente àquele ponto do gráfico
                                        const listaIds = docIds[datasetIndex]?.[dataIndex] || [];

                                        if (listaIds.length > 0) {
                                            return 'Documentos: ' + listaIds.join(', ');
                                        }
                                        return 'Nenhum documento encontrado';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
        </script>

</body>
</main>