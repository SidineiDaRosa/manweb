
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
            <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
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
                <td>{{$produto->quantidade}}</td>
            </tr>
          
        </table>
        </div>
    </div>

</main>

@endsection




