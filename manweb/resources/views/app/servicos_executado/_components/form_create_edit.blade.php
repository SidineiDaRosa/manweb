{{----------------------------------------}}
{{--mensagem de erro de serviço ja cadastrado----------------------}}
@if(session('error'))
<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 4px;">
    {{ session('error') }}
</div>
@endif
<form action="{{route('Servicos-executado.store',['$ordem_servico'=>$ordem_servico_id])}}" method="POST">
    @csrf
    <div class="row mb-1 ">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">ID Os</label>
        <div class="col-md-6">
            <input id="idOs" type="nuber" class="form-control custom-font-size 40" name="ordem_servico_id" value="{{$ordem_servico_id}}" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Data Emissão</label>

        <div class="col-md-6">
            <input type="date" class="form-control" id="data_emissao" name="data_emissao" placeholder="dataEmissao" value="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Hora emissão</label>

        <div class="col-md-6">
            <input type="time" class="form-control" name=hora_emissao id="hora_emissao" placeholder="horaEmissao" required value="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Data início</label>

        <div class="col-md-6">
            <input type="date" class="form-control" name="data_inicio" id="data_inicio" placeholder="dataPrevista" required value="" onchange="ValidateDatePrevista()">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe data.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Hora início</label>
        <div class="col-md-6">
            <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="horaPrevista" required value="">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe hora.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Data fim</label>

        <div class="col-md-6">
            <input type="date" class="form-control" name="data_fim" id="data_fim" placeholder="dataFim" required value="" onchange="ValidateDateFim()">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe data.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Hora fim</label>
        <div class="col-md-6">
            <input type="time" class="form-control" name="hora_fim" id="hora_fim" placeholder="horaFim" required value="">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe hora.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Executante da tarefa</label>
        <div class="col-md-6">
            <select name="funcionario_id" id="funcionario_id" class="form-control-template">
                <option value=""> --Selecione o Responsável--</option>
                @foreach ($funcionarios as $funcionario_find)
                <option value="{{$funcionario_find->id}}" {{($funcionario_find->responsavel ?? old('responsavel')) == $funcionario_find->primeiro_nome ? 'selected' : '' }}>
                    {{$funcionario_find->primeiro_nome}}
                </option>
                @endforeach
            </select>
            {{ $errors->has('responsavel') ? $errors->first('responsavel') : '' }}
        </div>
        <div class="invalid-tooltip">
            Por favor, informe os dados.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">descrição dos serviços executados</label>
        <div class="col-md-6">
            <input type="text" id="executado" type="text" class="form-control" name="descricao" value="" rows="3" require>
        </div>
        <div class="invalid-tooltip">
            Por favor, informe os dados.
        </div>
        <style>
            #executado {
                height: 50px;
            }
        </style>
    </div>

    <script>
        function ValidateDatePrevista() {
            let dataPrevista = document.getElementById('dataPrevista').value;
            let dataEmissao = document.getElementById('data_emissao').value;
            if (dataPrevista < dataEmissao) {
                alert('Atenção! A data prevista que você está inserindo é anterior a data de emissão.');
                //document.getElementById('dataPrevista').value = 'null';

            }
        }

        function ValidateDateFim() {
            let dataPrevista = document.getElementById('dataPrevista').value;
            let dataFim = document.getElementById('dataFim').value;
            if (dataFim < dataPrevista) {
                alert('Atenção! A data prevista deve ser maior que a data prevista para término.');
                document.getElementById('dataFim').value = 'null';
            }
        }
    </script>
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Total horas</label>

        <div class="col-md-6">
            <input type="number" class="form-control" id="total_horas" name="subtotal" value="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right"></label>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="CallSumHours()">
                Cadastrar
            </button>
        </div>
    </div>
</form>
</div>
<script>
    function CallSumHours() {
        function calcularTotalHoras(dataInicial, horaInicial, dataFinal, horaFinal) {
            const dataHoraInicial = new Date(`${dataInicial}T${horaInicial}`);
            const dataHoraFinal = new Date(`${dataFinal}T${horaFinal}`);

            const diferencaEmMilissegundos = dataHoraFinal - dataHoraInicial;
            const milissegundosEmHora = 3600000; // 1 hora em milissegundos

            const totalHoras = diferencaEmMilissegundos / milissegundosEmHora;
            //const totalHorasFormatado = Math.floor(parseFloat(totalHoras.toFixed(2))); // Remove as casas decimais
            const totalHorasFormatado = (parseFloat(totalHoras.toFixed(2))); // Remove as casas decimais
            document.getElementById('total_horas').value = totalHorasFormatado
            //return totalHoras;
        }

        const dataInicial = document.getElementById('data_inicio').value; // Valor do input da data inicial
        const horaInicial = document.getElementById('hora_inicio').value; // Valor do input da hora inicial
        const dataFinal = document.getElementById('data_fim').value; // Valor do input da data final
        const horaFinal = document.getElementById('hora_fim').value; // Valor do input da hora final

        if (dataInicial && horaInicial && dataFinal && horaFinal) {
            const totalHoras = calcularTotalHoras(dataInicial, horaInicial, dataFinal, horaFinal);
            //alert(`Total de horas: ${totalHoras}`);
        } else {
            //alert('Por favor, preencha todos os campos.');
        }
    }
</script>
{{---------------------------------------------------------------------}}
{{--Jason que verifica se as datas são válidas-------------------------}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Função para executar o código após a atualização da select
    function executarAposAtualizarSelect() {

        var dataInicio = document.getElementById("data_inicio").value;
        var horaInicio = document.getElementById("hora_inicio").value;
        var dataFim = document.getElementById("data_fim").value;
        var horaFim = document.getElementById("hora_fim").value;
        let selectElement = document.getElementById('funcionario_id');
        let executante = selectElement.value;
        $.ajax({
            type: "POST",
            url: '{{ route("validar-data-hora-termino") }}',
            data: {
                data_inicio: dataInicio,
                hora_inicio: horaInicio,
                data_fim: dataFim,
                hora_fim: horaFim,
                executante: executante,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.valid) {
                    alert("Data e hora válidas.");
                    var input = document.getElementById("data_inicio");
                    input.style.backgroundColor = "rgb(150, 255, 150)";
                    input.readOnly = true;

                    var inputHoraInicio = document.getElementById("hora_inicio");
                    inputHoraInicio.style.backgroundColor = "rgb(150, 255, 150)";
                    inputHoraInicio.readOnly = true;

                    var inputDesc = document.getElementById("executado");
                    inputDesc.focus();
                } else {
                    document.getElementById("data_inicio").value = 0;
                    document.getElementById("hora_inicio").value = 0;
                    document.getElementById('funcionario_id').value = 0;
                    alert("Você está tentando lançar em um período que já consta um lançamento de serviço seu!"+response.mensagem);

                    var input = document.getElementById("data_inicio");
                    input.style.backgroundColor = "rgb(255, 150, 150)";
                    input.focus();
                    input.setSelectionRange(input.value.length, input.value.length);

                    // Abrir a modal aqui
                    //var modal = document.getElementById('myModal');
                    //modal.style.display = "block";
                }
            }
        });
    }

    // Adicionar um evento change à select
    $(document).ready(function() {
        $('#funcionario_id').change(function() {
            executarAposAtualizarSelect();
        });
    });
    //--------------------------------------------------------------------------------------//
    //Verifica o entradas no data fim maior ou igual data_inicio----------------------------//
    document.getElementById('data_fim').addEventListener('change', function() {
        var dataInicio = document.getElementById('data_inicio').value;
        var dataFim = this.value;

        if (dataInicio > dataFim) {
            alert('A data de fim não pode ser menor que a data de início.');
            document.getElementById('data_fim').value = '';
            document.getElementById('data_fim').style.backgroundColor = "rgb(255, 150, 150)";
            document.getElementById('data_fim').focus();
        } else {
            document.getElementById('data_fim').style.backgroundColor = "rgb(150, 255, 150)";
        }
    });
    //---------------------------------------------------------------------------------------//
    //verifica  a hora fim
    document.getElementById('hora_fim').addEventListener('change', function() {
        var dataInicio = document.getElementById('data_inicio').value;
        var dataFim = document.getElementById('data_fim').value;
        var horaInicio = document.getElementById('hora_inicio').value;
        var horaFim = this.value;

        if (dataFim < dataInicio) {
            alert('A data de fim não pode ser menor que a data de início.');
            document.getElementById('data_fim').value = '';
            document.getElementById('data_fim').style.backgroundColor = 'rgb(255, 150, 150)';
            document.getElementById('data_fim').focus();
        } else if (dataFim == dataInicio && horaFim <= horaInicio) {
            alert('A hora de fim não pode ser menor que a hora de início para a mesma data.');
            document.getElementById('hora_fim').value = '';
            document.getElementById('hora_fim').style.backgroundColor = 'rgb(255, 150, 150)';
            document.getElementById('hora_fim').focus();
        } else {
            document.getElementById('data_fim').style.backgroundColor = 'rgb(150, 255, 150)';
            document.getElementById('hora_fim').style.backgroundColor = 'rgb(150, 255, 150)';
            CallSumHours()
        }
    });
</script>
</body>