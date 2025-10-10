@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container mt-4">

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
                    @foreach($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}" {{ request('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                        {{ $equipamento->nome }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-filter-circle me-1"></i> Filtrar
                </button>
            </form>

            <div class="d-flex flex-wrap gap-2">
                {{-- 🔹 Executar lubrificação --}}
                <button type="button" class="btn btn-outline-success btn-sm" onclick="abrirFormularioLubrificacao()">
                    <i class="bi bi-play-circle me-1"></i> Executar Lubrificação
                </button>

                {{-- 🔹 Criar nova lubrificação --}}
                <a href="{{ route('lubrificacao.create') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Nova Lubrificação
                </a>

                {{-- 🔹 executadas--}}
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
                    @foreach($lubrificacoes as $lubrificacao)
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
                        <td>{{ $lubrificacao->id }}</td>
                        <td>{{ $lubrificacao->equipamento->nome ?? '-' }}</td>
                        <td>{{ $lubrificacao->produto->nome ?? '-' }}</td>
                        <td>{{ $lubrificacao->observacoes ?? '-' }}</td>
                        <td>{{ $lubrificacao->tag ?? '-' }}</td>
                        <td>{{ $lubrificacao->intervalo ?? '-' }}</td>

                        {{-- 🔹 Status --}}
                        <td style="background-color: {{ $corFundo }};"
                            title="{{ $horasPassadas ? $horasPassadas.'h desde a última lubrificação' : 'Sem intervalo definido' }}">
                            {{ $icone }}
                        </td>

                        <td>{{ $lubrificacao->criado_em ? $lubrificacao->criado_em->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $lubrificacao->atualizado_em ? $lubrificacao->atualizado_em->format('d/m/Y H:i') : '-' }}</td>

                        {{-- 🔹 Ações --}}
                        <td>
                            <a href="{{ route('lubrificacao.show', $lubrificacao->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>

                            {{-- Corrigido: rota de edição da tabela correta --}}
                            <a href="{{ route('lubrificacao.edit', $lubrificacao->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('lubrificacao.destroy', $lubrificacao->id) }}" method="POST"
                                class="d-inline-block" onsubmit="return confirm('Deseja realmente excluir esta lubrificação?')">
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