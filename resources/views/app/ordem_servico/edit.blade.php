@extends('app.layouts.app')

@section('content')
<main class="content">

    <div>
        <div>
            <div>
                Editar Ordem de Serviço
            </div>
            <a href="{{route('ordem-servico.index')}}" class="btn-inf btn-inf-blue-dark">
                <span class="icon text-white-50">
                    <i class="icofont-filter"></i>
                </span>
                <span class="text">Filtros O.S.</span>
            </a>

            <a class="btn-inf btn-inf-brown" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> Dashboard
            </a>
        </div>
        <style>
            .card-body-main {
                margin: 1px;
                width: 90%;
            }
        </style>
        <div class="card-body-main">
            @component('app.ordem_servico.componentes.form_edit',
            [
            'ordem_servico'=>$ordem_servico,
            'equipamentos'=>$equipamentos,
            'funcionarios'=>$funcionarios,
            'empresas'=>$empresas,
            'projetos'=>$projetos
            ])
            @endcomponent
        </div>
    </div>

</main>

@endsection