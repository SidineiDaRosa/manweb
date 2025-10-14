@extends('app.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Projetos</h1>

    <a href="{{ route('projetos.create') }}" class="btn btn-primary mb-3">Novo Projeto</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Responsável</th>
                <th>Data de Início</th>
                <th>Data de Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projetos as $projeto)
                <tr>
                    <td>{{ $projeto->id }}</td>
                    <td>{{ $projeto->nome }}</td>
                    <td>
                        <span class="badge 
                            @if($projeto->status == 'ativo') bg-success
                            @elseif($projeto->status == 'concluido') bg-primary
                            @elseif($projeto->status == 'cancelado') bg-danger
                            @endif">
                            {{ ucfirst($projeto->status) }}
                        </span>
                    </td>
                    <td>{{ $projeto->responsavel ? $projeto->responsavel->primeiro_nome . ' ' . $projeto->responsavel->ultimo_nome : '-' }}</td>
                    <td>{{ $projeto->data_inicio ? \Carbon\Carbon::parse($projeto->data_inicio)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $projeto->data_fim ? \Carbon\Carbon::parse($projeto->data_fim)->format('d/m/Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('projetos.show', $projeto->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('projetos.edit', $projeto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir este projeto?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Nenhum projeto encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
