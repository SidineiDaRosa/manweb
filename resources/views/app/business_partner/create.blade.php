@extends('app.layouts.app')

@section('content')

<main class="content">
<div class="container">

    <h2>Cadastrar Business Partner</h2>

    <form action="{{ route('business-partners.store') }}" method="POST">
        @csrf

        {{-- Tipo --}}
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Selecione</option>
                <option value="PF">Pessoa Física</option>
                <option value="PJ">Pessoa Jurídica</option>
            </select>
        </div>

        {{-- Documento --}}
        <div class="mb-3">
            <label class="form-label">Documento (CPF / CNPJ)</label>
            <input type="text" name="document" class="form-control" required>
        </div>

        {{-- PF --}}
        <div id="pf-fields" style="display:none">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="name_first" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Sobrenome</label>
                <input type="text" name="name_last" class="form-control">
            </div>
        </div>

        {{-- PJ --}}
        <div id="pj-fields" style="display:none">
            <div class="mb-3">
                <label class="form-label">Razão Social</label>
                <input type="text" name="company_name" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nome Fantasia</label>
                <input type="text" name="trade_name" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Salvar
        </button>

    </form>
</div>

{{-- JS --}}
<script>
document.getElementById('type').addEventListener('change', function () {
    document.getElementById('pf-fields').style.display =
        this.value === 'PF' ? 'block' : 'none';

    document.getElementById('pj-fields').style.display =
        this.value === 'PJ' ? 'block' : 'none';
});
</script>
@endsection
</main>