@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">
        <h6>Lista de Lubrificações</h6>

        <div class="d-flex justify-content-between mb-3">
            <!-- Formulário de filtro -->
            <form id="frm_filtro_por_equipamento" action="{{ route('lubrificacao.index') }}" method="GET" class="d-flex align-items-center">
                <label for="equipamento_id" class="me-2">Filtrar por Equipamento:</label>
                <select name="equipamento_id" id="equipamento_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}" {{ request('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                        {{ $equipamento->nome }}
                    </option>
                    @endforeach
                </select>
            </form>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('frm_filtro_por_equipamento').submit();">
                Filtrar
            </button>
            <button type="button" class="btn btn-success" onclick="abrirFormularioLubrificacao()">Executar lubrificação</button>

            <script>
                function abrirFormularioLubrificacao() {
                    const equipamentoId = document.getElementById('equipamento_id').value;

                    if (!equipamentoId) {
                        alert('Selecione um equipamento primeiro!');
                        return;
                    }

                    // Monta a rota dinamicamente
                    const url = "{{ url('executar-lubrificacao') }}/" + equipamentoId;

                    // Abre o formulário em uma nova aba (ou modal, se quiser)
                    window.location.href = url;
                }
            </script>
            <!-- Botão de criar nova lubrificação -->
            <a href="{{ route('lubrificacao.create') }}" class="btn btn-success">
                <i class="fas fa-oil-can"></i>
                Nova Lubrificação
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Equipamento</th>
                    <th>Produto</th>
                    <th>Observações</th>
                    <th>Tag</th>
                    <th>intervalo</th>
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

                // Pega a última data (atualizado_em ou criado_em)
                $ultimaData = $lubrificacao->atualizado_em ?? $lubrificacao->criado_em;

                if ($ultimaData && $lubrificacao->intervalo) {
                $agora = now();

                // Calcula quantas horas se passaram desde a última data
                $horasPassadas = $agora->diffInHours($ultimaData);

                // Compara com o intervalo
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

                    <!-- Status com ícone e cor de fundo -->
                    <td class="text-center"
                        style="background-color: {{ $corFundo }};"
                        title="{{ $horasPassadas !== null ? $horasPassadas.'h desde a última lubrificação' : 'Sem intervalo definido' }}">
                        {{ $icone }}
                    </td>

                    <td>{{ $lubrificacao->criado_em ? $lubrificacao->criado_em->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $lubrificacao->atualizado_em ? $lubrificacao->atualizado_em->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        <a href="{{ route('lubrificacao.show', $lubrificacao->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('lubrificacao.edit', $lubrificacao->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('lubrificacao.destroy', $lubrificacao->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir esta lubrificação?')">Excluir</button>
                        </form>
                        <a href="{{ route('lubrificacao.executar.externo', $lubrificacao->id) }}"
                            class="btn btn-sm btn-success" target="_blank">
                            <i class="fas fa-play"></i> Executar
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</main>
@endsection