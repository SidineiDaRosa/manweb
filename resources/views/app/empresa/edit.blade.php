@extends('app.layouts.app')

@section('titulo', 'Fornecedor')

@section('content')

    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>Editar unidade da empresa</div>
                <div>
                    <a href="{{ route('fornecedor.create') }}" class="btn btn-primary btn-sm">
                        NOVO
                    </a>
                    <a href="{{ route('fornecedor.index') }}" class="btn btn-primary btn-sm">
                        LISTAGEM
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                @component('app.fornecedor._components.form_create_edit', ['fornecedor' => $fornecedor,'empresa'=>$empresa])
                @endcomponent
            </div>

        </div>


    </main>

@endsection
