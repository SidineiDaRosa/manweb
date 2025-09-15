{{----------------------------------------}}
{{--mensagem de erro de serviço ja cadastrado----------------------}}
@if(session('error'))
<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 4px;">
    {{ session('error') }}
</div>
@endif
<form id="meuForm" action="{{route('Servicos-executado.store',['$ordem_servico'=>$ordem_servico_id])}}" method="POST">
    @csrf

    <div class="row mb-1 ">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">ID O.S.</label>
        <div class="col-md-2">
            <input id="idOs" type="nuber" class="form-control custom-font-size 40" name="ordem_servico_id" value="{{$ordem_servico_id}}" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Data Emissão</label>

        <div class="col-md-2">
            <input type="date" class="form-control" id="data_emissao" name="data_emissao" placeholder="dataEmissao" value="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Hora emissão</label>

        <div class="col-md-2">
            <input type="time" class="form-control" name=hora_emissao id="hora_emissao" placeholder="horaEmissao" required value="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Data início</label>

        <div class="col-md-2">
            <input type="date" class="form-control" name="data_inicio" id="data_inicio" placeholder="dataPrevista" required value="" onchange="ValidateDatePrevista()">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe data.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Hora início</label>
        <div class="col-md-2">
            <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="horaPrevista" required value="">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe hora.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Data fim</label>

        <div class="col-md-2">
            <input type="date" class="form-control" name="data_fim" id="data_fim" placeholder="dataFim" required value="" onchange="ValidateDateFim()">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe data.
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Hora fim</label>
        <div class="col-md-2">
            <input type="time" class="form-control" name="hora_fim" id="hora_fim" placeholder="horaFim" required value="">
        </div>
        <div class="invalid-tooltip">
            Por favor, informe hora.
        </div>
    </div>

    <div class="div-description">
        <div id="div-executante">
            <select name="funcionario_id" id="funcionario_id" class="form-control" required style="font-family: Arial, Helvetica, sans-serif;">
                <option value="" style="font-family: Arial, Helvetica, sans-serif;"> --Selecione o Responsável--</option>
                @foreach ($funcionarios as $funcionario_find)
                <option value="{{$funcionario_find->id}}" {{($funcionario_find->responsavel ?? old('responsavel')) == $funcionario_find->primeiro_nome ? 'selected' : '' }}
                    style="font-family: Arial, Helvetica, sans-serif;">
                    {{$funcionario_find->primeiro_nome}}
                </option>
                @endforeach
            </select>
            {{ $errors->has('responsavel') ? $errors->first('responsavel') : '' }}
        </div>
        <style>
            .div-description {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: auto;
                /* Garante que o contêiner ocupe a altura total da viewport */
            }

            .form-control-txt {
                height: 100px;
                font-family: Arial, sans-serif;
                overflow: auto;
                white-space: pre-wrap;
                width: 50%;
                border: 1px solid blue;
                /* Ajusta a largura da borda */
                border-radius: 5px;
            }

            .form-control-txt:focus {
                border: 1px solid red;
                /* Borda vermelha quando o campo está em foco */
                outline: none;
                /* Remove o contorno padrão do navegador */
                box-shadow: 0 0 5px #721c24;
                /* Adiciona uma sombra à borda */
            }
            #div-executante{
                    width:33%;
                }

            @media (max-width: 900px) {
                .form-control-txt {
                    width: 100%;
                    /* Ajusta a largura do textarea em telas menores */
                }
                #div-executante{
                    width:100%;
                }
            }
        </style>

        <textarea class="form-control-txt" id="descricao" name="descricao" rows="5" cols="50" required placeholder="--descreva os serviços executados--"></textarea>
    </div>
    <script>
        //----------------------------------------------------------//
        //   Desabilita o texto descrição 
        //----------------------------------------------------------//
        document.addEventListener('DOMContentLoaded', function() {
            function disableDesc() {
                const descriptionElement = document.getElementById('descricao');
                const divDescriptionElement = document.getElementById('div-description');
                const divButtonElement = document.getElementById('div-button-send');
                const divExecutanteElement = document.getElementById('div-executante');
                // divDescriptionElement.style.display = 'none'; // Oculta a descrição ao iniciar
                divButtonElement.style.display = 'none'; // Oculta a descrição ao iniciar  
                descriptionElement.style.display = 'none'; // Oculta a descrição ao iniciar  
                divExecutanteElement.style.display = 'none'; // Oculta a descrição ao iniciar  
            }
            // Chama a função disableDesc ao carregar a página
            disableDesc();
        });

        function EnableDesc() {

            const descriptionElement = document.getElementById('descricao');
            //const divDescriptionElement = document.getElementById('div-description');
            const divButtonElement = document.getElementById('div-button-send');
            //divDescriptionElement.style.display = 'block'; // Exibe a descrição ao habilitar
            divButtonElement.style.display = 'block'; // Exibe a descrição ao habilitar  
            descriptionElement.style.display = 'block'; // Exibe a descrição ao habilitar 
            descriptionElement.focus(); // Chama a função focus() corretamente
        }
    </script>
    <div class="invalid-tooltip">Por favor,
        informe os dados. </div>
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
            } else {

            }
        }
    </script>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Tipo de serviço</label>
        <div class="col-md-2">
            <select class="form-control" name="tipo_de_servico" id="tipo_de_servico" name="tipo_de_servio" style="background-color: rgba(249, 187, 120, 0.2) ;">
                <option value="Corretiva">Corretiva</option>
                <option value="Preventiva">Preventiva</option>
                <option value="Preventiva">Preditiva</option>
                <option value="Inspeção">Chek-List</option>
                <option value="Ampliação">Ampliação</option>
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Estado avaliação</label>
        <div class="col-md-2">
            <select class="form-control" name="estado" id="estado" name="estado" style="background-color: rgba(249, 187, 120, 0.2) ;">
                <option value="Bom">Bom</option>
                <option value="Regular">Regular</option>
                <option value="Ruim">Ruim</option>
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Total horas</label>

        <div class="col-md-2">
            <input type="number" class="form-control" id="total_horas" name="subtotal" value="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right"></label>
        <!-- Modal -->
        <div class="modal fade" id="modalOpcoes" tabindex="-1" aria-labelledby="modalOpcoesLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalOpcoesLabel">Escolha uma opção</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Selecione apenas uma opção:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1" id="opcao1" name="option" required>
                            <label class="form-check-label" for="opcao1">Lançar os serviços apenas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" id="opcao2" name="option" required>
                            <label class="form-check-label" for="opcao2">Criar um pedido de saída, e lançar os materias utilizados</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="3" id="opcao3" name="option" required>
                            <label class="form-check-label" for="opcao3">Selecionar um pedido já aberto, e lançar os materiais</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmarOpcoes">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="div-button-send">
            <!-- Botão para abrir a modal -->
            <button type="button" class="btn btn-primary" id="btnModal" onclick="CallSumHours()">Cadastrar</button>
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

<script src=" https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    EnableDesc()
                    var inputDesc = document.getElementById("executado");
                    inputDesc.focus();
                } else {
                    document.getElementById("data_inicio").value = 0;
                    document.getElementById("hora_inicio").value = 0;
                    document.getElementById('funcionario_id').value = 0;
                    alert("Você está tentando lançar em um período que já consta um lançamento de serviço seu!" + response.mensagem);

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
    // Validação de hora de fim
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

            document.getElementById('div-executante').style.display = 'block'; // Oculta a descrição ao iniciar   
            CallSumHours()
        }
    });
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form com Modal</title>
    <!-- Incluindo o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Incluindo o JavaScript do Bootstrap e JavaScript personalizado -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Obtém o botão que abre a modal e o form
        const btnModal = document.getElementById('btnModal');
        const meuForm = document.getElementById('meuForm');

        // Referência para a modal
        const modalOpcoes = new bootstrap.Modal(document.getElementById('modalOpcoes'));

        // Abre a modal ao clicar no botão de envio
        btnModal.addEventListener('click', function() {
            modalOpcoes.show();
        });

        // Ao confirmar a seleção na modal, verifica se uma opção foi escolhida
        document.getElementById('confirmarOpcoes').addEventListener('click', function() {
            const radioSelecionado = document.querySelector('input[name="option"]:checked');
            if (radioSelecionado) {
                // Se uma opção estiver selecionada, submete o formulário
                meuForm.submit();
            } else {
                alert('Por favor, selecione uma opção.');
            }
        });
    </script>

</body>

</html>

</body>