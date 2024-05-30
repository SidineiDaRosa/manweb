@extends('app.layouts.app')

@section('titulo', 'Serviços executados')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Cadastrar serviço executado
            </div>
            <div>
            <a class="btn btn-outline-dark" href="{{ route('app.home') }}">
                        <i class="icofont-dashboard"></i> dashboard
                    </a>
            </div>
        </div>
        <div class="card-body">
            @component('app.servicos_executado._components.form_create_edit', ['ordem_servico'=>$ordem_servico,
            'funcionarios'=>$funcionarios,
            'ordem_servico_id'=>$ordem_servico_id,])
            @endcomponent
        </div>
    </div>
</main>
@endsection