<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Você pode executar qualquer ação que desejar aqui
    });
</script>
@if (isset($equipamento->id))
<form action="{{ route('equipamento.update', ['equipamento' => $equipamento->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @else
    <form action="{{ route('equipamento.store') }}" method="POST">
        @csrf
        @endif
        <!--------------------------------------------------------------------------------------->
        <!---------Empresa------------->
        <!--------------------------------------------------------------------------------------->
        <div class="row mb-1">
            <label for="empresa_id" class="col-md-4 col-form-label text-md-end text-right">
                Empresa 🏭
            </label>

            <div class="col-md-6">
                <select name="empresa_id" id="empresa_id" class="form-control">
                    <option value="">Selecione uma empresa</option>

                    @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id }}"
                        {{ old('empresa_id', $equipamento->empresa_id ?? '') == $empresa->id ? 'selected' : '' }}>
                        {{ $empresa->nome1 }}
                    </option>
                    @endforeach
                </select>

                @error('empresa_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-1">
            <label for="local_id" class="col-md-4 col-form-label text-md-end text-right">
                Local/Setor 🏢
            </label>

            <div class="col-md-6">
                <select name="local_id" id="local_id" class="form-control">
                    <option value="">Selecione um local</option>

                    @foreach ($localizacoes as $local)
                    <option value="{{ $local->id }}"
                        {{ (old('local_id', $equipamento->local_id ?? '') == $local->id) ? 'selected' : '' }}>
                        {{ $local->nome }}
                    </option>
                    @endforeach
                </select>

                @error('local_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row mb-1">
            <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Nome</label>

            <div class="col-md-6">
                <input id="nome" type="text" class="form-control" name="nome" value="{{$equipamento->nome ?? old('nome') }}" required autocomplete="nome" autofocus>
                {{ $errors->has('nome') ? $errors->first('nome') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="descricao" class="col-md-4 col-form-label text-md-end text-right">Descrição</label>

            <div class="col-md-6">
                <input id="descricao" name="descricao" type="text" class="form-control" descricao="descricao" value="{{$equipamento->descricao?? old('descricao') }}" required autocomplete="descricao" autofocus>
                {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="modelo" class="col-md-4 col-form-label text-md-end text-right">Modelo</label>

            <div class="col-md-6">
                <input id="modelo" type="text" class="form-control" name="modelo" value="{{$equipamento->modelo ?? old('modelo') }}" required autocomplete="modelo" autofocus>
                {{ $errors->has('modelo') ? $errors->first('modelo') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="modelo" class="col-md-4 col-form-label text-md-end text-right">Número de série</label>

            <div class="col-md-6">
                <input id="serial" type="text" class="form-control" name="serial" value="{{$equipamento->serial ?? old('serial') }}" required autocomplete="modelo" autofocus>
                {{ $errors->has('modelo') ? $errors->first('modelo') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="data_fabricacao" class="col-md-4 col-form-label text-md-end text-right">Data fabricação</label>

            <div class="col-md-6">
                <input id="data_fabricacao" type="date" class="form-control" name="data_fabricacao" value="{{$equipamento->data_fabricacao ?? old('data_fabricacao') }}" required autocomplete="" autofocus>
                {{ $errors->has('data_fabricacao') ? $errors->first('data_fabricacao') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="data_fabricacao" class="col-md-4 col-form-label text-md-end text-right">Data Instalação</label>
            <div class="col-md-6">
                <input id="data_instalacao" type="date" class="form-control" name="data_instalacao" value="{{$equipamento->data_instalacao ?? old('data_instalacao') }}" required autocomplete="" autofocus>
                {{ $errors->has('data_fabricacao') ? $errors->first('data_fabricacao') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="marca_id" class="col-md-4 col-form-label text-md-end text-right">Marca</label>
            <div class="col-md-6">
                <select name="marca_id" id="" class="form-control">
                    <option value=""> --Selecione a marca--</option>
                    @foreach ($marcas as $marca)
                    <option value="{{$marca->id}}" {{ ($equipamento->marca_id ?? old('marca_id')) == $marca->id ? 'selected' : '' }}>{{$marca->nome}}</option>
                    @endforeach
                </select>
                {{ $errors->has('marca_id') ? $errors->first('marca_id') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="equipamento_pai" class="col-md-4 col-form-label text-md-end text-right">Equipamento Pai</label>

            <div class="col-md-6">
                <select name="equipamento_pai" id="" class="form-control">
                    <option value=""> --Selecione o equipamento_pai--</option>
                    @foreach ($equipamentos as $equipment)
                    <option value="{{$equipment->id}}" {{ ($equipamento->equipamento_pai ?? old('equipamento_pai')) == $equipment->id ? 'selected' : '' }}>{{$equipment->nome}}</option>
                    @endforeach
                </select>
                {{ $errors->has('equipamento_pai') ? $errors->first('equipamento_pai') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="marca_id" class="col-md-4 col-form-label text-md-end text-right">Tipo de ativo</label>

            <div class="col-md-6">
                <select name="tipo_de_ativo" id="" class="form-control">
                    <option value="{{$equipamento->tipo_de_ativo?? old('tipo_de_ativo') }}">{{$equipamento->tipo_de_ativo?? old('tipo_de_ativo') }}</option>
                    <option value="Compressores">Compressores</option>
                    <option value="Caminhões">Caminhão</option>
                    <option value="Local Ala">Local Ala</option>
                    <option value="Máquinas pesada">Máquinas pesada</option>
                    <option value="Trator">Trator</option>
                    <option value="Automóveis">Automóveis</option>
                    <option value="Terrenos">Terrenos</option>
                    <option value="Imóveis">Imóveis</option>
                    <option value="Máquina industrial">Máquina industrial</option>
                    <option value="Reservatórios">Reservatórios</option>
                </select>
                {{ $errors->has('marca_id') ? $errors->first('marca_id') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="marca_id" class="col-md-4 col-form-label text-md-end text-right">Estado do ativo</label>
            <div class="col-md-6">
                <select name="estado_do_ativo" id="" class="form-control">
                    <option value="{{$equipamento->estado_do_ativo?? old('estado_do_ativo') }}">{{$equipamento->estado_do_ativo?? old('estado_do_ativo') }}</option>
                    <option value="Vendido">Vendido</option>
                    <option value="Desativado">Desativado</option>
                    <option value="Ativado">Ativado</option>
                </select>
                {{ $errors->has('marca_id') ? $errors->first('marca_id') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="marca_id" class="col-md-4 col-form-label text-md-end text-right">Criticidade</label>

            <div class="col-md-6">
                <select name="criticidade" id="" class="form-control">
                    <option value="{{$equipamento->criticidade?? old('criticidade') }}">{{$equipamento->criticidade?? old('criticidade') }}</option>
                    <option value="Extra alta">Extra alta</option>
                    <option value="Alta">Alta</option>
                    <option value="Média">Média</option>
                    <option value="Baixa">Baixa</option>
                </select>
                {{ $errors->has('marca_id') ? $errors->first('marca_id') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="anexo_1" class="col-md-4 col-form-label text-md-end text-right">Anexo 1</label>

            <div class="col-md-6">
                <input id="anexo_1" type="text" class="form-control" name="anexo_1" value="{{$equipamento->anexo_1 ?? old('anexo_1') }}">
                {{ $errors->has('anexo_1') ? $errors->first('anexo_1') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="anexo_2" class="col-md-4 col-form-label text-md-end text-right">Anexo 2</label>
            <div class="col-md-6">
                <input id="anexo_2" type="text" class="form-control" name="anexo_2" value="{{$equipamento->anexo_2 ?? old('anexo_2') }}">
                {{ $errors->has('anexo_2') ? $errors->first('anexo_2') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="anexo_3" class="col-md-4 col-form-label text-md-end text-right">Anexo 3</label>
            <div class="col-md-6">
                <input id="anexo_3" type="text" class="form-control" name="anexo_3" value="{{$equipamento->anexo_3 ?? old('anexo_3') }}">
                {{ $errors->has('anexo_3') ? $errors->first('anexo_3') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="anexo_2" class="col-md-4 col-form-label text-md-end text-right">Valor estimado</label>
            <div class="col-md-6">
                <input id="valor_estimado" type="text" class="form-control" name="valor_estimado" value="{{$equipamento->valor_estimado?? old('valor_estimado') }}" autocomplete="" autofocus>
                {{ $errors->has('data_fabricacao') ? $errors->first('data_fabricacao') : '' }}
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($equipamento) ? 'Atualizar' : 'Cadastrar' }}
                </button>
            </div>
        </div>
        <div class="row mb-1">
            <label for="data_fabricacao" class="col-md-4 col-form-label text-md-end text-right">Data Desativação</label>
            <div class="col-md-6">
                <input id="data_desativacao" type="date" class="form-control" name="data_desativacao" value="{{$equipamento->data_desativacao?? old('data_desativacao') }}" style="background: yellow;">
            </div>
        </div>
    </form>