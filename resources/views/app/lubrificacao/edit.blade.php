@extends('app.layouts.app')

@section('titulo', 'Editar Lubrificação')

@section('content')
<main class="content">
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5><i class="bi bi-pencil-square me-2"></i> Editar Lubrificação</h5>
            <a href="{{ route('lubrificacao.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        {{-- Exibe erros de validação --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm p-4 rounded-3">
            <form action="{{ route('lubrificacao.update', $lubrificacao->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Equipamento --}}
                <div class="mb-3">
                    <label for="equipamento_id" class="form-label fw-semibold">Equipamento</label>
                    <select name="equipamento_id" id="equipamento_id" class="form-control" required>
                        <option value="">Selecione o equipamento</option>
                        @foreach($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}"
                                {{ old('equipamento_id', $lubrificacao->equipamento_id) == $equipamento->id ? 'selected' : '' }}>
                                {{ $equipamento->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Produto --}}
                <div class="mb-3">
                    <label for="produto_id" class="form-label fw-semibold">Produto</label>
                    <select name="produto_id" id="produto_id" class="form-control" required>
                        <option value="">Selecione o produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}"
                                {{ old('produto_id', $lubrificacao->produto_id) == $produto->id ? 'selected' : '' }}>
                                {{ $produto->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tag --}}
                <div class="mb-3">
                    <label for="tag" class="form-label fw-semibold">Tag</label>
                    <input type="text" name="tag" id="tag" class="form-control"
                           value="{{ old('tag', $lubrificacao->tag) }}" required>
                </div>

                {{-- Intervalo em horas --}}
                <div class="mb-3">
                    <label for="intervalo" class="form-label fw-semibold">Intervalo (em horas)</label>
                    <input type="number" name="intervalo" id="intervalo" class="form-control"
                           value="{{ old('intervalo', $lubrificacao->intervalo) }}" min="1" required>
                </div>

                {{-- Observações --}}
                <div class="mb-3">
                    <label for="observacoes" class="form-label fw-semibold">Observações</label>
                    <textarea name="observacoes" id="observacoes" class="form-control" rows="3"
                              placeholder="Digite observações, se houver">{{ old('observacoes', $lubrificacao->observacoes) }}</textarea>
                </div>

                {{-- Botão --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
