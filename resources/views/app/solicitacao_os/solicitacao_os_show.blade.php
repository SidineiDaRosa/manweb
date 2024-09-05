@extends('app.layouts.app')
@section('content')

<main class="content">
    <div class="titulo-main">
        Solicitações de O.S
    </div>
    <form action="{{ route('solicitacoes-os') }}" method="get">
        <input type="datetime-local" class="form-control-template" name="datetime" id="datetime" style="width:250px;height:30px;font-size:20px;"> <br>
        <button type="submit" class="btn btn-outline-primary mb-1">
            Buscar
        </button>
    </form>
    <style>
        .titulo-main {
            font-size: 20px;
            color: gray;
            text-align: center;
            margin-top: -2;
        }
    </style>
    @foreach($solicitacoes as $solicitacao)
    <div style="padding:20px; align-items: center;">
        {{$solicitacao->id}} <br>
        {{$solicitacao->datatime}} <br>
        @foreach($funcionarios as $funcionario)
        @if ($funcionario->id == $solicitacao->emissor)
        {{ $funcionario->primeiro_nome }}
        @endif
        @endforeach
        {{$solicitacao->descricao}} <br>
        {{$solicitacao->status}} <br>
        <!-- Botão para "Aceitar" -->
        <a class="btn btn-outline-primary mb-1" href="{{ route('solicitacao_os.aceitar', $solicitacao->id) }}"
            onclick="event.preventDefault(); document.getElementById('aceitar-form-{{ $solicitacao->id }}').submit();">
            Aceitar
        </a>

        <form id="aceitar-form-{{ $solicitacao->id }}" action="{{ route('solicitacao_os.aceitar', $solicitacao->id) }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Botão para "Colocar em Espera" -->
        <a class="btn btn-outline-warning mb-1" href="{{ route('solicitacao_os.espera', $solicitacao->id) }}"
            onclick="event.preventDefault(); document.getElementById('espera-form-{{ $solicitacao->id }}').submit();">
            Colocar em Espera
        </a>

        <form id="espera-form-{{ $solicitacao->id }}" action="{{ route('solicitacao_os.espera', $solicitacao->id) }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Botão para "Recusar" -->
        <a class="btn btn-outline-danger mb-1" href="{{ route('solicitacao_os.recusar', $solicitacao->id) }}"
            onclick="event.preventDefault(); document.getElementById('recusar-form-{{ $solicitacao->id }}').submit();">
            Recusar
        </a>

        <form id="recusar-form-{{ $solicitacao->id }}" action="{{ route('solicitacao_os.recusar', $solicitacao->id) }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <hr>
    @endforeach
</main>

</html>