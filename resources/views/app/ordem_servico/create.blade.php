@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<main class="content">
    <div class="titulo-main">
        Criar ordem de serviço
        <a class="btn btn-primary btn-sm" href="{{route('ordem-servico.index')}}">Voltar</a>
        <a class="btn btn-outline-dark" href="{{ route('app.home') }}">
            <i class="icofont-dashboard"></i> dashboard
        </a>
    </div>

    <style>
        .titulo-main {
            font-size: 20px;
            color: gray;
            text-align: center;
            margin-top: -2;
        }
    </style>
    <div class="card-body">
        @component('app.ordem_servico.componentes.form_create', ['ordem_servico'=>$ordem_servico,
        'equipamentos'=>$equipamentos,'funcionarios'=>$funcionarios,
        'empresa'=>$empresa,
        'equipamento'=>$equipamento])
        @endcomponent
    </div>
</main>

@endsection