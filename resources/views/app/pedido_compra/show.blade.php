@extends('app.layouts.app')
@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Ordem de serviço
            </div>
            <div>
                <a class="btn btn-primary btn-lg mr-2" href="{{ route('ordem-servico.index') }}">Voltar</a>
                <a class="btn btn-primary btn-lg" href="{{ route('ordem-servico.index') }}">listar</a>
                <p>
                    <a class="btn btn-info btn-icon-split btn-warning" href="{{ route('app.home') }}">
                        <i class="icofont-dashboard"></i> dashboard
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table-template table-hover" border="1">
                <tr>
                    <td>ID</td>
                    <td>{{$ordem_servico->id}}</td>

                </tr>
                <tr>
                    <td>data emissao</td>
                    <td>{{$ordem_servico->data_emissao}}</td>

                    <td>hora emissao</td>
                    <td>{{$ordem_servico->hora_emissao}}</td>
                </tr>
                <tr>
                    <td>data inicio</td>
                    <td>{{$ordem_servico->data_inicio}}</td>

                    <td>hora inicio</td>
                    <td>{{$ordem_servico->hora_inicio}}</td>
                </tr>
                <td>patrimonio</td>
                <td>{{$ordem_servico->equipamento->nome}}</td>
                </tr>
                </tr>
                <td>Empresa</td>
                <td>{{$ordem_servico->Empresa->razao_social}}</td>
                </tr>
                <td>emissor</td>
                <td>{{$ordem_servico->emissor}}</td>
                </tr>
                <td>responsavel</td>
                <td>{{$ordem_servico->responsavel}}</td>
                </tr>
                <td>descrição</td>
                <td>{{$ordem_servico->descricao}}</td>
                </tr>
                <td>Executado</td>
                <td>{{$ordem_servico->Executado}}</td>
                </tr>

                <span>Descrição dos serviços a serem executados</span>
                <table class="table-template table-hover" border="1">
                    <tr>

                        <td>
                            {{$ordem_servico->descricao}}
                        </td>
                    </tr>
                </table>
                <span>Descrição dos serviços executados</span>
                <table class="table-template table-hover" border="1">
                        <td>
                            {{$ordem_servico->Executado}}
                        </td>
                   
                </table>

                <table class="table-template table-hover" border="1">
                    <tr>
                        <td>situação</td>
                        <td>{{$ordem_servico->situacao}}</td>
                        <td>R$:</td>
                        <td>{{$ordem_servico->valor}}</td>
                    </tr>
                    </tr>

                </table>@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div> Pedidos de compra lista</div>
            <div>
                <a href="" class="btn btn-sm btn-primary">
                    Lista
                </a>

            </div>

        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Data emissão</th>
                        <th scope="col" class="th-title">hora emissão</th>
                        <th scope="col" class="th-title">Data prevista</th>
                        <th scope="col" class="th-title">hora prevista</th>
                        <th scope="col" class="th-title">Equipamento</th>
                        <th scope="col" class="th-title">status</th>
                        <th scope="col" class="th-title">Emissor</th>
                        <th scope="col" class="th-title">operaçoes</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos_compra as $pedido_compra)
                    <tr>
                        <th scope="row">{{ $pedido_compra->id }}</td>
                        <td>{{ $pedido_compra->data_emissao }}</td>
                        <td>{{ $pedido_compra->hora_emissao }}</td>
                        <td>{{ $pedido_compra->data_prevista}}</td>
                        <td>{{ $pedido_compra->hora_prevista}}</td>
                        <td>{{ $pedido_compra->equipamento->nome}}</td>
                        <td>{{ $pedido_compra->funcionarios->primeiro_nome}}</td>
                        <td>{{ $pedido_compra->status}}</td>
                        <td>

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
    {{---------------------------------------------------------------}}
    {{--cadastro de pedido de compra lista de material----------------}}
    <form id="pedidoCompraForm" action="{{ route('pedido-compra-lista.store') }}" method="POST">
        @csrf
        @method('POST')

        <div class="row mb-1">
            <label for="pedidos_compra_id" class="col-md-4 col-form-label text-md-end text-right">Num pedido compra</label>
            <div class="col-md-6">
                <input name="pedidos_compra_id" id="pedidos_compra_id" type="text" class="form-control" value="{{ $pedido_compra->id }}" readonly>
                <span id="pedidos_compra_id_error" class="text-danger"></span>
            </div>
        </div>
        <div class="row mb-1">
            <label for="produto_id" class="col-md-4 col-form-label text-md-end text-right">Produto ID</label>
            <div class="col-md-6">
                <input name="produto_id" id="produto_id" type="text" class="form-control" value="{{ $produto_id }}" readonly>
                <span id="produto_id_error" class="text-danger"></span>
            </div>

            <button type="button" id="executarFormulario" class="btn btn-primary"> <span class="material-symbols-outlined">
                    search
                </span></button>
        </div>

        <div class="row mb-1">
            <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">Quantidade</label>
            <div class="col-md-6">
                <input name="quantidade" id="quantidade" type="text" class="form-control" value="{{ old('quantidade') }}">
                <span id="quantidade_error" class="text-danger"></span>
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" id="submitForm" class="btn btn-primary">
                    {{ isset($saida_produto) ? 'Atualizar' : 'Cadastrar' }}
                </button>
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


    @if(isset($produtos) && count($produtos) > 0)
    @foreach($produtos as $produto)
    @endforeach
    @endif
    @if(isset($pedido_compra_lista) && count($pedido_compra_lista) > 0)
    <table class="table-template table-striped table-hover table-bordered" id="table_lista_compra">
        <thead>
            <tr>
                <th scope="col" class="th-title">Id</th>
                <th scope="col" class="th-title">Pedido ID</th>
                <th scope="col" class="th-title">Produto ID</th>
                <th scope="col" class="th-title">nome</th>
                <th scope="col" class="th-title">Quantidade</th>
                <th scope="col" class="th-title">Imagem</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedido_compra_lista as $pedido_compra_ls)
            @php
            $produto = App\Models\Produto::find($pedido_compra_ls->produto_id);
            @endphp
            <tr>
                <td>{{ $pedido_compra_ls->id }}</td>
                <td>{{ $pedido_compra_ls->pedidos_compra_id}}</td>
                <td>{{ $pedido_compra_ls->produto_id}}</td>
                <td>{{ $produto->nome }}</td>
                <td>{{ $pedido_compra_ls->quantidade }}</td>
                <td>
                    <img src="/img/produtos/{{ $produto->image }}" alt="Imagem do Produto" class="preview-image">
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
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Não há itens na lista de compra.</p>
    @endif


    </div>
</main>
@endsection

        </div>

    </div>
    </div>

</main>
@endsection