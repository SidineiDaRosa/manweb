@if (isset($produto->id))
<form action="{{ route('Estoque-produto.update', ['entrada_produto' => $entrada_produto->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @else
    <form action="{{ route('Estoque-produto.store') }}" method="POST">
        @csrf
        @endif
        <!------------------------------------------------------------------->
        <div class="row mb-3">
            <label for="data" class="col-md-4 col-form-label text-md-end text-right">Data</label>
            <div class="col-md-6">
                <input name="data" id="data_emissao" type="date" class="form-control " value="{{ $produto->data ?? old('data') }}" readonly>
                {{ $errors->has('data') ? $errors->first('data') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="produto" class="col-md-4 col-form-label text-md-end text-right">Produto id</label>
            <div class="col-md-6">
                <input name="produto_id" id="produto_id" type="text" class="form-control " value="@foreach($produtos as $empresas_f)
                    {{$empresas_f['id']}}
                    @endforeach" readonly>
                {{ $errors->has('nome') ? $errors->first('nome') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="produto" class="col-md-4 col-form-label text-md-end text-right">Produto</label>
            <div class="col-md-6">
                <input name="produto" id="produto" type="text" class="form-control " value="@foreach($produtos as $empresas_f)
                    {{$empresas_f['nome']}}
                    @endforeach" readonly>
                {{ $errors->has('nome') ? $errors->first('nome') : '' }}
            </div>
        </div>
        <!--------------------------------------------------------------------------------------->
        <!---------Select empresa------------->
        <!--------------------------------------------------------------------------------------->
        <div class="row mb-1">
            <label for="empresas" class="col-md-4 col-form-label text-md-end text-right">Empresa:</label>
            <div class="col-md-6">
                <select name="empresa_id" id="empresa_id" class="form-control">
                    <option value=""> --Selecione a empresa--</option>
                    @foreach ($empresa as $empresas_find)
                    <option value="{{$empresas_find->id}}" {{($empresas_find->empresa_id ?? old('empresa_id')) == $empresas_find->id ? 'selected' : '' }}>
                        {{$empresas_find->razao_social}}
                    </option>
                    @endforeach
                </select>
                {{ $errors->has('empresa_id') ? $errors->first('empresa_id') : '' }}
            </div>
        </div>
        <!------------------------------------------------------------------------------------------->
        <div class="row mb-1">
            <label for="unidade_medida" class="col-md-4 col-form-label text-md-end text-right">Unid</label>
            <div class="col-md-6">
                <input name="unidade_medida" id="unidade_medida" type="text" class="form-control " value="{{$empresas_f->unidade_medida->nome}}" readonly>
            </div>
        </div>
        <div class="row mb-1">
            <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">Quantidade</label>
            <div class="col-md-6">
                <input name="quantidade" id="quantidade" type="text" class="form-control " value="0" readonly>
                {{ $errors->has('quantidade') ? $errors->first('quantidade') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">R$</label>
            <div class="col-md-6">
                <input name="valor" id="valor" type="text" class="form-control " value="0" readonly>
                {{ $errors->has('valor') ? $errors->first('valor') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="estoque_minimo" class="col-md-4 col-form-label text-md-end text-right">Estoque minimo</label>
            <div class="col-md-6">
                <input name="estoque_minimo" id="estoque_minimo" type="text" class="form-control " value="">
                {{ $errors->has('estoque_minimo') ? $errors->first('estoque_minimo') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="estoque_maximo" class="col-md-4 col-form-label text-md-end text-right">Estoque maximo</label>
            <div class="col-md-6">
                <input name="estoque_maximo" id="estoque_maximo" type="text" class="form-control " value="">
                {{ $errors->has('eestoque_maximo') ? $errors->first('estoque_maximo') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="local" class="col-md-4 col-form-label text-md-end text-right">Local</label>
            <div class="col-md-6">
                <input name="local" id="local" type="text" class="form-control " value="">
                {{ $errors->has('local') ? $errors->first('local') : '' }}
            </div>
</div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($entrada_produto) ? 'Atualizar' : 'Cadastrar' }}
                </button>
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <?php

                $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on") ? "https" : "http");
                $url = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $urlPaginaAtual = $protocolo . $url
                //echo $protocolo.$url;
                ?>
                Inserir no estoque:
                <p></p>
                {!! QrCode::size(100)->backgroundColor(255,90,0)->generate( $urlPaginaAtual ) !!}
            </div>
        </div>

    </form>