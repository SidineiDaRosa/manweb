@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div> Lista do estoque de produtos</div>

            <form id="formSearchingProducts" action="{{'Estoque-Produtos-filtro'}}" method="POST">
                @csrf
                <!--------------------------------------------------------------------------------------->
                <!---------Select empresa------------->
                <!--------------------------------------------------------------------------------------->

                <div class="col-md-4 mb-0">
                    <select name="empresa_id" id="empresa_id" class="form-control">
                        <option value=""> --Selecione a empresa--</option>
                        @foreach ($empresas as $empresas_find)
                        <option value="{{$empresas_find->id}}" {{($empresas_find->empresa_id ?? old('empresa_id')) == $empresas_find->id ? 'selected' : '' }}>
                            {{$empresas_find->razao_social}}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('empresa_id') ? $errors->first('empresa_id') : '' }}
                </div>
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="1">Busca pelo Id</option>
                        <option value="2">Pela empresa</option>
                       
                       
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
                    <i class="icofont-search"></i>
                </button>

            </form>
            <div>
                <a href="{{ route('produto.index') }}" class="btn btn-sm btn-primary">
                    Lista de produtos
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Produto id</th>
                        <th scope="col" class="th-title">Produto</th>
                        <th scope="col" class="th-title">Unid</th>
                        <th scope="col" class="th-title">Quantidade</th>
                        <th scope="col" class="th-title">Valor</th>
                        <th scope="col" class="th-title">estoque minimo</th>
                        <th scope="col" class="th-title">estoque máximo</th>
                        <th scope="col" class="th-title">Local</th>
                        <th scope="col" class="th-title">empresa</th>
                        <th scope="col" class="th-title">operaçoes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estoque_produtos as $estoque_produto)
                    <tr>
                        <th scope="row">{{ $estoque_produto->id }}</td>
                        <td>{{ $estoque_produto->produto->id}}</td>
                        <td>{{ $estoque_produto->produto->nome }}</td>
                        <td>{{ $estoque_produto->unidade_medida }}</td>
                        <td>{{ $estoque_produto->quantidade }}</td>
                        <td>{{ $estoque_produto->valor }}</td>
                        <td>{{ $estoque_produto->estoque_minimo }}</td>
                        <td>{{ $estoque_produto->estoque_maximo}}</td>
                        <td>{{ $estoque_produto->local}}</td>
                        <td>{{ $estoque_produto->empresa->nome_fantasia}}</td>

                        <td>
                            @foreach($produtos as $produto)
                            @endforeach
                            <a href="{{ route('entrada-produto.create',['produto' => $estoque_produto->produto->id,'estoque_id'=>$estoque_produto->id ]) }}" class="btn-sm btn-success">

                                <i class="icofont-database-add"></i>
                                </span>
                                <span class="text">Inserir estoque</span>
                            </a>
                           
                        <td>

                        </td>
                        </td>
                    </tr>



                    @endforeach

                </tbody>
            </table>


        </div>


    </div>


</main>
@endsection