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

    .sub-title-sm {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        font-size: 15px;
        color: #0056b3;
    }

    .sub-title-sm {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #0056b3;
    }

    .content-sm {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
        color: rgb(148, 139, 141)
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
                <strong class="title-sm">{{ $peca->descricao ?? 'Sem descrição' }}</strong>
                <hr>
                <span class="sub-title-sm ">Data Substituição: </span>
                <span class="content-sm">{{ $peca->data_substituicao }} as {{ $peca->hora_substituicao }}</span>

                <span class="sub-title-sm "> Status: </span>
                <span class="content-sm">{{ $peca->status }}</span>

                <span class="sub-title-sm "> Criticidade:</span>
                <span class="content-sm">{{ $peca->criticidade }}</span>

                <span class="sub-title-sm "> Próx. Manutenção:</span>
                <span class="content-sm">{{ $peca->data_proxima_manutencao }}</span>

                <span class="sub-title-sm "> Restam:</span>
                <span style="color: red;">{{ $peca->horas_proxima_manutencao }}h</span>
                <span class="sub-title-sm "> Tipo:</span>
                <span class="content-sm"> {{ $peca->tipo_componente }}</span>



            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</main>
@endsection