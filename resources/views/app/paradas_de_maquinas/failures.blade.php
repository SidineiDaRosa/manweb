@extends('app.layouts.app')
@include('app.paradas_de_maquinas.partials.modal_create_failures_subcategory')
@include('app.paradas_de_maquinas.partials.modal_edit_failures_subcategory')
@section('content')

<main class="content">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;">
            &times;
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;">
            &times;
        </button>
    </div>
    @endif
    <div class="card shadow-sm">

        <div class="card-body">
            <button class="btn-inf btn-inf-md btn-inf-blue-dark" data-bs-toggle="modal" data-bs-target="#modalFailure">
                Nova Falha
            </button>

            <div class="table-responsive">
                <table class="table table-hover table-bordered-none align-middle">

                    <thead class="table text-left" style="color:rgb(1,1,1,0.4)">
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Nome</th>
                            <th>Subcategorias</th>
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
                                        Editar Falha
                                    </button>

                                    <button class="btn-inf btn-inf-md btn-inf-red">
                                        Excluir Falha
                                    </button>

                                </div>
                            </td>
                            <td>
                                <div style="border: solid 0.5px rgb(1,1,1,0.2);padding:5px;border-radius:10px;">
                                    <div style="float:right;display:flex;margin-right:10px;">
                                        <button class="btn-inf btn-inf-sm btn-inf-blue-dark btn-create-subcategory"
                                            data-id="{{ $failure->id }}"
                                            data-name="{{ $failure->name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalCreateSubcategory">
                                            Nova Subcategoria
                                        </button>
                                    </div>
                                    {{--SUBCATEGORIAS--}}
                                    @foreach($failuresSubcategories as $failuresSubcategorie)
                                    @if($failuresSubcategorie->machine_failure_id == $failure->id)
                                    <div style="width:100%;display:flex;flex-direction:row;margin:5px;;">

                                        <div style="width:80%;padding:10px;">
                                            {{$failuresSubcategorie->name}}
                                        </div>
                                        <div style="float:right;display:flex;margin-right:10px;">
                                            <button
                                                class="btn-inf btn-inf-sm btn-inf-warning btn-edit-subcategory"
                                                data-id="{{ $failuresSubcategorie->id }}"
                                                data-name="{{ $failuresSubcategorie->name }}"
                                                data-description="{{ $failuresSubcategorie->description }}"
                                                data-category="{{ $failuresSubcategorie->category_id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditSubcategory">
                                                Editar
                                            </button>
                                        </div>

                                    </div>
                                    @endif
                                    @endforeach
                                </div>
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
    <input type="text" id="teste-id">
    <script>
        const modal = document.getElementById('modalEditarFailure');

        modal.addEventListener('show.bs.modal', function(event) {

            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description ?? '';

            // 🔥 Define a rota dinamicamente
            document.getElementById('formEditarFailure').action =
                `/failures-update/${id}`;
        });
    </script>
</main>

@endsection