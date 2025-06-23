@extends('app.layouts.app')
@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Pedido de saída sem O.S.
                <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
                <a class="btn btn-outline-primary mb-1" href="{{route('pedido-saida.index')}}"><span class="material-symbols-outlined">
                        format_list_bulleted
                    </span>
                </a>
                </a>
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
            {{--Cabeçalho do pedido--}}
            <div class="form-row">
                <div class="col-md-1">
                    <label for="quantidade">ID</label>
                    <input type="number" id="equipamento_id" name="equipamento_id" class="form-control" value="{{$pedido_saida->id}}" readonly>
                </div>
                <div class="col-md-1">
                    <label for="data_inicio">DataEmissão:</label>
                    <input type="text" class="form-control -lg" name="data_emissao" id="data_emissao" value="{{$pedido_saida->data_emissao}}" readonly>
                </div>
                <div class="col-md-1">
                    <label for="data_inicio">Hora Emissão:</label>
                    <input type="text" class="form-control -lg" name="data_emissao" id="data_emissao" value="{{$pedido_saida->hora_emissao}}" readonly>
                </div>
                <div class="col-md-1">
                    <label for="data_inicio">Data prevista:</label>
                    <input type="date" class="form-control -lg" name="data_emissao" id="data_prevista" value="{{$pedido_saida->data_emissao}}" readonly>
                </div>
                <div class="col-md-1">
                    <label for="data_inicio">Hora prevista:</label>
                    <input type="text" class="form-control -lg" name="data_emissao" id="data_emissao" value="{{$pedido_saida->hora_emissao}}" readonly>
                </div>
                <div class="col-md-1">
                    <label for="data_inicio">Situação:</label>
                    <input type="text" class="form-control -lg" name="situacao" id="situacao" value="{{$pedido_saida->status}}" readonly>
                </div>
                <div class="col-md-1">
                    <label for="data_inicio">Emissor:</label>
                    <input type="text" class="form-control -lg" name="situacao" id="situacao" value="{{$pedido_saida->funcionarios_id}}" readonly>
                </div>
            </div>
            {{-- Formulário com os dados para adicionar o item --}}
            <form id="form_add_item" action="{{ route('saida-produto-add-item.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="col-md-1">
                        <label for="equipamento_id">Equipamento_id</label>
                        <input type="number" id="equipamento_id" name="equipamento_id" class="form-control" value="{{$pedido_saida->equipamento_id}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="equipamento_id">Equipamento nome</label>
                        @php
                        $equipamentoId = $pedido_saida->equipamento_id;
                        $equipamento = $equipamentos->firstWhere('id', $equipamentoId);
                        @endphp

                        @if($equipamento)
                        <input type="text" id="equipamento_nome" name="equipamento_nome" class="form-control" value="{{ $equipamento->nome }}" readonly>
                        <input type="hidden" id="equipamento_id" name="equipamento_id" value="{{ $equipamento->id }}">
                        @else
                        <p>Equipamento não encontrado.</p>
                        @endif
                    </div>
                </div>
                <hr>
                <input class="form-control" type="text" id="search" placeholder="Pesquisar por iniciais...">
                <div class="form-group">
                    <label for="produto-select">Produto</label>
                    <select id="produto-select" name="produto_id" class="form-control">
                        <!-- As opções serão preenchidas dinamicamente -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" class="form-control" required>
                </div>
                <input type="hidden" name="pedido_id" value="{{ $pedido_saida->id }}">
                <button type="button" class="btn btn-primary" onclick="confirmSave()">Cadastrar</button>
            </form>

            <!-------------------------------------QR  code  teste---------------------------------------->

          

            <!----------------------------------------------------------------------------->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function confirmSave() {
                    Swal.fire({
                        title: 'Deseja cadastrar o item?',
                        text: "Você não poderá reverter isso!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim, cadastrar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submete o formulário
                            document.getElementById('form_add_item').submit();
                        }
                    });
                }

                // Adiciona um listener para o evento de tecla no formulário
                document.getElementById('form_add_item').addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault(); // Impede o envio do formulário padrão
                        confirmSave();
                    }
                });
            </script>

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

                table,
                th,
                td {
                    border: 1px solid black;
                }

                th,
                td {
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
                        <th>Descrição</th>
                        <th>Unidade de Medida</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Subtotal</th>
                        <th>Data</th>
                        <th>Equipamento ID</th>
                        <th>Ações</th> <!-- Adicionado para o botão de exclusão -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saidas_produtos as $saida_produto)
                    <tr>
                        <td>{{ $saida_produto->pedidos_saida_id }}</td>
                        <td>{{ $saida_produto->produto_id }}</td>
                        <td>
                            @php
                            $produto = $produtos->firstWhere('id', $saida_produto->produto_id);
                            @endphp
                            {{ $produto ? $produto->nome : 'Produto não encontrado' }}
                        </td>
                        <td>{{ $saida_produto->unidade_medida }}</td>
                        <td>{{ $saida_produto->quantidade }}</td>
                        <td>{{ $saida_produto->valor }}</td>
                        <td>{{ $saida_produto->subtotal }}</td>
                        <td>{{ $saida_produto->data }}</td>
                        <td>{{ $saida_produto->equipamento_id }}</td>
                        <td><!--//---------------------------//--->
                            <!-- Botão de exclusão -->
                            <form id="delete-form-{{ $saida_produto->id }}" action="{{ route('saida-produto.destroy', $saida_produto->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="pedidos_saida_id" value="{{ $saida_produto->pedidos_saida_id }}">
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $saida_produto->id }})">Deletar</button>
                            </form>
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                function confirmDelete(id) {
                                    Swal.fire({
                                        title: 'Deseja excluir este item do pedido? Neste caso o item será extornado para o estoque novamente.',
                                        text: "Você não poderá reverter isso!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Sim, excluir!',
                                        cancelButtonText: 'Cancelar'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Submete o formulário
                                            document.getElementById('delete-form-' + id).submit();
                                        }
                                    });
                                }
                            </script>
                        </td>
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