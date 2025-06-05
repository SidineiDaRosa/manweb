@extends('app.layouts.app')
@section('content')
<style>
    .equipamento-bloco {
        background-color: #f9f9f9;
        border-left: 5px solid #007bff;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .equipamento-nome {
        font-size: 1.2em;
        font-weight: bold;
        color: #0056b3;
        margin-bottom: 15px;
    }

    .pecas-lista {
        display: flex;
        flex-direction: column;
        /* empilha verticalmente */
        gap: 15px;
    }

    .peca-card {
        max-width: 100%;
        /* ocupar toda a largura do container */
        flex: none;
        /* desabilitar flex-grow e flex-shrink */
    }

    @media (max-width: 768px) {
        .peca-card {
            max-width: 100%;
        }
    }

    .btn-equipamento {
        float: right;
        margin-top: -5px;
    }
</style>

<main class="content">
    <h2>Notificações de Manutenção</h2>

    @foreach($agrupados as $nomeEquipamento => $pecas)
    <div class="equipamento-bloco">
        <div class="equipamento-nome">
            {{ $nomeEquipamento }}
            <a class="btn btn-outline-success btn-equipamento" href="{{ route('equipamento.show', ['equipamento' => $pecas->first()->equipamento_id]) }}">
                <i class="icofont-tractor"></i> Ir para o equipamento
            </a>
        </div>

        <div class="pecas-lista">
            @foreach($pecas as $peca)
            <div class="peca-card">
                <strong>{{ $peca->descricao ?? 'Sem descrição' }}</strong>
                <hr>
                <b>Status:</b> {{ $peca->status }}<br>
                <b>Criticidade:</b> {{ $peca->criticidade }}<br>
                <b>Data Substituição:</b> {{ $peca->data_substituicao }} {{ $peca->hora_substituicao }}<br>
                <b>Próx. Manutenção:</b> {{ $peca->data_proxima_manutencao }}<br>
                <b>Restam:</b> {{ $peca->horas_proxima_manutencao }}h<br>
                <b>Horímetro:</b> {{ $peca->horimetro ?? 'N/A' }}<br>
                <b>Componente:</b> {{ $peca->tipo_componente }}
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</main>
@endsection