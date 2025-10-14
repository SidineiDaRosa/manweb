@extends('app.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalhes do Projeto</h1>

    <div class="card">
        <div class="card-header">
            {{ $projeto->nome }}
        </div>
        <div class="card-body">
            <p><strong>Descrição:</strong> {{ $projeto->descricao ?? '-' }}</p>
            <p><strong>Data de Início:</strong> {{ $projeto->data_inicio ? \Carbon\Carbon::parse($projeto->data_inicio)->format('d/m/Y') : '-' }}</p>
            <p><strong>Data de Fim:</strong> {{ $projeto->data_fim ? \Carbon\Carbon::parse($projeto->data_fim)->format('d/m/Y') : '-' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($projeto->status == 'ativo') bg-success
                    @elseif($projeto->status == 'concluido') bg-primary
                    @elseif($projeto->status == 'cancelado') bg-danger
                    @endif">
                    {{ ucfirst($projeto->status) }}
                </span>
            </p>
            <p><strong>Responsável:</strong> {{ $projeto->responsavel ? $projeto->responsavel->primeiro_nome . ' ' . $projeto->responsavel->ultimo_nome : '-' }}</p>
            <p><strong>Criado em:</strong> {{ \Carbon\Carbon::parse($projeto->created_at)->format('d/m/Y H:i') }}</p>
            <p><strong>Atualizado em:</strong> {{ \Carbon\Carbon::parse($projeto->updated_at)->format('d/m/Y H:i') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('projetos.edit', $projeto->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('projetos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
@endsection
