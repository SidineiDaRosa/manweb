@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')


<main class="content">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ml-blue: #3483fa;
            --ml-green: #00a650;
            --ml-dark: #333;
            --ml-gray: #666;
            --ml-light-gray: #e6e6e6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 1800px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* Breadcrumb */
        .breadcrumb {
            padding: 16px 0;
            font-size: 14px;
            color: #666;
        }

        .breadcrumb a {
            color: var(--ml-blue);
            text-decoration: none;
        }

        /* Product Container */
        .product-container {
            display: flex;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 20px;
            flex-wrap: wrap;
        }

        /* Galeria de Imagens */
        .product-gallery {
            width: 50%;
            padding-right: 20px;
        }

        @media (max-width: 968px) {
            .product-gallery {
                width: 100%;
                padding-right: 0;
                margin-bottom: 20px;
            }
        }

        .main-image {
            text-align: center;
            margin-bottom: 15px;
            border: 1px solid #e6e6e6;
            border-radius: 4px;
            padding: 16px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .thumbnail {
            width: 60px;
            height: 60px;
            border: 1px solid #e6e6e6;
            border-radius: 4px;
            padding: 4px;
            cursor: pointer;
        }

        .thumbnail.active {
            border: 2px solid var(--ml-blue);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* container */
        .product-info {
            width: 50%;
            padding-left: 20px;
            border-left: 1px solid #e6e6e6;
        }

        @media (max-width: 968px) {
            .product-info {
                width: 100%;
                padding-left: 0;
                border-left: none;
            }
        }

        .condition {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .product-title {
            font-size: 22px;
            font-weight: 400;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .specs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .specs {
                grid-template-columns: 1fr;
            }
        }

        .spec {
            display: flex;
        }

        .spec-title {
            font-weight: 600;
            min-width: 180px;
            color: #666;
        }

        .seller-info {
            padding: 16px;
            background-color: #fff;
            border-radius: 6px;
            border: 1px solid #e6e6e6;
            margin-bottom: 20px;
        }

        .seller-info h3 {
            font-size: 18px;
            margin-bottom: 12px;
            font-weight: 400;
        }

        /* Botões de navegação */
        .navigation-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .nav-btn {
            padding: 8px 12px;
            background-color: white;
            border: 1px solid var(--ml-light-gray);
            border-radius: 4px;
            color: var(--ml-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .nav-btn:hover {
            background-color: #f8f8f8;
        }

        /* Tabela de estoque */
        .table-like-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            overflow-x: auto;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .table-like-header,
        .table-like-row {
            display: flex;
            width: 100%;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
            align-items: center;
        }

        .table-like-header {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .header-item,
        .row-item {
            flex: 1;
            padding: 0 5px;
        }

        /* Zebra stripes */
        .row-even {
            background-color: #f9f9f9;
        }

        .row-odd {
            background-color: #fff;
        }

        /* Cores de estoque */
        .bg-red {
            background-color: rgba(255, 0, 0, 0.3);
        }

        .bg-yellow {
            background-color: rgba(255, 255, 0, 0.3);
        }

        .bg-light-yellow {
            background-color: rgba(255, 255, 150, 0.2);
        }

        /* Botões de ação */
        .actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .actions a {
            flex: 1;
            text-align: center;
            padding: 5px 0;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .table-like-header {
                display: none;
            }

            .table-like-row {
                flex-direction: column;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                padding: 10px;
            }

            .row-item {
                border-bottom: 1px solid #eee;
                padding: 5px 0;
            }

            .row-item:last-child {
                border-bottom: none;
            }

            .actions {
                justify-content: flex-start;
                gap: 10px;
            }
        }

        /* Modal styles */
        .modal-content {
            border-radius: 4px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background-color: #f8f8f8;
            border-bottom: 1px solid #e6e6e6;
        }

        .modal-title {
            font-weight: 500;
        }

        .form-control-template {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: var(--ml-blue);
            border-color: var(--ml-blue);
        }

        .btn-primary:hover {
            background-color: #2968c8;
            border-color: #2968c8;
        }

        /* Botões específicos do almoxarifado */
        .btn-almoxarifado {
            padding: 10px 15px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .btn-almoxarifado:hover {
            background-color: #f8f8f8;
        }

        .btn-almoxarifado.primary {
            background-color: var(--ml-blue);
            color: white;
            border-color: var(--ml-blue);
        }

        .btn-almoxarifado.primary:hover {
            background-color: #2968c8;
        }
    </style>

    <div class="container">


        <!-- Botões de navegação -->
        <div class="navigation-buttons">
            <a href="{{ route('produto.index') }}" class="nav-btn">
                <i class="fas fa-list"></i> Lista de Produtos
            </a>
            <a href="{{ route('produto.create') }}" class="nav-btn">
                <i class="fas fa-plus"></i> Novo Produto
            </a>
            <a class="nav-btn" href="{{ route('produto.edit', ['produto' => $produto->id]) }}">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a class="nav-btn" href="{{ route('app.home') }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </div>

        <div class="product-container">
            <div class="product-gallery">
                <div class="main-image">
                    <img id="mainImage" src="/img/produtos/{{ $produto->image}}" alt="{{ $produto->nome }}">
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail active" onclick="changeImage('/img/produtos/{{ $produto->image}}')">
                        <img src="/img/produtos/{{ $produto->image}}" alt="Miniatura 1">
                    </div>
                    <div class="thumbnail" onclick="changeImage('/img/produtos/{{ $produto->image2}}')">
                        <img src="/img/produtos/{{ $produto->image2}}" alt="Miniatura 2">
                    </div>
                    <div class="thumbnail" onclick="changeImage('/img/produtos/{{ $produto->image3}}')">
                        <img src="/img/produtos/{{ $produto->image3}}" alt="Miniatura 3">
                    </div>
                </div>
            </div>

            <div class="product-info">
                <div class="condition">Produto cadastrado | {{ $estoque_produtos_sum }} em estoque</div>
                <h1 class="product-title">{{ $produto->nome }}</h1>

                <div class="seller-info">
                    <h3>container</h3>
                    <div class="specs">
                        <div class="spec">
                            <div class="spec-title">ID:</div>
                            <div class="spec-value">{{ $produto->id }}</div>
                        </div>
                        <div class="spec">
                            <div class="spec-title">Marca:</div>
                            <div class="spec-value">{{ $produto->marca->nome }}</div>
                        </div>
                        <div class="spec">
                            <div class="spec-title">Cód. Fabricante:</div>
                            <div class="spec-value">{{ $produto->cod_fabricante }}</div>
                        </div>
                        <div class="spec">
                            <div class="spec-title">Categoria:</div>
                            <div class="spec-value">{{ $produto->categoria->nome}}</div>
                        </div>
                        <div class="spec">
                            <div class="spec-title">Unidade Medida:</div>
                            <div class="spec-value">{{$produto->unidade_medida->nome}}</div>
                        </div>
                        <div class="spec">
                            <div class="spec-title">Familia:</div>
                            <div class="spec-value">{{$produto->familia->nome}}</div>
                        </div>
                    </div>

                    <!-- Botões de ação do almoxarifado -->
                    <div style="margin-top: 15px;">
                        <a href="{{ $produto->link_peca}}" target="blank" class="btn-almoxarifado">
                            <i class="fas fa-external-link-alt"></i> Ver no fabricante
                        </a>
                        <a href="{{route('pedido-saida-lista.index', ['produto_id'=>$produto->id])}}" target="blank" class="btn-almoxarifado">
                            <i class="bi bi-arrow-up-circle me-2"></i></i></i> Consultar saídas
                        </a>
                        <a href="{{route('entrada-produto.index', ['produto_id'=>$produto->id,'tipofiltro'=>2])}}" target="blank" class="btn-almoxarifado">
                            <i class="bi bi-arrow-down-circle me-2"></i>Consultar entradas
                        </a>
                        <a href="{{ route('Estoque-produto.create',['produto' => $produto->id]) }}" class="btn-almoxarifado primary">
                            <i class="fas fa-cubes"></i> Criar estoque
                        </a>

                        <a class="btn-almoxarifado @can('user') disabled @endcan" href="{{ route('produto.index', ['produto' => $produto->id,'tipofiltro'=>10]) }}" title="Onde é aplicado este produto"
                            target="_blank">
                            <i class="fas fa-wrench"></i> Onde é aplicado
                        </a>

                        <!-- Botão para abrir o modal -->
                        <a class="btn-almoxarifado @can('user') disabled @endcan" data-toggle="modal" data-target="#myModal" title="Gerar Pedido de Compra">
                            <i class="fas fa-shopping-cart"></i> Gerar Pedido de Compra
                        </a>
                    </div>
                </div>

                <!-- Descrição do produto -->
                <div class="seller-info">
                    <h3>Descrição do Produto</h3>
                    <p>{{ $produto->descricao }}</p>
                </div>
            </div>
        </div>


        <div class="estoques-container">
            <h5>Estoques Disponíveis</h5>

            @foreach ($estoque_produtos as $estoque_produto)
            <div class="estoque-row {{ $loop->even ? 'row-even' : 'row-odd' }}">

                <div class="item">
                    <div class="estoque-item"><strong>ID:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->id }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Produto ID:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->produto->id }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Produto:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->produto->nome }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Unid. Medida:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->unidade_medida }}</div>
                </div>

                <div class="item 
    {{ $estoque_produto->quantidade <= 0 
        ? 'bg-red' 
        : ($estoque_produto->quantidade == $estoque_produto->estoque_minimo 
            ? 'bg-yellow' 
            : ($estoque_produto->quantidade < $estoque_produto->estoque_minimo 
                ? 'bg-light-yellow' 
                : 'bg-success')) }}">

                    <div class="estoque-item"><strong>Quantidade:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->quantidade }}</div>
                </div>
                <div class="item">
                    <div class="estoque-item"><strong>Estoque Mín:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->estoque_minimo }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Estoque Máx:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->estoque_maximo }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Valor:</strong></div>
                    <div class="estoque-item">R$ {{ number_format($estoque_produto->valor, 2, ',', '.') }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Local:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->local }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Criticidade:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->criticidade }}</div>
                </div>

                <div class="item">
                    <div class="estoque-item"><strong>Empresa:</strong></div>
                    <div class="estoque-item">{{ $estoque_produto->empresa->nome_fantasia }}</div>
                </div>
                <div class="item">

                    <div class="estoque-item"> <a href="{{ route('entrada-produto.create',['produto' => $estoque_produto->produto->id,'estoque_id'=>$estoque_produto->id ]) }}"
                            class="btn btn-bg-template btn-outline-primary @can('user') disabled @endcan">
                            <i class="fas fa-plus-circle"></i>
                        </a></div>
                    <div class="estoque-item"> <a class="btn btn-bg-template btn-outline-success @can('user') disabled @endcan"
                            href="{{ route('Estoque-produto.edit', ['Estoque_produto' => $estoque_produto->id]) }}"
                            title="Editar dados do estoque">
                            <i class="fas fa-edit"></i>
                        </a></div>


                </div>

            </div>
            @endforeach
        </div>

        <style>
            .estoque-row {
                display: flex;
                flex-wrap: wrap;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 4px;
                margin-bottom: 12px;
                background: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                gap: 5px;
            }

            .item {
                display: flex;
                flex-direction: column;
                flex-wrap: wrap;
                flex: 1;
                /* rótulo e valor lado a lado */

                padding: 2px;
                width: auto;
            }

            .estoque-item {
                flex-wrap: wrap;
                /* cada um ocupa metade do .item */
                min-width: 0;
                /* permite encolher se necessário */
                word-wrap: break-word;
                /* quebra textos longos */
                width: 120px;
                padding: 5px;
            }

            /* cores de status */
            .bg-red {
                background: rgba(255, 0, 0, 0.2);
            }

            .bg-yellow {
                background: rgba(255, 255, 0, 0.5);
            }

            .bg-light-yellow {
                background: rgba(255, 255, 153, 0.5);
            }

            .bg-success {
                background: rgba(96, 139, 196, 0.2);
            }

            .actions {
                display: flex;
                gap: 8px;
            }

            /* no mobile, vira coluna */
            @media (max-width: 768px) {
                .estoque-row {
                    flex-direction: column;
                }

                .item {
                    flex-direction: row;
                }

                .estoque-item {
                    min-width: 50%;
                }
            }
        </style>

        <!-- Modal para Gerar Pedido de Compra -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Gerar Pedido de Compra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Preencha os dados para gerar um pedido de compra:</p>

                        @if(isset($equipamentos) && $equipamentos->isNotEmpty())
                        <div class="form-group">
                            <label for="patrimonio_id">Equipamento:</label>
                            <select class="form-control-template" id="patrimonio_id" name="patrimonio_id" required>
                                @foreach($equipamentos as $equipamento)
                                <option value="{{ $equipamento->id }}">
                                    {{ $equipamento->nome }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <p>Não há equipamentos disponíveis.</p>
                        @endif

                        <div class="form-group">
                            <label for="produto_id">ID Produto:</label>
                            <input class="form-control-template" type="number" name="produto_id" id="produto_id" value="{{$produto->id}}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Nome do Produto:</label>
                            <div class="conteudo">{{$produto->nome}}</div>
                        </div>

                        <div class="form-group">
                            <label for="quantidade">Quantidade:</label>
                            <input class="form-control-template" type="number" name="quantidade" id="quantidade" value="" placeholder="Digite a quantidade" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnSalvar">Salvar Pedido de compra</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // Função para trocar a imagem principal
            function changeImage(src) {
                document.getElementById('mainImage').src = src;

                // Remove a classe active de todas as miniaturas
                const thumbnails = document.querySelectorAll('.thumbnail');
                thumbnails.forEach(thumb => thumb.classList.remove('active'));

                // Adiciona a classe active à miniatura clicada
                event.currentTarget.classList.add('active');
            }

            // Script para o modal de pedido de compra
            $(document).ready(function() {
                $('#btnSalvar').click(function() {
                    var patrimonioId = $('#patrimonio_id').val();
                    var produtoId = $('#produto_id').val();
                    var qnt = $('#quantidade').val();
                    var data = {
                        patrimonio_id: patrimonioId,
                        id: produtoId,
                        quantidade: qnt
                    };

                    $.ajax({
                        url: '{{ route("pedido-compra-auto-generate") }}',
                        type: 'POST',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Resposta completa do controlador:', response);

                            setTimeout(function() {
                                if (response && response.message) {
                                    alert('Resposta: ' + response.message);
                                    $('#myModal').modal('hide');
                                } else {
                                    alert('Resposta do controlador não contém a mensagem esperada.');
                                }
                            }, 300);
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro ao gerar pedido de compra', error);
                            alert('Erro ao gerar pedido de compra, Atualize o formulário: ' + error);
                        }
                    });
                });
            });
        </script>
</main>

@endsection