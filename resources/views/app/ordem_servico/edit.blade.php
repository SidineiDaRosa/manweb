@extends('app.layouts.app')

@section('content')
<main class="content">

    <div class="card">
        <div class="card-header-template mb-1">
            <div>
                Editar ordem de serviço
            </div>
            <a href="{{route('ordem-servico.index')}}" class="btn btn-info btn-icon-split btn-sm">
                <span class="icon text-white-50">
                    <i class="icofont-filter"></i>
                </span>
                <span class="text">Filtros OS</span>
            </a>

            <a class="btn btn-outline-dark btn-sm" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> dashboard
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
            'empresas'=>$empresas
            ])
            @endcomponent
        </div>
    </div>

</main>

@endsection