@extends('app.layouts.app')
@section('content')

<main class="content">
    <h3 class="h3-gray">Soliciatação OS</h3>
    <div class="header-grid">
        <a class="btn-inf btn-inf-md btn-inf-brown" href="{{ route('app.home') }}" style="width:200px;">
            <i class="icofont-dashboard"></i> dashboard
        </a>
    </div>
    </style>
    <form action="{{ route('solicitacoes-os') }}" method="get" style="font-family: Arial,sans-serif;">
        <div class="header-grid">
            <input type="datetime-local" class="input" name="datetime" id="datetime" style="width:200px;" required>
            <input type="datetime-local" class="input" name="datetime_fim" id="datetime_fim" style="width:200px;" required>
        </div>
        <label for="option-all" class="btn-inf btn-inf-sm btn-inf-gray">Todas</label>
        <input type="radio" id="option-all" name="options" value="Todas" checked>

        <label for="option-accepted" class="btn-inf btn-inf-sm btn-inf-green"><i class="bi bi-check2-circle"></i> Aceitas</label>
        <input type="radio" id="option-accepted" name="options" value="Aceita">

        <label for="option-pending" class="btn-inf btn-inf-sm btn-inf-warning"><i class="bi bi-pause-circle"></i> Em espera</label>
        <input type="radio" id="option-pending" name="options" value="Em Espera">

        <label for="option-rejected" class="btn-inf btn-inf-sm btn-inf-red"><i class="bi bi-x-circle-fill text-danger"></i> Recusada</label>
        <input type="radio" id="option-rejected" name="options" value="Recusada">
        <input type="hidden" name="receptor" value="{{ auth()->user()->nome }}">
        <button type="submit" class="btn-inf btn-inf-md btn-inf-blue-dark">
            <i class="bi bi-search"></i>
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
padding:5px;width:200px;
    @if($solicitacao->status == 'Aberta') 
        background-color: red; 
    @elseif($solicitacao->status == 'Em Espera') 
        background-color: orange; 
    @elseif($solicitacao->status == 'Aceita') 
        background-color: #6aa9e9; 
    @else 
        background-color: lightgrey; 
    @endif
    width: 50%;border-radius:5px;
   
">
            Status: {{$solicitacao->status}} <br>
        </div> <br>
        <!-- Botão para "Aceitar" -->
        <a class="btn-inf btn-inf-sm btn-inf-blue-dark" href="{{ route('solicitacao_os.aceitar', $solicitacao->id) }}"
            onclick="event.preventDefault(); document.getElementById('aceitar-form-{{ $solicitacao->id }}').submit();">
            <i class="bi bi-check2-circle"></i> Aceitar
        </a>

        <form id="aceitar-form-{{ $solicitacao->id }}" action="{{ route('solicitacao_os.aceitar', $solicitacao->id) }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Botão para "Colocar em Espera" -->
        <a class="btn-inf btn-inf-sm btn-inf-warning" href="{{ route('solicitacao_os.espera', $solicitacao->id) }}"
            onclick="event.preventDefault(); document.getElementById('espera-form-{{ $solicitacao->id }}').submit();">
          <i class="bi bi-pause-circle"></i> Colocar em Espera
        </a>

        <form id="espera-form-{{ $solicitacao->id }}" action="{{ route('solicitacao_os.espera', $solicitacao->id) }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Botão para "Recusar" -->
        <a class="btn-inf btn-inf-sm btn-inf-red" href="{{ route('solicitacao_os.recusar', $solicitacao->id) }}"
            onclick="event.preventDefault(); document.getElementById('recusar-form-{{ $solicitacao->id }}').submit();">
           <i class="bi bi-x-circle-fill text-danger"></i> Recusar
        </a>

        <form id="recusar-form-{{ $solicitacao->id }}" action="{{ route('solicitacao_os.recusar', $solicitacao->id) }}" method="POST" style="display: none;">
            @csrf
        </form>
        <style>
            .img {
                max-width: 100%;
                /* A largura da imagem será ajustada ao máximo da tela */
                height: auto;
                /* A altura será ajustada automaticamente para manter a proporção */
                max-height: 100vh;
                /* A altura máxima será o tamanho da tela (viewport height) */
            }
        </style>

        <hr>

        <!-- A imagem será ajustada para caber na tela e será dimensionada proporcionalmente -->
        <img id="img" src="{{ asset('img/request_os/' . $solicitacao->imagem) }}" alt="Imagem da Solicitação" class="img">
    </div>
    <hr>
    @endforeach
</main>

</html>