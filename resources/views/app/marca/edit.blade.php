@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')

    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>Editar Marca</div>
                <div>
                    <a href="{{ route('marca.create') }}" class="btn btn-sm btn-primary">
                        NOVO
                    </a>
                    <a href="{{ route('marca.index') }}" class="btn btn-sm btn-primary">
                        LISTAGEM
                    </a>
                </div>
            </div>

            <div class="card-body">
                @component('app.marca._components.form_create_edit', ['marca' => $marca])
                @endcomponent

            </div>

        </div>


    </main>

@endsection
