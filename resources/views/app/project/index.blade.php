@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ordens de Serviço</h1>

    <a href="{{ route('ordens_servicos.create') }}" class="btn btn-primary mb-3">Nova Ordem</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Status</th>
                <th>Projeto</th>
                <th>Data Abertura</th>
                <th>Data Fechamento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordens as $ordem)
                <tr>
                    <td>{{ $ordem->id }}</td>
                    <td>{{ $ordem->titulo }}</td>
                    <td>{{ ucfirst($ordem->status) }}</td>
                    <td>{{ $ordem->projeto ? $ordem->projeto->nome : '-' }}</td>
                    <td>{{ $ordem->data_abertura }}</td>
                    <td>{{ $ordem->data_fechamento ?? '-' }}</td>
                    <td>
                        <a href="{{ route('ordens_servicos.edit', $ordem->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('ordens_servicos.destroy', $ordem->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
