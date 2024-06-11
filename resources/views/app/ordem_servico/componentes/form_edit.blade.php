{{--modal window --}}

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
<form action="{{route('ordem-servico.update',['ordem_servico' => $ordem_servico->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <!------------------------------------------------------------------------------------------->
    {{-------------------------------------------------------------------------}}
    {{--início da div que contem os box--}}


    <style>
        hr {
            margin: -5px;
        }

        .box-conteudo {
            margin-left: 50px;
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
                    <input type="text" class="input-text" name="ordem_servico_id" id="ordem_servico_id" value="{{$ordem_servico->id}}" readonly>
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
                <div class="titulo">Empresa:</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-text" name="empresa_id" id="empresa_id" value="{{$ordem_servico->empresa->id}}" readonly style="width:20%;">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                    <input type="text" class="input-text" name="razao_social" id="razao_social" value="{{$ordem_servico->empresa->razao_social}}" readonly style="width:80%;">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>

                <div class="titulo">ID patrimonio:</div>
                <hr>
                <div class="conteudo">
                    <input id="patrimonio" type="text" class="input-text" name="equipamento_id" value="{{ $ordem_servico->equipamento->id }}" disabled style="width:20%;">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
                <div class="titulo">Patrimonio:</div>
                <hr>
                <div class="conteudo">
                    <input id="patrimonio" type="text" class="input-text" name="equipamento_id" value="{{ $ordem_servico->equipamento->nome }}" disabled style="width:80%;">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </div>
                <div class="titulo">Emissor:</div>
                <hr>
                <div class="conteudo">
                    <input id="emissor" type="text" class="input-text" name="emissor" value="{{$ordem_servico->emissor}}" readonly>
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
                    <input type="date" class="input-text" id="data_emissao1" name="data_emissao" value="{{$ordem_servico->data_emissao}}" readonly>
                    <div class="invalid-tooltip">
                        informe a data
                    </div>
                    <input type="time" class="input-text" name=hora_emissao id="hora_Emissao1" required value="{{$ordem_servico->hora_emissao}}" readonly>
                    <div class="invalid-tooltip">
                        Por favor, informe a hora.
                    </div>
                </div>
                <div class="titulo">Previsão para início:</div>
                <hr>
                <div class="conteudo">
                    <input type="date" class="input-text" name="data_inicio" id="data_prevista" placeholder="dataPrevista" required value="{{$ordem_servico->data_inicio}}" onchange=" ValidateDate()">
                    <div class="invalid-tooltip">
                        Por favor, informe data
                    </div>
                    <script>
                        function ValidateDate() {

                            let dataEmissao = document.getElementById('data_emissao1').value;
                            let dataPrevista = document.getElementById('data_prevista').value;
                            let dataFim = document.getElementById('data_fim').value;
                            if (dataPrevista < dataEmissao) {
                                alert('A data prevista deve ser maior que a data de emissão!');
                                document.getElementById('data_prevista').value = 'null';
                                document.getElementById('data_prevista').style.backgroundColor = '#FFC0CB';
                                document.getElementById('data_prevista').focus();
                            } else {
                                document.getElementById('data_prevista').style.backgroundColor = '#7FFF7F';

                                if (dataFim < dataPrevista) {
                                    document.getElementById('data_fim').value = 'null';
                                    document.getElementById('data_fim').style.backgroundColor = '#FFC0CB';
                                } else {

                                    document.getElementById('data_fim').style.backgroundColor = '#7FFF7F';
                                }

                            }
                        }
                    </script>
                    <input type="time" class="input-text" name="hora_inicio" id="hora_prevista" placeholder="horaPrevista" required value="{{$ordem_servico->hora_inicio}}">
                    <div class="invalid-tooltip">
                        Por favor, informe hora.
                    </div>
                </div>
                <div class="titulo">Previsão para finalização:</div>
                <hr>
                <div class="conteudo">
                    <input type="date" class="input-text" name="data_fim" id="data_fim" placeholder="dataFim" required value="{{$ordem_servico->data_fim}}" required onchange="ValidateDate()">
                    <div class="invalid-tooltip">
                        Por favor, informe dataFim.
                    </div>
                    <input type="time" class="input-text" name="hora_fim" id="hora_Fim" placeholder="horaFim" required value="{{$ordem_servico->hora_fim}}">
                    <div class="invalid-tooltip">
                        Por favor, informe um estado válido.
                    </div>
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
            </div>
        </div>
        {{--Box 3--}}
        <div class="item">
            <div class="titulo">tipo de O.S</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="tendencia" id="tendencia" value="">
                    <option value="Corretiva">Corretiva</option>
                    <option value="Preventiva">Preventiva</option>
                    <option value="Preditiva">preditiva</option>
                    <option value="Melhoria">Melhoria</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>
            <div class="titulo">Gravidade</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="gravidade" id="gravidade" value="">
                    <option value="5">Extremamante grave</option>
                    <option value="4">Muito grave</option>
                    <option value="3">Grave</option>
                    <option value="2">Pouco grave</option>
                    <option value="1">Nada grave</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a urgencia.
                </div>
            </div>
            <div class="titulo">Urgência</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="urgencia" id="urgencia" value="">
                    <option value="5">Extremamante urgente</option>
                    <option value="4">Urgente</option>
                    <option value="3">Urgente se possível</option>
                    <option value="2">Pouco urgente</option>
                    <option value="1">Não urgente</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a urgencia.
                </div>
            </div>
            <div class="titulo">Tendência</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="tendencia" id="tendencia" value="">
                    <option value="5">Piorar rápidamante</option>
                    <option value="4">Piorar em curto prazo</option>
                    <option value="3">Piorar</option>
                    <option value="2">Piorar logo prazo</option>
                    <option value="1">Não irá piorar</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>
            <div class="titulo">Link</div>
            <hr>
            <div class="conteudo">
                <input id="link_foto" type="text" class="input-text" name="link_foto" value="{{$ordem_servico->link_foto}}" readonly>
                {{ $errors->has('link_foto') ? $errors->first('link_foto') : '' }}
            </div>
            <div class="titulo">Causa</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="causa" id="causa" value="">
                    <option value="5">Quebra</option>
                    <option value="4">Imprevisto</option>
                    <option value="3">Proposital</option>
                </select>
                <div class="invalid-tooltip">
                    Por favor, informe a tendência.
                </div>
            </div>
            <div class="titulo">Efeito</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" name="efeito" id="efeito" value="">
                    <option value="5">Prejuizo na produção</option>
                    <option value="4">Atrazo</option>
                    <option value="3">Riscos humano</option>
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
        </div>
        {{--fim card 3--}}
        {{----------------------------------------------------------------------------}}
        <div class="row sm-3 mb-0">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
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