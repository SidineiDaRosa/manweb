@if (isset($categoria->id))
                <form action="{{ route('categoria.update', ['categoria' => $categoria->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                @else
                    <form action="{{ route('categoria.store') }}" method="POST">
                        @csrf
            @endif

                <div class="row mb-3">
                    <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Nome</label>

                    <div class="col-md-6">
                        <input id="nome" type="text" class="form-control-template" name="nome"
                            value="{{$categoria->nome ?? old('nome') }}" required autocomplete="nome" autofocus>
                            {{ $errors->has('categoria') ? $errors->first('categoria') : '' }}
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="descricao" class="col-md-4 col-form-label text-md-end text-right">Descrição</label>

                    <div class="col-md-6">
                        <input id="descricao" name="descricao" type="text" class="form-control-template" descricao="descricao"
                            value="{{$categoria->descricao?? old('descricao') }}" required autocomplete="descricao">
                            {{ $errors->has('categoria') ? $errors->first('categoria') : '' }}                            
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ isset($categotia) ? 'Atualizar' : 'Cadastrar' }}
                        </button>
                    </div>
                </div>
            </form>