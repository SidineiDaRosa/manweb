@extends('app.layouts.app')

@section('titulo', 'Categoria')

@section('content')
<main class="content">
    <div class="card p-3">

        <h2>Categoria: {{ $categoria->nome }}</h2>
        <p>{{ $categoria->descricao }}</p>

        <!-- Botão para abrir modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#criarFamiliaModal">
            Criar Nova Família
        </button>

        <h3>Famílias desta categoria</h3>
        @if($familias->count() > 0)
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($familias as $familia)
                        <tr>
                            <td>{{ $familia->id }}</td>
                            <td>{{ $familia->nome }}</td>
                            <td>{{ $familia->descricao }}</td>
                            <td>{{ $familia->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $familia->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('familia.edit', $familia->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                <form action="{{ route('familia.destroy', $familia->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nenhuma família cadastrada nesta categoria.</p>
        @endif

        <a href="{{ route('categoria.index') }}" class="btn btn-secondary mt-3">Voltar</a>

    </div>
</main>

<!-- Modal de criação -->
<div class="modal fade" id="criarFamiliaModal" tabindex="-1" aria-labelledby="criarFamiliaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('familia.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="criarFamiliaModalLabel">Criar Nova Família</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="categoria_id" value="{{ $categoria->id }}">
            
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- CSS do Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- JS do Bootstrap (precisa do Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
