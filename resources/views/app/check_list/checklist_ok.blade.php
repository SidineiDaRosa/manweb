@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">

            <h6> Check-List Executado por Equipamento</h6>

            <button type="button" class="btn btn-outline-success"
                onclick="window.location.href='{{ route('check-list-index') }}'"
                style="float:right;margin-left:5px;">
                Check-List índice
            </button>

            <button type="button" class="btn btn-outline-success"
                onclick="window.location.href='{{ route('app.home') }}'"
                style="float:right;margin-left:5px;">
                Dashboard
            </button>

            <!-- FILTRO (sem depender de $equipamento) -->
            <form action="{{ route('checklist.executado') }}" method="post" id="form_filter_check_list">
                @csrf
                <div style="display: flex;flex-direction:row; gap:5px;">

                    <input type="date" class="form-control" name="data_inicio" style="width: 200px">

                    <input type="date" class="form-control" name="data_fim" style="width: 200px">
                    <input type="text" class="form-control" name="descricao" style="width: 200px" placeholder="--Digite uma descrição para busca--">
                    <select class="form-control" name="natureza" style="width: 300px;">
                        <option value="">--Selecione a gravidade--</option>
                        <option value="1">Normal</option>
                        <option value="2">Médio</option>
                        <option value="3">Alto</option>
                        <option value="4">Gravíssimo</option>
                    </select>

                    <button type="submit" class="btn btn-outline-success">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div style="margin-top:10px;">

            @if(isset($check_list_executado) && count($check_list_executado) > 0)

            @foreach($check_list_executado as $c)

            <div style="display:flex; flex-wrap:wrap; gap:15px; padding:10px;">

                <span style="width:120px;">
                    <strong>ID Checagem:</strong><br>
                    {{ $c->id }}
                </span>

                <span style="width:25%;">
                    <strong>Checklist:</strong><br>
                    ID: {{ $c->checkList->id ?? '—' }}<br>
                    {{ $c->checkList->descricao ?? 'Sem descrição' }}
                </span>

                <span style="width:20%;">
                    <strong>Observação:</strong><br>
                    <span style="color: {{ $c->observacao === 'Normal' ? 'green' : 'orange' }};">
                        {{ $c->observacao }}
                    </span>
                </span>

                <span style="width:15%;">
                    <strong>Funcionário:</strong><br>
                    {{ $c->funcionario }}
                </span>

                <!-- Barra de temperatura -->
                <div style="width: 25%; background:#e0e0e0; border-radius:5px; height:22px;">
                    <div style="
                        width: {{ min(100, ($c->temperatura / 200) * 100) }}%;
                        height:100%;
                        background:
                        @if($c->temperatura < 60)
                            #88e1d9
                        @elseif($c->temperatura <= 100)
                            #ffecb5
                        @else
                            #f25b61
                        @endif
                    ">
                        {{ $c->temperatura }}°C
                    </div>
                </div>

                <span style="width:10%;">
                    <strong>Vibração:</strong><br>
                    {{ $c->vibracao }}
                </span>

                <div style="width:150px; padding:5px;
                    @if($c->gravidade == 1) background:rgb(136,225,217);
                    @elseif($c->gravidade == 2) background:rgb(255,224,157);
                    @elseif($c->gravidade == 3) background:rgb(255,183,93);
                    @elseif($c->gravidade == 4) background:rgb(242,91,97);
                    @endif
                ">
                    <strong>Gravidade:</strong><br>
                    {{ $c->gravidade }}
                </div>

                <span style="width:20%;">
                    <strong>Data:</strong><br>
                    {{ \Carbon\Carbon::parse($c->data_verificacao)->format('d/m/Y') }}
                    às {{ $c->hora_verificacao }}
                </span>

                <span style="width:15%;">
                    <strong>Status:</strong><br>
                    {{ $c->status }}
                </span>

                <!-- IMAGEM -->
                @php
                $caminho = public_path($c->imagem);
                @endphp

                @if($c->imagem && file_exists($caminho))
                <img src="{{ asset($c->imagem) }}" style="max-width:150px;">
                @else
                <i class="text-danger">Imagem não disponível.</i>
                @endif

            </div>

            <hr>

            @endforeach

            @else
            <p class="text-center text-muted">Nenhum registro encontrado.</p>
            @endif

        </div>
    </div>
</main>
@endsection