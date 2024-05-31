@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<main class="content">
    <div class="titulo-main">
        Pedido de compra
    </div>
    <style>
        .titulo-main {
            font-size: 25px;
            color: gray;
            text-align: center;
            margin-top:-10px;
        }
    </style>
    <div class="card">
            @foreach ($pedidos_compra as $pedido_compra)
            @endforeach
        <div class="card-header-template">
            <div>
                <a href="{{route('pedido-compra.index')}}" class="btn btn-sm-template btn-outline-secondary">
                    <i class="icofont-list"></i>
                </a>
                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('pedido-compra-lista-printer', ['numpedidocompra'=>$pedido_compra->id]) }}">
                    <i class="icofont-printer"></i>
                </a>
                <a class="btn btn-sm-template btn-outline-dark" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
            </div>
        </div>
        <style>
            #cabecalho {
                text-align: center;
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                font-size: 30px;
            }

            .card-header-template {
                font-size: 20px;
                color: gray;
                background-color: white;


            }
        </style>

        {{-------------------------------------------------------------------------}}
        {{--Inicio do bloco que contém o continer dos gráficos---------------------}}
        <style>
            body,
            html {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .container-chart {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                align-items: flex-start;
                background-color: white;

            }

            textarea {
                font-size: 15px;
                font-weight: 500;
                color: magenta;
            }

            .item {
                width: calc(33% - 20px);
                height: auto;
                margin: 10px;
                padding: 15px;
                background-color: white;
                overflow: auto;
                /* Impede que o conteúdo transborde */
                font-weight: 500;
                margin-top: 0px;;
            }

            .box {
                display: flex;
                width: 100%;
                height: auto;
                margin-bottom: 1px;
                background-color: #ccc;
                border-radius: 5px;
                padding: 5px;


            }

            @media (max-width: 900px) {
                .item {
                    width: 100%;
                    margin: 0px -80;
                }
            }
            .box-conteudo {
                margin-left: 50px;
                justify-content: flex-start;
            }

            .titulo {
                display: flex;
                font-size: 15px;
                font-family: 'Poppins', sans-serif;

            }

            .conteudo {
                display: flex;
                font-size: 20px;
                font-family: 'Poppins', sans-serif;
                color: #007b00;
                margin-bottom: 5px;
            }

            #patrimonio {
                color: #2174d4;
            }
        </style>
        <div class="container-chart">
            {{--Box 1--}}
            <div class="item">

                <div class="titulo">Emissão</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->data_emissao }} {{ $pedido_compra->hora_emissao }}</div>
                <div class="titulo">Previsão</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->data_prevista}} {{ $pedido_compra->hora_prevista}}</div>

            </div>
            {{--Box 2--}}
            <div class="item">
                <div id=idOs class="conteudo" style="color:mediumblue">
                    ID:&nbsp&nbsp{{$pedido_compra->id}}
                </div>
                <div class="titulo">Patrimônio</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->equipamento->nome}}</div>
                <div class="titulo">Emissor</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->funcionarios->primeiro_nome}}</div>
            </div>
            {{--Box 3--}}
            <div class="item">
                <div class="titulo">Situação</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->status}}</div>
                <div class="titulo">Descrição</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->descricao}}</div>

            </div>
        </div>
        {{----------------------------------------------------------------}}
        {{--cadastro de pedido de compra lista de material----------------}}
        <script>
            //-----------------------------------------------------//
            // desativa buscar peças caso o pedido ja esteja fechado//
            document.addEventListener('DOMContentLoaded', function() {
                // Verifica se o status do pedido de compra é "fechado"
                if (document.getElementById('pedidos_compra_status').value === 'fechado') {
                    // Esconde o formulário
                    document.getElementById('pedidoCompraForm').style.display = 'none';
                    document.getElementById('enviar').style.display = 'none';
                }
            });
        </script>
        <form id="pedidoCompraForm" action="{{ route('pedido-compra-lista.store') }}" method="POST">
            @csrf
            @method('POST')
            {{---------------------------------------------------}}
            {{--Bloco escolha do produto para inserir no pedido--}}
            <div class="form-row">
                <div class="row mb-1">
                    <label for="pedidos_compra_id" class="col-md-4 col-form-label text-md-end text-right">ID Ped</label>
                    <div class="col-md-6">
                        <input name="pedidos_compra_id" id="pedidos_compra_id" type="text" class="form-control" value="{{ $pedido_compra->id }}" readonly>
                        <span id="pedidos_compra_id_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="row mb-6">
                    <label for="produto_id" class="col-md-4 col-form-label text-md-end text-right">ID Produto </label>
                    <div class="col-md-6">
                        <input name="produto_id" id="produto_id" type="text" class="form-control" value="{{ $produto_id }}" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-0 offset-md-0">
                        <button type="button" id="executarFormulario" class="btn btn-secondary sm" value="">
                            Buscar
                            <i class="icofont-search"></i>
                        </button>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">Quantidade</label>
                    <div class="col-md-6">
                        <input name="quantidade" id="quantidade" type="text" class="form-control" value="{{ old('quantidade') }}">
                        <span id="quantidade_error" class="text-danger"></span>
                    </div>
                    {{-------------------------------------------------}}
                    {{-- focus no input quantidade--}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('quantidade').focus();
                        });
                    </script>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" id="submitForm" class="btn btn-primary sm" value="">
                            Incluir no pedido
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <form id="formSearchingProducts" action="{{'Produtos-filtro'}}" method="POST" class="row mb-1">
            @csrf
            <div class="row mb-1">
                <div class="col-md-6">
                    <input name="num_pedido" id="num_pedido" type="text" class="form-control" value="{{ $pedido_compra->id }}" hidden>
                    <span id="quantidade_error" class="text-danger"></span>
                </div>
            </div>
        </form>
        <script>
            // Quando o botão for clicado
            $('#executarFormulario').click(function(e) {
                e.preventDefault(); // Evita o comportamento padrão de enviar o formulário

                // Obtém os dados do formulário
                var formData = $('#formSearchingProducts').serialize();

                // Envia a requisição AJAX
                $.ajax({
                    url: $('#formSearchingProducts').attr('action'), // Obtém a URL do formulário
                    type: 'POST', // Método do formulário
                    data: formData, // Dados do formulário
                    success: function(response) {
                        // Manipule a resposta aqui, se necessário
                        console.log(response);

                        // Submeta o formulário após o sucesso do AJAX
                        $('#formSearchingProducts').submit();
                    },
                    error: function(xhr, status, error) {
                        // Manipule os erros aqui, se necessário
                        console.error(xhr.responseText);
                    }
                });
            });
        </script>
        <table class="table-striped table-hover table-bordered" id="table_lista_compra">
            <thead>
                <tr>
                    <th hidden>Id</th>
                    <th>Produto ID</th>
                    <th>Código Fab</th>
                    <th>nome</th>
                    <th>Und</th>
                    <th>Quantidade</th>
                    <th>Imagem</th>
                    <th>operaçoes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido_compra_lista as $pedido_compra_ls)
                @php
                $produto = $produtos->firstWhere('id', $pedido_compra_ls->produto_id);
                $unidade_medida = $unidades_de_medida->firstWhere('id', $produto->unidade_medida_id);
                @endphp
                <tr>
                    <td hidden>{{ $pedido_compra_ls->id }}</td>
                    <td>{{ $pedido_compra_ls->produto_id }}</td>
                    <td>{{ $produto->cod_fabricante}}</td>
                    <td>{{ $produto->nome ?? 'Produto não encontrado' }}</td>
                    <td> {{$unidade_medida->nome}}</td>
                    <td>{{ $pedido_compra_ls->quantidade}}</td>
                    <td>
                        @if ($produto)
                        <img src="/img/produtos/{{ $produto->image }}" alt="Imagem do Produto" class="preview-image">
                        @endif
                        <style>
                            .preview-image {
                                width: 100px;
                                height: 100px;
                                object-fit: cover;
                                margin: 0 5px;
                                cursor: pointer;
                            }
                        </style>
                    </td>
                    <td>
                        <a class="btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' =>$pedido_compra_ls->produto_id]) }}">
                            <i class="icofont-eye-alt"></i>
                        </a>
                        <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarProduto()">
                            <i class="icofont-ui-delete"></i></a>
                        <script>
                            function DeletarProduto() {
                                var x;
                                var r = confirm("Deseja deletar o produto da lista de compra?");
                                if (r == true) {

                                    document.getElementById('form_{{$pedido_compra_ls->id }}').submit()
                                    //route('pedido-compra-lista.destroy',['pedidocompralista'=>2])
                                } else {
                                    x = "Você pressionou Cancelar!";
                                }
                                document.getElementById("demo").innerHTML = x;
                            }
                        </script>
                        <form id="form_{{$pedido_compra_ls->id}}" method="post" action="{{ route('delete-item-pedido-delete')}}">
                            @method('DELETE')
                            @csrf
                            <input type="text" value="{{ $pedido_compra_ls->produto_id}}" name="produto" hidden>
                            <input type="text" value="{{ $pedido_compra_ls->produto_id}}" name="produto_id" hidden>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    {{--====================================================================--}}
    {{--Função que fecha o pedido de compra-----------------------------------}}
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <div class="row mb-1">
        <hr>
            <div class="col-md-12">
                <button id="enviar" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#confirmModal">
                <img src="{{ asset('img/icon/finished-work.png') }}" alt="" style="height:25px; width:25px;">Fechar pedido compra</button>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Deseja realmente fechar o pedido de compra?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmarEnvio" data-bs-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Sucesso -->
    <div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sucessoModalLabel">Sucesso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pedido de compra fechado com sucesso!
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Erro -->
    <div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sucessoModalLabel"><i class="icofont-warning"></i>Alerta!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pedido de compra erro ao fechar!
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="valor" placeholder="Digite um valor" value="{{$pedido_compra->id}}" hidden readonly>
    <script>
        $(document).ready(function() {
            $('#confirmarEnvio').click(function() {
                var valor = $('#valor').val(); // Obtém o valor do input

                $.ajax({
                    type: 'GET', // Método HTTP da requisição
                    url: '{{ route("updatepedidocompra") }}', // URL para onde a requisição será enviada
                    data: {
                        valor: valor
                    }, // Dados a serem enviados (no formato chave: valor)
                    success: function(response) {
                        $('#mensagem').text('Resposta do servidor: ' + response); // Exibe a resposta do servidor
                        $('#sucessoModal').modal('show'); // Exibe a modal de sucesso
                    },
                    error: function(xhr, status, error) {
                        $('#mensagem').text('Erro ao enviar valor: ' + error); // Exibe mensagem de erro, se houver
                        $('#erroModal').modal('show'); // Exibe a modal de sucesso
                    }
                });
            });
        });
    </script>

</main>
@endsection