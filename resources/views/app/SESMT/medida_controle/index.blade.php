@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">
        <h3>Medidas do Risco: {{ $risco->nome }}</h3>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('riscos.medidas') }}" class="btn btn-secondary mb-3">Voltar</a>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNovaMedida">
            Nova Medida
        </button>

        {{-- TABELA --}}
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Criado em</th>
                    <th width="150">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risco->medidas as $medida)
                <tr>
                    <td>{{ $medida->id }}</td>
                    <td>{{ $medida->descricao }}</td>
                    <td>{{ $medida->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning"
                            onclick='editarMedida(@json($medida))'>
                            Editar
                        </button>

                        <button class="btn btn-sm btn-danger">
                            Excluir
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Nenhuma medida cadastrada para este risco
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL NOVA MEDIDA --}}
    <div class="modal fade" id="modalNovaMedida" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('riscos.medidas.store', $risco->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Medida para: {{ $risco->nome }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="risco_id" value="{{ $risco->id }}">

                        <div class="mb-3">
                            <label>Descrição da Medida</label>
                            <textarea name="descricao" class="form-control" required></textarea>
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

    {{-- MODAL EDITAR MEDIDA --}}
    <div class="modal fade" id="modalEditarMedidaRisco" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('risco_medidas.update') }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="medida_id">
                <input type="hidden" name="risco_id" value="{{ $risco->id }}">

                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Editar Medida de Controle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Descrição da Medida</label>
                            <textarea name="descricao" id="medida_descricao" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-warning">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</main>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function editarMedida(medida) {
        document.getElementById('medida_id').value = medida.id;
        document.getElementById('medida_descricao').value = medida.descricao;

        let modal = new bootstrap.Modal(document.getElementById('modalEditarMedidaRisco'));
        modal.show();
    }
</script>

@endsection