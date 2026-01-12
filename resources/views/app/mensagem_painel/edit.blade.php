@extends('app.layouts.app')

@section('title', 'Editar Mensagem')

@section('content')
<main class="content">
    <div class="container py-4">
        <h2>✏️ Editar Mensagem</h2>

        {{-- Mensagens de sucesso --}}
        @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        @endif

        {{-- Mensagens de erro --}}
        @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('mensagens.update', $mensagem->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')

            {{-- Título (opcional) --}}
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $mensagem->titulo) }}" placeholder="Título da mensagem (opcional)">
            </div>

            {{-- Mensagem --}}
            <div class="mb-3">
                <label for="mensagem" class="form-label">Mensagem <span class="text-danger">*</span></label>
                <textarea name="mensagem" id="mensagem" class="form-control" rows="4" required>{{ old('mensagem', $mensagem->mensagem) }}</textarea>
            </div>

            {{-- Tipo --}}
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="info" {{ old('tipo', $mensagem->tipo)=='info' ? 'selected' : '' }}>ℹ️ Info</option>
                    <option value="alerta" {{ old('tipo', $mensagem->tipo)=='alerta' ? 'selected' : '' }}>⚠️ Alerta</option>
                    <option value="urgente" {{ old('tipo', $mensagem->tipo)=='urgente' ? 'selected' : '' }}>❗ Urgente</option>
                </select>
            </div>

            {{-- Ativo --}}
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ativo" id="ativoSim" value="1" {{ old('ativo', $mensagem->ativo)==1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativoSim">Ativo</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ativo" id="ativoNao" value="0" {{ old('ativo', $mensagem->ativo)==0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativoNao">Inativo</label>
                </div>
            </div>

            {{-- Período de exibição --}}
            <div class="mb-3">
                <label class="form-label">Período de exibição</label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="datetime-local" name="inicio" class="form-control" value="{{ old('inicio', $mensagem->inicio ? $mensagem->inicio->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="datetime-local" name="fim" class="form-control" value="{{ old('fim', $mensagem->fim ? $mensagem->fim->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>
                <small class="text-muted">Se não informado, a mensagem será exibida sempre que estiver ativa.</small>
            </div>

            {{-- Ordem --}}
            <div class="mb-3">
                <label for="ordem" class="form-label">Ordem</label>
                <input type="number" name="ordem" id="ordem" class="form-control" value="{{ old('ordem', $mensagem->ordem) }}" placeholder="Ordem de exibição (menor aparece primeiro)">
            </div>

            {{-- Botões --}}
            <div class="mt-4">
                <a href="{{ route('mensagens.index') }}" class="btn btn-secondary me-2">⬅️ Voltar</a>
                <button type="submit" class="btn btn-success">💾 Atualizar Mensagem</button>
            </div>
        </form>
    </div>
</main>
@endsection
