@include('app.layouts.header')
@include('app.paradas_de_maquinas.partials.modal_create')
@include('app.paradas_de_maquinas.partials.modal_edit')

<main class="content py-4">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">MTBF · MTT · OEE</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalParada">
                <i class="bi bi-play-circle"></i> Iniciar Parada
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Equipamento</th>
                        <th>OS</th>
                        <th>Falha</th>
                        <th>Motivo</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Duração</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paradas as $parada)

                    @php
                    $isActive = is_null($parada->ended_at);
                    $start = $parada->started_at ? \Carbon\Carbon::parse($parada->started_at) : null;
                    $end = $parada->ended_at ? \Carbon\Carbon::parse($parada->ended_at) : null;
                    @endphp

                    <tr class="{{ $isActive ? 'table-danger' : '' }}">
                        <td>#{{ $parada->id }}</td>
                        <td>{{ $parada->equipamento->nome ?? 'N/A' }}</td>
                        <td>{{ $parada->ordem->descricao ?? 'Sem título' }}</td>
                        <td>{{ $parada->failure->name ?? 'N/A' }}</td>
                        <td>{{ $parada->reason ?: '-' }}</td>
                        <td>{{ $start?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>{{ $end?->format('d/m/Y H:i') ?? '-' }}</td>

                        <td>
                            @if($end)
                            <span class="badge bg-info">
                                {{ $start->diffForHumans($end, true) }}
                            </span>
                            @elseif($start)
                            <span class="badge bg-warning text-dark">
                                em andamento
                            </span>
                            @else
                            -
                            @endif
                        </td>

                        <td class="text-center">
                            @if($isActive)
                            <button type="button"
                                class="btn btn-sm btn-primary btn-edit-parada"
                                data-id="{{ $parada->id }}"
                                data-equipment="{{ $parada->equipment_id }}"
                                data-ordem="{{ $parada->ordem_servico_id }}"
                                data-falha="{{ $parada->falha_id }}"
                                data-reason="{{ $parada->reason }}"
                                data-started="{{ $parada->started_at }}"
                                data-ended="{{ $parada->ended_at }}"
                                data-fail="{{ $parada->failure_id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            @else
                            -
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            Nenhuma parada registrada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</main>