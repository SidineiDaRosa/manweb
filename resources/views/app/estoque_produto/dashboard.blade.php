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
                                                        Qnt. Máximo: <strong class="text-dark">{{ $produto->estoque_minimo }}</strong> | Qnt Minimo {{ $produto->estoque_maximo }}
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
                    <!---------------------->
                    <!--Pedidos de compra-->
                    <!---------------------->
                    <div class="card-body p-2">
                        <!-- Cabeçalho Compacto -->
                        <div class="row g-1 fw-bold text-muted pb-1 mb-2 border-bottom d-none d-md-flex align-items-center" style="font-size: 0.75rem;">
                            <div class="col-md-1 ps-3">ID</div>
                            <div class="col-md-1">Emissão</div>
                            <div class="col-md-2">Previsão</div>
                            <div class="col-md-1">Destino</div>
                            <div class="col-md-2">Fornecedor</div>
                            <div class="col-md-2">Funcionário</div>
                            <div class="col-md-1">Status</div>
                            <div class="col-md-1">Descrição</div>
                            <div class="col-md-1 text-end pe-3">Ações</div>
                        </div>

                        <!-- Lista de Pedidos -->
                        <div class="d-flex flex-column gap-1">
                            @forelse($pedidos_compra as $pedido)
                            @php
                            $dataPrev = \Carbon\Carbon::parse($pedido->data_prevista . ' ' . $pedido->hora_prevista);
                            $atrasado = $dataPrev->isPast() && !in_array(strtolower($pedido->status), ['fechado', 'concluido', 'cancelado', 'aprovado']);
                            @endphp

                            <div class="border rounded bg-white shadow-sm @if($atrasado) border-danger-subtle @endif">

                                <!-- Linha do Pedido Slim (Adicionado classe js-linha-pedido) -->
                                <div class="row g-1 align-items-center py-1 px-3 m-0 style-trigger text-dark js-linha-pedido"
                                    data-target-id="detalhes-{{ $pedido->id }}"
                                    style="cursor: pointer; font-size: 0.82rem; min-height: 38px;">

                                    <div class="col-6 col-md-1 d-flex align-items-center gap-1">
                                        <i class="icofont-rounded-down text-muted btn-arrow" style="transition: transform 0.2s; font-size: 0.95rem;"></i>
                                        <div><span class="d-md-none text-muted xx-small d-block">ID</span><span class="fw-bold">#{{ $pedido->id }}</span></div>
                                    </div>

                                    <div class="col-6 col-md-1">
                                        <span class="d-md-none text-muted xx-small d-block">Emissão</span>
                                        <span class="text-nowrap">{{ \Carbon\Carbon::parse($pedido->data_emissao)->format('d/m/y') }}</span>
                                    </div>

                                    <div class="col-6 col-md-2">
                                        <span class="d-md-none text-muted xx-small d-block">Previsão</span>
                                        <div class="text-nowrap {{ $atrasado ? 'text-danger fw-bold' : '' }}">
                                            {{ \Carbon\Carbon::parse($pedido->data_prevista)->format('d/m/y') }}
                                            @if($atrasado)<span class="badge bg-danger p-1 ms-1 fw-normal" style="font-size: 0.6rem;">Atrasado</span>@endif
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-1 text-truncate">
                                        <span class="d-md-none text-muted xx-small d-block">Destino</span>
                                        <span class="text-secondary">{{ $pedido->equipamento->nome ?? '-' }}</span>
                                    </div>

                                    <div class="col-6 col-md-2 text-truncate">
                                        <span class="d-md-none text-muted xx-small d-block">Fornecedor</span>
                                        <span class="text-secondary">{{ $pedido->fornecedor->nome ?? '-' }}</span>
                                    </div>

                                    <div class="col-6 col-md-2 text-truncate">
                                        <span class="d-md-none text-muted xx-small d-block">Funcionário</span>
                                        <span class="text-secondary">{{ $pedido->funcionario->nome ?? '-' }}</span>
                                    </div>

                                    <div class="col-6 col-md-1">
                                        <span class="d-md-none text-muted xx-small d-block">Status</span>
                                        <span class="badge @if($atrasado) bg-danger @else bg-secondary @endif py-05 px-15" style="font-size: 0.7rem;">{{ $pedido->status }}</span>
                                    </div>

                                    <div class="col-6 col-md-1 text-truncate">
                                        <span class="d-md-none text-muted xx-small d-block">Descrição</span>
                                        <span class="text-muted" title="{{ $pedido->descricao }}">{{ $pedido->descricao }}</span>
                                    </div>

                                    <!-- Botão de Ação -->
                                    <div class="col-6 col-md-1 text-end pe-md-1" onclick="event.stopPropagation();">
                                        <span class="d-md-none text-muted xx-small d-block text-start mb-1">Ações</span>
                                        <a href="{{ route('pedido-compra-lista.index', ['numpedidocompra' => $pedido->id]) }}" class="btn-inf btn-inf-green d-inline-flex align-items-center justify-content-center" style="padding: 2px 8px; font-size: 0.8rem; height: 24px;"><i class="icofont-eye"></i></a>
                                    </div>
                                </div>

                                <!-- Gaveta Expansível de Itens (Controlada via CSS classes d-none/d-flex por segurança) -->
                                <div class="d-none border-top @if($atrasado) border-danger-subtle bg-danger-subtle bg-opacity-10 @else bg-light @endif" id="detalhes-{{ $pedido->id }}">
                                    <div class="p-2 px-3 w-100">
                                        <div class="d-flex flex-column gap-1 bg-white p-2 rounded border" style="font-size: 0.78rem;">
                                            <!-- Cabeçalho Interno dos Itens -->
                                            <div class="row g-1 fw-bold text-muted border-bottom pb-1 mb-1 d-none d-md-flex" style="font-size: 0.7rem;">
                                                <div class="col-md-1">ID Item</div>
                                                <div class="col-md-5">Produto / Material</div>
                                                <div class="col-md-2 text-center">Quantidade</div>

                                                <div class="col-md-2 text-center">Status</div>
                                                <div class="col-md-2 text-center">img</div>
                                                <div class="col-md-2 text-end">Vlr. Unitário</div>
                                            </div>

                                            <!-- Filtra a lista de itens para pegar apenas os deste pedido específico -->
                                            @forelse($pedido_compra_itens->where('pedidos_compra_id', $pedido->id) as $item)
                                            <div class="row g-1 align-items-center py-2 text-secondary border-bottom border-light-subtle">
                                                <div class="col-2 col-md-1 small text-muted">#{{ $item->id }}</div>
                                                <div class="col-10 col-md-5 fw-semibold text-dark text-truncate">
                                                    {{ $item->produto->nome ?? 'Produto ID: ' . $item->produto_id }}
                                                </div>
                                                <div class="col-4 col-md-2 text-md-center font-monospace fw-bold text-dark">
                                                    <span class="d-md-none text-muted small me-1">Qtd:</span>{{ $item->quantidade }}
                                                </div>
                                                <div class="col-4 col-md-2 text-md-center">
                                                    <span class="d-md-none text-muted small me-1">Status:</span>
                                                    <span class="badge bg-light text-secondary border px-2 py-05" style="font-size: 0.68rem;">
                                                        {{ $item->status }}
                                                    </span>
                                                </div>
                                                <div class="col-4 col-md-2 text-md-end text-nowrap">
                                                   
                                                    <img src="/img/produtos/{{  $item->produto->image }}" alt="Imagem do Produto" class="preview-image">
                                                    <style>
                                                        .preview-image{
                                                            height:55px;
                                                            width:55px;
                                                        }
                                                    </style>
                                                </div>
                                                <div class="col-4 col-md-2 text-md-end text-nowrap">
                                                    <span class="d-md-none text-muted small me-1">Unit:</span>
                                                    R$ {{ number_format($item->valor_unitario ?? $item->produto->preco_custo ?? 0, 2, ',', '.') }}
                                                </div>
                                            </div>
                                            @empty
                                            <div class="text-center text-muted py-2 small">Nenhum item vinculado a este pedido.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>


                            </div>
                            @empty
                            <div class="text-center text-muted py-4 border rounded bg-light small">Nenhum pedido de compra encontrado.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- JavaScript Puro (Garante que vai abrir mesmo se o JS do Bootstrap sumir) -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll('.js-linha-pedido').forEach(linha => {
                                linha.addEventListener('click', function() {
                                    const targetId = this.getAttribute('data-target-id');
                                    const gaveta = document.getElementById(targetId);
                                    const seta = this.querySelector('.btn-arrow');

                                    if (gaveta) {
                                        if (gaveta.classList.contains('d-none')) {
                                            // Abre a gaveta
                                            gaveta.classList.remove('d-none');
                                            this.classList.add('linha-ativa');
                                            if (seta) seta.style.transform = 'rotate(180deg)';
                                        } else {
                                            // Fecha a gaveta
                                            gaveta.classList.add('d-none');
                                            this.classList.remove('linha-ativa');
                                            if (seta) seta.style.transform = 'rotate(0deg)';
                                        }
                                    }
                                });
                            });
                        });
                    </script>

                    <style>
                        .xx-small {
                            font-size: 0.65rem;
                        }

                        .py-05 {
                            padding: 0.15rem 0.4rem;
                        }

                        .px-15 {
                            padding: 0.15rem 0.4rem;
                        }

                        .style-trigger:hover {
                            background-color: rgba(0, 0, 0, 0.015) !important;
                        }

                        .linha-ativa {
                            background-color: rgba(13, 110, 253, 0.02) !important;
                        }
                    </style>

                    <!-- Fim pedidos de compra -->

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