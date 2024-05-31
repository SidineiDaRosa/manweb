@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>LISTAGEM DE PRODUTOS</div>

            <form id="formSearchingProducts" action="{{'Produtos-filtro'}}" method="POST">
                @csrf

                <!--input box filtro buscar produto--------->

                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search"></i>
                </button>
            </form>

            <div>
                <a href="{{ route('item-produto.index') }}" class="btn btn-sm btn-primary">
                    Status estoque de produtos
                </a>

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
            width: 500px;
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
    <div class="card-body">
        <table class="table table-dark table-sm table-hover table-responsive-md-1 mb-0">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">cod_fabricante</th>
                    <th scope="col">Nome</th>
                    <th scope="col">un medida</th>
                    <th scope="col">Dados técnicos</th>
                    <th scope="col">Estoque Mínimo</th>
                    <th scope="col">Estoque atual</th>
                    <th scope="col">Estoque Máximo</th>
                    <th scope="col">Fabricante</th>
                    <th scope="col">Ver peça</th>
                    <th scope="col">local estoque</th>
                    <th scope="col">Entrada estoque</th>
                    <th scope="col">Saida estoque</th>
                    <th scope="col">Operações</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($produtos as $produto)
                <tr>
                    <th scope="row">{{ $produto->id }}</td>
                    <td>{{ $produto->cod_fabricante }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->unidade_medida_id}}</td>
                    <td>{{ $produto->descricao }}</td>
                    <td>{{ $produto->estoque_minimo }}</td>
                    <td>{{ $produto->estoque_ideal }}</td>
                    <td>{{ $produto->estoque_maximo }}</td>
                    <td>{{ $produto->marca->nome}}</td>
                    <td><a href="{{ $produto->link_peca}}" target="blank">Ver peça</a></td>
                    <td>{{ $produto->local_estoque}}</td>

                    <td>
                        <a href="{{ route('entrada-produto.create',['produto' => $produto->id]) }}" class="btn-sm btn-success">

                            <i class="icofont-database-add"></i>
                            </span>
                            <span class="text">Inserir estoque</span>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('Saida-produto.create',['produto' => $produto->id]) }}" class="btn-sm btn-warning">
                            <i class="icofont-cart-alt"></i>
                            </span>
                            <span class="text">saida estoque</span>
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