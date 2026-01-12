@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">

        {{-- TÍTULO --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>📢 Mensagens do Painel</h4>

            <a href="{{ route('mensagens.create') }}" class="btn btn-primary">
                ➕ Nova Mensagem
            </a>
        </div>

        {{-- ALERTA DE SUCESSO --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- TABELA --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Mensagem</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Período</th>
                            <th>Ordem</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mensagens as $mensagem)
                        <tr>
                            <td>{{ $mensagem->id }}</td>

                            <td>{{ $mensagem->titulo ?? '-' }}</td>

                            <td style="max-width: 400px;">
                                {{ Str::limit($mensagem->mensagem, 120) }}
                            </td>

                            <td>
                                @if($mensagem->tipo === 'info')
                                <span class="badge bg-primary">Info</span>
                                @elseif($mensagem->tipo === 'alerta')
                                <span class="badge bg-warning text-dark">Alerta</span>
                                @else
                                <span class="badge bg-danger">Urgente</span>
                                @endif
                            </td>

                            <td>
                                @if($mensagem->ativo)
                                <span class="badge bg-success">Ativa</span>
                                @else
                                <span class="badge bg-secondary">Inativa</span>
                                @endif
                            </td>

                            <td>
                                <small>
                                    {{ $mensagem->inicio ? $mensagem->inicio->format('d/m/Y H:i') : '—' }}
                                    <br>
                                    {{ $mensagem->fim ? $mensagem->fim->format('d/m/Y H:i') : '—' }}
                                </small>
                            </td>

                            <td>{{ $mensagem->ordem }}</td>

                            <td class="text-end">
                              
                                <a href="{{ route('mensagens.edit', $mensagem->id) }}">  ✏️</a>
                                <form action="{{ route('mensagens.destroy', $mensagem) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Deseja remover esta mensagem?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Nenhuma mensagem cadastrada
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
@endsection