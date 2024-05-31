@if (isset($produto->id))
<form action="{{ route('empresas.update', ['fornecedor' => $fornecedor->id]) }}" method="POST">
    @csrf
    @method('PUT')
@else
    <form action="{{ route('empresas.store') }}" method="POST">
        @csrf
@endif

<div class="row mb-1">
    <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Razão Social</label>

    <div class="col-md-6">
        <input id="razao_social" type="text" class="form-control" name="razao_social"
            value="" required autocomplete="razao_social" autofocus>
            {{ $errors->has('razao_social') ? $errors->first('razao_social') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Nome Fantasia</label>

    <div class="col-md-6">
        <input id="nome_fantasia" name="nome_fantasia" type="text" class="form-control" nome_fantasia="nome_fantasia"
            value="" required autocomplete="nome_fantasia" autofocus>
            {{ $errors->has('nome_fantasia') ? $errors->first('nome_fantasia') : '' }}                            
    </div>
</div>

<div class="row mb-1">
    <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">CNPJ</label>

    <div class="col-md-6">
        <input id="cnpj" name="cnpj" type="text" class="form-control" cnpj="cnpj"
            value="" required autocomplete="cnpj" autofocus>
            {{ $errors->has('cnpj') ? $errors->first('cnpj') : '' }}                            
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


