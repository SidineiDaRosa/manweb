@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4">Pesquisa de KPIs de Manutenção</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('kpis.dashboard') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Data de Início</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Data de Fim</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                        <a href="{{ route('kpis.dashboard') }}" class="btn btn-secondary">Limpar Filtros</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Resultados da Pesquisa</h5>

                <p>Aqui você pode exibir os principais KPIs calculados com base nos filtros aplicados. Por exemplo:</p>

                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="bg-light p-3 rounded text-center">
                            <h4 class="mb-0">MTBF</h4>
                            <p class="h2">150 Horas</p>
                            <small class="text-muted">Tempo Médio Entre Falhas</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="bg-light p-3 rounded text-center">
                            <h4 class="mb-0">MTTR</h4>
                            <p class="h2">3 Horas</p>
                            <small class="text-muted">Tempo Médio para Reparo</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="bg-light p-3 rounded text-center">
                            <h4 class="mb-0">Taxa de Ocupação</h4>
                            <p class="h2">95%</p>
                            <small class="text-muted">Disponibilidade do Equipamento</small>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4">Ordens de Serviço (Tabela detalhada)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>OS #</th>
                                <th>Equipamento</th>
                                <th>Data</th>
                                <th>Tempo de Parada</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($orders) && count($orders) > 0)
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->equipment->name }}</td>
                                <td>{{ $order->date }}</td>
                                <td>{{ $order->downtime }}h</td>
                                <td>{{ $order->status }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">Nenhum dado encontrado para os filtros selecionados.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @endsection
</main>