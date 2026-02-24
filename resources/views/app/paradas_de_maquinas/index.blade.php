@include('app.layouts.header')
@include('app.paradas_de_maquinas.partials.modal_create')
@include('app.paradas_de_maquinas.partials.modal_edit')
@include('app.paradas_de_maquinas.partials.modal_create_event')

<main class="content py-4">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                use Carbon\Carbon;
                use Carbon\CarbonInterval;

                // Função para calcular o tempo parado de uma parada considerando os eventos
                function calcularTempoParado($parada, $events) {
                $eventsParada = $events->where('downtime_id', $parada->id)
                ->sortBy('event_timestamp'); // Ordena por horário

                $tempoParado = 0;
                $inicioPeriodo = null;

                foreach ($eventsParada as $event) {
                $timestamp = Carbon::parse($event->event_timestamp);

                switch ($event->event_type) {
                case 'INICIO':
                $inicioPeriodo = $timestamp;
                break;

                case 'PAUSA':
                if ($inicioPeriodo) {
                $tempoParado += $inicioPeriodo->diffInSeconds($timestamp);
                $inicioPeriodo = null; // Pausa suspende o tempo parado
                }
                break;

                case 'RETOMADA':
                $inicioPeriodo = $timestamp; // Retomada reinicia contagem
                break;

                case 'FIM':
                if ($inicioPeriodo) {
                $tempoParado += $inicioPeriodo->diffInSeconds($timestamp);
                $inicioPeriodo = null;
                }
                break;
                }
                }

                // Se a parada ainda estiver ativa (sem FIM), conta até agora
                if ($inicioPeriodo) {
                $tempoParado += $inicioPeriodo->diffInSeconds(now());
                }

                return $tempoParado;
                }

                // 1. Tempo total de vida útil
                $primeiraParada = $paradas->min('started_at');
                $dataInicio = $primeiraParada ? Carbon::parse($primeiraParada) : now()->subDays(1);
                $tempoTotalVidaUtil = now()->diffInSeconds($dataInicio);

                // 2. Tempo total parado somando todas as paradas
                $totalSegundosParado = $paradas->reduce(function ($carry, $parada) use ($machine_downtime_events) {
                return $carry + calcularTempoParado($parada, $machine_downtime_events);
                }, 0);

                // 3. Quantidade de paradas
                $totalParadas = $paradas->count();

                // 4. MTTR e MTBF
                $mttrSegundos = $totalParadas > 0 ? $totalSegundosParado / $totalParadas : 0;
                $tempoOperando = $tempoTotalVidaUtil - $totalSegundosParado;
                $mtbfSegundos = $totalParadas > 0 ? $tempoOperando / $totalParadas : $tempoOperando;

                // 5. Formatação legível
                $formatar = fn($segundos) => CarbonInterval::seconds($segundos)->cascade()->forHumans(['short' => true]);

                $mtbfFinal = $formatar($mtbfSegundos);
                $mttrFinal = $formatar($mttrSegundos);
                $totalParadoFinal = $formatar($totalSegundosParado);

                // Paradas ativas
                $paradasAtivas = $paradas->filter(function($parada) use ($machine_downtime_events) {
                $eventsParada = $machine_downtime_events->where('downtime_id', $parada->id)
                ->sortByDesc('event_timestamp');
                $ultimoEvento = $eventsParada->first();
                return !$ultimoEvento || $ultimoEvento->event_type != 'FIM';
                })->count();

                // Tempo total das paradas ativas
                $totalSegundosAtivas = $paradas->filter(function($parada) use ($machine_downtime_events) {
                $eventsParada = $machine_downtime_events->where('downtime_id', $parada->id)
                ->sortByDesc('event_timestamp');
                $ultimoEvento = $eventsParada->first();
                return !$ultimoEvento || $ultimoEvento->event_type != 'FIM';
                })->reduce(function($carry, $parada) use ($machine_downtime_events) {
                return $carry + calcularTempoParado($parada, $machine_downtime_events);
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
            <button type="button" class="btn-inf btn-inf-warning" data-bs-toggle="modal" data-bs-target="#modalCreateParada">
                <i class="bi bi-play-circle"></i> Iniciar Parada
            </button>

        </div>
        <form action="{{ route('machine_downtime.index') }}" method="GET">

            <div style="gap:5px;display:flex;flex-direction:row;">

                <span class="fw-semibold text-muted me-3" style="width:20%;">
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
                    value="{{ request('descricao') }}" style="width:350px;border-radius:15px;background-color:khaki">

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

                <!-- Tipo de falha   selecionada para filtros-->
                <select name="falha_id" class="form-control" style="width:300px;">
                    <option value="">Todas as Falhas</option>
                    @foreach($flaiures as $fl)
                    <option value="{{ $fl->id }}">
                        {{ $fl->name }} - {{ Str::limit($fl->description, 40, '...') }}
                    </option>
                    @endforeach

                </select>
                <!-- Status -->
                <select name="status" class="form-control" style="width:300px;">
                    <option value="">Todos Status</option>
                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>
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

                    <td>
                        <div>
                            <h6 class="h6-gray">iD:#{{ $parada->id }} </h6>
                            <hr>
                            </span>
                            <h4 class="h5-gray">#{{ $parada->equipamento->id ?? '-' }} | {{ $parada->equipamento->nome ?? '-' }}</h4>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span style="font-size:12px;font-weight:600;color: gray;"> Iniciado:</span> {{ $parada->startedby->name ?? '-' }}
                        </div>
                        <hr>
                        <div>
                            <span style="font-size:12px;font-weight:600;color: gray;"> Finalizado:</span> {{$parada->endedBy->name ?? '?' }}
                        </div>
                    </td>
                    <td>{{ $parada->ordem_servico_id ?? 'OS não anexada!' }}</td>
                    <td>{{ $parada->failure->name ?? 'N/A' }} <br>
                        <hr>
                        <h6 class="h6-black">Subcategoria: </h6>
                        <h4 class="h4-gray">{{ $parada->machine_failure_subcategorie?->name ?? 'N/A' }}</h4>


                    </td>
                    <td>{{ $parada->reason ?: '-' }} <br>
                        @foreach($machine_downtime_events as $machine_downtime_event)
                        @if($machine_downtime_event->downtime_id == $parada->id)
                        <div class="row mb-2 p-2" style="background-color: #f0f0f0; border-radius:5px;">
                            <span style="font-weight:600;font-size:12px;color:rgb(1,1,1,0.5)">Evento:</span>
                            <div class="col-2"><strong style="font-weight:600;font-size:12px;color:rgb(1,1,1,0.9)">{{ $machine_downtime_event->event_type }}</strong></div>
                            <div class="col-3">{{ \Carbon\Carbon::parse($machine_downtime_event->event_timestamp)->format('d/m/Y H:i') }}</div>
                            <div class="col-5">
                                @if($machine_downtime_event->reason_detail)
                                Motivo: {{ $machine_downtime_event->reason_detail }}
                                @endif
                            </div>
                            <div class="col-2">Usuário: {{ $machine_downtime_event->user->name ?? 'Desconhecido' }}</div>
                        </div>
                        @endif
                        @endforeach

                    </td>
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
                            data-failure="{{ $parada->failure_id}}"
                            data-subcategoria="{{  $parada->machine_failure_subcategorie?->id}}"
                            data-reason="{{ $parada->reason }}"
                            data-started="{{ $parada->started_at }}"
                            data-ended="{{ $parada->ended_at }}">

                            <i class="bi bi-check-circle"></i> Resolver
                        </button>

                        <button type="button" class="btn-inf btn-inf-md btn-inf-orange"
                            data-bs-toggle="modal"
                            data-bs-target="#createEventModal"
                            data-downtime="{{ $parada->id }}">
                            <i class="bi bi-plus-circle"></i>
                            Novo Evento
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