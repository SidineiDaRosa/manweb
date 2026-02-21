@extends('app.layouts.app')

@section('content')

<main class="content">
    <div class="card shadow-sm">

        <div class="card-body">
            <button class="btn-inf btn-inf-md btn-inf-blue-dark" data-bs-toggle="modal" data-bs-target="#modalFailure">
                Nova Falha
            </button>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Nome</th>
                            <th>Subcategorias</th>

                            <th style="width:150px;">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($failures as $failure)
                        <tr>
                            <td class="text-center">{{ $failure->id }}</td>

                            <td> <span style="font-weight: 600;color:rgba(1,1,1,0.5)">{{ $failure->name }} <br>

                                </span>
                                {{ $failure->description ?? '-' }} <br>
                                <div class="d-flex justify-content-center gap-2">

                                    <button
                                        class="btn-inf btn-inf-md btn-inf-warning btnEditar"
                                        data-id="{{ $failure->id }}"
                                        data-name="{{ $failure->name }}"
                                        data-description="{{ $failure->description }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarFailure">
                                        Editar
                                    </button>

                                    <button class="btn-inf btn-inf-md btn-inf-red">
                                        Excluir
                                    </button>

                                </div>
                            </td>
                            <td>
                                @foreach($failuresSubcategories as $failuresSubcategorie)
                                @if($failuresSubcategorie->machine_failure_id == $failure->id)
                                <div style="width:100;border:solid rgb(1,1,1,0.2) 0.5px;border-radius:10px;display:flex;flex-direction:row;margin:5px;;">
                                    <div style="width:80%;padding:5px;">
                                        {{$failuresSubcategorie->name}}
                                    </div>
                                    <div style="float:right;display:flex;margin-right:10px;">
                                        <button    class="btn-inf btn-inf-sm btn-inf-blue-dark">Editar</button>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Nenhuma falha cadastrada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="modal fade" id="modalFailure" tabindex="-1" aria-labelledby="modalFailureLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('failures.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFailureLabel">Cadastrar Nova Falha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text"
                                name="name"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="description"
                                class="form-control"
                                rows="3"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button"
                            class="btn-inf btn-inf-md btn-inf-red"
                            data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="btn-inf btn-inf-md btn-inf-green">
                            Salvar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditarFailure" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" id="formEditarFailure">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Falha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text"
                                name="name"
                                id="edit_name"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="description"
                                id="edit_description"
                                class="form-control"
                                rows="3"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button"
                            class="btn-inf btn-inf-md btn-inf-red"
                            data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="btn-inf btn-inf-md btn-inf-green">
                            Atualizar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const botoesEditar = document.querySelectorAll('.btnEditar');

            botoesEditar.forEach(botao => {
                botao.addEventListener('click', function() {

                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description');

                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_description').value = description;

                    // Ajusta a action dinamicamente
                    document.getElementById('formEditarFailure').action =
                        '/failures-update/' + id;

                });
            });

        });
    </script>
</main>

@endsection