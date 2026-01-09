@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Business Partner</h2>

            <div>
                <a href="{{ route('business-partners.index') }}" class="btn btn-secondary">
                    Voltar
                </a>

                <a href="{{ route('business-partners.edit', $businessPartner->id) }}"
                    class="btn btn-warning">
                    Editar
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">

                <p><strong>ID:</strong> {{ $businessPartner->id }}</p>

                <p>
                    <strong>Tipo:</strong>
                    {{ $businessPartner->type === 'PF' ? 'Pessoa Física' : 'Pessoa Jurídica' }}
                </p>

                <p><strong>Documento:</strong> {{ $businessPartner->document }}</p>

                @if ($businessPartner->type === 'PF')
                <p><strong>Nome:</strong>
                    {{ $businessPartner->name_first }} {{ $businessPartner->name_last }}
                </p>
                @else
                <p><strong>Razão Social:</strong> {{ $businessPartner->company_name }}</p>
                <p><strong>Nome Fantasia:</strong> {{ $businessPartner->trade_name }}</p>
                @endif

                <p><strong>Chave de Pesquisa:</strong> {{ $businessPartner->search_key }}</p>

                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-success">
                        {{ $businessPartner->status }}
                    </span>
                </p>

                <p>
                    <strong>Criado em:</strong>
                    {{ $businessPartner->created_at->format('d/m/Y H:i') }}
                </p>

            </div>
        </div>

        {{-- Ações futuras --}}
        <div class="card">
            <div class="card-header">
                Próximos passos
            </div>
            <div class="card-body">

                <a href="#"
                    class="btn btn-outline-primary me-2">
                    Adicionar Endereço
                </a>

                <a href="#"
                    class="btn btn-outline-secondary">
                    Gerenciar Papéis
                </a>

            </div>
        </div>
</main>