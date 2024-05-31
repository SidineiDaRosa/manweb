            @if (isset($produto->id))
                <form action="{{ route('produto_fornecedor.update', ['produto_fornecedor' => $produto_fornecedor->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                @else
                    <form action="{{ route('produto_fornecedor.store') }}" method="POST">
                        @csrf
            @endif


                <div class="row mb-3">
                    <label for="fornecedor_id" class="col-md-4 col-form-label text-md-end">Produto</label>

                    <div class="col-md-6">
                        <select name="fornecedor_id" id="" class="form-control">
                            <option value=""> --Selecione a marca--</option>
                            @foreach ($marcas as $marca)
                                <option value="{{$marca->id}}"  {{ ($produto->fornecedor_id ?? old('fornecedor_id')) == $marca->id ? 'selected' : '' }}>{{$marca->nome}}</option>
                            @endforeach
                        </select>
                        {{ $errors->has('fornecedor_id') ? $errors->first('fornecedor_id') : '' }} 
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

