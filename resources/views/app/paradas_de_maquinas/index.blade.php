@include('app.layouts.header')
@include('app.paradas_de_maquinas.partials.modal_create')
@include('app.paradas_de_maquinas.partials.modal_edit')
<main class="content">
    <h1>MTBF MTT OEE</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalParada">
        Iniciar Parada
    </button>

    <div style="display: flex; flex-direction: column; gap: 10px; font-family: sans-serif;">
        @foreach($paradas as $parada)

        <div
            style="display: flex; flex-wrap: wrap; gap: 12px 20px; padding: 12px; background-color: #ffffff; border-bottom: 1px solid #ddd; 
        @if(!$parada->ended_at) border-left: 4px solid red; @endif">
            <div style="min-width: 120px;"><strong>ID:</strong> {{ $parada->id }}</div>
            <div style="min-width: 150px;"><strong>Equipamento:</strong> {{ $parada->equipamento->nome ?? 'N/A' }}</div>
            <div style="min-width: 150px;"><strong>OS:</strong> {{ $parada->ordem->descricao ?? 'Sem título' }}</div>
            <div style="min-width: 120px;"><strong>Falha:</strong> {{ $parada->falha->name ?? 'N/A' }}</div>
            <div style="min-width: 120px;"><strong>Motivo:</strong> {{ $parada->reason ?? '-' }}</div>
            <div style="min-width: 130px;"><strong>Criado:</strong> {{ $parada->created_at?->format('d/m/Y H:i') ?? '-' }}</div>
            <div style="min-width: 130px;"><strong>Início:</strong> {{ $parada->started_at?->format('d/m/Y H:i') ?? '-' }}</div>
            <div style="min-width: 130px;"><strong>Fim:</strong> {{ $parada->ended_at?->format('d/m/Y H:i') ?? '-' }}</div>

            <!-- Botão de edição -->
            <button type="button" class="btn btn-warning btn-edit-parada"
                data-id="{{ $parada->id }}"
                data-equipment="{{ $parada->equipment_id }}"
                data-ordem="{{ $parada->ordem_servico_id }}"
                data-falha="{{ $parada->falha_id }}"
                data-reason="{{ $parada->reason }}"
                data-started="{{ $parada->started_at }}"
                data-ended="{{ $parada->ended_at }}">
                Editar
            </button>
        </div>
        @endforeach
    </div>

</main>