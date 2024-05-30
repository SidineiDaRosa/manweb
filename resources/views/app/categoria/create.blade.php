@extends('app.layouts.app')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <p class="mb-0">Cadastro de categorias</p>

        </div>
        <div class="card-footer justify-content-left">
            <a href="{{route('categoria.index')}}" class="btn">
                Listagem de Categorias
            </a>
        </div>
        <div class="card-body">
            @component('app.categoria._components.form_create_edit')
            @endcomponent
        </div>
    </div>

</main>

@endsection