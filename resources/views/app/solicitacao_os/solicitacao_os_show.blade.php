@extends('app.layouts.app')
@section('content')

<main class="content">
    <div class="titulo-main">
        Solicitações de O.S
    </div>
    <form action="{{ route('solicitacoes-os') }}" method="get" style="font-family: Arial,sans-serif;">
        Entre:
        <input type="datetime-local" class="form-control-template" name="datetime" id="datetime" style="width:250px;height:30px;font-size:20px;"> <br>
        <input type="datetime-local" class="form-control-template" name="datetime_fim" id="datetime_fim" style="width:250px;height:30px;font-size:20px;"> <br>
        <label for="option-all">Todas</label>
        <input type="radio" id="option-all" name="options" value="Todas" checked>

        <label for="option-accepted">Aceitas</label>
        <input type="radio" id="option-accepted" name="options" value="Aceita">

        <label for="option-pending">Em espera</label>
        <input type="radio" id="option-pending" name="options" value="Em Espera">

        <label for="option-rejected">Recusada</label>
        <input type="radio" id="option-rejected" name="options" value="Recusada">
        <input type="hidden" name="receptor" value="{{ auth()->user()->nome }}">
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
    <div style="padding:20px; align-items: center;font-family:arial,sanserif;">
        ID: {{$solicitacao->id}} <br>
        Emissão: {{ \Carbon\Carbon::parse($solicitacao->datetime)->format('d/m/Y H:i:s') }} <br>

        @foreach($funcionarios as $funcionario)
        @if ($funcionario->id == $solicitacao->emissor)
        Emissor: {{ $funcionario->primeiro_nome }} <br>
        Verificado Por: {{ $solicitacao->receptor}} <br>
        Atualizado: {{ $solicitacao->updated_at->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }} <br>
        @endif
        @endforeach
        <div style="width: 60%; word-wrap: break-word;font-family:Arial, Helvetica, sans-serif">
           <span style="font-family:Arial;font-weight:bold;">Descrição: </span> {!! nl2br(e($solicitacao->descricao)) !!}
        </div><br>

        <div style="
    @if($solicitacao->status == 'Aberta') 
        background-color: red; 
    @elseif($solicitacao->status == 'Em Espera') 
        background-color: orange; 
    @elseif($solicitacao->status == 'Aceita') 
        background-color: green; 
    @else 
        background-color: lightgrey; 
    @endif
    width: 50%;
">
            Status: {{$solicitacao->status}} <br>
        </div> <br>
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