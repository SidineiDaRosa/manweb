@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">
        <h3 class="mb-4">Lista de Materiais / EPIs</h3>

        {{-- Mensagens de sucesso --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Botão para criar novo material --}}
        <div class="mb-3">
            <a href="{{ route('material_epis.create') }}" class="btn btn-primary">Cadastrar Novo Material / EPI</a>
        </div>

        {{-- Tabela de materiais --}}
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>CA</th>
                    <th>Validade</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materiais as $material)
                {{-- Linha principal do material --}}
                <tr class="table-primary">
                    <td>{{ $material->id }}</td>
                    <td>{{ $material->nome }}</td>
                    <td>{{ $material->tipo }}</td>
                    <td>{{ $material->ca }}</td>
                    <td>{{ $material->validade ? \Carbon\Carbon::parse($material->validade)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $material->quantidade_estoque }}</td>
                    <td>
                        @if($material->status == 1)
                        <span class="badge bg-success">Ativo</span>
                        @else
                        <span class="badge bg-secondary">Inativo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('material_epis.show', $material->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('material_epis.edit', $material->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('material_epis.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente excluir este material?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>

                {{-- Linhas de riscos vinculados --}}
                @foreach($materiais_risco->where('material_id', $material->id) as $materialRisco)
                <tr class="table-light">
                    <td colspan="2" class="text-end"><strong>Risco:</strong></td>
                    <td colspan="6">
                        {{ $materialRisco->risco->nome ?? '' }} {{-- Aqui pegamos o nome do risco --}}

                        @if($materialRisco->status == 1)
                        <span class="badge bg-success">Ativo</span>
                        @else
                        <span class="badge bg-secondary">Inativo</span>
                        @endif

                        @if(!empty($materialRisco->observacoes))
                        - {{ $materialRisco->observacoes }}
                        @endif
                    </td>
                </tr>
                @endforeach


                @empty
                <tr>
                    <td colspan="8" class="text-center">Nenhum material / EPI cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection