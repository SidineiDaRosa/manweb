@extends('app.layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid px-3 px-md-4 mt-3">
            <div class="card-sistema">


                <style>
                    /* ===== FUNDO DO SISTEMA ===== */
                    .content {
                        min-height: calc(100vh - 70px);
                    }

                    /* card principal */
                    .card-sistema {
                        background: #fff;
                        border-radius: 12px;
                        box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
                        overflow: hidden;
                    }


                    /* ===== CARD PRINCIPAL ===== */
                    .container {
                        background: #fff;
                        border-radius: 12px;
                        box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
                        padding: 0;
                        overflow: hidden;
                    }

                    /* ===== CABEÇALHO DA TELA ===== */
                    h5 {
                        margin: 0;
                        padding: 18px 22px;
                        background: linear-gradient(135deg, #1f2937, #374151);
                        color: #fff;
                        font-weight: 600;
                        letter-spacing: .4px;
                        border-bottom: 1px solid #e5e7eb;
                    }

                    /* ===== TOOLBAR ===== */
                    .d-flex.flex-wrap.align-items-center {
                        padding: 18px 22px;
                        border-bottom: 1px solid #edf0f2;
                        background: #fbfcfd;
                    }

                    /* ===== FILTRO ===== */
                    #frm_filtro_por_equipamento label {
                        font-size: 13px;
                        font-weight: 600;
                        color: #6b7280;
                    }

                    #frm_filtro_por_equipamento select {
                        border: 1px solid #d1d5db;
                        border-radius: 8px;
                        padding: 5px 8px;
                        font-size: 13px;
                        height: 34px;
                        background: #fff;
                    }

                    /* ===== BOTÕES ===== */
                    .btn {
                        border-radius: 8px;
                        font-size: 13px;
                        padding: 6px 12px;
                        font-weight: 600;
                        border: none;
                        box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
                    }

                    .btn-success {
                        background: #76a888;
                    }

                    .btn-success:hover {
                        background: #2aca65;
                    }

                    .btn-outline-success {
                        background: #ff951d2a;
                        color: #ffa600;
                    }

                    .btn-outline-success:hover {
                        background: #ecc41059;
                        color: #ffc400
                    }

                    .btn-primary {
                        background: #294061;
                    }

                    .btn-primary:hover {
                        background: #5574ca;
                    }

                    /* ===== TABELA PROFISSIONAL ===== */
                    .table {
                        margin: 0;
                        font-size: 13.5px;
                    }

                    .table thead th {
                        background: #f9fafb;
                        color: #6b7280;
                        text-transform: uppercase;
                        font-size: 11.5px;
                        letter-spacing: .6px;
                        border-bottom: 1px solid #e5e7eb !important;
                    }

                    .table tbody td {
                        border: none !important;
                        border-bottom: 1px solid #f0f2f4 !important;
                        padding: 11px 10px;
                    }

                    .table tbody tr {
                        transition: .12s ease;
                    }

                    .table tbody tr:hover {
                        background: #f6f8fb;
                    }

                    /* ================= MOBILE ================= */
                    @media (max-width: 768px) {

                        h5 {
                            font-size: 15px;
                            padding: 14px 16px;
                        }

                        /* toolbar vira coluna */
                        .d-flex.flex-wrap.align-items-center {
                            flex-direction: column;
                            align-items: stretch !important;
                            gap: 12px;
                        }

                        /* filtro ocupa largura total */
                        #frm_filtro_por_equipamento {
                            width: 100%;
                            flex-direction: column;
                            align-items: stretch;
                        }

                        #frm_filtro_por_equipamento select,
                        #frm_filtro_por_equipamento button {
                            width: 100%;
                        }

                        /* botões em coluna */
                        .acoes-toolbar {
                            width: 100%;
                            flex-direction: column;
                        }

                        .acoes-toolbar .btn {
                            width: 100%;
                            min-width: unset;
                        }

                        /* tabela estilo mobile */
                        .table thead {
                            display: none;
                        }

                        .table tbody tr {
                            display: block;
                            background: #fff;
                            margin: 12px;
                            border-radius: 10px;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
                            padding: 10px;
                        }

                        .table tbody td {
                            display: flex;
                            justify-content: space-between;
                            padding: 8px 10px;
                            border-bottom: 1px solid #eef2f6 !important;
                            text-align: right;
                        }

                        .table tbody td::before {
                            content: attr(data-label);
                            font-weight: 600;
                            color: #6b7280;
                            text-align: left;
                        }

                        .table tbody td:last-child {
                            border-bottom: none !important;
                        }

                        /* ações centralizadas */
                        td:last-child {
                            justify-content: center !important;
                            gap: 10px;
                        }
                    }

                    /* ===== STATUS ===== */
                    .status {
                        padding: 4px 10px;
                        border-radius: 999px;
                        font-weight: 700;
                        font-size: 11.5px;
                        letter-spacing: .4px;
                    }

                    .status-ok {
                        background: #dcfce7;
                        color: #166534;
                    }

                    .status-proximo {
                        background: #fef3c7;
                        color: #92400e;
                    }

                    .status-atrasado {
                        background: #fee2e2;
                        color: #991b1b;
                        animation: pulse 1.4s infinite;
                    }

                    /* atraso piscando */
                    @keyframes pulse {
                        0% {
                            box-shadow: 0 0 0 0 rgba(220, 38, 38, .5);
                        }

                        70% {
                            box-shadow: 0 0 0 6px rgba(220, 38, 38, 0);
                        }

                        100% {
                            box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
                        }
                    }

                    /* ===== COLUNA AÇÕES ===== */
                    td .btn {
                        background: none !important;
                        box-shadow: none;
                        padding: 5px 7px;
                    }

                    .btn-info {
                        color: #0284c7;
                    }

                    .btn-warning {
                        color: #ca8a04;
                    }

                    .btn-danger {
                        color: #dc2626;
                    }

                    .btn-info:hover {
                        background: #e0f2fe !important;
                    }

                    .btn-warning:hover {
                        background: #fef9c3 !important;
                    }

                    .btn-danger:hover {
                        background: #fee2e2 !important;
                    }

                    /* ===== ALERTA ===== */
                    .alert-success {
                        margin: 18px 22px;
                        border-radius: 10px;
                        border: none;
                        background: #618f79;
                        color: #065f46;
                    }

                    /* ===== RESPONSIVO ===== */
                    .table-responsive {
                        border-radius: 0 0 12px 12px;
                        overflow: hidden;
                    }

                    /* ===== TOOLBAR ORGANIZADA ===== */
                    .toolbar {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 18px 22px;
                        border-bottom: 1px solid #edf0f2;
                        background: #fbfcfd;
                        gap: 20px;
                        flex-wrap: wrap;
                    }

                    /* grupo da direita (botoes) */
                    .acoes-toolbar {
                        display: flex;
                        gap: 12px;
                        align-items: center;
                        flex-wrap: wrap;
                    }

                    /* melhora clique e respiro */
                    .acoes-toolbar .btn {
                        min-width: 170px;
                        height: 36px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    /* filtro não esmagar */
                    #frm_filtro_por_equipamento {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        flex-wrap: wrap;
                    }

                    /* select mais bonito */
                    #equipamento_id {
                        min-width: 220px;
                    }
                </style>

                <h5><i class="bi bi-droplet-half me-2"></i> Lista de Lubrificações</h5>

                {{-- 🔹 Mensagem de sucesso --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif

                <div class="d-flex flex-wrap align-items-center justify-content-between my-3 gap-2">

                    {{-- 🔹 Filtro por equipamento --}}
                    <form id="frm_filtro_por_equipamento" action="{{ route('lubrificacao.index') }}" method="GET"
                        class="d-flex align-items-center">
                        <label for="equipamento_id" class="me-2 fw-semibold">Filtrar por Equipamento:</label>
                        <select name="equipamento_id" id="equipamento_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($equipamentos as $equipamento)
                                <option value="{{ $equipamento->id }}"
                                    {{ request('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                                    {{ $equipamento->nome }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-filter-circle me-1"></i> Filtrar
                        </button>
                    </form>

                    <div class="acoes-toolbar">
                        {{-- 🔹 Executar lubrificação --}}
                        <button type="button" class="btn btn-outline-success btn-sm"
                            onclick="abrirFormularioLubrificacao()">
                            <i class="bi bi-play-circle me-1"></i> Executar Lubrificação
                        </button>

                        {{-- 🔹 Criar nova lubrificação --}}
                        <a href="{{ route('lubrificacao.create') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Nova Lubrificação
                        </a>

                        {{-- 🔹 executadas --}}
                        <a href="{{ route('lubrificacao.executadas') }}" class="btn btn-primary">
                            Ver Lubrificações Executadas
                        </a>
                    </div>
                </div>

                {{-- 🔹 Script do botão de execução --}}
                <script>
                    function abrirFormularioLubrificacao() {
                        const equipamentoId = document.getElementById('equipamento_id').value;

                        if (!equipamentoId) {
                            alert('Selecione um equipamento primeiro!');
                            return;
                        }

                        const url = "{{ url('executar-lubrificacao') }}/" + equipamentoId;
                        window.location.href = url;
                    }
                </script>

                {{-- 🔹 Tabela --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Equipamento</th>
                                <th>Produto</th>
                                <th>Observações</th>
                                <th>Tag</th>
                                <th>Intervalo (h)</th>
                                <th>Status</th>
                                <th>Criado em</th>
                                <th>Atualizado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lubrificacoes as $lubrificacao)
                                @php
                                    $status = 'ok';
                                    $icone = '✅';
                                    $horasPassadas = null;
                                    $corFundo = '#d4edda'; // verde claro por padrão

                                    $ultimaData = $lubrificacao->atualizado_em ?? $lubrificacao->criado_em;

                                    if ($ultimaData && $lubrificacao->intervalo) {
                                        $agora = now();
                                        $horasPassadas = $agora->diffInHours($ultimaData);

                                        if ($horasPassadas > $lubrificacao->intervalo) {
                                            $status = 'atrasado';
                                            $icone = '⚠️';
                                            $corFundo = '#f8d7da'; // vermelho claro
                                        } elseif ($horasPassadas >= $lubrificacao->intervalo - 24) {
                                            $status = 'proximo';
                                            $icone = '⚠️';
                                            $corFundo = '#fff3cd'; // amarelo claro
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td data-label="Equipamento">{{ $lubrificacao->equipamento->nome ?? '-' }}</td>
                                    <td data-label="Produto">{{ $lubrificacao->produto->nome ?? '-' }}</td>
                                    <td data-label="Observações">{{ $lubrificacao->observacoes ?? '-' }}</td>
                                    <td data-label="Tag">{{ $lubrificacao->tag ?? '-' }}</td>
                                    <td data-label="Intervalo (h)">{{ $lubrificacao->intervalo ?? '-' }}</td>

                                    <td data-label="Status" style="background-color: {{ $corFundo }};"
                                        title="{{ $horasPassadas ? $horasPassadas . 'h desde a última lubrificação' : 'Sem intervalo definido' }}">
                                        {{ $icone }}
                                    </td>

                                    <td data-label="Criado em">
                                        {{ $lubrificacao->criado_em ? $lubrificacao->criado_em->format('d/m/Y H:i') : '-' }}
                                    </td>

                                    <td data-label="Atualizado em">
                                        {{ $lubrificacao->atualizado_em ? $lubrificacao->atualizado_em->format('d/m/Y H:i') : '-' }}
                                    </td>

                                    <td data-label="Ações">


                                        {{-- 🔹 Ações --}}
                                    <td>
                                        <a href="{{ route('lubrificacao.show', $lubrificacao->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Corrigido: rota de edição da tabela correta --}}
                                        <a href="{{ route('lubrificacao.edit', $lubrificacao->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('lubrificacao.destroy', $lubrificacao->id) }}"
                                            method="POST" class="d-inline-block"
                                            onsubmit="return confirm('Deseja realmente excluir esta lubrificação?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
    </main>
@endsection
