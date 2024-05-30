@extends('app.layouts.app')

@section('content')

<main class="content">
    <div class="card">
        <div class="titulo-main">
        Cadastro de peça do equipamento
        </div>
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
            @component('app.peca_equipamento._components.form_create_edit', ['produtos'=>$produtos, 'equipamento'=>$equipamento,'categorias' => $categorias])
            @endcomponent
        </div>
    </div>

</main>
@endsection