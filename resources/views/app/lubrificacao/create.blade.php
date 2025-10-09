@extends('app.layouts.app')

@section('titulo', 'Nova Lubrificação')

@section('content')
<main class="content">
    <div class="container">
        <h6>Nova Lubrificação</h6>

        <a href="{{ route('lubrificacao.index') }}" class="btn btn-secondary mb-3">Voltar</a>

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

        <form action="{{ route('lubrificacao.store') }}" method="POST">
            @csrf

            {{-- Equipamento --}}
            <div class="mb-3">
                <label for="equipamento_id" class="form-label">Equipamento</label>
                <select name="equipamento_id" id="equipamento_id" class="form-control" required>
                    <option value="">Selecione o equipamento</option>
                    @foreach($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}" {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                        {{ $equipamento->nome }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Produto --}}
            <div class="mb-3">
                <label for="produto_id" class="form-label">Produto</label>
                <select name="produto_id" id="produto_id" class="form-control" required>
                    <option value="">Selecione o produto</option>
                    @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                        {{ $produto->nome }}
                    </option>
                    @endforeach
                </select>
            </div>


            {{-- Observações --}}
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea
                    name="observacoes"
                    id="observacoes"
                    class="form-control"
                    rows="3"
                    placeholder="Digite observações, se houver" required>{{ old('observacoes') }}</textarea>
            </div>
            {{-- Observações --}}
            <div class="mb-3">

                <label for="observacoes" class="form-label">Tag</label>

                <input type="text" name="tag"
                    id="tag"
                    class="form-control" required>
            </div>
            <div class="mb-3">

                <label for="observacoes" class="form-label">Intervalo em hs</label>

                <input type="text" name="intervalo"
                    id="intervalo"
                    class="form-control"required>
            </div>
            <button type="submit" class="btn btn-primary" >Salvar</button>
        </form>
    </div>
</main>
@endsection