{{--modal window --}}
<style>
    form {
        background-color: rgb(220, 220, 220);
    }
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
<!----**************************************************************************************--->
<!----Grava -->
<!---*************************************************************************************----->

{{---------------------------------------------------------------------}}
{{--Inicio de formulário de ordem de serviço--=------------------------}}
<form action="{{route('ordem-servico.update',['ordem_servico' => $ordem_servico->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <!------------------------------------------------------------------------------------------->
    <div class="form-row">
        <div class="col-md-1 mb-0">
            <label for="idOs" class="col-md-4 col-form-label text-md-end">ID</label>
            <input id="id1" type="nuber" class="form-control" name="id" value="{{$ordem_servico->id}}" disabled>
            {{ $errors->has('id') ? $errors->first('id') : '' }}
        </div>

        <!------------------------------------------------------>
        <!-------------empresa--------------->
        <div class="col-sm-1 mb-0">
            <label for="empresa_id" class="col-md-6 col-form-label text-md-end">E_id</label>
            <input type="text" class="form-control" name="empresa_id" id="empresa_id" value="{{$ordem_servico->empresa->id}}" readonly>
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}

        </div>
        <div class="col-sm-4 mb-0">
            <label for="empresa_id" class="col-md-6 col-form-label text-md-end">Empresa</label>
            <input type="text" class="form-control" name="razao_social" id="razao_social" value="{{$ordem_servico->empresa->razao_social}}" readonly>
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}

        </div>
        <!------------------------------------------------------------------------------------------->
        <!----equipamento-->
        <!------------------------------------------------------------------------------------------->
        <div class="col-md-1 mb-0">
            <label for="equipamento" class="col-md-6 col-form-label text-md-end">ID </label>
            <input id="patrimonio" type="text" class="form-control" name="equipamento_id" value="{{ $ordem_servico->equipamento->id }}" disabled>
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}

        </div>
        <div class="col-md-4">
            <label for="equipamento" class="col-md-6 col-form-label text-md-end">Equipamento/Patrimônio</label>
            <input id="patrimonio" type="text" class="form-control" name="equipamento_id" value="{{ $ordem_servico->equipamento->nome }}" disabled>
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
        </div>

    </div>
    <!------------------------------------------------------------------------------------------->
    <!----Datas---------------------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------->
    <div class="form-row">
        <div class="col-md-1 mb-0">
            <label for="data_Emissao">Data emissao</label>
            <input type="date" class="form-control" id="data_emissao1" name="data_emissao" value="{{$ordem_servico->data_emissao}}" readonly>
            <div class="invalid-tooltip">
                informe a data
            </div>
        </div>
        <div class="col-md-1 mb-0">
            <label for="horaEmissao">Hora emissao</label>
            <input type="time" class="form-control" name=hora_emissao id="hora_Emissao1" required value="{{$ordem_servico->hora_emissao}}" readonly>
            <div class="invalid-tooltip">
                Por favor, informe a hora.
            </div>
        </div>

        <div class="col-sm-1 mb-0">
            <label for="dataPrevista">Data prevista</label>
            <input type="date" class="form-control" name="data_inicio" id="data_prevista" placeholder="dataPrevista" required value="{{$ordem_servico->data_inicio}}" onchange=" ValidateDate()">
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
        </div>

        <div class="col-sm-1 mb-0">
            <label for="horaPrevista">Hora prevista</label>
            <input type="time" class="form-control" name="hora_inicio" id="hora_prevista" placeholder="horaPrevista" required value="{{$ordem_servico->hora_inicio}}">
            <div class="invalid-tooltip">
                Por favor, informe hora.
            </div>
        </div>
        <div class="col-sm-1 mb-0">
            <label for="dataFim">Data fim</label>
            <input type="date" class="form-control" name="data_fim" id="data_fim" placeholder="dataFim" required value="{{$ordem_servico->data_fim}}" required onchange="ValidateDate()">
            <div class="invalid-tooltip">
                Por favor, informe dataFim.
            </div>

        </div>
        <div class="col-sm-1 mb-0">
            <label for="horaFim">Hora fim</label>
            <input type="time" class="form-control" name="hora_fim" id="hora_Fim" placeholder="horaFim" required value="{{$ordem_servico->hora_fim}}">
            <div class="invalid-tooltip">
                Por favor, informe um estado válido.
            </div>
        </div>
        <div class="col-sm-3 mb-0">
            <label for="situacao" class="">Situação</label>
            <input id="situacao" type="text" class="form-control-template" name="situacao" value="{{$ordem_servico->situacao}}" readonly>
            <div class="invalid-tooltip">
                Por favor, informe situacao.
            </div>
        </div>
        <div class="col-sm-3 mb-0">
            <label for="openmodalsituacao" class="">Editar status</label>
            <p>
                <input class="btn btn-warning" type="button" name="openmodalsituacao" id="openmodalsituacao" value="Alterar status" onclick="abreModal()">
        </div>
        <div class="col-md-2 mb-0">
            <label for="tendencia" class="col-md-4 col-form-label text-md-end">Tipo de os</label>
            <select class="form-control" name="tendencia" id="tendencia" value="">
                <option value="Corretiva">Corretiva</option>
                <option value="Preventiva">Preventiva</option>
                <option value="Preditiva">preditiva</option>
                <option value="Melhoria">Melhoria</option>

            </select>
            <div class="invalid-tooltip">
                Por favor, informe a tendência.
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------->
    <!----Emissor e responsavel-->
    <!------------------------------------------------------------------------------------------->
    <div class="form-row">
        <div class="col-sm-6 mb-0">
            <label for="emissor" class="col-md-4 col-form-label text-md-end">Emissor</label>
            <input id="emissor" type="text" class="form-control" name="emissor" value="{{$ordem_servico->emissor}}" readonly>
            {{ $errors->has('nome') ? $errors->first('nome') : '' }}

        </div>
        <!-------------------------------------------------------------------------------------------->
        <!---Responsável ------------->
        <!-------------------------------------------------------------------------------------------->
        <div class="col-md-6 mb-0">
            <label for="responsavel" class="col-md-4 col-form-label text-md-end">Responsável</label>
            <select name="responsavel" id="responsavel" class="form-control-template">
                <option value="{{$ordem_servico->responsavel}}">{{$ordem_servico->responsavel}}</option>
                @foreach ($funcionarios as $funcionario_find)
                <option value="{{$funcionario_find->primeiro_nome}}" {{($funcionario_find->responsavel ?? old('responsavel')) == $funcionario_find->primeiro_nome ? 'selected' : '' }}>
                    {{$funcionario_find->primeiro_nome}}
                </option>
                @endforeach
            </select>
            {{ $errors->has('responsavel') ? $errors->first('responsavel') : '' }}
        </div>
    </div>
    <div class="form-row">
        <div class="col-sm-6 mb-0">
            <label for="responsavel" class="col-md-6 col-form-label text-md-end">Descrição</label>
            <textarea id="descricao" name="descricao" cols="30" rows="3" class="form-control">{{$ordem_servico->descricao}}</textarea>

            {{ $errors->has('nome') ? $errors->first('nome') : '' }}
            <style>
                #descricao {
                    font-family: 'Roboto', sans-serif;
                    font-weight: 300;
                    /* Define a espessura da fonte como leve (300) */
                    font-size: 16px;
                    /* Define o tamanho da fonte como 14px */
                }
            </style>
        </div>
        <!------------------------------------------------>
        <!------------------------------------------------>
    </div>
    <div class="form-row mb-0">

        <div class="col-md-4 mb-0">
            <label for="link_foto" class="col-md-4 col-form-label text-md-end">link foto</label>
            <input id="link_foto" type="text" class="form-control" name="link_foto" value="{{$ordem_servico->link_foto}}" readonly>
            {{ $errors->has('link_foto') ? $errors->first('link_foto') : '' }}

        </div>
        <div class="col-md-2 mb-0">
            <label for="status_servicos" class="col-md-4 col-form-label text-md-end">status %</label>
            <input id="status_servicos" type="text" class="form-control-template" name="status_servicos" value="{{$ordem_servico->status_servicos}}">
            {{ $errors->has('status_servicos') ? $errors->first('status_servicos') : '' }}
        </div>
        <div class="col-md-2 mb-0">
            <label for="gravidade" class="col-md-4 col-form-label text-md-end">Gravidade</label>
            <select class="form-control" name="gravidade" id="gravidade" value="">
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

        <div class="col-md-2 mb-0">
            <label for="urgencia" class="col-md-4 col-form-label text-md-end">Urgência</label>
            <select class="form-control" name="urgencia" id="urgencia" value="">
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
        <!---->
        <div class="col-md-2 mb-0">
            <label for="tendencia" class="col-md-4 col-form-label text-md-end">Tendência</label>
            <select class="form-control" name="tendencia" id="tendencia" value="">
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
        <div class="col-md-2 mb-0">
            <label for="causa" class="col-md-4 col-form-label text-md-end">Causa</label>
            <select class="form-control" name="causa" id="causa" value="">
                <option value="5">Quebra</option>
                <option value="4">Imprevisto</option>
                <option value="3">Proposital</option>
            </select>
            <div class="invalid-tooltip">
                Por favor, informe a tendência.
            </div>
        </div>
        <div class="col-md-2 mb-0">
            <label for="efeito" class="col-md-4 col-form-label text-md-end">Efeito</label>
            <select class="form-control" name="efeito" id="efeito" value="">
                <option value="5">Prejuizo na produção</option>
                <option value="4">Atrazo</option>
                <option value="3">Riscos humano</option>
            </select>
            <div class="invalid-tooltip">
                Por favor, informe a tendência.
            </div>
        </div>
        <div class="col-md-2 mb-0">
            <label for="solucao" class="col-md-4 col-form-label text-md-end">Solução</label>
            <select class="form-control" name="solucao" id="solucao" value="">
                <option value="5">Agilizar</option>
                <option value="4">Mão de obra autonama</option>
                <option value="3">Acionar segurança</option>
            </select>
            <div class="invalid-tooltip">
                Por favor, informe a tendência.
            </div>
        </div>

    </div>
    <hr>
    <div class="row sm-3 mb-0">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-lg btn-block">
                Alterar ordem de serviço
            </button>
        </div>
    </div>

</form>