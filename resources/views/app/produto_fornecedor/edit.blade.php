



@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header">
            <p>Editar Produto</p>
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
            @component('app.produto._components.form_create_edit', ['produto'=>$produto, 'marcas'=>$marcas])
                    
                @endcomponent  
        </div>
    </div>

</main>

@endsection





