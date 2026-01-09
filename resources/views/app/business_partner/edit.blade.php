@extends('app.layouts.app')

@section('content')
<main class="content">
<div class="container">

    <h2>Editar Business Partner</h2>

    <form action="{{ route('business-partners.update', $businessPartner->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- TIPO (não editável) --}}
        <div class="mb-3">
            <label class="form-label">Tipo</label><br>

            @if($businessPartner->type === 'PF')
                <span class="badge bg-primary">Pessoa Física</span>
            @else
                <span class="badge bg-success">Pessoa Jurídica</span>
            @endif

            <input type="hidden" name="type" value="{{ $businessPartner->type }}">
        </div>

        {{-- DOCUMENTO (não editável) --}}
        <div class="mb-3">
            <label class="form-label">Documento</label>
            <input type="text"
                   class="form-control"
                   value="{{ $businessPartner->document }}"
                   disabled>

            <input type="hidden"
                   name="document"
                   value="{{ $businessPartner->document }}">
        </div>

        {{-- CAMPOS PF --}}
        @if($businessPartner->type === 'PF')
        <div id="pf-fields">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text"
                       name="name_first"
                       class="form-control"
                       value="{{ old('name_first', $businessPartner->name_first) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Sobrenome</label>
                <input type="text"
                       name="name_last"
                       class="form-control"
                       value="{{ old('name_last', $businessPartner->name_last) }}">
            </div>
        </div>
        @endif

        {{-- CAMPOS PJ --}}
        @if($businessPartner->type === 'PJ')
        <div id="pj-fields">
            <div class="mb-3">
                <label class="form-label">Razão Social</label>
                <input type="text"
                       name="company_name"
                       class="form-control"
                       value="{{ old('company_name', $businessPartner->company_name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nome Fantasia</label>
                <input type="text"
                       name="trade_name"
                       class="form-control"
                       value="{{ old('trade_name', $businessPartner->trade_name) }}">
            </div>
        </div>
        @endif

        {{-- STATUS --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="ATIVO" {{ $businessPartner->status === 'ATIVO' ? 'selected' : '' }}>
                    Ativo
                </option>
                <option value="INATIVO" {{ $businessPartner->status === 'INATIVO' ? 'selected' : '' }}>
                    Inativo
                </option>
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                Atualizar
            </button>

            <a href="{{ route('business-partners.show', $businessPartner->id) }}"
               class="btn btn-secondary">
                Cancelar
            </a>
        </div>

    </form>
</div>
</main>
@endsection
