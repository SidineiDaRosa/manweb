<div class="card-body">
    <form action="{{ route('ordem-producao.store') }}" method="POST">
        @csrf
        <div class="row mb-1">
            <label for="equipamento_id" class="col-md-4 col-form-label text-md-end text-right">Equipamento</label>
            <div class="col-md-6">
                <select name="equipamento_id" id="equipamento_id" class="form-control-template" required autofocus>
                    <option value=""> --Selecione o Equipamento--</option>
                    @foreach ($equipamentos as $equipamento)
                        <option value="{{ $equipamento->id }}"
                            {{ ($ordem_producao->equipamento_id ?? old('equipamento_id')) == $equipamento->id ? 'selected' : '' }}>
                            {{ $equipamento->nome }}
                        </option>
                    @endforeach
                </select>
                {{ $errors->has('equipamento_id') ? $errors->first('equipamento_id') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="produto" class="col-md-4 col-form-label text-md-end text-right">Produto</label>

            <div class="col-md-6">
                <select name="produto_id" id="" class="form-control-template" required>
                    <option value=""> --Selecione o Produto-</option>
                    @foreach ($produtos as $produto)
                        <option value="{{ $produto->id }}"
                            {{ ($ordem_producao->produto_id ?? old('produto_id')) == $produto->id ? 'selected' : '' }}>
                            {{ $produto->nome }}</option>
                    @endforeach
                </select>
                {{ $errors->has('produto_id') ? $errors->first('produto_id') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="quantidade_producao"
                class="col-md-4 col-form-label text-md-end text-right">Quantidade_producao</label>

            <div class="col-md-6">
                <input name="quantidade_producao" id="quantidade_producao" type="text" class="form-control-template "
                    quantidade_producao="quantidade_producao"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                    value="{{ $produto->quantidade_producao ?? old('quantidade_producao') }}" required
                    placeholder="Somente Números">
                {{ $errors->has('quantidade_producao') ? $errors->first('quantidade_producao') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="data_inicio" class="col-md-4 col-form-label text-md-end text-right">Data Inicial</label>

            <div class="col-md-6">
                <input name="data_inicio" id="data_inicio" type="date" class="form-control-template "
                    data_inicio="data_inicio" value="{{ \Carbon\Carbon::now() ?? old('data_inicio') }}">
                {{ $errors->has('data_inicio') ? $errors->first('data_inicio') : '' }}
            </div>
        </div>


        <div class="row mb-1">
            <label for="data_fim" class="col-md-4 col-form-label text-md-end text-right">Data Final</label>

            <div class="col-md-6">
                <input name="data_fim" id="data_fim" type="date" class="form-control-template" data_fim="data_fim"
                    value="{{ $produto->data_fim ?? old('data_fim') }}" autofocus>
                {{ $errors->has('data_fim') ? $errors->first('data_fim') : '' }}

            </div>
        </div>

        <div class="row mb-1">
            <label for="hora_inicio" class="col-md-4 col-form-label text-md-end text-right">Hora Inicial</label>

            <div class="col-md-6">
                <input name="hora_inicio" id="hora_inicio" type="time" class="form-control-template"
                    hora_inicio="hora_inicio" value="{{ $produto->hora_inicio ?? old('hora_inicio') }}" autofocus>
                {{ $errors->has('hora_inicio') ? $errors->first('hora_inicio') : '' }}

            </div>
        </div>

        <div class="row mb-1">
            <label for="hora_fim" class="col-md-4 col-form-label text-md-end text-right">Hora Final</label>

            <div class="col-md-6">
                <input name="hora_fim" id="hora_fim" type="time" class="form-control-template" hora_fim="hora_fim"
                    value="{{ $produto->hora_fim ?? old('hora_fim') }}" autofocus>
                {{ $errors->has('hora_fim') ? $errors->first('hora_fim') : '' }}

            </div>
        </div>

        <div class="row mb-1">
            <label for="horimetro_inicial" class="col-md-4 col-form-label text-md-end text-right">Horímetro
                Inicial</label>

            <div class="col-md-6">
                <input name="horimetro_inicial" id="horimetro_inicial" disabled
                    class="form-control-disabled" horimetro_inicial="horimetro_inicial"
                    value="{{ $produto->horimetro_inicial ?? old('horimetro_inicial') }}" autofocus>
                {{ $errors->has('horimetro_inicial') ? $errors->first('horimetro_inicial') : '' }}

            </div>
        </div>

        <div class="row mb-1">
            <label for="horimetro_final" class="col-md-4 col-form-label text-md-end text-right">Horímetro
                Final</label>

            <div class="col-md-6">
                <input name="horimetro_final" id="horimetro_final" type="number" step="0.01"
                    class="form-control-template" horimetro_final="horimetro_final"
                    value="{{ $produto->horimetro_final ?? old('horimetro_final') }}" autofocus>
                {{ $errors->has('horimetro_final') ? $errors->first('horimetro_final') : '' }}

            </div>
        </div>


        <div class="row mb-1">
            <label for="situacao" class="col-md-4 col-form-label text-md-end text-right">Situação</label>

            <div class="col-md-6">
                <select name="status" id="status" class="form-control-template">
                    <option value="">--Selecione a Situação--</option>
                    <option value="ABERTO">Aberto</option>
                    <option value="EM PRODUÇÃO">Em produção</option>
                    <option value="CONCLUIDO">Concluida</option>
                </select>
                {{ $errors->has('situacao') ? $errors->first('situacao') : '' }}

            </div>
        </div>



        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
</div>


<script>
    $(function() {
        $('#equipamento_id').change(function() {
            var equipamento_id = $("#equipamento_id option:selected").val();
            $("#horimetro_inicial").val('');
            $.ajax({
                url: "{{route('utils.get-horimetro-inicial')}}",
                type: "get",
                data: {
                    'equipamento_id': equipamento_id,
                },
                dataType: "json",
                success:function(response) {
                    $("#horimetro_inicial").val(response);
                }
            })
            
        });
    });

    // executa quando a pagina é carregada

    window.onload = function() {
        let data_atual = new Date();
        var dia = String(data_atual.getDate()).padStart(2, '0');
        var mes = String(data_atual.getMonth() + 1).padStart(2, '0');
        var ano = data_atual.getFullYear();
        data_atual = ano + '-' + mes + '-' + dia;
        document.getElementById("data_inicio").value = data_atual;
        document.getElementById("data_fim").value = data_atual;
    }
</script>
