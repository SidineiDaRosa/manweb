@extends('app.layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Editar Projeto</h1>

    <form action="{{ route('projetos.update', $projeto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $projeto->nome) }}" required>
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao', $projeto->descricao) }}</textarea>
            @error('descricao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="data_inicio" class="form-label">Data de Início</label>
            <input type="date" name="data_inicio" id="data_inicio" class="form-control @error('data_inicio') is-invalid @enderror" value="{{ old('data_inicio', $projeto->data_inicio) }}">
            @error('data_inicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="data_fim" class="form-label">Data de Fim</label>
            <input type="date" name="data_fim" id="data_fim" class="form-control @error('data_fim') is-invalid @enderror" value="{{ old('data_fim', $projeto->data_fim) }}">
            @error('data_fim')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                <option value="ativo" {{ old('status', $projeto->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="concluido" {{ old('status', $projeto->status) == 'concluido' ? 'selected' : '' }}>Concluído</option>
                <option value="cancelado" {{ old('status', $projeto->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="responsavel_id" class="form-label">Responsável</label>
            <select name="responsavel_id" id="responsavel_id" class="form-control @error('responsavel_id') is-invalid @enderror">
                <option value="">Selecione</option>
                @foreach($funcionarios as $func)
                    <option value="{{ $func->id }}" {{ old('responsavel_id', $projeto->responsavel_id) == $func->id ? 'selected' : '' }}>
                        {{ $func->primeiro_nome }} {{ $func->ultimo_nome }}
                    </option>
                @endforeach
            </select>
            @error('responsavel_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('projetos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
