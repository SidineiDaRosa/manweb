@extends('app.layouts.app')

@section('titulo', 'Marca')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header">
            <p>Visualizar Marca</p>
        </div>
        <div class="card-header justify-content-left">
            <a href="{{route('produto.index')}}" class="btn">
                LISTAGEM DE MARCAS
            </a>

            <a href="{{route('produto.create')}}" class="btn">
                NOVA MARCA
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <tr>
                    <td>ID</td>
                    <td>{{$marca->id}}</td>
                </tr>
                <tr>
                    <td>Nome</td>
                    <td>{{$marca->nome}}</td>
                </tr>
                <tr>
                    <td>DESCRIÇÂO</td>
                    <td>{{$marca->descricao}}</td>
                </tr>
            </table>
        </div>

        </div>
    </div>

</main>

@endsection





