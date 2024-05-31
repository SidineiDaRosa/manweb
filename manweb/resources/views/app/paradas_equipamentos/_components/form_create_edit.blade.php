            @if (isset($marca->id))
                <form action="{{ route('marca.update', ['marca' => $marca->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                @else
                    <form action="{{ route('marca.store') }}" method="POST">
                        @csrf
            @endif

                <div class="row mb-3">
                    <label for="nome" class="col-md-4 col-form-label text-md-end">Nome</label>

                    <div class="col-md-6">
                        <input id="nome" type="text" class="form-control" name="nome"
                            value="{{$marca->nome ?? old('nome') }}" required autocomplete="nome" autofocus>
                            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="descricao" class="col-md-4 col-form-label text-md-end">Descrição</label>

                    <div class="col-md-6">
                        <input id="descricao" name="descricao" type="text" class="form-control" descricao="descricao"
                            value="{{$marca->descricao?? old('descricao') }}" required autocomplete="descricao" autofocus>
                            {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}                            
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ isset($marca) ? 'Atualizar' : 'Cadastrar' }}
                        </button>
                    </div>
                </div>
            </form>


