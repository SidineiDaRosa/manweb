@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                LISTAGEM DE MARCAS
            </div>
            <div>
                <a href="{{ route('marca.create') }}" class="btn btn-sm btn-primary">
                    <i class="icofont-database-add icofont-2x"></i>
                    Novo marca
                </a>
            </div>

        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Operações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($marcas as $marca)
                    <tr>
                        <th scope="row">{{ $marca->id }}</td>
                        <td>{{ $marca->nome }}</td>
                        <td>{{ $marca->descricao }}</td>
                        <td>
                            <a class="btn btn-sm-template btn-outline-primary" href="{{ route('marca.show', ['marca' => $marca->id]) }}">
                                <i class="icofont-eye-alt"></i></a>
                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('marca.edit', ['marca' => $marca->id]) }}">

                                <i class="icofont-ui-edit"></i> </a>
                            <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarMarca()">
                                <i class="icofont-ui-delete"></i></a>
                        </td>
                        <script>
                            function DeletarMarca() {
                                var x;
                                var r = confirm("Deseja deletar o registro marca?");
                                if (r == true) {

                                    document.getElementById('form_{{ $marca->id }}').submit()
                                } else {
                                    x = "Você pressionou Cancelar!";
                                }
                                document.getElementById("demo").innerHTML = x;
                            }
                        </script>
                       
                            <form id="form_{{ $marca->id }}" method="post" action="{{ route('marca.destroy', ['marca' => $marca->id]) }}" hidden>
                                @method('DELETE')
                                @csrf

                            </form>
                        

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>


</main>

@endsection