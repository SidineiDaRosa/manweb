            @if (isset($produto->id))
            <form action="{{ route('entrada-produto.update', ['entrada_produto' => $entrada_produto->id]) }}" method="POST">
                @csrf
                @method('PUT')
                @else
                <form action="{{ route('entrada-produto.store') }}" method="POST">
                    @csrf
                    @endif
                    <!------------------------------------------------------------------->
                    <div class="row mb-1">
                        <label for="estoque_id" class="col-md-4 col-form-label text-md-end text-right">Estoque</label>
                        <div class="col-md-6">
                            <input name="estoque_id" id="estoque_id" type="text" class="form-control " value="@foreach($estoque as $estoque_f)
                    {{$estoque_f['id']}}
                    @endforeach" readonly>
                            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                        </div>
                    </div>
                    @foreach ($empresa as $empresas_find)
                    @endforeach
                    <div class="row mb-1">
                        <label for="empresa_id" class="col-md-4 col-form-label text-md-end text-right">Empresa</label>
                        <div class="col-md-6">
                            <input name="empresa_id" id="empresa_id" type="text" class="form-control " value="{{$estoque_f->empresa->id}}" readonly>

                        </div>
                    </div>
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

                    <div class="row mb-1">
                        <label for="fornecedor_id" class="col-md-4 col-form-label text-md-end text-right">Fornecedor</label>
                        <div class="col-md-6">
                            <select name="fornecedor_id" id="" class="form-control">
                                <option value=""> --Selecione o fornecedor--</option>
                                @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}" {{ ($fornecedor->fornecedor_id ?? old('fornecedor_id')) == $fornecedor->id ? 'selected' : '' }}>
                                    {{ $fornecedor->nome_fantasia }}
                                </option>
                                @endforeach
                            </select>
                            {{ $errors->has('fornecedor_id') ? $errors->first('fornecedor_id') : '' }}
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">Quantidade</label>
                        <div class="col-md-6">
                            <input name="quantidade" id="quantidade" type="text" class="form-control " value="{{ $produto->quantidade ?? old('quantidade') }}">
                            {{ $errors->has('quantidade') ? $errors->first('quantidade') : '' }}
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">R$</label>
                        <div class="col-md-6">
                            <input name="valor" id="valor" type="text" class="form-control " value="{{ $produto->valor ?? old('valor') }}">
                            {{ $errors->has('valor') ? $errors->first('valor') : '' }}
                        </div>
                    </div>

                    <div class="row mb-1">
                        <label for="nota_fiscal" class="col-md-4 col-form-label text-md-end text-right">Nota Fiscal</label>
                        <div class="col-md-6">
                            <input name="nota_fiscal" id="nota_fiscal" type="text" class="form-control " value="{{ $produto->nota_fiscal ?? old('nota_fiscal') }}">
                            {{ $errors->has('nota_fiscal') ? $errors->first('nota_fiscal') : '' }}
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