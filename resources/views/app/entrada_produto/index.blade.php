@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div> Lista entrada de produtos</div>

            <form id="formSearchingProducts" action="{{'Ent-Produtos-filtro'}}" method="POST">
                @csrf
                <!--------------------------------------------------------------------------------------->
                <!---------Select empresa------------->
                <!--------------------------------------------------------------------------------------->

                <div class="col-md-4 mb-0">
                    <select name="empresa_id" id="empresa_id" class="form-control">
                        <option value=""> --Selecione a empresa--</option>
                        @foreach ($empresa as $empresas_find)
                        <option value="{{$empresas_find->id}}" {{($empresas_find->empresa_id ?? old('empresa_id')) == $empresas_find->id ? 'selected' : '' }}>
                            {{$empresas_find->razao_social}}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('empresa_id') ? $errors->first('empresa_id') : '' }}
                </div>
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="1">Busca pelo ID</option>
                        <option value="2">Busca Pelas inicias</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por categoria</option>
                        <option value="5">Busca Pela empresa</option>
                    </select>
                </div>
                <!---estilização do input box buscar produtos---->
                <style>
                    #formSearchingProducts {
                        background-color: white;
                        width: 800px;
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
                    <i class="icofont-search"></i>
                </button>

            </form>
            <div>
                <a href="{{ route('produto.index') }}" class="btn btn-sm btn-primary">
                    Lista de produtos
                </a>
                <a href="{{route('Estoque-produto.index')}}" class="btn btn-sm btn-primary">
                    Estoque produtos
                </a>

            </div>

        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Produto Id</th>
                        <th scope="col" class="th-title">Produto</th>
                        <th scope="col" class="th-title">Quantidade</th>
                        <th scope="col" class="th-title">Valor</th>
                        <th scope="col" class="th-title">Data</th>
                        <th scope="col" class="th-title">Fornecedor</th>
                        <th scope="col" class="th-title">Empresa</th>
                        <th scope="col" class="th-title">Operações</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas_produtos as $entrada_produto)
                    <tr>
                        <th scope="row">{{ $entrada_produto->id }}</td>
                        <td>{{ $entrada_produto->produto->id }}</td>
                        <td>{{ $entrada_produto->produto->nome }}</td>
                        <td>{{ $entrada_produto->quantidade }}</td>
                        <td>{{ $entrada_produto->valor }}</td>
                        <td>{{ $entrada_produto->data}}</td>
                        <td>{{ $entrada_produto->Fornecedor->nome_fantasia}}</td>
                        @foreach ($empresa as $empresas_find)

                        @endforeach
                        <td>{{$entrada_produto->empresa->razao_social}}</td>
                        <td>
                            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('entrada-produto.show', ['entrada_produto' => $entrada_produto->id]) }}">
                                    <i class="icofont-eye-alt"></i>
                                </a>
                                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('entrada-produto.edit', ['entrada_produto' => $entrada_produto->id]) }}">

                                    <i class="icofont-ui-edit"></i> </a>
                                <form id="form_{{$entrada_produto->id }}" method="post" action="{{ route('entrada-produto.destroy', ['entrada_produto' => $entrada_produto->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="document.getElementById('form_{{ $entrada_produto->id }}').submit()">
                                        <i class="icofont-ui-delete"></i>
                                    </a>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>


</main>
@endsection