@extends('app.layouts.app')
@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Pedido de saída sem os
                <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
                <a class="btn btn-outline-primary mb-1" href="{{route('pedido-saida.index')}}"><span class="material-symbols-outlined">
                        format_list_bulleted
                    </span>
                </a>
            </a>
            </div>
            <div>
                ID:{{$pedido_saida->id}}
                data:{{$pedido_saida->data_emissao}}
                ID:{{$pedido_saida->equipamento_id}}
            </div>
        </div>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Filtrar Produtos</title>
            <script>
    document.addEventListener('DOMContentLoaded', function() {
        const produtos = @json($produtos); // Converte o array de produtos para JSON

        const searchInput = document.getElementById('search');
        const selectElement = document.getElementById('produto-select');

        function filterProdutos(query) {
            selectElement.innerHTML = ''; // Limpa as opções existentes
            const filteredProdutos = produtos.filter(produto =>
                produto.nome.toLowerCase().startsWith(query.toLowerCase()) // Verifica se começa com a query
            );
            filteredProdutos.forEach(produto => {
                const option = document.createElement('option');
                option.value = produto.id;
                option.textContent = `${produto.nome} (ID: ${produto.id})`; // Exibe nome e ID
                selectElement.appendChild(option);
            });
        }

        searchInput.addEventListener('input', function() {
            filterProdutos(searchInput.value);
        });

        // Inicializa com todos os produtos
        filterProdutos('');
    });
</script>

        </head>

        <body>
            <input class="form-control" type="text" id="search" placeholder="Pesquisar por iniciais...">
            <form action="{{ route('saida-produto-add-item.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="produto-select">Produto</label>
                    <select id="produto-select" name="produto_id" class="form-control">
                        <!-- As opções serão preenchidas dinamicamente -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantidade">Equipamento_id</label>
                    <input type="number" id="equipamento_id" name="equipamento_id" class="form-control" value="{{$pedido_saida->equipamento_id}}" readonly>
                </div>
                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" class="form-control" required>
                </div>
                <input type="hidden" name="pedido_id" value="{{ $pedido_saida->id }}">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </body>

        </html>
        <!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h6>Lista de Produtos</h6>
    @if(isset($saidas_produtos) && $saidas_produtos->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Pedidos Saída ID</th>
                    <th>Produto ID</th>
                    <th>Unidade de Medida</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                    <th>Subtotal</th>
                    <th>Data</th>
                    <th>Equipamento ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saidas_produtos as $saida_produto)
                    <tr>
                        <td>{{ $saida_produto->pedidos_saida_id }}</td>
                        <td>{{ $saida_produto->produto_id }}</td>
                        <td>{{ $saida_produto->unidade_medida }}</td>
                        <td>{{ $saida_produto->quantidade }}</td>
                        <td>{{ $saida_produto->valor }}</td>
                        <td>{{ $saida_produto->subtotal }}</td>
                        <td>{{ $saida_produto->data }}</td>
                        <td>{{ $saida_produto->equipamento_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            Nenhum produto neste pedido, disponível para exibir.
        </div>
    @endif
</body>
</html>
</main>
@endsection