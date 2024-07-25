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
         <!---estilização do input box buscar produtos---->
    <style>
        #formSearchingProducts {
            background-color: white;
            width: 900px;
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

        #tblProdutos {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            background-color: rgb(211, 211, 211);
        }

        thead {
            background-color: rgb(169, 169, 169);
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 3px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        tr:hover {
            background-color: rgb(169, 169, 169);
        }
    </style>
    <!-------------------------------------------------------------------------->
    <div class="card-top">
        <style>
            .card-top {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 2px;
                margin-bottom: 2px;
            }
        </style>
        <div class="card-header-template">
            <form id="formSearchingProducts" action="{{ route('pedido-saida.show', ['pedido_saida' => $pedido_saida->id]) }}" method="POST">
                @csrf
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="2">Busca Pelas inicias</option>
                        <option value="1">Busca pelo ID</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por categoria</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="categoria_id" id="" class="form-control-template">
                        <option value=""> --Selecione a Categoria--</option>
                        @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('categoria_id') ? $errors->first('categoria_id') : '' }}
                </div>
                <!--input box filtro buscar produto--------->
                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search icofont-2x"></i>
                </button>
            </form>
        </div>
    </div>
    <hr>
    </div>
</main>
@endsection