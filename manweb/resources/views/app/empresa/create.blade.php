@extends('app.layouts.app')

@section('titulo', 'Fornecedor')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>Cadastrar nova empresa unidade</div>
            <div>
                <a href="{{route('fornecedor.index')}}" class="btn btn-primary btn-sm">
                    LISTAGEM
                </a>
            </div>
        </div>
        
        <div class="card-body">
        @component('app.empresa._components.form_create', ['empresa'=>$empresa])     
            @endcomponent
        </div>

    </div>


</main>

@endsection

