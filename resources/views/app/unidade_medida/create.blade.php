@extends('app.layouts.app')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <p class="mb-0">Cadastro de Produtos</p>

        </div>
        <div class="card-footer justify-content-left">
            <a href="{{route('produto.index')}}" class="btn">
                LISTAGEM DE PRODUTOS
            </a>
        </div>
        <div class="card-body">
            @component('app.produto._components.form_create_edit', ['marcas'=>$marcas, 'unidades'=>$unidades, 'categorias'=>$categorias])       
            @endcomponent
        </div>
    </div>

</main>

@endsection




