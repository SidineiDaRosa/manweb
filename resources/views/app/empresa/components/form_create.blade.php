@if (isset($produto->id))
<form action="{{ route('empresas.update', ['fornecedor' => $fornecedor->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @else
    <form action="{{ route('empresas.store') }}" method="POST">
        @csrf
        @endif
        <div class="row mb-1">
            <label for="tipo_pessoa" class="col-md-4 col-form-label text-md-end text-right">
                Tipo PF/PJ
            </label>

            <div class="col-md-6">
                <select id="tipo_pessoa"
                    name="tipo_pessoa"
                    class="form-control"
                    required>

                    <option value="">Selecione</option>

                    <option value="PF"
                        {{ (old('tipo_pessoa', $fornecedor->tipo_pessoa ?? '') == 'PF') ? 'selected' : '' }}>
                        Pessoa Física
                    </option>

                    <option value="PJ"
                        {{ (old('tipo_pessoa', $fornecedor->tipo_pessoa ?? '') == 'PJ') ? 'selected' : '' }}>
                        Pessoa Jurídica
                    </option>

                </select>

                {{ $errors->has('tipo_pessoa') ? $errors->first('tipo_pessoa') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Razão Social PJ/Nome completo PF</label>

            <div class="col-md-6">
                <input id="razao_social" type="text" class="form-control" name="razao_social"
                    value="{{$fornecedor->razao_social ?? old('razao_social') }}" required autocomplete="razao_social" autofocus>
                {{ $errors->has('razao_social') ? $errors->first('razao_social') : '' }}
            </div>
        </div>


        <div class="row mb-1">
            <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Nome Fantasia PJ/Apelido PF</label>

            <div class="col-md-6">
                <input id="nome_fantasia" name="nome_fantasia" type="text" class="form-control" nome_fantasia="nome_fantasia"
                    value="{{$fornecedor->nome_fantasia?? old('nome_fantasia') }}" required autocomplete="nome_fantasia" autofocus>
                {{ $errors->has('nome_fantasia') ? $errors->first('nome_fantasia') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">CNPJ PJ/CPF PF</label>

            <div class="col-md-6">
                <input id="cnpj" name="cnpj" type="text" class="form-control" cnpj="cnpj"
                    value="{{$fornecedor->cnpj?? old('cnpj') }}" required autocomplete="cnpj" autofocus>
                {{ $errors->has('cnpj') ? $errors->first('cnpj') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="insc_estadual" class="col-md-4 col-form-label text-md-end text-right">Inscrição Estadual</label>

            <div class="col-md-6">
                <input id="insc_estadual" name="insc_estadual" type="text" class="form-control" insc_estadual="insc_estadual"
                    value="{{$fornecedor->insc_estadual?? old('insc_estadual') }}" required autocomplete="insc_estadual" autofocus>
                {{ $errors->has('insc_estadual') ? $errors->first('insc_estadual') : '' }}
            </div>
        </div>
        <!--Busca país-->
        <div class="row mb-1">
            <label class="col-md-4 col-form-label text-md-end text-right">
                País
            </label>
            <div class="col-md-6">
                <select id="pais" name="pais" class="form-control" required>
                    <option value="">Selecione o país</option>
                </select>
            </div>
        </div>

        <!--busca estado da federação brasileira-->
        <!-- Estado (select – Brasil) -->
        <div class="row mb-1" id="estado-select-group" style="display:none;">
            <label class="col-md-4 col-form-label text-md-end text-right">
                Estado
            </label>

            <div class="col-md-6">
                <select id="estado_select" name="estado" class="form-control">
                    <option value="">Selecione o estado</option>
                </select>
                {{ $errors->first('estado') }}
            </div>
        </div>

        <!-- Estado / Província (texto livre – exterior) -->
        <div class="row mb-1" id="estado-input-group" style="display:none;">
            <label class="col-md-4 col-form-label text-md-end text-right">
                Estado / Província
            </label>

            <div class="col-md-6">
                <input type="text"
                    id="estado_input"
                    name="estado"
                    class="form-control"
                    placeholder="Ex: Buenos Aires"
                    value="{{ old('estado') }}">
                {{ $errors->first('estado') }}
            </div>
        </div>

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