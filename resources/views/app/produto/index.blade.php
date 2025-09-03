@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>LISTAGEM DE PRODUTOS</div>
            {{---------------------------------------------------------------}}

            {{---------------------------fim----------------------------------}}
            {{$num_pedido}}
            <form id="formSearchingProducts" action="{{'Produtos-filtro'}}" method="POST">
                @csrf

                <input type="number" name="num_pedido" value="{{$num_pedido}}" hidden>
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="2">Busca Pelas inicias</option>
                        <option value="1">Busca pelo ID</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por categoria</option>
                        <option value="5">Busca Pelo estoque minimo</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="categoria_id" id="" class="form-control-template">
                        <option value=""> --Selecione a Categoria--</option>
                        @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('categoria_id') ? $errors->first('categoria_id') : '' }}
                </div>
                <!--input box filtro buscar produto--------->

                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search"></i>
                </button>
            </form>
            <div>
                <a href="{{ route('produto.create') }}" class="btn btn-outline-primary btn-sm">
                    <img src="" alt="">
                    <span class="material-symbols-outlined">
                        forms_add_on
                    </span>
                    Novo Produto
                </a>
                <a href="{{route('pedido-compra.index')}}" class="btn btn-outline-primary btn-sm">
                    Pedidos de compra
                </a>
                <a class="btn btn-outline-dark btn-sm" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
            </div>
        </div>
    </div>
    <!---estilização do input box buscar produtos---->
    <style>
        #formSearchingProducts {
            background-color: white;
            width: 900px;
            height: 44px;
            border-radius: 5px;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        input {
            all: unset;
            font: 16px system-ui;
            color: blue;
            height: 100%;
            width: 100%;
            padding: 6px 10px;
        }

        ::placeholder {
            color: blueviolet;
            opacity: 0.9;
        }


        button {
            all: unset;
            cursor: pointer;
            width: 44px;
            height: 44px;
        }

        #tblProdutos {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            background-color: rgb(211, 211, 211);
        }

        thead {
            background-color: rgb(169, 169, 169);
            font-family: 'Poppins', sans-serif;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 3px;
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        tr:hover {
            background-color: rgb(169, 169, 169);
        }
    </style>
    {{--=============================================--}}
    {{--inicio Tabela de produtos--}}
    <div class="card-body">
        <div class="produtos-grid">
            @foreach ($produtos as $produto)
            <div class="produto-card">
                <!-- Cabeçalho -->
                <div class="produto-header">
                    <span class="produto-id">ID: {{ $produto->id }}</span>
                    <span class="produto-codigo">{{ $produto->cod_fabricante }}</span>
                </div>

                <!-- Corpo -->
                <div class="produto-body">
                    <div class="produto-nome">{{ $produto->nome }}</div>

                    <div class="produto-info">
                        <span>
                            <span class="info-label">Unidade:</span>
                            {{ $produto->unidade_medida->nome }}
                        </span>
                        <span>
                            <span class="info-label">Categoria:</span>
                            {{ $produto->categoria->nome }}
                        </span>
                        <span>
                            <span class="info-label">Fabricante:</span>
                            {{ $produto->marca->nome }}
                        </span>
                        <span>
                            <span class="info-label">Descrição:</span>
                            {{ Str::limit($produto->descricao, 50) }}
                        </span>
                    </div>

                    <!-- Imagem -->
                    <div class="produto-imagem">
                        <img src="/img/produtos/{{ $produto->image }}" alt="{{ $produto->nome }}">
                    </div>

                    <!-- Link para peça -->
                    <div style="text-align: center; margin: 8px 0;">
                        <a href="{{ $produto->link_peca }}" target="_blank" style="font-size: 13px;">
                            Ver no site do fabricante <i class="icofont-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Rodapé com ações -->
                <div class="produto-actions">
                    <a href="{{ route('Estoque-produto.create',['produto' => $produto->id]) }}"
                        class="btn-sm-template btn-outline-success">
                        <i class="icofont-database-add"></i>
                        Criar estoque
                    </a>

                    <div class="btn-group">
                        <a class="btn-sm-template btn-outline-primary"
                            href="{{ route('produto.show', ['produto' => $produto->id]) }}">
                            <i class="icofont-eye-alt"></i>
                        </a>

                        <a class="btn-sm-template btn-outline-success @can('user') disabled @endcan"
                            href="{{ route('produto.edit', ['produto' => $produto->id]) }}">
                            <i class="icofont-ui-edit"></i>
                        </a>

                        <a class="btn-sm-template btn-outline-danger @can('user') disabled @endcan"
                            href="#" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            onclick="DeletarProduto()">
                            <i class="icofont-ui-delete"></i>
                        </a>
                    </div>
                </div>

                <!-- Pedido especial -->
                @if(isset($num_pedido) && $num_pedido >= 1)
                <div style="margin-top: 10px; text-align: center;">
                    <a href="{{ route('pedido-compra-lista.index', ['produto_id' => $produto->id,'numpedidocompra'=>$num_pedido]) }}"
                        class="pedido-badge">
                        Adicionar ao pedido: {{ $num_pedido }}
                    </a>
                </div>
                @endif

                <!-- Form para deletar (hidden) -->
                <form id="form_{{ $produto->id }}" method="post"
                    action="{{ route('produto.destroy', ['produto' => $produto->id]) }}">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
            @endforeach
        </div>
    </div>
    <style>
        /* ESTILO GERAL DA LISTAGEM */
        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .produto-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .produto-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* CABEÇALHO DO CARD */
        .produto-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .produto-id {
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }

        .produto-codigo {
            background: #f0f0f0;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #666;
        }

        /* CORPO DO CARD */
        .produto-body {
            margin-bottom: 15px;
        }

        .produto-nome {
            font-weight: bold;
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 8px;
            word-break: break-word;
        }

        .produto-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            font-size: 13px;
            color: #666;
        }

        .produto-info span {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 12px;
            margin-bottom: 2px;
        }

        /* IMAGEM DO PRODUTO */
        .produto-imagem {
            text-align: center;
            margin: 10px 0;
        }

        .produto-imagem img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        /* RODAPÉ DO CARD - AÇÕES */
        .produto-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .btn-sm-template {
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }

        .btn-outline-primary {
            border: 1px solid #007bff;
            color: #007bff;
        }

        .btn-outline-success {
            border: 1px solid #28a745;
            color: #28a745;
        }

        .btn-outline-danger {
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        .btn-outline-primary:hover {
            background: #007bff;
            color: white;
        }

        .btn-outline-success:hover {
            background: #28a745;
            color: white;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
        }

        /* BADGE PARA PEDIDOS */
        .pedido-badge {
            background: #ff6b35;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 768px) {
            .produtos-grid {
                grid-template-columns: 1fr;
            }

            .produto-info {
                grid-template-columns: 1fr;
            }

            .produto-actions {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }

            .btn-group {
                justify-content: center;
            }
        }

        /* ESTILOS PARA STATUS/ESTADO */
        .estoque-minimo {
            background: rgba(255, 193, 7, 0.2);
            border-left: 4px solid #ffc107;
        }

        .estoque-critico {
            background: rgba(220, 53, 69, 0.1);
            border-left: 4px solid #dc3545;
        }
    </style>
    <script>

    </script>
</main>
@endsection