@if (isset($produto->id))
    <form action="{{ route('produto.update', ['produto' => $produto->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
@else
    <form action="{{ route('produto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
@endif

<div class="row mb-1">
    <label for="cod_fabricante" class="col-md-4 col-form-label text-md-end text-right">Cod fabricante</label>
    <div class="col-md-6">
        <input id="cod_fabricante" type="text" class="form-control" name="cod_fabricante" value="{{ $produto->cod_fabricante ?? old('cod_fabricante') }}" required autocomplete="cod_fabricante" autofocus>
        {{ $errors->has('cod_fabricante') ? $errors->first('cod_fabricante') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Nome</label>
    <div class="col-md-6">
        <input id="nome" type="text" class="form-control" name="nome" value="{{ $produto->nome ?? old('nome') }}" required autocomplete="nome" autofocus>
        {{ $errors->has('nome') ? $errors->first('nome') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="descricao" class="col-md-4 col-form-label text-md-end text-right">Dados técnicos</label>
    <div class="col-md-6">
        <textarea id="descricao" name="descricao" rows="3" class="form-control" required autocomplete="descricao" autofocus>{{ $produto->descricao ?? old('descricao') }}</textarea>
        {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="marca_id" class="col-md-4 col-form-label text-md-end text-right">Marca</label>
    <div class="col-md-6">
        <select name="marca_id" id="" class="form-control">
            <option value=""> --Selecione a marca--</option>
            @foreach ($marcas as $marca)
                <option value="{{ $marca->id }}" {{ ($produto->marca_id ?? old('marca_id')) == $marca->id ? 'selected' : '' }}>
                    {{ $marca->nome }}
                </option>
            @endforeach
        </select>
        {{ $errors->has('marca_id') ? $errors->first('marca_id') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="unidade_medida_id" class="col-md-4 col-form-label text-md-end text-right">Unidade de Medida</label>
    <div class="col-md-6">
        <select name="unidade_medida_id" id="" class="form-control">
            <option value=""> --Selecione a Unidade de Medida--</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ ($produto->unidade_medida_id ?? old('unidade_medida_id')) == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->nome }}
                </option>
            @endforeach
        </select>
        {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="categoria_id" class="col-md-4 col-form-label text-md-end text-right">Categoria</label>
    <div class="col-md-6">
        <select name="categoria_id" id="" class="form-control">
            <option value=""> --Selecione a Categoria--</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nome }}
                </option>
            @endforeach
        </select>
        {{ $errors->has('categoria_id') ? $errors->first('categoria_id') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="link_peca" class="col-md-4 col-form-label text-md-end text-right">Link para peça</label>
    <div class="col-md-6">
        <input name="link_peca" id="link_peca" type="text" class="form-control @error('link_peca') is-invalid @enderror" value="{{ $produto->link_peca ?? old('link_peca') }}">
        {{ $errors->has('link_peca') ? $errors->first('link_peca') : '' }}
    </div>
</div>

<div class="row mb-1">
    <label for="image" class="col-md-4 col-form-label text-md-end text-right">Carregar uma imagem 1</label
