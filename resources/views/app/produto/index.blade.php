@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <!-- CABEÇALHO-->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #2ec4b6;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        
        .top-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 25px;
            border: none;
        }
        
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.2);
        }
        
        .search-input-group {
            display: flex;
            flex-grow: 1;
            max-width: 400px;
        }
        
        .search-input {
            border-right: none;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        
        .search-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            padding: 0 15px;
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            background-color: var(--secondary-color);
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .btn-modern {
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary-modern {
            background-color: var(--primary-color);
            border: none;
            color: white;
        }
        
        .btn-primary-modern:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-outline-modern {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }
        
        .btn-outline-modern:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .filter-select {
            min-width: 200px;
        }
        
        .category-select {
            min-width: 220px;
        }
        
        @media (max-width: 992px) {
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input-group {
                max-width: 100%;
            }
            
            .action-buttons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-card">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-4">
                <!-- Formulário de busca -->
                <form id="formSearchingProducts" action="{{'produtos-filtro'}}" method="POST" class="search-form">
                    @csrf
                    <input type="number" name="num_pedido" value="{{$num_pedido}}" hidden>
                    
                    <select class="form-select filter-select" name="tipofiltro" id="tipofiltro">
                        <option value="2">Busca Pelas Iniciais</option>
                        <option value="1">Busca pelo ID</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por Categoria</option>
                        <option value="5">Busca Pelo Estoque Mínimo</option>
                    </select>
                    
                    <select name="categoria_id" class="form-select category-select">
                        <option value="">-- Selecione a Categoria --</option>
                        @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                        @endforeach
                    </select>
                    
                    <div class="search-input-group">
                        <input class="form-control search-input" type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Botões de ação -->
                <div class="action-buttons">
                    <a href="{{ route('produto.create') }}" class="btn btn-primary-modern btn-modern">
                        <i class="bi bi-plus-circle"></i> Novo Produto
                    </a>
                    <a href="{{route('pedido-compra.index')}}" class="btn btn-outline-modern btn-modern">
                        <i class="bi bi-cart-check"></i> Pedidos de Compra
                    </a>
                    <a class="btn btn-outline-modern btn-modern" href="{{ route('app.home') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para mostrar/ocultar o campo de categoria baseado no tipo de filtro
        document.addEventListener('DOMContentLoaded', function() {
            const tipoFiltro = document.getElementById('tipofiltro');
            const categoriaSelect = document.querySelector('select[name="categoria_id"]');
            const searchInput = document.getElementById('query');
            
            // Inicialmente, esconder o campo de categoria se não for o selecionado
            toggleCategoryField();
            
            tipoFiltro.addEventListener('change', toggleCategoryField);
            
            function toggleCategoryField() {
                if (tipoFiltro.value === '4') {
                    categoriaSelect.closest('.category-select').style.display = 'block';
                    searchInput.style.display = 'none';
                } else if (tipoFiltro.value === '5') {
                    categoriaSelect.closest('.category-select').style.display = 'none';
                    searchInput.style.display = 'none';
                    searchInput.disabled = true;
                } else {
                    categoriaSelect.closest('.category-select').style.display = 'none';
                    searchInput.style.display = 'block';
                    searchInput.disabled = false;
                    
                    // Atualizar placeholder baseado na seleção
                    if (tipoFiltro.value === '1') {
                        searchInput.placeholder = "Digite o ID do produto...";
                    } else if (tipoFiltro.value === '3') {
                        searchInput.placeholder = "Digite o código do fabricante...";
                    } else {
                        searchInput.placeholder = "Buscar produto...";
                    }
                }
            }
        });
    </script>
</body>
</html>
    <!-- ESTILOS PARA OS CARDS (NOVA PARTE) -->
    <style>
        .top {
            display: flex;
            flex-direction: row;
        }

        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .produto-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .produto-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .produto-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .produto-id {
            font-weight: bold;
            color: #2c3e50;
            font-size: 14px;
        }

        .produto-codigo {
            background: #e3f2fd;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            color: #1976d2;
            font-weight: 500;
        }

        .produto-body {
            margin-bottom: 20px;
        }

        .produto-nome {
            font-weight: 600;
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .produto-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            font-size: 12px;
            margin-bottom: 3px;
            display: block;
        }

        .produto-imagem {
            text-align: center;
            margin: 15px 0;
        }

        .produto-imagem img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #f0f0f0;
        }

        .produto-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 2px solid #f0f0f0;
        }

        .btn-group {
            display: flex;
            gap: 8px;
        }

        .btn-sm-template {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
            border: 1px solid;
        }

        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }

        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-danger {
            border-color: #dc3545;
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

        .pedido-badge {
            background: linear-gradient(45deg, #ff6b35, #ff8c42);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .pedido-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 8px rgba(255, 107, 53, 0.3);
        }

        @media (max-width: 768px) {
            .top {
                display: flex;
                flex-direction: column;
            }

            .produtos-grid {
                grid-template-columns: 1fr;
            }

            .produto-info {
                grid-template-columns: 1fr;
            }

            .produto-actions {
                flex-direction: column;
                gap: 12px;
            }

            .btn-group {
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <!-- LISTAGEM DE PRODUTOS EM CARDS (SUBSTITUI A TABELA) -->
    <div class="card-body">
        <div class="produtos-grid">
            @foreach ($produtos as $produto)
            <div class="produto-card">
                <!-- Cabeçalho do Card -->
                <div class="produto-header">
                    <span class="produto-id">ID: {{ $produto->id }}</span>
                    <span class="produto-codigo">{{ $produto->cod_fabricante }}</span>
                </div>

                <!-- Corpo do Card -->
                <div class="produto-body">
                    <div class="produto-nome">{{ $produto->nome }}</div>

                    <div class="produto-info">
                        <div>
                            <span class="info-label">Unidade:</span>
                            {{ $produto->unidade_medida->nome }}
                        </div>
                        <div>
                            <span class="info-label">Categoria:</span>
                            {{ $produto->categoria->nome }}
                        </div>
                        <div>
                            <span class="info-label">Fabricante:</span>
                            {{ $produto->marca->nome }}
                        </div>
                        <div>
                            <span class="info-label">Descrição:</span>
                            {{ Str::limit($produto->descricao, 60) }}
                        </div>
                    </div>

                    <!-- Imagem -->
                    <div class="produto-imagem">
                        <img src="/img/produtos/{{ $produto->image }}" alt="{{ $produto->nome }}">
                    </div>

                    <!-- Link para peça -->
                    <div style="text-align: center; margin: 12px 0;">
                        <a href="{{ $produto->link_peca }}" target="_blank"
                            style="color: #1976d2; text-decoration: none; font-size: 13px;">
                            <i class="icofont-external-link"></i> Ver no site do fabricante
                        </a>
                    </div>
                </div>

                <!-- Rodapé com Ações -->
                <div class="produto-actions">
                    <a href="{{ route('Estoque-produto.create',['produto' => $produto->id]) }}"
                        class="btn-sm-template btn-outline-success">
                        <i class="icofont-database-add"></i>
                        Estoque
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
                            href="#" onclick="deletarProduto({{ $produto->id }})">
                            <i class="icofont-ui-delete"></i>
                        </a>
                    </div>
                </div>

                <!-- Pedido Especial -->
                @if(isset($num_pedido) && $num_pedido >= 1)
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ route('pedido-compra-lista.index', ['produto_id' => $produto->id,'numpedidocompra'=>$num_pedido]) }}"
                        class="pedido-badge">
                        <i class="icofont-cart"></i> Adicionar ao Pedido {{ $num_pedido }}
                    </a>
                </div>
                @endif

                <!-- Form para deletar -->
                <form id="form_{{ $produto->id }}" method="post"
                    action="{{ route('produto.destroy', ['produto' => $produto->id]) }}">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
            @endforeach
        </div>
    </div>
</main>

<script>
    function deletarProduto(produtoId) {
        if (confirm('Deseja deletar este produto?')) {
            document.getElementById('form_' + produtoId).submit();
        }
    }
</script>

@endsection