@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>Listagem de Produtos</div>

                <div>
                    <a href="{{ route('produto.create') }}" class="btn btn-primary btn-sm">
                        NOVO
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Estoque Mínimo</th>
                            <th scope="col">Estoque Máximo</th>
                            <th scope="col">Visualizar</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <th scope="row">{{ $produto->id }}</td>
                                <td>{{ $produto->nome }}</td>
                                <td>{{ $produto->descricao }}</td>
                                <td>{{ $produto->estoque_minimo }}</td>
                                <td>{{ $produto->estoque_maximo }}</td>
                                <td><a href="{{ route('produto.show', ['produto' => $produto->id]) }}">Visualizar</a></td>
                                <td>
                                    <form id="form_{{ $produto->id }}" method="post"
                                        action="{{ route('produto.destroy', ['produto' => $produto->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <a href="#"
                                            onclick="document.getElementById('form_{{ $produto->id }}').submit()">Excluir</a>
                                    </form>
                                </td>
                                <td><a href="{{ route('produto.edit', ['produto' => $produto->id]) }}">Editar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>


        </div>


    </main>
@endsection
