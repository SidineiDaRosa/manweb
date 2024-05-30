
@if (isset($produto->id))
<form action="{{ route('fornecedor.update', ['fornecedor' => $fornecedor->id]) }}" method="POST">
    @csrf
    @method('PUT')
@else
    <form action="{{ route('fornecedor.store') }}" method="POST">
        @csrf
@endif

<div class="row mb-1">
    <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Razão Social</label>

    <div class="col-md-6">
        <input id="razao_social" type="text" class="form-control" name="razao_social"
            value="{{$fornecedor->razao_social ?? old('razao_social') }}" required autocomplete="razao_social" autofocus>
            {{ $errors->has('razao_social') ? $errors->first('razao_social') : '' }}
    </div>
</div>


<div class="row mb-1">
    <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Nome Fantasia</label>

    <div class="col-md-6">
        <input id="nome_fantasia" name="nome_fantasia" type="text" class="form-control" nome_fantasia="nome_fantasia"
            value="{{$fornecedor->nome_fantasia?? old('nome_fantasia') }}" required autocomplete="nome_fantasia" autofocus>
            {{ $errors->has('nome_fantasia') ? $errors->first('nome_fantasia') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">CNPJ</label>

    <div class="col-md-6">
        <input id="cnpj" name="cnpj" type="text" class="form-control" cnpj="cnpj"
            value="{{$fornecedor->cnpj?? old('cnpj') }}" required autocomplete="cnpj" autofocus>
            {{ $errors->has('cnpj') ? $errors->first('cnpj') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="insc_estadual" class="col-md-4 col-form-label text-md-end text-right">Inscrição Estadual</label>

    <div class="col-md-6">
        <input id="insc_estadual" name="insc_estadual" type="text" class="form-control" insc_estadual="insc_estadual"
            value="{{$fornecedor->insc_estadual?? old('insc_estadual') }}" required autocomplete="insc_estadual" autofocus>
            {{ $errors->has('insc_estadual') ? $errors->first('insc_estadual') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="endereco" class="col-md-4 col-form-label text-md-end text-right">Endereço</label>

    <div class="col-md-6">
        <input id="endereco" name="endereco" type="text" class="form-control" endereco="endereco"
            value="{{$fornecedor->endereco?? old('endereco') }}" required autocomplete="endereco" autofocus>
            {{ $errors->has('endereco') ? $errors->first('endereco') : '' }}                            
    </div>
</div>


<div class="row mb-1">
    <label for="bairro" class="col-md-4 col-form-label text-md-end text-right">Bairro</label>

    <div class="col-md-6">
        <input id="bairro" name="bairro" type="text" class="form-control" bairro="bairro"
            value="{{$fornecedor->bairro?? old('bairro') }}" required autocomplete="bairro" autofocus>
            {{ $errors->has('bairro') ? $errors->first('bairro') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="cidade" class="col-md-4 col-form-label text-md-end text-right">Cidade</label>

    <div class="col-md-6">
        <input id="cidade" name="cidade" type="text" class="form-control" cidade="cidade"
            value="{{$fornecedor->cidade?? old('cidade') }}" required autocomplete="cidade" autofocus>
            {{ $errors->has('cidade') ? $errors->first('cidade') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="estado" class="col-md-4 col-form-label text-md-end text-right">Estado</label>

    <div class="col-md-6">
        <input id="estado" name="estado" type="text" class="form-control" estado="estado"
            value="{{$fornecedor->estado?? old('estado') }}" required autocomplete="estado" autofocus>
            {{ $errors->has('estado') ? $errors->first('estado') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="telefone" class="col-md-4 col-form-label text-md-end text-right">Telefone</label>

    <div class="col-md-6">
        <input id="telefone" name="telefone" type="text" class="form-control" telefone="telefone"
            value="{{$fornecedor->telefone?? old('telefone') }}" required autocomplete="telefone" autofocus>
            {{ $errors->has('telefone') ? $errors->first('telefone') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="contato" class="col-md-4 col-form-label text-md-end text-right">Contato</label>

    <div class="col-md-6">
        <input id="contato" name="contato" type="text" class="form-control" contato="contato"
            value="{{$fornecedor->contato?? old('contato') }}" required autocomplete="contato" autofocus>
            {{ $errors->has('contato') ? $errors->first('contato') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="email" class="col-md-4 col-form-label text-md-end text-right">Email</label>

    <div class="col-md-6">
        <input id="email" name="email" type="text" class="form-control" email="email"
            value="{{$fornecedor->email?? old('email') }}" required autocomplete="email" autofocus>
            {{ $errors->has('email') ? $errors->first('email') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="site" class="col-md-4 col-form-label text-md-end text-right">Site</label>

    <div class="col-md-6">
        <input id="site" name="site" type="text" class="form-control" site="site"
            value="{{$fornecedor->site?? old('site') }}" required autocomplete="site" autofocus>
            {{ $errors->has('site') ? $errors->first('site') : '' }}                            
    </div>
</div>



<div class="row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($produto) ? 'Atualizar' : 'Cadastrar' }}
        </button>
    </div>
</div>
</form>


