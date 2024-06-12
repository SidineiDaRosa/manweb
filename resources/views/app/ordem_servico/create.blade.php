@extends('app.layouts.app')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<main class="content">
    <div class="card">
        <div class="card-header-template mb-1">
            Criar ordem de serviço
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
            @component('app.ordem_servico.componentes.form_create', ['ordem_servico'=>$ordem_servico,
            'equipamentos'=>$equipamentos,'funcionarios'=>$funcionarios,
            'empresa'=>$empresa,
            'equipamento'=>$equipamento])
            @endcomponent
        </div>
    </div>
</main>

@endsection