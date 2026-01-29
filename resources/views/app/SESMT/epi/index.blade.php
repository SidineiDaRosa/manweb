@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">
        <h3>EPIs vinculados ao Risco: {{ $risco->nome }}</h3>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close"
                data-bs-dismiss="alert"
                aria-label="Fechar"
                style="border:none; background:none; font-size:20px; font-weight:bold;">
                &times;
            </button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ops! Verifique os campos:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close"
                data-bs-dismiss="alert"
                aria-label="Fechar"
                style="border:none; background:none; font-size:20px; font-weight:bold;">
                &times;
            </button>
        </div>
        @endif
        <a href="{{route('riscos.medidas')}}" class="btn btn-secondary mb-3">Voltar</a>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNovoEpi">
            Vincular Novo EPI
        </button>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>EPI</th>
                    <th>Status</th>
                    <th>Observações</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risco->materiais as $vinculo)
                <tr>
                    <td>{{ $vinculo->id }}</td>
                    <td>{{ $vinculo->material->nome ?? 'EPI não encontrado' }}</td>
                    <td>
                        @if($vinculo->status)
                        <span class="badge bg-success">Necessário</span>
                        @else
                        <span class="badge bg-secondary">Não usado</span>
                        @endif
                    </td>
                    <td>{{ $vinculo->observacoes ?? '-' }}</td>
                    <td>{{ $vinculo->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditarEpi{{ $vinculo->id }}">
                            Editar
                        </button>
                    </td>
                </tr>

                {{-- MODAL DO VÍNCULO --}}
                <div class="modal fade"
                    id="modalEditarEpi{{ $vinculo->id }}"
                    tabindex="-1"
                    aria-hidden="true">

                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('epis.update', $vinculo->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Editar EPI – {{ $vinculo->material->nome }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label>EPI</label>
                                        <select name="material_id" class="form-select">
                                            @foreach($materiais_epis as $epi)
                                            <option value="{{ $epi->id }}"
                                                {{ $epi->id == $vinculo->material_id ? 'selected' : '' }}>
                                                {{ $epi->nome }} | CA {{ $epi->ca }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-select">
                                            <option value="1" {{ $vinculo->status ? 'selected' : '' }}>Necessário</option>
                                            <option value="0" {{ !$vinculo->status ? 'selected' : '' }}>Não usado</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Observações</label>
                                        <textarea name="observacoes"
                                            class="form-control">{{ $vinculo->observacoes }}</textarea>
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

                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Nenhum EPI vinculado a este risco
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="modal fade" id="modalNovoEpi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('epis.store', $risco->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Vincular EPI ao Risco: {{ $risco->nome }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>EPI</label>
                            <select name="material_id" class="form-control" required>
                                <option value="">Selecione um EPI</option>
                                @foreach($materiais_epis as $epi)
                                <option value="{{ $epi->id }}">{{ $epi->nome }} | {{ $epi->descricao}} | CA: {{ $epi->ca}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="1">Necessário</option>
                                <option value="0">Não usado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Observações</label>
                            <textarea name="observacoes" class="form-control"></textarea>
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

    <script>
        public

        function update(Request $request, $id) {
            $request - > validate([
                'status' => 'required|boolean',
                'observacoes' => 'nullable|string',
            ]);

            $vinculo = RiscoMaterial::findOrFail($id);

            $vinculo - > update([
                'status' => $request - > status,
                'observacoes' => $request - > observacoes,
            ]);

            return redirect() - > back() - > with('success', 'EPI atualizado com sucesso!');
        }
    </script>

</main>
@endsection