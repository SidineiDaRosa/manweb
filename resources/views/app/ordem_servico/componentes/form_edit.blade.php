{{--modal window --}}

<script>
    function ValidateHoraInicio() {
        var dataInicioElement = document.getElementById('dataPrevista');
        var horaInicioElement = document.getElementById('hora_inicio');
        var dataFimElement = document.getElementById('dataFim');
        var horaFimElement = document.getElementById('hora_fim');

        // Validação de data e hora
        var dataInicio = new Date(dataInicioElement.value);
        var horaInic = horaInicioElement.value;
        var dataFim = new Date(dataFimElement.value);
        var horaFim = horaFimElement.value;

        // Verifica se as datas e horas estão preenchidas
        if (!dataInicio || !horaInic || !dataFim) {
            alert('Por favor, preencha todas as datas e horas.');
            return;
        }

        // Verifica se dataPrevista é igual a dataFim para validar as horas
        if (dataInicio.getTime() === dataFim.getTime()) {
            // Verifica se horaFim é maior que horaInicio
            if (horaFim <= horaInic) {
                alert('Hora de fim deve ser maior que hora de início.');
                horaFimElement.style.background = "red";
                horaFimElement.value = '';
                return;
            }
        }
        // Resetar estilos caso válido
        horaInicioElement.style.background = "rgb(150, 255, 150)";
        horaFimElement.style.background = "rgb(150, 255, 150)";
    }
</script>
</style>
<div class="bg-modal" id="bg-modal">
    <div class="modal-md">
        <h6>Alteração do status da ordem de serviço</h6>
        <div class="col-md-12 mb-4">
            <select class="form-control" name="situacao" id="situacao2" value="option">
                <script>
                    //var select = document.getElementById('situacao2');
                    //var v1 = select.options[select.selectedIndex].value;
                    function FunSituacao() {
                        var alterSatatusOs
                        var select = document.getElementById('situacao2');
                        var alterSatatusOs = select.options[select.selectedIndex].value;
                        document.getElementById('situacao').value = alterSatatusOs;
                        fechaModal();
                    }
                </script>
                <option value="aberto">Aberto</option>
                <option value="fechado">Fechado</option>
                <option value="indefinido">Indefinido</option>
                <option value="cancelada">Cancelada</option>
                <option value="em andamento">Em andamento</option>
                {{ $errors->has('nome') ? $errors->first('nome') : '' }}
            </select>
            <div class="invalid-tooltip">
                Por favor, informe situacao.
            </div>
        </div>
        <div class="class=col-md-12 mb-1">
            <a class="btn btn-md-template btn-primary" onclick="FunSituacao()">
                <span class="icon text-white-50">
                    <i class="icofont-save"></i>
                </span>
                <span class="text">Salvar</span>
            </a>
            <a class="btn btn-primary btn-md btn-danger" onclick="fechaModal()">
                <span class="icon text-white-50">
                    <i class="icofont-close-circled"></i>
                </span>
                <span class="text">Cancelar</span>
            </a>
        </div>
    </div>
</div>
<style>
    .bg-modal {
        width: 100%;
        height: 100%;
        background-color: #e4e6ee8e;
        position: fixed;
        z-index: 2;
        display: none;
    }

    .modal-md {
        width: 33%;
        height: 33%;
        margin-left: 33%;
        background-color: #778d97;
        align-items: center;
        text-align: center;
        margin-top: 5%;
        border: none;
        padding: 10px;

    }

    .modal span {
        float: right;
        font-size: 22px;
        color: #000;
        margin: 20px 20px;
        cursor: pointer;
    }

    .modal span:hover {
        color: crimson;
        font-size: 30px;
    }

    #btNaoSalvar {
        background-color: rgb(150, 11, 69);
    }

    #btSalvar {
        background-color: lightgreen;
    }

    .bt-tm-1 {
        width: 200px;
        height: 50px;
    }

    @media only screen and (max-width: 640px) {
        .modal {
            width: 100%;
            height: 100%;
            margin-left: 0%;
            background-color: #cad5da;
            border: 1px solid #110947;
            align-items: center;
            text-align: center;

        }

    }
</style>
<script>
    function abreModal() {
        document.getElementById('bg-modal').style.display = 'block';
    }

    function fechaModal() {
        document.getElementById('bg-modal').style.display = 'none';
    }
</script>
{{---------------------------------------------------------------------}}
{{--Inicio de formulário de ordem de serviço--=------------------------}}
<form action="{{ route('ordem-servico.update', ['ordem_servico' => $ordem_servico->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <!------------------------------------------------------------------------------------------->
    {{-------------------------------------------------------------------------}}
    {{--início da div que contem os box--}}


    <style>
        hr {
            margin: -5px;
        }

        .box-conteudo {
            margin-left: 5px;
            justify-content: flex-start;
        }

        .titulo {
            display: flex;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;

        }

        .conteudo {
            display: flex;
            font-size: 20px;
            font-weight: 400;
            font-family: 'Poppins', sans-serif;
            color: #007b00;
            margin-bottom: -1px;
            align-items: flex-end;
        }

        #patrimonio {
            color: #2174d4;
        }

        .span-texto-sm {
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            color: mediumblue;
            font-size: 15px;
            margin-bottom: 1px;
        }

        .input-text {
            margin-top: 5px;
            width: 50%;
            border: none;
            color: #2174d4;
        }
    </style>
    <div class="container-chart">
        {{--Box 1--}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">ID:</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-text" name="ordem_servico_id" id="ordem_servico_id" value="{{$ordem_servico->id}}" readonly style="color:#007b00">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
                <div class="titulo">Empresa:</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-text" name="empresa_id" id="empresa_id" value="{{$ordem_servico->empresa->id}}" readonly style="width:20%;color:#007b00">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                    <input type="text" class="input-text" name="razao_social" id="razao_social" value="{{$ordem_servico->empresa->razao_social}}" readonly style="width:80%;color:#007b00">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>

                <div class="titulo">ID patrimonio:</div>
                <hr>
                <div class="conteudo">
                    <input id="equipamento_id" type="text" class="input-text" name="equipamento_id" value="{{ $ordem_servico->equipamento->id}}" readonly style="width:20%;color:#007b00">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
                <div class="titulo">Patrimonio:</div>
                <hr>
                <div class="conteudo">
                    <input id="patrimonio" type="text" class="input-text" name="nome" value="{{ $ordem_servico->equipamento->nome }}" disabled style="width:80%;color:#007b00">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
                <div class="titulo">Emissor:</div>
                <hr>
                <div class="conteudo">
                    <input id="emissor" type="text" class="input-text" name="emissor" value="{{$ordem_servico->emissor}}" readonly style="color:#007b00">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
                <div class="titulo">Executor:</div>
                <hr>
                <div class="conteudo">
                    <select name="responsavel" id="responsavel" class="input-text">
                        <option value="{{$ordem_servico->responsavel}}">{{$ordem_servico->responsavel}}</option>
                        @foreach ($funcionarios as $funcionario_find)
                        <option value="{{$funcionario_find->primeiro_nome}}" {{($funcionario_find->responsavel ?? old('responsavel')) == $funcionario_find->primeiro_nome ? 'selected' : '' }}>
                            {{$funcionario_find->primeiro_nome}}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('responsavel') ? $errors->first('responsavel') : '' }}
                </div>
                <div class="titulo">Emissão:</div>
                <hr>
                <div class="conteudo">
                    <input type="date" class="input-text" id="d_emissao" name="data_emissao" value="{{$ordem_servico->data_emissao}}" readonly>
                    <div class="invalid-tooltip">
                        informe a data
                    </div>
                    <input type="time" class="input-text" name="hora_emissao" id="h_emissao" required value="{{$ordem_servico->hora_emissao}}" readonly>
                    <div class="invalid-tooltip">
                        Por favor, informe a hora.
                    </div>
                </div>
                <div class="titulo">Previsão para início:</div>
                <hr>
                <div class="conteudo">
                    <input type="date" class="input-text" name="data_inicio" id="dataPrevista" required value="{{$ordem_servico->data_inicio}}" onchange=" ValidateDate()">
                    <div class="invalid-tooltip">
                        Por favor, informe data
                    </div>
                    <input type="time" class="input-text" name="hora_inicio" id="hora_Inicio" required value="{{$ordem_servico->hora_inicio}}" onchange="ValidateHora()">
                    <div class="invalid-tooltip">
                        Por favor, informe hora.
                    </div>
                    <script>
                        function ValidateHora(){
                            document.getElementById('hora_Fim').value=''// seta para vazio a hora inicio
                            document.getElementById('hora_Fim').style.backgroundColor = '#FFC0CB'
                            alert('Escolha a hora de fim')
                        }
                    </script>
                </div>
                <div class="titulo">Previsão para finalização:</div>
                <hr>
                <div class="conteudo">
                    <input type="date" class="input-text" name="data_fim" id="dataFim" required value="{{$ordem_servico->data_fim}}" required onchange="ValidateDate()">
                    <div class="invalid-tooltip">
                        Por favor, informe dataFim.
                    </div>

                    <input type="time" class="input-text" name="hora_fim" id="hora_Fim" value="{{$ordem_servico->hora_fim}}" onchange="ValidateHoraFim()">
                    <div class="invalid-tooltip">
                        Por favor, informe um estado válido.
                    </div>
                    <script>
                        function ValidateDate() {
                            // Validação de data
                            let dataEmissao = document.getElementById('d_emissao').value;
                            let dataPrevista = document.getElementById('dataPrevista').value;
                            let dataFim = document.getElementById('dataFim').value;
                            if (dataPrevista < dataEmissao) {
                                alert('A data prevista deve ser maior que a data de emissão!');
                                document.getElementById('dataPrevista').value = 'null';
                                document.getElementById('dataPrevista').style.backgroundColor = '#FFC0CB';
                                document.getElementById('dataPrevista').focus();
                            } else {
                                document.getElementById('dataPrevista').style.backgroundColor = '#7FFF7F';

                                if (dataFim < dataPrevista) {
                                    document.getElementById('dataFim').value = 'null';
                                    document.getElementById('dataFim').style.backgroundColor = '#FFC0CB';
                                } else {

                                    document.getElementById('dataFim').style.backgroundColor = '#7FFF7F';
                                }

                            }
                        }
                        // Validação de horas
                        function ValidateHoraFim() {

                            // Validação de data
                            let dataInicio = document.getElementById('dataPrevista').value;

                            let horaInicio = document.getElementById('hora_Inicio').value;

                            let dataFim = document.getElementById('dataFim').value;

                            let horaFim = document.getElementById('hora_Fim').value;

                            // Validação de data e hora
                            // Verifica se as datas e horas estão preenchidas
                            if (!dataInicio || !horaInicio || !dataFim) {
                                alert('Por favor, preencha todas as datas e horas.');
                                return;
                            }

                            // Verifica se dataPrevista é igual a dataFim para validar as horas
                            if (dataInicio === dataFim) {
                                // Verifica se horaFim é maior que horaInicio
                                if (horaFim <= horaInicio) {
                                    alert('Hora de fim deve ser maior que hora de início.');
                                    document.getElementById('hora_Fim').style.backgroundColor = 'red'
                                    document.getElementById('hora_Fim').value = ''
                                    return;
                                } else {
                                    document.getElementById('hora_Fim').style.backgroundColor = "rgb(150, 255, 150)"
                                    document.getElementById('hora_Inicio').style.backgroundColor = "rgb(150, 255, 150)"
                                }
                            } else {
                                document.getElementById('hora_Fim').style.backgroundColor = "rgb(150, 255, 150)"
                                document.getElementById('hora_Inicio').style.backgroundColor = "rgb(150, 255, 150)"
                            }
                            // Resetar estilos caso válido
                            //horaInicioElement.style.background = "rgb(150, 255, 150)";
                            //horaFimElement.style.background = "rgb(150, 255, 150)";
                            // document.getElementById('hora_Fim').style.backgroundColor = "rgb(150, 255, 150)"
                            //document.getElementById('hora_Fim').style.background = ''
                        }
                    </script>
                </div>
            </div>
        </div>
        {{--Box 2--}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">
                    <textarea id="descricao" class="form-control" rows="6" style="color:crimson" name="descricao" placeholder="--Insira a descrição do serviço--">{{$ordem_servico->descricao}}</textarea>
                </div>
                <style>
                    #txt-area {
                        height: auto;
                        width: 100%;
                        border: 1px solid rgba(33, 116, 212, 0.3);
                        border-radius: 5px;
                        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                        background-color: transparent;
                        /* Transparent background */

                    }

                    #txt-area:focus {
                        border-color: rgba(33, 116, 212, 0.5);
                        /* Use the same rgba color but with a different opacity */
                        box-shadow: 0 0 0 0.1rem rgba(33, 116, 212, 0.25);
                        /* Add a shadow to match Bootstrap */
                        outline: none;
                        /* Remove the default outline */

                    }
                </style>
                <div class="titulo">Situação:</div>
                <hr>
                <div class="conteudo">
                    <input id="situacao" type="text" class="input-text" name="situacao" value="{{$ordem_servico->situacao}}" readonly style="height:30px;">
                    <div class="invalid-tooltip">
                        Por favor, informe situacao.
                    </div>
                    <input class="btn btn-outline-success btn-sm" type="button" name="openmodalsituacao" id="openmodalsituacao" value="Alterar status" onclick="abreModal()">
                </div>
                <div class="titulo">Progressão do serviço:</div>
                <hr>
                <div class="conteudo">
                    <input id="status_servicos" type="text" class="input-text" value="{{$ordem_servico->status_servicos}}">%
                </div>
                <div class="titulo"></div>
                <hr>
                <div class="conteudo">
                    <style>
                        .progress-bar {
                            width: 100%;
                            background-color: #f1f1f1;
                        }

                        .progress {
                            height: 30px;
                            background-color: #4caf50;
                            text-align: center;
                            line-height: 30px;
                            color: white;
                        }

                        .progress-container {
                            width: 100%;
                            margin: 20px auto;
                        }

                        input[type="range"] {
                            width: 100%;
                        }
                    </style>
                    <div class="progress-container">
                        <input type="range" min="0" max="100" value="{{$ordem_servico->status_servicos}}" class="slider" id="progressSlider" onchange="updateProgress()" name="status_servicos">
                    </div>
                    <script>
                        function updateProgress() {
                            // Obtém o valor do controle deslizante
                            let progresServ = document.getElementById('progressSlider').value;
                            // Atualiza o valor do campo de entrada
                            document.getElementById('status_servicos').value = progresServ;
                        }
                    </script>
                    {{-----------------------------------------------------------------}}

                </div>
                <div class="titulo">Imagem:</div>
                <hr style="margin-bottom:3px;">
                <div class="conteudo">
                    <input class="btn btn-outline-dark btn-sm" type="file" id="imagem" name="imagem" style="font-family:'Poppins', sans-serif; font-weight:300; background-color:green; width:100%">
                </div>
            </div>
        </div>
        {{--Box 3--}}
        <div class="item">
            <div class="titulo">Natureza da O.S</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="natureza_do_servico" id="natureza_do_servico" value="">
                <option value="{{$ordem_servico->natureza_do_servico}}">{{$ordem_servico->natureza_do_servico}}</option>
                    <option value="corretiva">Corretiva</option>
                    <option value="ampliacao">Ampliação</option>
                    <option value="investimento">Investimento</option>
                    <option value="Preventiva">Preventiva</option>
                    <option value="Preditiva">Preditiva</option>
                    <option value="Instalação">Instalação</option>
                    <option value="rotina">Rotina periódica check-list</option>
                    <option value="outro">Outro</option>

                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>
            <div class="titulo">Especialidade da O.S</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="especialidade_do_servico" id="especialidade_do_servico" value="">
                <option value="{{$ordem_servico->especialidade_do_servico}}">{{$ordem_servico->especialidade_do_servico}}</option>
                    <option value="eletrica">Elétrica</option>
                    <option value="mecanica">Mecanica</option>
                    <option value="civil">Civil</option>
                    <option value="SESMT">SEMT</option>
                    <option value="Tarefa avulsa">Tarefa avulsa</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tarefa.
                </div>
            </div>
            <div class="titulo">Gravidade</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="gravidade" id="gravidade" value="">
                    <option value="{{$ordem_servico->gravidade}}">{{$ordem_servico->gravidade}}</option>
                    <option value="5">Extremamante grave 5</option>
                    <option value="4">Muito grave 4</option>
                    <option value="3">Grave 3</option>
                    <option value="2">Pouco grave 3</option>
                    <option value="1">Nada grave 1</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a gravidade.
                </div>
            </div>
            <div class="titulo">Urgência</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="urgencia" id="urgencia" value="">
                    <option value="{{$ordem_servico->urgencia}}">{{$ordem_servico->urgencia}}</option>
                    <option value="5">Extremamante urgente 5</option>
                    <option value="4">Urgente 4</option>
                    <option value="3">Urgente se possível 3</option>
                    <option value="2">Pouco urgente 2</option>
                    <option value="1">Não urgente 1</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a Urgência.
                </div>
            </div>
            <div class="titulo">Tendência</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="tendencia" id="tendencia" value="">
                    <option value="{{$ordem_servico->tendencia}}">{{$ordem_servico->tendencia}}</option>
                    <option value="5">Piorar rápidamante 5</option>
                    <option value="4">Piorar em curto prazo 4</option>
                    <option value="3">Piorar 3</option>
                    <option value="2">Piorar logo prazo 2</option>
                    <option value="1">Não irá piorar 1</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>

            <div class="titulo">Causa</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="causa" id="causa" value="">
                    <option value="6">Nenhuma</option>
                    <option value="5">Quebra imprevisto</option>
                    <option value="4">Erro operacional</option>
                    <option value="3">Proposital</option>
                    <option value="2">Desgaste Fadiga</option>
                    <option value="1">Erro de projeto peça com defeito</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>
            <div class="titulo">Efeito</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="efeito" id="efeito" value="">
                    <option value="2">Nenhum</option>
                    <option value="3">Riscos humano</option>
                    <option value="4">Atrazo na produção</option>
                    <option value="5">Prejuizo na produção</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>
            <div class="titulo">Solução</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="solucao" id="solucao" value="">
                    <option value="5">Agilizar</option>
                    <option value="4">Mão de obra autonama</option>
                    <option value="3">Acionar segurança</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>
            {{-- Início de assinatura manual --}}
            <div id="confirmacao" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border-radius: 5px; text-align: center;">
                    <p>Deseja salvar esta assinatura?</p>
                    <button type="button" class="btn btn-success" onclick="saveSignature()">Sim</button>
                    <button type="button" class="btn btn-danger" onclick="cancelSignature()">Cancelar</button>
                </div>
            </div>

            <canvas id="meuCanvas" width="150" height="50" style="border: 1px solid black;"></canvas>
            <input type="hidden" id="signature_receptor" name="signature_receptor" value="null">
            <br>
            <button type="button" class="btn btn-outline-primary btn-sm" id="salvar" onclick="showConfirmation()">Salvar Assinatura</button>

            {{-- Botão de envio, inicialmente desabilitado --}}

            <script>
                const canvas = document.getElementById('meuCanvas');
                const ctx = canvas.getContext('2d');
                let desenhando = false;

                canvas.addEventListener('mousedown', (e) => {
                    desenhando = true;
                    ctx.beginPath();
                    ctx.moveTo(e.offsetX, e.offsetY);
                });

                canvas.addEventListener('mousemove', (e) => {
                    if (desenhando) {
                        ctx.lineTo(e.offsetX, e.offsetY);
                        ctx.stroke();
                    }
                });

                canvas.addEventListener('mouseup', () => {
                    desenhando = false;
                });

                canvas.addEventListener('mouseout', () => {
                    desenhando = false;
                });

                function showConfirmation() {
                    document.getElementById('confirmacao').style.display = 'block';
                }

                function saveSignature() {
                    const dataURL = canvas.toDataURL('image/png');
                    document.getElementById('signature_receptor').value = dataURL;
                    document.getElementById('confirmacao').style.display = 'none'; // Esconde a div de confirmação
                    document.getElementById('submitBtn').disabled = false; // Habilita o botão de envio
                }

                function cancelSignature() {
                    document.getElementById('confirmacao').style.display = 'none'; // Esconde a div de confirmação
                }
            </script>
            {{-- Fim de assinatura manual --}}

        </div>
        {{--fim card 3--}}
        <div class="row sm-3 mb-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    Alterar ordem de serviço
                </button>
            </div>
        </div>

</form>
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }


    .container-chart {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: flex-start;
        background-color: white;
        margin: -1;

    }

    /*borda total de horas trabalhadas*/
    .mb-3,
    .my-3 {
        border-bottom: none;
    }


    .item {
        width: calc(33% - 20px);
        height: auto;
        margin: 10px;
        padding: 15px;
        background-color: white;
        overflow: auto;
        /* Impede que o conteúdo transborde */
        font-weight: 500;
    }

    .box {
        display: flex;
        width: 100%;
        height: auto;
        margin-bottom: 1px;
        background-color: #ccc;
        border-radius: 5px;
        padding: 5px;


    }

    @media (max-width: 900px) {
        .item {
            width: 100%;
            margin: 0px -80;
        }
    }

    .card-header-template {
        background-color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        margin-bottom: 20px;


    }

    .card-header-template h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
        line-height: 3rem;
        color: #2C2A2A;



    }

    .container-chart img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 20px auto;
    }

    .progress {
        height: 20px;
        background-color: #e9ecef;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        color: #fff;
        text-align: center;
        line-height: 20px;
        background-color: #2174d4;
        transition: width 0.5s ease-in-out;
    }

    div.card-header-template {
        background-color: white;


    }

    .card-header {
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;
        background-color: #2C2A2A;

    }

    .card-body {
        background-color: #e9ecef;



    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captura de Assinatura</title>
    <style>
        #signature-pad {
            border: 1px solid #000;
            width: 100%;
            max-width: 600px;
            /* Ajuste conforme necessário */
            height: 200px;
            /* Altura fixa ou ajustável conforme necessário */
        }
    </style>
    <!-- Incluir a biblioteca Signature Pad -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>
</head>

<body>
    <div hidden>
        <!-- Canvas para a assinatura -->
        <canvas id="signature-pad"></canvas>

        <!-- Campo oculto para armazenar a assinatura -->
        <input type="hidden" id="signatureData" name="signatureData">

        <!-- Botões para ações -->
        <button onclick="saveSignature()">Salvar Assinatura</button>
        <button onclick="clearSignature()">Limpar Assinatura</button>
    </div>
    <!-- Script para inicializar o Signature Pad -->
    <script>
        // Variável global para o Signature Pad
        var signaturePad;

        // Função para inicializar o Signature Pad
        function initializeSignaturePad() {
            var canvas = document.getElementById('signature-pad');
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)' // Cor de fundo do canvas
            });
        }

        // Função para salvar a assinatura
        function saveSignature1() {
            if (signaturePad.isEmpty()) {
                alert('Por favor, assine antes de salvar.');
            } else {
                var dataURL = signaturePad.toDataURL();
                document.getElementById('signatureData').value = dataURL;
                alert('Assinatura capturada com sucesso!');
            }
        }

        // Função para limpar a assinatura
        function clearSignature() {
            signaturePad.clear();
        }

        // Inicializar o Signature Pad
        initializeSignaturePad();
    </script>
</body>

</html>