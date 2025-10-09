@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">
        <h6>Detalhes da Lubrificação</h6>

        <div class="card mt-3">
            <div class="card-body">

                {{-- Dados da lubrificação --}}
                <div class="mb-3"><strong>ID:</strong> <span>{{ $lubrificacao->id }}</span></div>
                <div class="mb-3"><strong>Equipamento:</strong> <span>{{ $lubrificacao->equipamento->nome ?? '-' }}</span></div>
                <div class="mb-3"><strong>Produto:</strong> <span>{{ $lubrificacao->produto->nome ?? '-' }}</span></div>
                <div class="mb-3"><strong>Produção:</strong> <span>{{ $lubrificacao->producao ?? '-' }}</span></div>
                <div class="mb-3"><strong>Observações:</strong> <span>{{ $lubrificacao->observacoes ?? '-' }}</span></div>
                 <div class="mb-3"><strong>Tag:</strong> <span>{{ $lubrificacao->tag ?? '-' }}</span></div>
                <div class="mb-3"><strong>Criado em:</strong> <span>{{ $lubrificacao->criado_em ? $lubrificacao->criado_em->format('d/m/Y H:i') : '-' }}</span></div>
                <div class="mb-3"><strong>Atualizado em:</strong> <span>{{ $lubrificacao->atualizado_em ? $lubrificacao->atualizado_em->format('d/m/Y H:i') : '-' }}</span></div>

                <div class="mt-4">
                    <a href="{{ route('lubrificacao.index') }}" class="btn btn-secondary">Voltar</a>
                    <a href="{{ route('lubrificacao.edit', $lubrificacao->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('lubrificacao.destroy', $lubrificacao->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir esta lubrificação?')">Excluir</button>
                    </form>
                    <a href="{{ route('lubrificacoes-executadas.index', $lubrificacao->id) }}" class="btn btn-warning">Executadas</a>
                </div>
            </div>
        </div>

        {{-- Lista de Tipos de Medição --}}
        <div class="card mt-4" hidden>
            <div class="card-header d-flex justify-content-between align-items-center" hidden>
                <span>Tipos de Intervalos</span>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMedicaoModal">Adicionar</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lubrificacao_intervalos as $medicao)
                        <tr>
                            <td>{{ $medicao->id }}</td>
                            <td>{{ $medicao->tipo }}</td>
                            <td>{{ $medicao->valor }}</td>
                            <td>
                                {{-- Aqui você pode colocar editar/excluir --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal para adicionar nova medição --}}
        <div class="modal fade" id="addMedicaoModal" tabindex="-1" aria-labelledby="addMedicaoModalLabel" aria-hidden="true" hidden>
            <div class="modal-dialog">
                <form action="{{ route('medicao.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lubrificacao_id" value="{{ $lubrificacao->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMedicaoModalLabel">Adicionar Medição</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo de Medição</label>
                                <select name="tipo" id="tipo" class="form-select" required>
                                    <option value="">Selecione</option>
                                    @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="valor" class="form-label">Valor</label>
                                <input type="number" step="0.01" name="valor" id="valor" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (necessário para modais) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</main>
@endsection