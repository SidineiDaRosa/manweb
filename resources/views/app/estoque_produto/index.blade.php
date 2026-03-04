@extends('app.layouts.app')

@section('content')
<main class="content">
    <div>
        <h3 class="h3-gray">Estoque Produtos</h3>
        <div class="header-grid">

            <a href="{{ route('produto.index') }}" class="btn-inf btn-inf-md btn-inf-blue-dark">
                <i class="bi bi-grid-3x2-gap"></i> Produtos
            </a>
            <a class="btn-inf btn-inf-md btn-inf-gray" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> Dashboard
            </a>
        </div>
        <br>
        <div class="container-row">
            <form id="formSearchingProducts" action="{{ route('estoque-produtos-filtro') }}" method="POST">
                @csrf

                {{-- Empresa fixa --}}
                <input type="hidden" name="empresa_id" value="2">

                <div class="row">

                    <div class="col-md-3 mb-2">
                        <select class="form-control" name="tipofiltro" id="tipofiltro">
                            <option value="id">Busca pelo ID</option>
                            <option value="categoria">Busca pela Categoria</option>
                            <option value="descricao">Busca pela Descrição</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <select name="categoria_id" id="categoria_id" class="form-control">
                            <option value=""> --Selecione a categoria-- </option>
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">
                                {{ $categoria->nome }}
                            </option>
                            @endforeach
                        </select>
                        {{ $errors->first('categoria_id') }}
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="text"
                            id="query"
                            class="form-control"
                            name="produto"
                            placeholder="Buscar produto...">
                    </div>

                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn-inf btn-inf-md btn-inf-blue-dark">
                            <i class="icofont-search"></i> Buscar
                        </button>
                    </div>

                </div>
            </form>
        </div>
        <div class="card-body">
            {{--Table stock os products searching--}}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Estoque_Id</th>
                        <th>Produto</th>
                        <th>Unid</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Estoque Minimo</th>
                        <th>Estoque Máximo</th>
                        <th>Local</th>
                        <th>Criticidade</th>
                        <th>Empresa</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estoque_produtos as $estoque_produto)
                    <tr>
                        <td>{{ $estoque_produto->id }}</td>
                        <td>
                            <a class="txt-link" href="{{ route('produto.show', ['produto' => $estoque_produto->produto->id]) }}" target="blank">
                                ID:&nbsp{{ $estoque_produto->produto->id}},&nbsp{{ $estoque_produto->produto->nome }}
                            </a>
                        </td>
                

                        <td>{{ $estoque_produto->unidade_medida }}</td>
                        <td @if($estoque_produto->quantidade <= 0) style="background-color: red;" @elseif($estoque_produto->quantidade > 0 && $estoque_produto->quantidade < $estoque_produto->estoque_minimo) style="background-color: yellow;"
                                    @elseif($estoque_produto->quantidade == $estoque_produto->estoque_minimo) style="background-color:rgba(127, 255, 0, 0.5);"
                                    @else style="background-color: green;"
                                    @endif
                                    >{{ $estoque_produto->quantidade }}</td>
                        <td>{{ $estoque_produto->valor }}</td>
                        <td>{{ $estoque_produto->estoque_minimo }}</td>
                        <td>{{ $estoque_produto->estoque_maximo}}</td>
                        <td>{{ $estoque_produto->local}}</td>
                        <td>{{ $estoque_produto->criticidade}}</td>
                        <td>{{ $estoque_produto->empresa->nome_fantasia}}</td>
                        <td>
                            @foreach($produtos as $produto)
                            @endforeach
                            <a href="{{ route('entrada-produto.create',['produto' => $estoque_produto->produto->id,'estoque_id'=>$estoque_produto->id ]) }}"
                                class="btn-inf btn-inf-md btn-inf-blue-dark">
                                <i class="bi bi-arrow-down-circle"></i> Inserir Estoque
                            </a>
                            {{--//-----------------------------------------//--}}
                            {{--// Cria automaticamente um pedido de compra//--}}
                            {{--//-----------------------------------------//--}}

                            {{--//-----------------------------------------//--}}
                            <a class="btn-inf btn-inf-md btn-inf-warning" href="{{ route('Estoque-produto.edit', ['Estoque_produto' => $estoque_produto->id]) }}">
                                <i class="icofont-ui-edit"></i>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>


    </div>

    <!---estilização do input box buscar produtos---->
    <style>
        #formSearchingProducts {
            background-color: white;
            width: 100%;
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
    </style>
    <!-------------------------------------------------------------------------->
    <!--input box filtro buscar produto--------->


</main>
@endsection