@extends('app.layouts.app')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>Visualizar Marca</div>
                <div>
                    <a href="{{ route('marca.index') }}" class="btn btn-sm btn-primary">
                        LISTAGEM
                    </a>

                    <a href="{{ route('marca.create') }}" class="btn btn-sm btn-primary">
                        NOVO
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table-template table-hover table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>{{ $marca->id }}</td>
                    </tr>
                    <tr>
                        <td>Nome</td>
                        <td>{{ $marca->nome }}</td>
                    </tr>
                    <tr>
                        <td>DESCRIÇÂO</td>
                        <td>{{ $marca->descricao }}</td>
                    </tr>
                </table>
            </div>

        </div>
        </div>

    </main>
@endsection
