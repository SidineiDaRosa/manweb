@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>LISTAGEM DE PRODUTOS</div>

            <form id="formSearchingProducts" action="{{'Produtos-filtro'}}" method="POST">
                @csrf
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="1">Busca pelo ID</option>
                        <option value="2">Busca Pelas inicias</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por categoria</option>
                        <option value="5">Busca Pelo estoque minimo</option>
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
                    <i class="icofont-search"></i>
                </button>
            </form>

            <div>

                <a href="{{ route('produto.create') }}" class="btn btn-sm btn-primary">
                    <i class="icofont-database-add icofont-2x"></i>
                    Novo produto
                </a>
            </div>
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
    <div class="card-body">
        <table class="" id="tblProdutos">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Qrcode</th>
                    <th scope="col">cod_fabricante</th>
                    <th scope="col">Nome</th>
                    <th scope="col">un medida</th>
                    <th scope="col">Dados técnicos</th>
                    <th scope="col">Fabricante</th>
                    <th scope="col">Ver peça</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Cad Estoque</th>
                    <th scope="col">Operações</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($produtos as $produto)
                <tr>
                    <th scope="row">{{ $produto->id }}</td>
                    <td> {!! QrCode::size(100)->backgroundColor(255,90,0)->generate( $produto->id.'--'.$produto->nome) !!}</td>
                    <td>{{ $produto->cod_fabricante }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->unidade_medida->nome}}</td>
                    <td>{{ $produto->descricao }}</td>
                    <td>{{ $produto->marca->nome}}</td>
                    <td><a href="{{ $produto->link_peca}}" target="blank">Ver no site do fabricante
                    <i class="icofont-arrow-right"></i>
                    </a></td>
                    <td>
                        <img src="/img/produtos/{{ $produto->image}}" alt="imagem" class="preview-image">
                    </td>
                    <style>
                        .preview-image {
                            width: 100px;
                            height: 100px;
                            object-fit: cover;
                            margin: 0 5px;
                            cursor: pointer;
                        }
                    </style>

                    <td>
                        <a href="{{ route('Estoque-produto.create',['produto' => $produto->id]) }}" class="btn-sm btn-success">
                            <i class="icofont-database-add"></i>
                            </span>
                            <span class="text">Criar estoque</span>
                        </a>
                    </td>
                    <td>
                        <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                            <a class="btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' => $produto->id]) }}">
                                <i class="icofont-eye-alt"></i>
                            </a>

                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('produto.edit', ['produto' => $produto->id]) }}">

                                <i class="icofont-ui-edit"></i> </a>

                            <form id="form_{{ $produto->id }}" method="post" action="{{ route('produto.destroy', ['produto' => $produto->id]) }}">
                                @method('DELETE')
                                @csrf

                            </form>
                            <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarProduto()">
                                <i class="icofont-ui-delete"></i>
                                <script>
                                    function DeletarProduto() {
                                        var x;
                                        var r = confirm("Deseja deletar o produto?");
                                        if (r == true) {

                                            document.getElementById('form_{{ $produto->id }}').submit()
                                        } else {
                                            x = "Você pressionou Cancelar!";
                                        }
                                        document.getElementById("demo").innerHTML = x;
                                    }
                                </script>
                            </a>
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