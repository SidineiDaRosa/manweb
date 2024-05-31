@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')

<main class="">
    <div id="div-top"class="">
        <div class="">
            @foreach ($pedido_saida as $pedido_f)
            @endforeach

            <form id="formSearchingProducts" action="{{'item-produto-filtro'}}" method="POST">
                @csrf
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="1">Busca pelo ID</option>
                        <option value="2">Busca Pelas inicias</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por categoria</option>
                        <option value="0">Busca Pelo estoque minimo</option>
                    </select>
                </div>
                <!--input box filtro buscar produto--------->
                
                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search"></i>
                </button>
                <input type="text" name="pedido" value="{{$pedido_f->id}}" readonly>
            </form>
        </div>
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
        #div-top{
            background-color:blueviolet;
            margin-bottom:3px;
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
                        <a href="{{ route('Saida-produto.create',['produto' => $produto->id,'pedido' => $pedido_f->id]) }}" class="btn-sm btn-warning">
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