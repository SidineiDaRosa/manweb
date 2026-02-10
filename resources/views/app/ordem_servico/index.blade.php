@extends('app.layouts.app')

@section('content')

@php
// Evita erro de variável indefinida
$classData = $classData ?? '';
$classHora = $classHora ?? '';
@endphp

<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<main class="content">

    <!-- ==================== FILTROS RÁPIDOS ==================== -->
    <div class="card-header" style="background:#f2f2f2; border-radius:8px; padding:8px;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:8px;gap:5px; ">

            <a href="#" class="btn btn-info" onclick="SetDataHoje()">📆 O.S. hoje</a>
            <a href="#" class="btn btn-info" onclick="exibirIntervaloSemanaAtual()">📅 O.S semana</a>
            <a href="#" class="btn btn-info" onclick="GetOsEmAndamento()"> 🔄 O.S. Em Andamento</a>
            <a href="#" class="btn btn-info" onclick="SetAbertas()">🔓 O.S. aberta</a>
            <a href="#" class="btn btn-info" onclick="SetOsVencidas()">⏰ O.S. Vencidas</a>
            <a class="btn btn-dark" href="{{ route('app.home') }}">Dashboard</a>
            <a class="btn btn-dark" href="{{ route('ordem.servico.filtrar') }}">T</a>

        </div>
    </div>
    <script>
        function formatDateBR(date) {
            const d = new Date(date);
            let dia = String(d.getDate()).padStart(2, '0');
            let mes = String(d.getMonth() + 1).padStart(2, '0');
            let ano = d.getFullYear();
            return `${ano}-${mes}-${dia}`; // formato que o input date aceita
        }

        // --------- FILTROS RÁPIDOS ---------

        function SetDataHoje() {
            let hoje = new Date();
            document.getElementById('data_inicio').value = formatDateBR(hoje);
            document.getElementById('data_fim').value = formatDateBR(hoje);
            FiltraOs();
        }

        function SetAbertas() {
            document.getElementById('situacao').value = "aberto";
            FiltraOs();
        }

        function GetOsEmAndamento() {
            document.getElementById('situacao').value = "em andamento";
            FiltraOs();
        }

        function SetOsVencidas() {
            let hoje = new Date();
            document.getElementById('data_fim').value = formatDateBR(hoje);
            document.getElementById('tipo_consulta').value = "3"; // entre datas
            FiltraOs();
        }

        function exibirIntervaloSemanaAtual() {
            let hoje = new Date();
            let primeiroDia = new Date(hoje);
            primeiroDia.setDate(hoje.getDate() - hoje.getDay());

            let ultimoDia = new Date(primeiroDia);
            ultimoDia.setDate(primeiroDia.getDate() + 6);

            document.getElementById('data_inicio').value = formatDateBR(primeiroDia);
            document.getElementById('data_fim').value = formatDateBR(ultimoDia);

            FiltraOs();
        }
    </script>

    <!-- ==================== FORMULÁRIO DE FILTRO ==================== -->
    <div class="card p-3 mt-3">

        <form action="{{ url('filtro-os') }}" method="POST" id="form_filt_os">
            @csrf

            <div class="row g-2" style="gap:2px;">

                <div class="col-md-1">
                    <label>ID</label>
                    <input type="number" class="form-control" name="id" placeholder="ID">
                </div>
                <style>
                    label {
                        font-size: 15px;
                        font-weight: 500;
                    }
                </style>
                <div class="col-md-0">
                    <label>Data inicial</label>
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio">
                </div>

                <div class="col-md-0">
                    <label>Hora prevista</label>
                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio">
                </div>

                <div class="col-md-0">
                    <label>Data final</label>
                    <input type="date" class="form-control" name="data_fim" id="data_fim">
                </div>

                <div class="col-md-0">
                    <label>Hora fim</label>
                    <input type="time" class="form-control" name="hora_fim" id="hora_fim">
                </div>

                <div class="col-md-3">
                    <label>Situação</label>
                    <select class="form-control" name="situacao" id="situacao">
                        <option value="todas">Todas</option>
                        <option value="aberto">🔓 Aberto</option>
                        <option value="fechado">🔒 Fechado</option>
                        <option value="indefinido">❔ Indefinido</option>
                        <option value="cancelada">❌ Cancelada</option>
                        <option value="em andamento">🕐 Em andamento</option>
                        <option value="pausado">⏸️ Pausado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Tipo</label>
                    <select class="form-control" name="tipo_consulta" id="tipo_consulta">
                        <option value="9">📝 Pela descrição</option>
                        <option value="2">🗓️ Por data</option>
                        <option value="5">🖥️ Por equipamento</option>
                        <option value="1">🆔 Pelo ID</option>
                    </select>

                </div>


            </div>

            <div class="row mt-3 justify-content-center">
                <div class="col-md-6">
                    <input type="text" name="like" class="form-control"
                        placeholder="Digite descrição, máquina ou serviço..."
                        style="background:rgba(218, 218, 212, 0.3);border-radius:15px;">
                </div>

                <div class="col-md-2">
                    <a href="#" class="btn btn-outline-warning w-100" onclick="FiltraOs()">Filtrar</a>
                </div>
            </div>

        </form>
    </div>

    <!-- ==================== TABELA ==================== -->
    <style>
        .table td {
            vertical-align: middle;
        }

        .progress {
            height: 10px;
        }
    </style>

    <script>
        function DeletarOs(id) {
            if (confirm("Deseja deletar a ordem de serviço?")) {
                document.getElementById('form_' + id).submit();
            }
        }

        function FiltraOs() {
            document.getElementById('form_filt_os').submit();
        }
    </script>
    <div class="lista-os">

        @foreach($ordens_servicos as $ordem)

        <div class="card mb-3 p-3 border">


            <style>
                strong {
                    font-size: 15px;
                    font-weight:700;
                }
            </style>
            <div class="row" style="gap:5px;">
                <div><strong>ID:</strong> {{ $ordem->id }}</div>

                <div class="col-md-0">
                    <strong>Emissão:</strong><br>
                    {{ date('d/m/Y', strtotime($ordem->data_emissao)) }} <br>
                    {{ $ordem->hora_emissao }}
                </div>

                <div class="col-md-0">
                    <strong>Previsão Início:</strong><br>
                    {{ date('d/m/Y', strtotime($ordem->data_inicio)) }}<br>
                    {{ $ordem->hora_inicio }}
                </div>

                <div class="col-md-0">
                    <strong>Previsão Fim:</strong><br>
                    <div class="{{ $classData }}">
                        {{ date('d/m/Y', strtotime($ordem->data_fim)) }}<br>
                    </div>
                    <div class="{{ $classHora }}">
                        {{ $ordem->hora_fim }}
                    </div>
                </div>

                <div class="col-md-2">
                    <strong>Empresa:</strong> {{ $ordem->Empresa->razao_social }}<br>
                    <strong>Patrimônio:</strong> {{ $ordem->equipamento->nome }}<br>
                    <strong>Projeto:</strong> {{ $ordem->projeto_id }}
                </div>

                <div class="col-md-2">
                    <strong>Emissor:</strong> {{ $ordem->emissor }}<br>
                    <strong>Responsável:</strong> {{ $ordem->responsavel }}
                </div>
                <div>
                    <strong>Progresso:</strong>
                    <div class="progress">
                        <div class="progress-bar bg-warning"
                            style="width: {{ $ordem->status_servicos }}%">
                            {{ $ordem->status_servicos }}%
                        </div>
                    </div>
                </div>
                <div><strong>Status:</strong> {{ $ordem->situacao }}</div>
                <div class="col-md-4 d-flex gap-2 align-items-center">

                    <a class="btn btn-outline-primary btn-sm"
                        href="{{ route('ordem-servico.show', $ordem->id) }}">
                        👁 Visualizar
                    </a>

                    <a class="btn btn-outline-success btn-sm @can('user') disabled @endcan"
                        href="{{ route('ordem-servico.edit', $ordem->id) }}">
                        ✏️ Editar
                    </a>

                    <form id="form_{{ $ordem->id }}" method="POST"
                        action="{{ route('ordem-servico.destroy', $ordem->id) }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                    <a class="btn btn-outline-danger btn-sm @can('user') disabled @endcan"
                        href="#"
                        onclick="DeletarOs({{ $ordem->id }})">
                        🗑️ Excluir
                    </a>

                </div>

                <div>
                    <strong>Descrição:</strong><br>

                    {{ $ordem->descricao }}

                    @if(isset($servicos_executado[$ordem->id]))
                    <div class="mt-2 p-2 border rounded bg-light">
                        <strong style="font-size: 12px;">Serviços Executados:</strong>

                        @foreach($servicos_executado[$ordem->id] as $servico)
                        <div class="d-flex align-items-center gap-2 mt-1 p-2 border rounded bg-white">
                            <span class="material-symbols-outlined text-primary">engineering</span>

                            <div>
                                <strong>{{ $servico->funcionario->primeiro_nome ?? '—' }}</strong><br>
                                <small>{{ $servico->descricao }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>


            </div>


        </div>

        @endforeach
    </div>

</main>
@endsection