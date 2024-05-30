@extends('app.layouts.app')
@section('titulo', 'Produtos')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-1">
            <p>Listagem de Produtos</p>
        </div>
        <div class="card-header justify-content-left py-1">
            <a href="" class="btn">
                Listagem categoria
            </a>
            <div>
                <a href="{{ route('categoria.create') }}" class="btn btn-sm btn-primary">
                    <i class="icofont-database-add icofont-2x"></i>
                    Novo categoria
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Visualizar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categorias as $categoria)
                    <tr>
                        <th scope="row">{{ $categoria->id }}</td>
                        <td>{{ $categoria->nome }}</td>
                        <td>{{ $categoria->descricao }}</td>
                        <td>
                       
                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="">
                                <i class="icofont-ui-edit"></i> </a>
                                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="">
                                <i class="icofont-ui-edit"></i> </a>
                        </td>

                        @endforeach
                </tbody>
            </table>


        </div>


    </div>


</main>
@endsection