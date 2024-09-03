@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div> Lista do estoque de produtos
                <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
            </div>

            <form id="formSearchingProducts" action="{{'Estoque-Produtos-filtro'}}" method="POST" style="margin-right:10%;">
                @csrf
                <!--------------------------------------------------------------------------------------->
                <!---------Select empresa------------->
                <!--------------------------------------------------------------------------------------->

                <div class="col-md-4 mb-0">
                    <select name="empresa_id" id="empresa_id" class="form-control">
                        <option value=""> --Selecione a empresa--</option>
                        @foreach ($empresas as $empresas_find)
                        <option value="{{$empresas_find->id}}"
                            {{ $empresas_find->id == 2 ? 'selected' : '' }}>
                            {{$empresas_find->razao_social}}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('empresa_id') ? $errors->first('empresa_id') : '' }}
                </div>
                <div class="col-md-3 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="2">Pela empresa</option>
                        <option value="1">Busca pelo Id</option>
                    </select>
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

                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search icofont-2x"></i>
                </button>

            </form>
            <div>
                <a href="{{ route('produto.index') }}" class="btn btn-sm btn-primary">
                    Lista de produtos
                </a>
            </div>
        </div>
        <div class="card-body">
            {{--Table stock os products searching--}}
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Estoque_Id</th>
                        <th scope="col" class="th-title">Produto</th>
                        <th scope="col" class="th-title">Unid</th>
                        <th scope="col" class="th-title">Quantidade</th>
                        <th scope="col" class="th-title">Valor</th>
                        <th scope="col" class="th-title">Estoque Minimo</th>
                        <th scope="col" class="th-title">Estoque Máximo</th>
                        <th scope="col" class="th-title">Local</th>
                        <th scope="col" class="th-title">Criticidade</th>
                        <th scope="col" class="th-title">Empresa</th>
                        <th scope="col" class="th-title">Operações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estoque_produtos as $estoque_produto)
                    <tr>
                        <td>{{ $estoque_produto->id }}</td>
                        <td>
                            <a href="{{ route('produto.show', ['produto' => $estoque_produto->produto->id]) }}" target="blank">{{ $estoque_produto->produto->id}} {{ $estoque_produto->produto->nome }}<span class="material-symbols-outlined">
                                    open_in_new
                                </span></a>
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
                            <a href="{{ route('entrada-produto.create',['produto' => $estoque_produto->produto->id,'estoque_id'=>$estoque_produto->id ]) }}" class="btn-sm btn-success">
                                <i class="icofont-database-add">Inserir Estoque</i>
                            </a>
                            {{--//-----------------------------------------//--}}
                            {{--// Cria automaticamente um pedido de compra//--}}
                            {{--//-----------------------------------------//--}}

                            {{--//-----------------------------------------//--}}
                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('Estoque-produto.edit', ['Estoque_produto' => $estoque_produto->id]) }}" title="editar dados do estoque">
                                <i class="icofont-ui-edit"></i>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>


    </div>


</main>
@endsection