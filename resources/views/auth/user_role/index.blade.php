{{-- resources/views/user_roles/index.blade.php --}}

@extends('app.layouts.app')

@section('content')
    <main class="content">


        <div class="container">
            <h1 class="mb-4">Lista de User Roles</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('user_roles.create') }}" class="btn btn-primary mb-3">Novo Role</a>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Usuário</th>
                        <th>Nível</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->nome }}</td>
                            <td>{{ $role->descricao ?? '-' }}</td>
                            <td>{{ $role->user->name ?? '-' }}</td>
                            <td>{{ $role->level ?? '-' }}</td>
                            <td>
                                <a href="{{ route('user_roles.show', $role->id) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('user_roles.edit', $role->id) }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('user_roles.destroy', $role->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Deseja realmente excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" disabled>Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum role encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
</main>
