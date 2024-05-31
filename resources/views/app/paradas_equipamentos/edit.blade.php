@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header">
            <p>Editar Marca</p>
        </div>
        <div class="card-header justify-content-left">
            <a href="{{route('produto.create')}}" class="btn">
                NOVA MARCA
            </a>
            <a href="{{route('produto.index')}}" class="btn">
                LISTAGEM
            </a>
        </div>
        <div class="card-body">
            @component('app.marca._components.form_create_edit', ['marca'=>$marca])
                    
            @endcomponent  

        </div>

    </div>


</main>

@endsection
