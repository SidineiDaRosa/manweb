@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header-template mb-1">
                <div>
                    CADASTRAR NA MARCA
                </div>
                <div>
                    <a class="btn btn-info btn-sm mr-2" href="{{ route('marca.create') }}">LISTAGEM</a>
                </div>
            </div>
            <div class="card-body">
                @component('app.marca._components.form_create_edit')
                @endcomponent
            </div>
        </div>
    </main>
@endsection
