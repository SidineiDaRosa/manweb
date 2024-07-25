@extends('app.layouts.app')
@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Pedido de saida sem os
            </div>
            <div>
                ID:{{$pedido_saida->id}}
                data:{{$pedido_saida->data_emissao}}
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
                            produto.nome.toLowerCase().includes(query.toLowerCase())
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

            <select id="produto-select" name="produto" class="form-control">
                <!-- As opções serão preenchidas dinamicamente -->
            </select>
            <a class="btn btn-outline-success mb-1" href="{{ route('pedido-saida.show', ['pedido_saida' => $pedido_saida->id,'os'=>0]) }}">
                <i class="icofont-tractor"></i>
                Adicionar ao pedido
            </a>
        </body>

        </html>
</main>
@endsection