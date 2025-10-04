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
                <select name="categoria_id" id="categoria_id" class="form-control">
                    <option value="">--Selecione a Categoria--</option>
                    @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-1">
            <label for="familia_id" class="col-md-4 col-form-label text-md-end text-right">Família</label>
            <div class="col-md-6">
                <select name="familia_id" id="familia_id" class="form-control">
                    <option value="">--Selecione a família--</option>
                    @foreach ($familias as $familia)
                    <option value="{{ $familia->id }}" data-categoria="{{ $familia->categoria_id }}"
                        {{ (old('familia_id', $produto->familia_id ?? '') == $familia->id) ? 'selected' : '' }}>
                        {{ $familia->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categoriaSelect = document.getElementById('categoria_id');
                const familiaSelect = document.getElementById('familia_id');

                // Guarda todas as opções de família originais
                const todasFamilias = Array.from(familiaSelect.querySelectorAll('option'));

                function filtrarFamilias() {
                    const categoriaId = categoriaSelect.value;

                    // Limpa todas as opções
                    familiaSelect.innerHTML = '<option value="">--Selecione a família--</option>';

                    // Adiciona somente as que pertencem à categoria
                    todasFamilias.forEach(option => {
                        if (option.value === "" || option.dataset.categoria === categoriaId) {
                            // Clona a opção para evitar duplicação
                            familiaSelect.appendChild(option.cloneNode(true));
                        }
                    });

                    // Mantém a seleção antiga caso exista
                    const selectedFamilia = "{{ $produto->familia_id ?? old('familia_id') }}";
                    if (selectedFamilia) {
                        familiaSelect.value = selectedFamilia;
                    }
                }

                categoriaSelect.addEventListener('change', filtrarFamilias);

                // Filtra ao carregar a página (para edição)
                filtrarFamilias();
            });
        </script>


        <div class="row mb-1">
            <label for="link_peca" class="col-md-4 col-form-label text-md-end text-right">Link para peça</label>
            <div class="col-md-6">
                <input name="link_peca" id="link_peca" type="text" class="form-control @error('link_peca') is-invalid @enderror" value="{{ $produto->link_peca ?? old('link_peca') }}">
                {{ $errors->has('link_peca') ? $errors->first('link_peca') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="status" class="col-md-4 col-form-label text-md-end text-right">Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">Selecione...</option>
                    <option value="ativo" {{ (old('status') ?? $produto->status ?? '') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ (old('status') ?? $produto->status ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    <option value="pendente" {{ (old('status') ?? $produto->status ?? '') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="row mb-1">
            <label for="image" class="col-md-4 col-form-label text-md-end text-right">Carregar uma imagem 1</label>
            <div class="col-md-6">
                <input type="file" id="image" name="image">
            </div>
        </div>

        <div class="row mb-1">
            <label for="image2" class="col-md-4 col-form-label text-md-end text-right">Carregar uma imagem 2</label>
            <div class="col-md-6">
                <input type="file" id="image2" name="image2">
            </div>
        </div>

        <div class="row mb-1">
            <label for="image3" class="col-md-4 col-form-label text-md-end text-right">Carregar uma imagem 3</label>
            <div class="col-md-6">
                <input type="file" id="image3" name="image3">
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($produto) ? 'Atualizar' : 'Cadastrar' }}
                </button>
            </div>
        </div>
    </form>