@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>Visualizar Produto</div>
                <div>
                    <a href="{{ route('produto.index') }}" class="btn btn-sm btn-primary">
                        Lista de produtos
                    </a>
                    <a href="{{ route('produto.create') }}" class="btn btn-sm btn-primary">
                        NOVO
                    </a>

                </div>
            </div>
            <div class="card-body">
                <table class="table-template table-hover">
                    <tr>
                        <td class="text-right pr-2">ID</td>
                        <td>{{ $produto->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">Nome</td>
                        <td>{{ $produto->nome }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">DESCRIÇÂO</td>
                        <td>href="{{ $produto->descricao }}"</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2"> MARCA</td>
                        <td>{{ $produto->marca->nome }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">ESTOQUE MÍNIMO</td>
                        <td>{{ $produto->estoque_minimo }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">ESTOQUE ATUAL</td>
                        <td>{{ $produto->estoque_ideal }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">ESTOQUE MÁXIMO</td>
                        <td>{{ $produto->estoque_maximo }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">Local no estoque</td>
                        <td>{{ $produto->local_estoque}}</td>
                    </tr>
                </table>
            </div>
        </div>

    </main>

@endsection
