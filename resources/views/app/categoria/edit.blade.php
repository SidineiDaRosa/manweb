@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header">
            <p>Listagem de Categorias</p>
        </div>
        <div class="card-footer justify-content-left">
            <a href="{{route('produto.index')}}" class="btn">
                LISTAGEM DE PRODUTOS
            </a>

            <a href="{{route('categoria.create')}}" class="btn">
                NOVO 
            </a>
        </div>
        <div class="card-body">
            @component('app.categoria._components.form_create_edit', ['categoria' => $categoria])
            @endcomponent
        </div>
    </div>

</main>

@endsection