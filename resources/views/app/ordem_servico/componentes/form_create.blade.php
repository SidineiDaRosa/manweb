<form id="frmCadOs" action="{{ route('ordem-servico.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-------------------------------------------------------------------------}}
    {{--início da div que contem os box--}}
    {{-------------------------------------------------------------------------}}
    {{--Inicio do bloco que contém o continer dos gráficos---------------------}}

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
            width: auto;
            border: none;
            color: #2174d4;
        }
    </style>
    <div class="container-chart">
        {{--Box 1--}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo"> Empresa</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" id="empresa_id" type="text" name="empresa_id" value="@foreach($empresa as $empresas_f)
                    {{$empresas_f['id']}}
                    @endforeach" readonly>
                </div>
                {{-----------------------------------------------}}
                {{--Patrimônio--}}
                <?php
                foreach ($equipamentos as $equip_nome) {
                    if ($equip_nome->id == $equipamento) {

                        break; // opcional, para interromper o loop após encontrar o equipamento
                    }
                }
                ?>
                <div class="titulo">ID patrimonio:</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" id="patrimonio_id" type="nuber" name="equipamento_id" value="{{$equipamento}}" require readonly>
                </div>
                <div class="titulo">Nome do patrimônio:</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" name="equipamento_nome" id="equipamento_nome" type="text" value="{{ $equip_nome->nome }}" readonly style="width:100%;">
                </div>
                <div class="titulo">Emissor:</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-text" id="emissor" name="emissor" placeholder="emissor" value="{{auth()->user()->name}}" readonly>
                </div>
                {{-----------------------------------------}}
                {{--Responsável para executar a terefa--}}
                <div class="titulo">Executor:</div>
                <hr>
                <div class="conteudo">
                    <select class="input-text" name="responsavel" id="responsavel" class="form-control-template">
                        <option value=""> --Selecione o Responsável--</option>
                        @foreach ($funcionarios as $funcionario_find)
                        <option value="{{$funcionario_find->primeiro_nome}}" {{($funcionario_find->responsavel ?? old('responsavel')) == $funcionario_find->primeiro_nome ? 'selected' : '' }}>
                            {{$funcionario_find->primeiro_nome}}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('responsavel') ? $errors->first('responsavel') : '' }}
                </div>
                <div class="titulo">Emissão</div>
                <hr>
                <div class="conteudo"><input class="input-text" type="date" id="data_emissao" name="data_emissao" readonly><input class="input-text" type="nuber" id="hora_emissao" name="hora_emissao" readonly></div>
                <div class="titulo">Previsão para início</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" type="date" name="data_prevista" id="dataFim" placeholder="dataFim" required value="" onchange="ValidateDateFim()">
                    <div class="conteudo"> <input class="input-text" type="time" class="form-control" name="hora_inicio" id="horaPrevista" placeholder="horaPrevista" required value=""></div>
                </div>
                <div class="titulo">Data prevista para término</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" type="date" name="data_fim" id="dataFim" placeholder="dataFim" required value="" onchange="ValidateDateFim()">
                    <input class="input-text" type="time" name="hora_fim" id="horaFim" placeholder="dataFim" required value="" onchange="ValidateDateFim()">
                </div>
            </div>

        </div>

        {{--Box 2--}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">
                    <textarea id="descricao" class="form-control" rows="6" style="color:crimson" name="descricao" placeholder="--Insira a descrição do serviço--"></textarea>
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
                <div class="titulo">Progresso do serviço:</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" id="status_servicos" type="text" name="status_servicos" value="" placeholder="--Insira progresso--">%
                </div>
                <div class="form-group">
                    <label for="imagem">Imagem:</label>
                    <input type="file" class="form-control-file" id="imagem" name="imagem">
                </div>
                <script>
                    function validateImageSize() {
                        var input = document.getElementById('imagem');
                        var fileSize = input.files[0].size; // Tamanho do arquivo em bytes
                        var maxSize = 1024 * 1024; // Tamanho máximo permitido (1MB, por exemplo)

                        if (fileSize < maxSize) {
                            document.getElementById('error-message').innerText = 'A imagem deve ter no mínimo 1MB.';
                            input.value = ''; // Limpa o campo de arquivo selecionado
                        } else {
                            document.getElementById('error-message').innerText = '';
                        }
                    }
                </script>
            </div>
        </div>
        {{--Box 3--}}
        <div class="item">

            <div class="titulo">Situação</div>
            <hr>
            <div class="conteudo">

                <select class="input-text" class="form-control" name="situacao" id="situacao" value="">
                    <option value="aberto">Aberto</option>
                    <option value="fechado">Fechado</option>
                    <option value="indefinido">Indefinido</option>
                    <option value="cancelada">Cancelada</option>
                    <option value="em andamento">Em andamento</option>
                </select>

            </div>
            <div class="titulo">Tipo de os</div>
            <hr>
            <div class="conteudo">
                <select class="input-text" class="form-control" name="tendencia" id="tendencia" value="">
                    <option value="Corretiva">Corretiva</option>
                    <option value="Preventiva">Preventiva</option>
                    <option value="Preditiva">preditiva</option>
                    <option value="Melhoria">Melhoria</option>

                </select>
            </div>
            <div class="titulo">link</div>
            <hr>
            <div class="conteudo">
                <input class="input-text" id="link_foto" type="text" class="form-control" name="link_foto" value="" readonly>
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

        <!------------------------------------------------------------------------------------------->
        <!----Datas-->
        <!------------------------------------------------------------------------------------------->
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



</form>
<button type="button" class="btn btn-primary btn-lg btn-block" onclick="CadastraFormOs()">
    Cadastrar
</button>

<script>
    function CadastraFormOs() {
        document.getElementById("frmCadOs").submit();
    }
</script>
<script>
    $(function() {
        $('#equipamento_id').change(function() {
            var equipamento_id = $("#equipamento_id option:selected").val();
            $("#horimetro_inicial").val('');
            $.ajax({
                url: "{{route('get-last-id-os')}}",
                type: "get",
                data: {
                    'id_os': equipamento_id,
                },
                dataType: "json",
                success: function(response) {
                    let newOs = response + 1;
                    $("#idOs").val(newOs);
                }
            })

        });

    });
</script>
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