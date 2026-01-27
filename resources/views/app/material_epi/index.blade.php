@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">
        <h3 class="mb-4">Lista de Materiais / EPIs</h3>

        {{-- Mensagens de sucesso --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;">
                &times;
            </button>
        </div>
        @endif



        {{-- Botão para criar novo material --}}
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoMaterial">
            Cadastrar Novo Material / EPI
        </button>

        {{-- Tabela de materiais --}}
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>CA</th>
                    <th>Validade</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materiais as $material)
                {{-- Linha principal do material --}}
                <tr class="table-primary">
                    <td>{{ $material->id }}</td>
                    <td>{{ $material->nome }}</td>
                    <td>{{ $material->tipo }}</td>
                    <td>{{ $material->ca }}</td>
                    <td>{{ $material->validade ? \Carbon\Carbon::parse($material->validade)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $material->quantidade_estoque }}</td>
                    <td>
                        @if($material->status == 1)
                        <span class="badge bg-success">Ativo</span>
                        @else
                        <span class="badge bg-secondary">Inativo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('material_epis.show', $material->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <!-- Botão Editar atualizado -->
                        <button
                            class="btn btn-sm btn-warning btnEditarMaterial"
                            data-id="{{ $material->id }}"
                            data-nome="{{ $material->nome }}"
                            data-tipo="{{ $material->tipo }}"
                            data-ca="{{ $material->ca }}"
                            data-validade="{{ $material->validade ? $material->validade : '' }}"
                            data-quantidade="{{ $material->quantidade_estoque }}"
                            data-status="{{ $material->status }}">
                            Editar
                        </button>
                        <form action="{{ route('material_epis.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente excluir este material?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>

                {{-- Linhas de riscos vinculados --}}
                @foreach($materiais_risco->where('material_id', $material->id) as $materialRisco)
                <tr class="table-light">
                    <td colspan="2" class="text-end"><strong>Risco associado Material:</strong></td>
                    <td colspan="6">
                        {{ $materialRisco->risco->nome ?? '' }} {{-- Aqui pegamos o nome do risco --}}

                        @if($materialRisco->status == 1)
                        <span class="badge bg-success">Ativo</span>
                        @else
                        <span class="badge bg-secondary">Inativo</span>
                        @endif

                        @if(!empty($materialRisco->observacoes))
                        - {{ $materialRisco->observacoes }}
                        @endif
                    </td>
                </tr>
                @endforeach


                @empty
                <tr>
                    <td colspan="8" class="text-center">Nenhum material / EPI cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Antes do fechamento do body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="modal fade" id="modalNovoMaterial" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('material_epis.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Novo Material / EPI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <option value="EPI">EPI</option>
                                    <option value="Ferramenta">Ferramenta</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">CA</label>
                                <input type="text" name="ca" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Validade</label>
                                <input type="date" name="validade" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Quantidade</label>
                                <input type="number" name="quantidade_estoque" class="form-control" required min="0">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" selected>Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Editar Material / EPI -->
    <div class="modal fade" id="modalEditarMaterial" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- O action será definido dinamicamente via JS -->
                <form id="formEditarMaterial" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Material / EPI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" id="editNome" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" id="editTipo" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <option value="EPI">EPI</option>
                                    <option value="Ferramenta">Ferramenta</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">CA</label>
                                <input type="text" name="ca" id="editCa" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Validade</label>
                                <input type="date" name="validade" id="editValidade" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Quantidade</label>
                                <input type="number" name="quantidade_estoque" id="editQuantidade" class="form-control" required min="0">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="editStatus" class="form-control">
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const editarModal = new bootstrap.Modal(document.getElementById('modalEditarMaterial'));

        document.querySelectorAll('.btnEditarMaterial').forEach(btn => {
            btn.addEventListener('click', function() {
                // Pegando os dados do botão
                const id = this.dataset.id;
                const nome = this.dataset.nome;
                const tipo = this.dataset.tipo;
                const ca = this.dataset.ca;
                const validade = this.dataset.validade;
                const quantidade = this.dataset.quantidade;
                const status = this.dataset.status;

                // Preenchendo a modal
                document.getElementById('editNome').value = nome;
                document.getElementById('editTipo').value = tipo;
                document.getElementById('editCa').value = ca;
                document.getElementById('editValidade').value = validade;
                document.getElementById('editQuantidade').value = quantidade;
                document.getElementById('editStatus').value = status;

                // Atualizando a action do formulário
                document.getElementById('formEditarMaterial').action = `/material_epis/${id}`;

                // Abrindo a modal
                editarModal.show();
            });
        });
    </script>


</main>
@endsection