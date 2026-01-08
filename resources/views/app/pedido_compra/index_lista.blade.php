@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<main class="content">
    <div class="titulo-main">
        Pedido de compra
    </div>
    <div id="alerta-topo" class="alert d-none alert-dismissible fade show text-center" role="alert"
        style="position:fixed; top:10px; left:50%; transform:translateX(-50%);
            z-index:9999; width:50%; font-weight:600;">
        <span id="alerta-msg"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Executar após o carregamento do DOM
            let produtoId = document.getElementById('produto_id').value;
            let quantidadeElement = document.getElementById('quantidade');

            if (produtoId >= 1) {
                quantidadeElement.disabled = false; // Habilitar o campo
            } else {
                quantidadeElement.disabled = true; // Desabilitar o campo
            }
        });
    </script>
    <style>
        .titulo-main {
            font-size: 25px;
            color: gray;
            text-align: center;
            margin-top: -10px;
        }

        main {}
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
                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('app.home') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('pedido-compra.edit', ['pedido_compra' => $pedido_compra->id]) }}" title="Editar Dados do Pedido, Finalizar.">
                    <i class="icofont-ui-edit"></i>
                    <i class="bi bi-arrow-repeat"></i>
                    Inserir Atualização
                </a>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

                <a href="{{ route('pedido.open', $pedido_compra->id) }}" class="btn btn-sm-template btn-outline-primary">

                    <i class="bi bi-card-checklist"></i> Eventos Inseridos
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
        {{--Inicio do bloco que contém o continer ---------------------}}
        <style>
            body,
            html {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            textarea {
                font-size: 15px;
                font-weight: 500;
                color: magenta;
            }

            .container-chart {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                align-items: flex-start;
                background-color: white;
                margin: 0;

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
                margin-top: 0px;
                ;
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
                font-size: 17px;
                font-family: 'Poppins', sans-serif;
                color: #7b817bff;
                margin-bottom: 5px;
            }

            #patrimonio {
                color: #2174d4;
            }
        </style>
        <div class="container-chart">
            {{--Box 1--}}
            <div class="item">

                <div class="titulo">
                    📅 Emissão</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ \Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/Y') }} {{ $pedido_compra->hora_emissao }}</div>
                <div class="titulo"> 📅 Previsão</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/Y') }} {{ $pedido_compra->hora_prevista}}</div>
                <div class="titulo">Fechamento</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">
                    {{ optional($pedido_compra)->data_fechamento ? \Carbon\Carbon::parse($pedido_compra->data_fechamento)->format('d/m/Y') : 'Data de fechamento não disponível' }}
                </div>
            </div>
            {{--Box 2--}}
            <div class="item">
                <div id=idOs class="conteudo" style="color:mediumblue">
                    ID:&nbsp&nbsp{{$pedido_compra->id}}
                </div>
                <div class="titulo">⚙️ Patrimônio</div>
                <hr style="margin:-3px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->equipamento->nome}}</div>
                <div class="titulo">Emissor</div>
                <hr style="margin:-3px;color:#ccc;">
                <div class="conteudo"> @php
                    $emissor = $emissores->firstWhere('id', $pedido_compra->funcionarios->id);
                    @endphp
                    @if($emissor)
                    {{ $emissor->name }}
                    @else
                    Emissor não encontrado
                    @endif
                </div>
            </div>
            {{--Box 3--}}
            <div class="item">
                <div class="titulo">Situação</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->status}}</div>
                <div class="titulo">Descrição</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->descricao}}</div>
                <div class="titulo">Fornecedor do pedido</div>
                <hr style="margin:-5px;color:#ccc;">
                <div class="conteudo">{{ $pedido_compra->fornecedor->razao_social ?? 'Não informado' }}</div>

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
            <div class="container-row-column">
                <style>
                    .div-column {
                        display: flex;
                        flex-direction: column;
                        margin-left: 20px;
                        margin-right: 20px;
                    }

                    .container-row-column {
                        display: flex;
                        flex-direction: row;
                        justify-content: center;
                        /* Alinha os itens ao centro horizontalmente */
                        align-items: center;
                        /* Alinha os itens ao centro verticalmente */
                        text-align: center;
                        /* Centraliza o texto */
                        background-color: #f7fEEf;
                    }

                    @media (max-width: 900px) {
                        .div-column {
                            margin-left: 20px;
                            margin-right: 20px;
                        }

                        .container-row-column {
                            flex-direction: column;
                            /* Altera a direção para uma coluna em telas menores */
                            justify-content: flex-start;
                            /* Alinha os itens à esquerda */
                            align-items: flex-start;
                            /* Alinha os itens ao topo */
                            text-align: left;
                            /* Define o texto para a esquerda */
                        }
                    }
                </style>
                <div class="div-column" hidden>
                    <div class="titulo">ID Pedido</div>
                    <hr style="margin:-1px;color:#ccc;">
                    <div class="conteudo" style="color:#2174d4 !important;">
                        {{ $pedido_compra->id }}
                        <input name="pedidos_compra_id" id="pedidos_compra_id" type="text" class="form-control" value="{{ $pedido_compra->id }}" readonly hidden>
                    </div>
                </div>
                <div class="div-column">
                    <div class="titulo">ID Produto</div>
                    <hr style="margin:-1px;color:#ccc;">
                    <div class="conteudo">
                        {{ $produto_id}}
                        <input name="produto_id" id="produto_id" type="text" class="form-control" value="{{ $produto_id }}" readonly hidden>
                    </div>
                </div>
                <div class="div-column">
                    <div class="titulo">Buscar</div>
                    <hr style="margin:-1px;color:#ccc;">
                    <div class="conteudo">
                        <div class="col-md-0 offset-md-0">
                            <button type="button" id="executarFormulario" class="btn btn-success sm">
                                Buscar
                                <i class="icofont-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="div-column">
                    <div class="titulo">Quantidade</div>
                    <hr style="margin:-0px;color:#ccc;">
                    <div class="conteudo">
                        <input name="quantidade" id="quantidade" type="text" class="form-control" value="{{ old('quantidade') }}">
                    </div>
                </div>
                <div class="div-column">
                    <div class="titulo">Status</div>
                    <hr style="margin:-0px;color:#ccc;">
                    <div class="conteudo">
                        <input
                            name="status"
                            id="status"
                            type="text"
                            class="form-control"
                            value="Pendente"
                            readonly
                            onmousedown="return false"
                            onselectstart="return false"
                            tabindex="-1">
                    </div>
                </div>
                <div class="div-column">
                    <div class="titulo">Inserir</div>
                    <hr style="margin:-1px;color:#ccc;">
                    <div class="conteudo">
                        <div class="col-md-0 offset-md-0">
                            <button type="submit" id="submitForm" class="btn btn-outline-primary sm" value="">
                                Incluír no Pedido
                            </button>
                        </div>
                    </div>
                </div>
                {{-------------------------------------------------}}
                {{-- focus no input quantidade--}}
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('quantidade').focus();
                    });
                </script>
            </div>
        </form>
        <form id="formSearchingProducts" action="{{'produtos-filtro'}}" method="POST" class="row mb-1">
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
        <!---------------------------------------------------------->
        <!--   Itens do pedido-------------------------------------->
        <!-- Itens do Pedido de Compra -->
        <style>
            .item-top {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                padding: 15px;
                border: 1px solid #ccc;
                border-radius: 8px;
                margin-bottom: 15px;
                align-items: flex-start;
                background-color: #f9f9f9;
            }

            .item-box {
                display: flex;
                flex-direction: column;
                min-width: 120px;
                max-width: 200px;
                word-wrap: break-word;
            }

            .item-title {
                font-weight: bold;
                margin-bottom: 5px;
                color: #333;
                font-size: 0.9rem;
            }

            .item-text {
                font-size: 0.9rem;
                color: #555;
            }

            .preview-image {
                max-width: 100px;
                max-height: 100px;
                object-fit: contain;
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-top: 5px;
            }

            .item-actions {
                display: flex;
                gap: 10px;
                margin-top: 10px;
                flex-wrap: wrap;
            }
        </style>

        <div class="container">
            @foreach ($pedido_compra_lista as $pedido_compra_ls)
            @php
            $produto = $produtos->firstWhere('id', $pedido_compra_ls->produto_id);
            $unidade_medida = $unidades_de_medida->firstWhere('id', $produto->unidade_medida_id ?? 0);
            @endphp

            <div class="item-top">
                <div class="item-box" hidden>
                    <div class="item-title">item ID:</div>
                    <div class="item-text">{{ $pedido_compra_ls->id }}</div>
                </div>
                <div class="item-box">
                    <div class="item-title">Produto ID:</div>
                    <div class="item-text">{{ $pedido_compra_ls->produto_id }}</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Código Fab:</div>
                    <div class="item-text">{{ $produto->cod_fabricante ?? '-' }}</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Descrição do produto:</div>
                    <div class="item-text">{{ $produto->nome ?? 'Produto não encontrado' }}</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Unidade:</div>
                    <div class="item-text">{{ $unidade_medida->nome ?? '-' }}</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Quantidade:</div>
                    <div class="item-text">{{ $pedido_compra_ls->quantidade }}</div>
                </div>
                <div class="item-box">
                    <div class="item-title">Status Item:</div>
                    <div class="item-text
        @if($pedido_compra_ls->status == 'Pendente') status-pendente
        @elseif($pedido_compra_ls->status == 'Concluido') status-concluido
        @elseif($pedido_compra_ls->status == 'Cancelado') status-cancelado
        @elseif($pedido_compra_ls->status == 'Parcial') status-parcial
        @endif
        p-2 rounded text-center"
                        id="status-item-{{ $pedido_compra_ls->id }}">
                        {{ $pedido_compra_ls->status }}
                    </div>
                </div>

                <style>
                    .status-pendente {
                        background-color: #fff3cd;
                        /* fundo amarelo claro */
                        color: #856404;
                        /* texto laranja escuro */
                    }

                    .status-concluido {
                        background-color: #d4edda;
                        /* fundo verde claro */
                        color: #155724;
                        /* texto verde escuro */
                    }

                    .status-cancelado {
                        background-color: #f8d7da;
                        /* fundo vermelho claro */
                        color: #721c24;
                        /* texto vermelho escuro */
                    }

                    .status-parcial {
                        background-color: #cce5ff;
                        /* fundo azul claro */
                        color: #004085;
                        /* texto azul escuro */
                    }
                </style>

                <div class="item-box">
                    <div class="item-title">Imagem:</div>
                    @if ($produto && $produto->image)
                    <img src="/img/produtos/{{ $produto->image }}" alt="Imagem do Produto" class="preview-image">
                    @else
                    <div class="text-muted">Sem imagem</div>
                    @endif
                </div>

                <div class="item-box item-actions">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('produto.show', ['produto' => $pedido_compra_ls->produto_id]) }}" target="blank">
                        <i class="icofont-eye-alt"></i> Ver
                    </a>
                    @if($pedido_compra_ls->status != 'Concluido')
                    <a href="javascript:void(0);"
                        class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete({{ $pedido_compra_ls->id }})">
                        <i class="icofont-delete"></i> Excluir
                    </a>

                    <form id="delete-item-form-{{ $pedido_compra_ls->id }}"
                        action="{{ route('pedido-compra-lista.destroy', $pedido_compra_ls->id) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#entradaModal-{{ $produto->id }}">
                        <i class="icofont-check-circled"></i> Dar Entrada
                    </button>
                    @endif
                    <!-- Modal Atulizar item -->
                    <div class="modal fade" id="entradaModal-{{ $produto->id }}" tabindex="-1" aria-labelledby="entradaModalLabel-{{ $produto->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form class="entradaForm">
                                    @csrf
                                    <input type="hidden" name="pedido_compra_id" value="{{ $pedido_compra->id }}">
                                    <input type="hidden" name="item_id" value="{{ $pedido_compra_ls->id }}">
                                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                    @if($pedido_compra->fornecedor)
                                    <input type="hidden" name="fornecedor_id" value="{{ $pedido_compra->fornecedor->id }}">
                                    @endif

                                    <div class="modal-header">
                                        <h5 class="modal-title">Entrada de Produto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Produto</label>
                                            <input type="text" class="form-control" value="{{ $produto->nome }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Quantidade Recebida</label>
                                            <input type="number" name="quantidade" class="form-control" min="1" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Valor</label>
                                            <input type="number" name="valor" class="form-control" placeholder="R$ 0,00" step="0.01" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="Pendente">Pendente</option>
                                                <option value="Concluido">Concluído</option>
                                                <option value="Cancelado">Cancelado</option>
                                                <option value="Parcial">Parcial</option>
                                            </select>
                                        </div>
                                        <div class="alert alert-success d-none msg-sucesso"></div>
                                        <div class="alert alert-danger d-none msg-erro"></div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Registrar Entrada</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- Modal atulizar item fim -->
                </div>
            </div>
            @endforeach
        </div>



        <script>
            function confirmDelete(itemId) {
                if (confirm('Você tem certeza que deseja deletar este item?')) {
                    document.getElementById('delete-item-form-' + itemId).submit();
                }
            }
        </script>

    </div>
    <div class="alert alert-success d-none" id="msg-sucesso"></div>
    <div class="alert alert-danger d-none" id="msg-erro"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Adiciona CSRF no header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.entradaForm').submit(function(e) {
                e.preventDefault();

                let form = $(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('pedido.store.ajax') }}",
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        // Mensagem dentro do modal (opcional)
                        form.find('.msg-sucesso').text(response.mensagem).removeClass('d-none');
                        form.find('.msg-erro').addClass('d-none');

                        // Fecha modal e reseta form
                        form.closest('.modal').modal('hide');
                        form[0].reset();

                        // Pega o ID do item
                        let itemId = form.find('input[name="item_id"]').val();
                        // Seleciona a div do status correta
                        let statusDiv = $('#status-item-' + itemId);

                        // Atualiza o texto do status
                        statusDiv.text(response.status);

                        // Remove todas as classes de status anteriores
                        statusDiv.removeClass('status-pendente status-concluido status-cancelado status-parcial');

                        // Adiciona a classe correspondente ao novo status
                        if (response.status === 'Pendente') {
                            statusDiv.addClass('status-pendente');
                        } else if (response.status === 'Concluido') {
                            statusDiv.addClass('status-concluido');
                        } else if (response.status === 'Cancelado') {
                            statusDiv.addClass('status-cancelado');
                        } else if (response.status === 'Parcial') {
                            statusDiv.addClass('status-parcial');
                        }

                        // ✅ Mostra mensagem fixa no topo
                        let alerta = document.getElementById('alerta-topo');
                        alerta.classList.remove('d-none'); // remove classe que esconde
                        alerta.classList.add('alert-success'); // define tipo de alerta
                        document.getElementById('alerta-msg').innerText = response.mensagem;

                        // Atualiza quantidade na tela (opcional)
                        console.log("Novo estoque:", response.novo_estoque);
                    },

                    error: function(xhr) {
                        console.log(xhr.responseJSON); // Mostra erro real do Laravel no console
                        let msg = 'Erro ao enviar dados do item';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        form.find('.msg-erro').text(msg).removeClass('d-none');
                        form.find('.msg-sucesso').addClass('d-none');
                    }
                });
            });
        });
    </script>


    {{--====================================================================--}}
    {{--Função que fecha o pedido de compra-----------------------------------}}
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <div class="row mb-1" hidden>
            <hr>
            <div class="col-md-12">
                <button id="enviar" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">
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

    <input type="text" id="pedido_compra_id" placeholder="Digite um valor" value="{{$pedido_compra->id}}" hidden readonly>

    <script>
        $(document).ready(function() {
            $('#confirmarEnvio').click(function() {
                var valor = $('#valor').val();

                $.ajax({
                    type: 'POST', // POST e não GET
                    url: '{{ route("updatepedidocompra") }}',
                    data: {
                        valor: valor,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF
                    },
                    success: function(response) {
                        $('#mensagem').text(response.mensagem);
                        $('#sucessoModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#mensagem').text('Erro ao enviar os dados: ' + error);
                        $('#erroModal').modal('show');
                    }
                });
            });
        });
    </script>

</main>
@endsection