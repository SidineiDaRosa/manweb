@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>Listagem de Fornecedores</div>
            <div>

                <a href="{{ route('fornecedor.create') }}" class="btn btn-sm btn-primary">
                    <i class="icofont-database-add icofont-2x"></i>
                    Novo fornecedor
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table-template table-hover table-striped table-bordered">
                <thead class="bg-active">
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Nome</th>
                        <th scope="col" class="th-title">CNPJ</th>
                        <th scope="col" class="th-title">Endereço</th>
                        <th scope="col" class="th-title">Cidade</th>
                        <th scope="col" class="th-title">Estado</th>
                        <th scope="col" class="th-title">Telefone</th>
                        <th scope="col" class="th-title">site</th>
                        <th scope="col" class="th-title">Operações</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($fornecedores as $fornecedor)
                    <tr>
                        <th scope="row">{{ $fornecedor->id }}</td>
                        <td>{{ $fornecedor->nome_fantasia }}</td>
                        <td>{{ $fornecedor->cnpj }}</td>
                        <td>{{ $fornecedor->endereco }}</td>
                        <td>{{ $fornecedor->cidade }}</td>
                        <td>{{ $fornecedor->estado }}</td>
                        <td>{{ $fornecedor->telefone }}</td>
                        <td>{{ $fornecedor->site }}</td>
                        <td>
                            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('fornecedor.show', ['fornecedor' => $fornecedor->id]) }}">
                                    <i class="icofont-eye-alt"></i></a>
                                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('fornecedor.edit', ['fornecedor' => $fornecedor->id]) }}">

                                    <i class="icofont-ui-edit"></i> </a>
                                <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarFornecedor()">
                                    <i class="icofont-ui-delete"></i></a>
                            </div>
                            <script>
                                function DeletarFornecedor() {
                                    var x;
                                    var r = confirm("Deseja deletar o fornecedor?");
                                    if (r == true) {

                                        document.getElementById('form_{{ $fornecedor->id }}').submit()
                                    } else {
                                        x = "Você pressionou Cancelar!";
                                    }
                                    document.getElementById("demo").innerHTML = x;
                                }
                            </script>

                            <form id="form_{{ $fornecedor->id }}" method="post" action="{{ route('fornecedor.destroy', ['fornecedor' => $fornecedor->id]) }}" hidden>
                                @method('DELETE')
                                @csrf
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>


</main>

@endsection