@if (isset($estoque->id))
    <form action="{{ route('Estoque-produto.update', ['Estoque_produto' => $estoque->id]) }}" method="POST">
        @csrf
        @method('PUT')
@else
    <form action="{{ route('Estoque-produto.store') }}" method="POST">
        @csrf
@endif
@foreach($produtos as $produto)
@endforeach
    <!-- Campos do formulário -->
    <div class="row mb-3">
        <label for="data" class="col-md-4 col-form-label text-md-end text-right">Data</label>
        <div class="col-md-6">
            <input name="data" id="data_emissao" type="date" class="form-control" value="{{ $estoque->data ?? old('data') }}" readonly>
            {{ $errors->has('data') ? $errors->first('data') : '' }}
        </div>
    </div>
    <div class="row mb-1">
        <label for="produto" class="col-md-4 col-form-label text-md-end text-right">Produto id</label>
        <div class="col-md-6">
            <input name="produto_id" id="produto_id" type="text" class="form-control" value="{{$produto->id ?? old('produto_id') }}" readonly>
            {{ $errors->has('produto_id') ? $errors->first('produto_id') : '' }}
        </div>
    </div>
    <div class="row mb-1">
        <label for="produto" class="col-md-4 col-form-label text-md-end text-right">Produto</label>
        <div class="col-md-6">
            <input name="produto" id="produto" type="text" class="form-control" value="{{ $produto->nome ?? old('produto_nome') }}" readonly>
            {{ $errors->has('produto') ? $errors->first('produto') : '' }}
        </div>
    </div>

   <!-- Select empresa -->
<div class="row mb-1">
    <label for="empresa_id" class="col-md-4 col-form-label text-md-end text-right">Empresa:</label>
    <div class="col-md-6">
        <input type="text" name="empresa_id" id="empresa_id" class="form-control" value="2" readonly>
    </div>
</div>

    <div class="row mb-1">
        <label for="unidade_medida" class="col-md-4 col-form-label text-md-end text-right">Unid</label>
        <div class="col-md-6">
            <input name="unidade_medida" id="unidade_medida" type="text" class="form-control" value="{{$produto->unidade_medida_id}}" readonly>
            {{ $errors->has('unidade_medida') ? $errors->first('unidade_medida') : '' }}
        </div>
    </div>

    <div class="row mb-1">
        <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">Quantidade</label>
        <div class="col-md-6">
    <input name="quantidade" id="quantidade" type="text" class="form-control" 
           value="{{ isset($estoque->quantidade) ? $estoque->quantidade : old('quantidade', '0') }}" readonly>
    {{ $errors->has('quantidade') ? $errors->first('quantidade') : '' }}
</div>
    </div>
    <div class="row mb-1">
        <label for="valor" class="col-md-4 col-form-label text-md-end text-right">R$</label>
        <div class="col-md-6">
            <input name="valor" id="valor" type="text" class="form-control" value="{{ $estoque->valor ?? old('valor') }}">
            {{ $errors->has('valor') ? $errors->first('valor') : '' }}
        </div>
    </div>

    <div class="row mb-1">
        <label for="estoque_minimo" class="col-md-4 col-form-label text-md-end text-right">Estoque mínimo</label>
        <div class="col-md-6">
            <input name="estoque_minimo" id="estoque_minimo" type="text" class="form-control" value="{{ $estoque->estoque_minimo ?? old('estoque_minimo') }}">
            {{ $errors->has('estoque_minimo') ? $errors->first('estoque_minimo') : '' }}
        </div>
    </div>

    <div class="row mb-1">
        <label for="estoque_maximo" class="col-md-4 col-form-label text-md-end text-right">Estoque máximo</label>
        <div class="col-md-6">
            <input name="estoque_maximo" id="estoque_maximo" type="text" class="form-control" value="{{ $estoque->estoque_maximo ?? old('estoque_maximo') }}">
            {{ $errors->has('estoque_maximo') ? $errors->first('estoque_maximo') : '' }}
        </div>
    </div>

    <div class="row mb-1">
        <label for="local" class="col-md-4 col-form-label text-md-end text-right">Local</label>
        <div class="col-md-6">
            <input name="local" id="local" type="text" class="form-control" value="{{ $estoque->local ?? old('local') }}">
            {{ $errors->has('local') ? $errors->first('local') : '' }}
        </div>
    </div>
    <div class="row mb-1">
        <label for="criticidade" class="col-md-4 col-form-label text-md-end text-right">Criticidade</label>
        <div class="col-md-6">
            <input name="criticidade" id="criticidade" type="text" class="form-control" value="{{ $estoque->criticidade ?? old('criticidade') }}">
            {{ $errors->has('criticidade') ? $errors->first('criticidade') : '' }}
        </div>
    </div>
    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($estoque) ? 'Atualizar' : 'Cadastrar' }}
            </button>
        </div>
    </div>

</form>
