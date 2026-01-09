<form action="{{ isset($fornecedor->id) ? route('empresas.update', $fornecedor->id) : route('empresas.store') }}" method="POST">
    @csrf
    @if(isset($fornecedor->id))
        @method('PUT')
    @endif

    {{-- Tipo PF/PJ --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Tipo PF/PJ</label>
        <div class="col-md-6">
            <select name="tipo" class="form-control" {{ isset($fornecedor->id) ? 'disabled' : 'required' }}>
                <option value="">Selecione</option>
                <option value="F" {{ (old('tipo', $fornecedor->tipo ?? '') == 'F') ? 'selected' : '' }}>Pessoa Física</option>
                <option value="J" {{ (old('tipo', $fornecedor->tipo ?? '') == 'J') ? 'selected' : '' }}>Pessoa Jurídica</option>
            </select>
            {{-- Desabilitado no edit, obrigatório no create --}}
        </div>
    </div>

    {{-- Name1 / Razão Social --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Razão Social / Nome</label>
        <div class="col-md-6">
            <input type="text" name="name1" class="form-control"
                value="{{ old('name1', $fornecedor->name1 ?? '') }}" required>
        </div>
    </div>

    {{-- Name2 / Nome Fantasia --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Nome Fantasia / Apelido</label>
        <div class="col-md-6">
            <input type="text" name="name2" class="form-control"
                value="{{ old('name2', $fornecedor->name2 ?? '') }}">
        </div>
    </div>

    {{-- Name3 --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Complemento 1</label>
        <div class="col-md-6">
            <input type="text" name="name3" class="form-control"
                value="{{ old('name3', $fornecedor->name3 ?? '') }}">
        </div>
    </div>

    {{-- Name4 --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">Complemento 2</label>
        <div class="col-md-6">
            <input type="text" name="name4" class="form-control"
                value="{{ old('name4', $fornecedor->name4 ?? '') }}">
        </div>
    </div>

    {{-- Documento (CPF/CNPJ) --}}
    <div class="row mb-1">
        <label class="col-md-4 col-form-label text-md-end">CPF / CNPJ</label>
        <div class="col-md-6">
            <input type="text" name="documento" class="form-control"
                value="{{ old('documento', $fornecedor->documento ?? '') }}" {{ isset($fornecedor->id) ? 'disabled' : 'required' }}>
        </div>
    </div>

    {{-- Demais campos (Inscrição estadual, Cidade, Bairro, Endereço, Telefone, Contato, Email, Site) --}}
    @foreach(['insc_estadual', 'cidade', 'bairro', 'endereco', 'telefone', 'contato', 'email', 'site'] as $campo)
        <div class="row mb-1">
            <label class="col-md-4 col-form-label text-md-end">{{ ucwords(str_replace('_', ' ', $campo)) }}</label>
            <div class="col-md-6">
                <input type="{{ $campo == 'email' ? 'email' : ($campo == 'site' ? 'url' : 'text') }}"
                       name="{{ $campo }}" class="form-control"
                       value="{{ old($campo, $fornecedor->$campo ?? '') }}">
            </div>
        </div>
    @endforeach

    {{-- Botão --}}
    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($fornecedor->id) ? 'Atualizar' : 'Cadastrar' }}
            </button>
        </div>
    </div>
</form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const paisSelect = document.getElementById('pais');
                const estadoSelect = document.getElementById('estado');

                // 🔹 Carregar países
                fetch('https://restcountries.com/v3.1/all?fields=name,cca2')
                    .then(res => res.json())
                    .then(paises => {
                        paises.sort((a, b) =>
                            a.name.common.localeCompare(b.name.common)
                        );

                        paises.forEach(pais => {
                            const option = document.createElement('option');
                            option.value = pais.cca2; // BR, US...
                            option.textContent = pais.name.common;
                            paisSelect.appendChild(option);
                        });
                    });

                // 🔹 Quando mudar o país
                paisSelect.addEventListener('change', function() {

                    const pais = this.value;

                    estadoSelect.innerHTML = '';
                    estadoSelect.disabled = true;

                    // 🇧🇷 Brasil → IBGE
                    if (pais === 'BR') {
                        estadoSelect.innerHTML = '<option value="">Carregando estados...</option>';

                        fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
                            .then(res => res.json())
                            .then(estados => {

                                estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';

                                estados.forEach(estado => {
                                    const option = document.createElement('option');
                                    option.value = estado.sigla;
                                    option.textContent = estado.nome;
                                    estadoSelect.appendChild(option);
                                });

                                estadoSelect.disabled = false;
                            })
                            .catch(() => {
                                estadoSelect.innerHTML =
                                    '<option value="">Erro ao carregar estados</option>';
                            });
                    } else {
                        estadoSelect.innerHTML =
                            '<option value="">Estados disponíveis apenas para Brasil</option>';
                    }
                });

            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const paisSelect = document.getElementById('pais');

                const estadoSelectGroup = document.getElementById('estado-select-group');
                const estadoInputGroup = document.getElementById('estado-input-group');

                const estadoSelect = document.getElementById('estado_select');
                const estadoInput = document.getElementById('estado_input');

                paisSelect.addEventListener('change', function() {

                    const pais = this.value;

                    // limpa valores
                    estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';
                    estadoInput.value = '';

                    if (pais === 'BR') {
                        // 🇧🇷 Brasil → select
                        estadoSelectGroup.style.display = 'flex';
                        estadoInputGroup.style.display = 'none';

                        estadoSelect.disabled = false;
                        estadoInput.disabled = true;

                        fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
                            .then(res => res.json())
                            .then(estados => {
                                estados.forEach(estado => {
                                    const option = document.createElement('option');
                                    option.value = estado.sigla;
                                    option.textContent = estado.nome;
                                    estadoSelect.appendChild(option);
                                });
                            });

                    } else if (pais) {
                        // 🌍 Exterior → texto livre
                        estadoSelectGroup.style.display = 'none';
                        estadoInputGroup.style.display = 'flex';

                        estadoSelect.disabled = true;
                        estadoInput.disabled = false;

                    } else {
                        // nenhum país
                        estadoSelectGroup.style.display = 'none';
                        estadoInputGroup.style.display = 'none';
                    }
                });
            });
        </script>
        <div class="row mb-1">
            <label for="cidade" class="col-md-4 col-form-label text-md-end text-right">Cidade</label>

            <div class="col-md-6">
                <input id="cidade" name="cidade" type="text" class="form-control" cidade="cidade"
                    value="{{$fornecedor->cidade?? old('cidade') }}" required autocomplete="cidade" autofocus>
                {{ $errors->has('cidade') ? $errors->first('cidade') : '' }}
            </div>
        </div>


        <div class="row mb-1">
            <label for="bairro" class="col-md-4 col-form-label text-md-end text-right">Bairro</label>

            <div class="col-md-6">
                <input id="bairro" name="bairro" type="text" class="form-control" bairro="bairro"
                    value="{{$fornecedor->bairro?? old('bairro') }}" required autocomplete="bairro" autofocus>
                {{ $errors->has('bairro') ? $errors->first('bairro') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="endereco" class="col-md-4 col-form-label text-md-end text-right">Endereço</label>

            <div class="col-md-6">
                <input id="endereco" name="endereco" type="text" class="form-control" endereco="endereco"
                    value="{{$fornecedor->endereco?? old('endereco') }}" required autocomplete="endereco" autofocus>
                {{ $errors->has('endereco') ? $errors->first('endereco') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="telefone" class="col-md-4 col-form-label text-md-end text-right">Telefone</label>

            <div class="col-md-6">
                <input id="telefone" name="telefone" type="text" class="form-control" telefone="telefone"
                    value="{{$fornecedor->telefone?? old('telefone') }}" required autocomplete="telefone" autofocus>
                {{ $errors->has('telefone') ? $errors->first('telefone') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="contato" class="col-md-4 col-form-label text-md-end text-right">Contato</label>

            <div class="col-md-6">
                <input id="contato" name="contato" type="text" class="form-control" contato="contato"
                    value="{{$fornecedor->contato?? old('contato') }}" required autocomplete="contato" autofocus>
                {{ $errors->has('contato') ? $errors->first('contato') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="email" class="col-md-4 col-form-label text-md-end text-right">Email</label>

            <div class="col-md-6">
                <input id="email" name="email" type="text" class="form-control" email="email"
                    value="{{$fornecedor->email?? old('email') }}" required autocomplete="email" autofocus>
                {{ $errors->has('email') ? $errors->first('email') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="site" class="col-md-4 col-form-label text-md-end text-right">Site</label>

            <div class="col-md-6">
                <input id="site" name="site" type="url" class="form-control" site="site"
                    value="{{$fornecedor->site?? old('site') }}" required autocomplete="site" autofocus>
                {{ $errors->has('site') ? $errors->first('site') : '' }}
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