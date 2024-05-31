@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>
                    CADASTRAR NA MARCA
                </div>
                <div>
                    <a class="btn btn-sm btn-primary" href="{{ route('marca.index') }}">LISTAGEM</a>
                </div>
            </div>
            <div class="card-body">
                @component('app.marca._components.form_create_edit')
                @endcomponent
            </div>
        </div>
    </main>
@endsection
