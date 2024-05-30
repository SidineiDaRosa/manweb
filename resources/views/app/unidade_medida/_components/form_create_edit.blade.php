            @if (isset($produto->id))
                <form action="{{ route('produto.update', ['produto' => $produto->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                @else
                    <form action="{{ route('produto.store') }}" method="POST">
                        @csrf
            @endif

            <div class="row mb-3">
                <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Nome</label>

                <div class="col-md-6">
                    <input id="nome" type="text" class="form-control" name="nome"
                        value="{{ $produto->nome ?? old('nome') }}" required autocomplete="nome" autofocus>
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
            </div>


            <div class="row mb-3">
                <label for="descricao" class="col-md-4 col-form-label text-md-end text-right">Descrição</label>

                <div class="col-md-6">
                    <input id="descricao" name="descricao" type="text" class="form-control" descricao="descricao"
                        value="{{ $produto->descricao ?? old('descricao') }}" required autocomplete="descricao"
                        autofocus>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                </div>
            </div>

            <div class="row mb-3">
                <label for="marca_id" class="col-md-4 col-form-label text-md-end text-right">Marca</label>

                <div class="col-md-6">
                    <select name="marca_id" id="" class="form-control">
                        <option value=""> --Selecione a marca--</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}"
                                {{ ($produto->marca_id ?? old('marca_id')) == $marca->id ? 'selected' : '' }}>
                                {{ $marca->nome }}</option>
                        @endforeach
                    </select>
                    {{ $errors->has('marca_id') ? $errors->first('marca_id') : '' }}
                </div>
            </div>

            <div class="row mb-3">
                <label for="unidade_id" class="col-md-4 col-form-label text-md-end text-right">Unidade de Medida</label>

                <div class="col-md-6">
                    <select name="unidade_medida" id="" class="form-control">
                        <option value=""> --Selecione a Unidade de Medida--</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}"
                                {{ ($produto->unidade_medida ?? old('unidade_medida')) == $unidade->id ? 'selected' : '' }}>
                                {{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                    {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}
                </div>
            </div>

            <div class="row mb-3">
                <label for="categoria_id" class="col-md-4 col-form-label text-md-end text-right">Categoria</label>

                <div class="col-md-6">
                    <select name="categoria_id" id="" class="form-control">
                        <option value=""> --Selecione a Categoria--</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                    {{ $errors->has('categoria_id') ? $errors->first('categoria_id') : '' }}
                </div>
            </div>


            <div class="row mb-3">
                <label for="estoque_minimo" class="col-md-4 col-form-label text-md-end text-right">Estoque Mínimo</label>

                <div class="col-md-6">
                    <input name="estoque_minimo" id="estoque_minimo" type="text"
                        class="form-control @error('estoque_minimo') is-invalid @enderror"
                        estoque_minimo="estoque_minimo"
                        value="{{ $produto->estoque_minimo ?? old('estoque_minimo') }}" required
                        autocomplete="estoque_minimo" autofocus>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                </div>
            </div>

            <div class="row mb-3">
                <label for="estoque_ideal" class="col-md-4 col-form-label text-md-end text-right">Estoque Mínimo</label>

                <div class="col-md-6">
                    <input name="estoque_ideal" id="estoque_ideal" type="text"
                        class="form-control @error('estoque_ideal') is-invalid @enderror"
                        estoque_ideal="estoque_ideal"
                        value="{{ $produto->estoque_ideal ?? old('estoque_ideal') }}" required
                        autocomplete="estoque_ideal" autofocus>
                    {{ $errors->has('estoque_ideal') ? $errors->first('estoque_ideal') : '' }}
                </div>
            </div>


            <div class="row mb-3">
                <label for="estoque_maximo" class="col-md-4 col-form-label text-md-end text-right">Estoque Máximo</label>

                <div class="col-md-6">
                    <input name="estoque_maximo" id="estoque_maximo" type="text"
                        class="form-control @error('estoque_maximo') is-invalid @enderror"
                        estoque_maximo="estoque_maximo"
                        value="{{ $produto->estoque_maximo ?? old('estoque_maximo') }}" required
                        autocomplete="estoque_maximo" autofocus>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}

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
