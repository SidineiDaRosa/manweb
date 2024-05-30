@extends('app.layouts.app')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>CADASTRO DE PRODUTOS</div>
                <div>
                    <a href="{{ route('produto.index') }}" class="btn btn-sm btn-primary">
                        LISTAGEM
                    </a>
                </div>
            </div>

            <div class="card-body">
                @component('app.produto._components.form_create_edit', ['marcas' => $marcas, 'unidades' => $unidades,
                    'categorias' => $categorias                 
                    ])
                @endcomponent
            </div>
        </div>

    </main>
@endsection
