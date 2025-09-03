@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <!-- CABEÇALHO (MANTIDO ORIGINAL) -->
    <div class="card">
        <div class="card-header-template">
            <div>LISTAGEM DE PRODUTOS</div>
            {{$num_pedido}}
            <form id="formSearchingProducts" action="{{'Produtos-filtro'}}" method="POST">
                @csrf
                <input type="number" name="num_pedido" value="{{$num_pedido}}" hidden>
                <div class="col-md-12 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="2">Busca Pelas inicias</option>
                        <option value="1">Busca pelo ID</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por categoria</option>
                        <option value="5">Busca Pelo estoque minimo</option>
                    </select>
                </div>
                <div class="col-md-12">
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
                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search"></i>
                </button>
            </form>
            <div>
                <a href="{{ route('produto.create') }}" class="btn btn-outline-primary btn-sm">
                    <span class="material-symbols-outlined">forms_add_on</span>
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

    <!-- ESTILOS PARA OS CARDS (NOVA PARTE) -->
    <style>
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

        .btn-outline-primary { border-color: #007bff; color: #007bff; }
        .btn-outline-success { border-color: #28a745; color: #28a745; }
        .btn-outline-danger { border-color: #dc3545; color: #dc3545; }
        
        .btn-outline-primary:hover { background: #007bff; color: white; }
        .btn-outline-success:hover { background: #28a745; color: white; }
        .btn-outline-danger:hover { background: #dc3545; color: white; }

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