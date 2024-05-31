
@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header">
            <p>Visualizar Produto</p>
        </div>
        <div class="card-footer justify-content-left">
            <a href="{{route('produto.index')}}" class="btn">
                LISTAGEM DE PRODUTOS
            </a>
            <a href="{{route('produto.create')}}" class="btn">
                NOVO PRODUTO
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
            <tr>
                <td class="text-right pr-5">ID</td>
                <td>{{$produto->id}}</td>
            </tr>
            <tr>
                <td class="text-right pr-5">Nome</td>
                <td>{{$produto->nome}}</td>
            </tr>
            <tr>
                <td class="text-right pr-5">DESCRIÇÂO</td>
                <td>{{$produto->descricao}}</td>
            </tr>
            <tr>
                <td class="text-right pr-5"> MARCA</td>
                <td>{{$produto->marca->nome}}</td>
            </tr>
            <tr>
                <td class="text-right pr-5">ESTOQUE MÍNIMO</td>
                <td>{{$produto->estoque_minimo}}</td>
            </tr>
            <tr>
                <td class="text-right pr-5">ESTOQUE MÁXIMO</td>
                <td>{{$produto->estoque_maximo}}</td>
            </tr>
        </table>
        </div>
    </div>

</main>

@endsection




