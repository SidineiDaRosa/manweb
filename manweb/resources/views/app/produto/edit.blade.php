



@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>EDITAR PRODUTO</div>
            <div>
                <a href="{{route('produto.index')}}" class="btn btn-sm btn-primary">
                    LISTAGEM
                </a>
    
                <a href="{{route('produto.create')}}" class="btn btn-sm btn-primary">
                    NOVO
                </a>
            </div>
        </div>
        
        <div class="card-body">
            @component('app.produto._components.form_create_edit', ['produto'=>$produto, 'marcas'=>$marcas, 'unidades'=>$unidades, 'categorias'=>$categorias])
                    
                @endcomponent  
        </div>
    </div>

</main>

@endsection





