<form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Tipo --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Tipo PF/PJ</label>
        <div class="col-md-6">
            <select name="tipo" class="form-control" disabled>
                <option value="F" {{ $empresa->tipo == 'F' ? 'selected' : '' }}>Pessoa Física</option>
                <option value="J" {{ $empresa->tipo == 'J' ? 'selected' : '' }}>Pessoa Jurídica</option>
            </select>
            {{-- Campo desabilitado porque não pode ser alterado --}}
        </div>
    </div>

    {{-- Name1 / Razão Social --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Razão Social / Nome</label>
        <div class="col-md-6">
            <input type="text" name="nome1" class="form-control"
                value="{{ old('nome1', $empresa->nome1) }}" required>
            {{ $errors->first('name1') }}
        </div>
    </div>

    {{-- Name2 / Nome Fantasia --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Nome Fantasia</label>
        <div class="col-md-6">
            <input type="text" name="nome2" class="form-control"
                value="{{ old('nome2', $empresa->nome2) }}">
            {{ $errors->first('name2') }}
        </div>
    </div>

    {{-- Name3 (opcional) --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Complemento 1</label>
        <div class="col-md-6">
            <input type="text" name="name3" class="form-control"
                value="{{ old('name3', $empresa->name3) }}">
            {{ $errors->first('name3') }}
        </div>
    </div>

    {{-- Name4 (opcional) --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Complemento 2</label>
        <div class="col-md-6">
            <input type="text" name="name4" class="form-control"
                value="{{ old('name4', $empresa->name4) }}">
            {{ $errors->first('name4') }}
        </div>
    </div>

    {{-- Documento (CPF/CNPJ) --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">CPF / CNPJ</label>
        <div class="col-md-6">
            <input type="text" name="cnpj" class="form-control"
                value="{{ old('cnpj', $empresa->cnpj) }}" disabled>
            {{-- Campo desabilitado porque não pode ser alterado --}}
        </div>
    </div>

    {{-- Inscrição estadual --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Inscrição Estadual</label>
        <div class="col-md-6">
            <input type="text" name="insc_estadual" class="form-control"
                value="{{ old('insc_estadual', $empresa->insc_estadual) }}">
            {{ $errors->first('insc_estadual') }}
        </div>
    </div>

    {{-- Cidade --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Cidade</label>
        <div class="col-md-6">
            <input type="text" name="cidade" class="form-control"
                value="{{ old('cidade', $empresa->cidade) }}" required>
            {{ $errors->first('cidade') }}
        </div>
    </div>

    {{-- Bairro --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Bairro</label>
        <div class="col-md-6">
            <input type="text" name="bairro" class="form-control"
                value="{{ old('bairro', $empresa->bairro) }}">
            {{ $errors->first('bairro') }}
        </div>
    </div>

    {{-- Endereço --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Endereço</label>
        <div class="col-md-6">
            <input type="text" name="endereco" class="form-control"
                value="{{ old('endereco', $empresa->endereco) }}">
            {{ $errors->first('endereco') }}
        </div>
    </div>

    {{-- Telefone --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Telefone</label>
        <div class="col-md-6">
            <input type="text" name="telefone" class="form-control"
                value="{{ old('telefone', $empresa->telefone) }}">
            {{ $errors->first('telefone') }}
        </div>
    </div>

    {{-- Contato --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Contato</label>
        <div class="col-md-6">
            <input type="text" name="contato" class="form-control"
                value="{{ old('contato', $empresa->contato) }}">
            {{ $errors->first('contato') }}
        </div>
    </div>

    {{-- Email --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Email</label>
        <div class="col-md-6">
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $empresa->email) }}">
            {{ $errors->first('email') }}
        </div>
    </div>

    {{-- Site --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Site</label>
        <div class="col-md-6">
            <input type="url" name="site" class="form-control"
                value="{{ old('site', $empresa->site) }}">
            {{ $errors->first('site') }}
        </div>
    </div>

    {{-- Botão --}}
    <div class="row mt-3">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Atualizar
            </button>
        </div>
    </div>
</form>
