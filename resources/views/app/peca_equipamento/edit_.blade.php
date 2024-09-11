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

        .card-body-main {
            margin: 1px;
            width: 100%;
        }
    </style>
    <div class="card-body-main">
        @component('app.peca_equipamento.edit', ['produtos'=>$produtos, 'equipamento'=>$equipamento,'categorias' => $categorias,'pecas_equipamentos'=>$pecas_equipamentos,'produto_nome'=>$produto_nome])
        @endcomponent
    </div>

</main>
@endsection