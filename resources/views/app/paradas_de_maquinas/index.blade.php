@include('app.layouts.header')
@include('app.paradas_de_maquinas.partials.modal_create')
@include('app.paradas_de_maquinas.partials.modal_edit')

<main class="content py-4">


    <!--Mesagem de confirmação de verificação da APR-->
    @if(session('success'))
    <div class="alert alert-success custom-alert position-relative">
        {!! session('success') !!}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;">
            &times;
        </button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-warning custom-alert position-relative">
        <!-- Ícone de alerta -->
        <i class="bi bi-exclamation-triangle-fill fs-4 mt-1"></i>
        {!! session('error') !!}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;">
            &times;
        </button>
    </div>
    @endif
    <div class="container-fluid" style="background:rgba(1,1,1,0.02);">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div style="gap: 40px;display:flex;flex-direction:row;">


                @php
                // 1. Defina o período total que você está analisando (ex: tempo desde a primeira parada até agora)
                $primeiraParada = $paradas->min('started_at');
                $dataInicio = $primeiraParada ? \Carbon\Carbon::parse($primeiraParada) : now()->subDays(1);
                $tempoTotalVidaUtil = now()->diffInSeconds($dataInicio);

                // 2. Calcula o Tempo Total Parado (Downtime)
                $totalSegundosParado = $paradas->reduce(function ($carry, $parada) {
                $start = \Carbon\Carbon::parse($parada->started_at);
                $end = $parada->ended_at ? \Carbon\Carbon::parse($parada->ended_at) : now();
                return $carry + $start->diffInSeconds($end);
                }, 0);

                // 3. Quantidade de paradas
                $totalParadas = $paradas->count();

                // 4. Cálculos MTTR e MTBF
                // MTTR: Média de tempo para consertar (Tempo Parado / Qtd Paradas)
                $mttrSegundos = $totalParadas > 0 ? $totalSegundosParado / $totalParadas : 0;

                // MTBF: Média de tempo entre falhas (Tempo total operando / Qtd Paradas)
                $tempoOperando = $tempoTotalVidaUtil - $totalSegundosParado;
                $mtbfSegundos = $totalParadas > 0 ? $tempoOperando / $totalParadas : $tempoOperando;

                // 5. Formatação para os cards
                $formatar = function($segundos) {
                return \Carbon\CarbonInterval::seconds($segundos)->cascade()->forHumans(['short' => true]);
                };

                $mtbfFinal = $formatar($mtbfSegundos);
                $mttrFinal = $formatar($mttrSegundos);
                $totalParadoFinal = $formatar($totalSegundosParado);

                //Paradas ativas
                // Paradas ativas (sem ended_at)
                $paradasAtivas = $paradas->whereNull('ended_at')->count();

                // Tempo total das paradas ativas
                $totalSegundosAtivas = $paradas->whereNull('ended_at')->reduce(function ($carry, $parada) {
                $start = \Carbon\Carbon::parse($parada->started_at);
                return $carry + $start->diffInSeconds(now());
                }, 0);

                $totalAtivasFormatado = $formatar($totalSegundosAtivas);

                @endphp

                <!-- Card MTBF -->
                <div class="card-inf-md">
                    <div class="card-inf-header">
                        <div class="card-title">MTBF</div>
                        <div class="card-inf-ico">
                            <i class="bi bi-clock-history" style="font-size: 22px; color:blueviolet;"></i>
                        </div>
                    </div>
                    <div class="card-data" style="font-size: 24px;">
                        {{ $mtbfFinal }}
                    </div>
                    <div class="card-description">
                        Tempo médio entre falhas
                    </div>
                </div>

                <!-- Card MTTR -->
                <div class="card-inf-md">
                    <div class="card-inf-header">
                        <div class="card-title">MTTR</div>
                        <div class="card-inf-ico">
                            <i class="bi bi-tools" style="font-size: 22px; color:orange;"></i>
                        </div>
                    </div>
                    <div class="card-data" style="font-size: 24px;">
                        {{ $mttrFinal }}
                    </div>
                    <div class="card-description">
                        Média de tempo de reparo
                    </div>
                </div>

                <!-- Card Tempo Total Parado -->
                <div class="card-inf-md">
                    <div class="card-inf-header">
                        <div class="card-title">Total Parado</div>
                        <div class="card-inf-ico">
                            <i class="bi bi-exclamation-octagon" style="font-size: 22px; color:red;"></i>
                        </div>
                    </div>
                    <div class="card-data" style="font-size: 24px;">
                        {{ $totalParadoFinal }}
                    </div>
                    <div class="card-description">
                        {{ $totalParadas }} paradas registradas
                    </div>
                </div>
                <!-- Paradas Ativas -->
                <div class="card-inf-md">
                    <div class="card-inf-header">
                        <div class="card-title">Paradas Ativas</div>
                        <div class="card-inf-ico">
                            <i class="bi bi-clock-history" style="font-size: 22px; color:blueviolet;"></i>
                        </div>
                    </div>
                    <div class="card-data" style="font-size: 24px;">
                        {{ $paradasAtivas }}
                    </div>
                    <div class="card-description">
                        {{ $totalAtivasFormatado }} em aberto
                    </div>
                </div>
            </div>
            <button type="button" class="btn-inf btn-inf-warning" data-bs-toggle="modal" data-bs-target="#modalParada">
                <i class="bi bi-play-circle"></i> Iniciar Parada
            </button>
        </div>
        <form action="{{ route('machine_downtime.index') }}" method="GET">

            <div class="d-flex align-items-center gap-2 flex-nowrap">

                <span class="fw-semibold text-muted me-3"style="width:20%;">
                    REGISTROS DE PARADAS
                </span>

                <!-- Data Início -->
                <input type="datetime-local"
                    name="data_inicio"
                    class="form-control"
                    value="{{ request('data_inicio') }}" style="width:250px;">

                <!-- Data Fim -->
                <input type="datetime-local"
                    name="data_fim"
                    class="form-control"
                    value="{{ request('data_fim') }}" style="width:250px;">

                <!-- Descrição -->
                <input type="text"
                    name="descricao"
                    class="form-control"
                    placeholder="Buscar descrição"
                    value="{{ request('descricao') }}" style="width:300px;">

                <!-- Equipamento -->
                <select name="equipamento_id" class="form-control" style="width:300px;">
                    <option value="">Todas as Máquinas</option>
                    @foreach($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}"
                        {{ request('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                        {{ $equipamento->nome }}
                    </option>
                    @endforeach
                </select>

                <!-- Status -->
                <select name="status" class="form-control" style="width:300px;">
                    <option value="">Todos Status</option>
                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }} >
                        Ativo
                    </option>
                    <option value="finalizado" {{ request('status') == 'finalizado' ? 'selected' : '' }}>
                        Finalizado
                    </option>
                </select>

                <!-- Botão -->
                <button type="submit" class="btn-inf btn-inf-green">
                    Buscar
                </button>

            </div>

        </form>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr style="color:rgba(1,1,1,0.5);font-weight:400;">
                    <th>#</th>
                    <th>Equipamento</th>
                    <th>Usuários</th>
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

                <tr>
                    <td>#{{ $parada->id }}</td>
                    <td>
                        <div>
                            <span style="font-size:15px;font-weight:600;color:rgba(1,1,1,0.9);"> {{ $parada->equipamento->nome ?? '-' }}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span style="font-size:12px;font-weight:600;color: gray;"> Iniciado:</span> {{ $parada->startedby->name ?? '-' }}
                        </div>
                        <div>
                            <span style="font-size:12px;font-weight:600;color: gray;"> Finalizado:</span> {{$parada->endedBy->name ?? '?' }}
                        </div>
                    </td>
                    <td>{{ $parada->ordem_servico_id ?? 'OS não anexada!' }}</td>
                    <td>{{ $parada->failure->name ?? 'N/A' }}</td>
                    <td>{{ $parada->reason ?: '-' }}</td>
                    <td>{{ $start?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>
                        @if($end)
                        {{ $end->format('d/m/Y H:i') }}
                        @else
                        <span class="btn-inf btn-inf-sm btn-inf-red">
                            <i class="bi bi-exclamation-triangle"></i> Em aberto
                        </span>
                        @endif
                    </td>
                    <td>
                        @php
                        // Se não houver fim, usa a hora atual para o cálculo
                        $tempoEfetivo = $end ?? now();
                        $diff = $start->diff($tempoEfetivo);

                        // Formata como: 02:30 (horas:minutos) ou como desejar
                        $time_stoped = $diff->format('%H:%I');
                        @endphp

                        {{ $time_stoped }}
                    </td>

                    <td class="text-center">
                        @if($isActive)
                        <button type="button"
                            class="btn-inf btn-inf-md btn-inf-blue-dark btn-edit-parada"
                            data-id="{{ $parada->id }}"
                            data-equipment="{{ $parada->equipment_id }}"
                            data-ordem="{{ $parada->ordem_servico_id }}"
                            data-falha="{{ $parada->falha_id }}"
                            data-reason="{{ $parada->reason }}"
                            data-started="{{ $parada->started_at }}"
                            data-ended="{{ $parada->ended_at }}"
                            data-failure="{{ $parada->failure_id}}">
                            <i class="bi bi-check-circle"></i> Resolver
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

</main>