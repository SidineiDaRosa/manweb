@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">
        <h3>Riscos Cadastrados</h3>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNovoRisco">
            Novo Risco
        </button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riscos as $risco)
                <tr>
                    <td>{{ $risco->id }}</td>
                    <td>{{ $risco->tipo_risco }}</td>
                    <td>{{ $risco->nome }}</td>
                    <td>{{ Str::limit($risco->descricao, 50) }}</td>
                    <td>
                        Norma NR
                        <a href="{{ $risco->link_item }}" target="_blank">
                            <i class="bi bi-arrow-up-right-square"></i>
                        </a>
                    </td>
                    <td>{{ $risco->ativo ? 'Ativo' : 'Inativo' }}</td>
                    <td>
                        <div>
                            <button class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#modalRisco"
                                data-id="{{ $risco->id }}"
                                data-tipo="{{ $risco->tipo_risco }}"
                                data-nome="{{ $risco->nome }}"
                                data-descricao="{{ $risco->descricao }}"
                                data-link-item="{{ $risco->link_item }}"
                                data-status="{{ $risco->ativo ? 'Ativo' : 'Inativo' }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarRisco"
                                data-id="{{ $risco->id }}"
                                data-tipo="{{ $risco->tipo_risco }}"
                                data-nome="{{ $risco->nome }}"
                                data-descricao="{{ $risco->descricao }}"
                                data-ativo="{{ $risco->ativo }}"
                                data-link-item="{{ $risco->link_item }}">
                                <i class="bi bi-pencil-fill"></i>

                            </button>
                        </div>

                        <div>
                            <a href="{{ route('riscos.medidas.index', $risco->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi-exclamation-triangle-fill"></i> Medidas de Controle do Risco
                            </a>
                            <a href="{{ route('epis_index', $risco->id) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-cone-striped"></i> EPIs Vinculado ao Risco
                            </a>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal -->
    <div class="modal fade" id="modalRisco" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes do Risco</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="m_id"></span></p>
                    <p><strong>Tipo:</strong> <span id="m_tipo"></span></p>
                    <p><strong>Nome:</strong> <span id="m_nome"></span></p>
                    <p><strong>Descrição:</strong></p>
                    <p id="m_descricao"></p>
                     <p><strong>link_NR:</strong></p>
                    <p id="m_link_item"></p>
                    <p><strong>Status:</strong> <span id="m_status"></span></p>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!--Visualização-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalRisco');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                document.getElementById('m_id').textContent = button.getAttribute('data-id');
                document.getElementById('m_tipo').textContent = button.getAttribute('data-tipo');
                document.getElementById('m_nome').textContent = button.getAttribute('data-nome');
                document.getElementById('m_descricao').textContent = button.getAttribute('data-descricao');
                 document.getElementById('m_link_item').textContent = button.getAttribute('data-link_item');
                document.getElementById('m_status').textContent = button.getAttribute('data-status');
            });
        });
    </script>
    <!--Envia edição-->
    <div class="modal fade" id="modalEditarRisco" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="formEditarRisco">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Risco</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-3">
                            <label>Tipo</label>
                            <input type="text" class="form-control" name="tipo_risco" id="edit_tipo">
                        </div>

                        <div class="mb-3">
                            <label>Nome</label>
                            <input type="text" class="form-control" name="nome" id="edit_nome">
                        </div>

                        <div class="mb-3">
                            <label>Descrição</label>
                            <textarea class="form-control" name="descricao" id="edit_descricao"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Local de referência da Norma</label>
                            <textarea  class="form-control" name="link_item" id="edit_link_item"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select class="form-control" name="ativo" id="edit_ativo">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEditar = document.getElementById('modalEditarRisco');

            modalEditar.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_tipo').value = button.getAttribute('data-tipo');
                document.getElementById('edit_nome').value = button.getAttribute('data-nome');
                document.getElementById('edit_descricao').value = button.getAttribute('data-descricao');
                document.getElementById('edit_ativo').value = button.getAttribute('data-ativo');
                document.getElementById('edit_link_item').value = button.getAttribute('data-link-item');


                // Ajusta a action do form dinamicamente
                document.getElementById('formEditarRisco').action = `/riscos/${id}`;
            });
        });
    </script>
    <!--  Novo risco-->
    <div class="modal fade" id="modalNovoRisco" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('riscos.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Novo Risco</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Tipo</label>
                            <input type="text" name="tipo_risco" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Descrição</label>
                            <textarea name="descricao" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Local de referência da Norma</label>
                            <textarea type="text" class="form-control" name="link_item" id="link_item"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="ativo" class="form-control" required>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    

</main>
@endsection