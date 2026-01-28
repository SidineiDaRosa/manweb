@extends('app.layouts.app')

@section('content')
<main class="content">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">

        {{-- TÍTULO + BOTÃO --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-geo-alt-fill me-2"></i> Locais / Setores
            </h4>

            <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalAreaLoca">
                <i class="bi bi-plus-circle me-1"></i> Novo Local
            </button>

        </div>

        {{-- ALERTA --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- TABELA --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locais as $local)
                            <tr>
                                <td>{{ $local->id }}</td>
                                <td class="fw-bold">{{ $local->nome }}</td>
                                <td>{{ $local->descricao ?? '-' }}</td>
                                <td>
                                    @if($local->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                    @else
                                    <span class="badge bg-secondary">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-end">

                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="abrirModalEditar({{ $local }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('locais.destroy', $local->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Deseja realmente excluir este local?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Nenhum local cadastrado.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
    <!-- MODAL CADASTRO DE ÁREA / LOCAL -->
    <div class="modal fade" id="modalAreaLoca" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('locais.store') }}" method="POST">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-geo-alt-fill me-2"></i> Novo Local / Área
                        </h5>
                        <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        {{-- NOME --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text"
                                name="nome"
                                class="form-control"
                                placeholder="Ex: Almoxarifado"
                                required>
                        </div>

                        {{-- DESCRIÇÃO --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição</label>
                            <textarea name="descricao"
                                class="form-control"
                                rows="3"
                                placeholder="Descrição do local (opcional)"></textarea>
                        </div>

                        {{-- STATUS --}}
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                name="ativo"
                                id="ativo"
                                checked>
                            <label class="form-check-label" for="ativo">
                                Ativo
                            </label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Salvar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-- MODAL EDITAR LOCAL -->
    <div class="modal fade" id="modalEditarLocal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="formEditarLocal" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-square me-2"></i> Editar Local
                        </h5>
                        <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        {{-- NOME --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text"
                                name="nome"
                                id="edit_nome"
                                class="form-control"
                                required>
                        </div>

                        {{-- DESCRIÇÃO --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição</label>
                            <textarea name="descricao"
                                id="edit_descricao"
                                class="form-control"
                                rows="3"></textarea>
                        </div>

                        {{-- STATUS --}}
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                name="ativo"
                                id="edit_ativo">
                            <label class="form-check-label" for="edit_ativo">
                                Ativo
                            </label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-warning">
                            Atualizar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <script>
        function abrirModalEditar(local) {

            // Preenche os campos
            document.getElementById('edit_nome').value = local.nome;
            document.getElementById('edit_descricao').value = local.descricao ?? '';
            document.getElementById('edit_ativo').checked = local.ativo == 1;

            // Ajusta a action do form
            let form = document.getElementById('formEditarLocal');
            form.action = `/locais/${local.id}`;

            // Abre a modal
            let modal = new bootstrap.Modal(document.getElementById('modalEditarLocal'));
            modal.show();
        }
    </script>


</main>
@endsection