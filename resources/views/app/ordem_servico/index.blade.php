@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<main class="content">
    <div class="card-header" style="background-color: rgb(245, 246, 248);">

        <div style="
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 8px;
      padding: 8px;
      background: #f2f2f2;
      border-radius: 8px;
      align-items: start;
    ">

            <div>
                <a href="#" class="btn btn-info btn-icon-split" onclick="SetDataHoje()">
                    <span class="icon text-white-50"><i class="icofont-filter"></i></span>
                    <span class="text">O.S. hoje</span>
                </a>
            </div>

            <div>
                <a href="#" class="btn btn-info btn-icon-split" onclick="GetOsEmAndamento()">
                    <span class="icon text-white-50"><i class="icofont-filter"></i></span>
                    <span class="text">O.S. Em Andamento</span>
                </a>
            </div>

            <div>
                <a href="#" class="btn btn-info btn-icon-split" onclick="SetAbertas()">
                    <span class="icon text-white-50"><i class="icofont-filter"></i></span>
                    <span class="text">O.S. aberta</span>
                </a>
            </div>

            <div>
                <a href="#" class="btn btn-info btn-icon-split" onclick="exibirIntervaloSemanaAtual()">
                    <span class="icon text-white-50"><i class="icofont-filter"></i></span>
                    <span class="text">O.S semana</span>
                </a>
            </div>

            <div>
                <a href="#" class="btn btn-info btn-icon-split" onclick="SetOsVencidas()">
                    <span class="icon text-white-50"><i class="icofont-filter"></i></span>
                    <span class="text">O.S. Vencidas</span>
                </a>
            </div>

            <div>
                <a class="btn btn-dark" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> Dashboard
                </a>
            </div>

        </div>
    </div>

    <div class="card" style="background-color: rgb(245, 246, 248);">
        <style>
            .card-header {
                background-color: rgb(211, 211, 211);
                opacity: 0.95;
            }
        </style>

        <script>
            function Funcao() {
                alert('teste');
                document.getElementById("t1").value = "{{ $funcionarios }}"
            }
        </script>
        <!------------------------------------->
        <!----teste de url--------------------->
        <form action="{{ 'filtro-os' }}" method="POST" id="form_filt_os">
            @csrf
            <!------------------------------------------------------------------------------------------->
            <!----datas---------------------------------------------------------------------------------->
            <!------------------------------------------------------------------------------------------->
            <div class="form-row">

                <div class="col-md-0">
                    <label for="id">ID:</label>
                    <input type="number" class="form-control" id="id" name="id" placeholder="--Digite o ID--" value="">
                </div>
                <p>
                <div class="col-sm-1.5">
                    <label for="data_inicio">Data inicial:</label>
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio" placeholder="dataPrevista">
                </div>
                <div class="col-md-0">
                    <label for="hora_inicio">Hora prevista:</label>
                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="horaPrevista" value="">
                </div>
                <div class="col-md-1.5">
                    <label for="dataFim">Data final:</label>
                    <input type="date" class="form-control" name="data_fim" id="data_fim" placeholder="dataFim" value="">
                </div>
                <div class="col-md-0">
                    <label for="horaFim">Hora fim:</label>
                    <input type="time" class="form-control" name="hora_fim" id="horaFim" placeholder="horaFim" value="">
                </div>
                <div class="col-md-3 mb-0" hidden>
                    <label for="responsavel" class="">Responsável:</label>
                    <select name="responsavel" id="responsavel" class="form-control">
                        <option value="todos">Todos</option>
                        @foreach ($funcionarios as $funcionario)
                        <option value="{{ $funcionario->primeiro_nome}}"
                            {{ $funcionario->primeiro_nome}}
                            </option>
                            @endforeach
                    </select>
                    {{ $errors->has('responsavel') ? $errors->first('responsavel') : '' }}
                </div>

                <!--------------------------------------------------------------------------------------->
                <!---------Select empresa------------->
                <!--------------------------------------------------------------------------------------->
                <div class="col-md-5 mb-0" hidden>
                    <label for="empresas" class="">Empresa:</label>
                    <select name="empresa_id" id="empresa_id" class="form-control">
                        <option value=""> --Selecione a empresa--</option>
                        @foreach ($empresa as $empresas_find)
                        <option value="{{ $empresas_find->id }}"
                            {{ ($empresas_find->id == 2) ? 'selected' : (($empresas_find->empresa_id ?? old('empresa_id')) == $empresas_find->id ? 'selected' : '') }}>
                            {{ $empresas_find->razao_social }}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('empresa_id') ? $errors->first('empresa_id') : '' }}
                </div>
                <script>
                    function alterarTexto() {
                        // Seleciona o elemento pelo ID
                        alert();
                        document.getElementById("empresa_id").value = 2;

                        updateIdPatrimonio()
                    }
                </script>
                {{----------------------------------------------------------------}}
                {{--Select para escolher o patrimônio-----------------------------}}
                <div class="col-md-3 mb-0" hidden>
                    <label for="id">Patrimônio:</label>
                    <input type="number" class="form-control" id="patrimonio" name="patrimonio_id" placeholder="ID patrimonio" value="" hidden>
                    <select class="form-control" id="results" onchange="updateIdPatrimonio()">
                        <option class="form-control" value="" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                         font-weight:300px;">Selecione um resultado</option>
                    </select>
                </div>
                <!------------------------------------------------------------------------>
                <div class="col-md-2 mb-0">
                    <label for="situacao">Situação:</label>
                    <select class="form-control" name="situacao" id="situacao">
                        <option value="todas"> Todas</option>
                        <option value="aberto">🔓 Aberto</option>
                        <option value="fechado">🔒 Fechado</option>
                        <option value="indefinido">❔ Indefinido</option>
                        <option value="cancelada">❌ Cancelada</option>
                        <option value="em andamento">🕐 Em andamento</option>
                        <option value="pausado">⏸️ Pausado</option>
                    </select>
                </div>

                <div class="col-md-2 mb-0">
                    <label for="tipo_consulta" class="">Tipo de consulta:</label>

                    <select class="form-control" name="tipo_consulta" id="tipo_consulta" value="">
                        <option value="9" style="background-color: #81b0eeff;">📝Pela descrição</option>
                        <option value="6">🗓️ Data Inicial</option>
                        <option value="5">🗓️ ⚙️Data inicial e Equipamento</option>
                        <option value="1" style="background-color: #a3e6a3;">🆔 Pelo ID</option>
                        <option value="2">>=Data inicial <= Data inicial </option>
                        <option value="3">>=Data inicial e <=Data final</option>
                        <option value="4">=Data final</option>
                        <option value="7">Imprimir</option>
                        <option value="8">Ordenado pela Emissão</option>
                    </select>
                </div>
            </div>
            <p></p>
            <div class="row justify-content-center">
                <div class="col-md-3 mb-12">
                    <input value="" name="like" id="like" class="form-control"
                        placeholder="--Digite aqui uma descrição ou maquina ou serviço a fazer--"
                        style="background-color: rgba(255, 255, 153, 0.3);">
                </div>
                <select name="situacao" id="situacao" class="form-control" hidden>
                    <option value="executar">Executar</option>
                    <option value="executado">Executado</option>
                </select>
                <div>
                    <a href="#" class="btn btn-outline-warning" onclick="FiltraOs()" style="color: orangered;">
                        <i class="icofont-filter"></i> Filtrar
                    </a>
                </div>
            </div>


        </form>

        <!--------------------------------Ajax para pesquisa------------------------------------->
        <!-- resources/views/your_view.blade.php -->
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Search Example</title>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        </head>


        <script>
            function updateIdPatrimonio() {
                let sh = document.getElementById('results').value;
                document.getElementById('patrimonio').value = sh; // Corrigido para 'patrimonio'
            }

            $(document).ready(function() {
                $('#empresa_id').on('change', function() {
                    var query = $(this).val();

                    $.ajax({
                        url: '{{ route("search") }}',
                        type: 'GET',
                        data: {
                            'query': query
                        },
                        success: function(data) {
                            console.log(data); // Verificar os dados retornados
                            $('#results').empty();
                            $('#results').append('<option value="">Selecione um resultado</option>');

                            $.each(data, function(key, item) {
                                $('#results').append('<option value="' + item.id + '">' + item.nome + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log('Erro na requisição AJAX: ' + error);
                        }
                    });
                });
            });
        </script>


        </html>

        <!----------------------------------fim do ajax------------------------------------------>
        <script>
            //------------------------------------------------------------------//
            //Código que executa os filtros do formulário index ordem de serviço
            let data_atual = new Date();
            var dia = String(data_atual.getDate()).padStart(2, '0');
            var mes = String(data_atual.getMonth() + 1).padStart(2, '0');
            var ano = data_atual.getFullYear();
            data_atual = ano + '-' + mes + '-' + dia;

            function SetDataHoje() { //função que executa o filtro da data de hoje
                document.getElementById("data_inicio").value = data_atual;
                document.getElementById("data_fim").value = data_atual;
                document.getElementById("situacao").value = 'aberto';
                document.getElementById("tipo_consulta").value = 6;
                document.getElementById("empresa_id").value = 2;
                document.getElementById('form_filt_os').submit();
            }

            function FiltraOs() { //Função que executa o filtro de acordo com as especificações escolhidas
                document.getElementById('form_filt_os').submit();
            }

            function SetAbertas() {

                document.getElementById("data_inicio").value = '2000-01-01';
                document.getElementById("data_fim").value = '2030-01-01';
                document.getElementById("situacao").value = 'aberto';
                document.getElementById("tipo_consulta").value = 6;
                document.getElementById("empresa_id").value = 2;
                document.getElementById('form_filt_os').submit();
            }

            function SetOsVencidas() { //Filtra os ja vencidas

                document.getElementById("data_inicio").value = '2000-01-01';
                document.getElementById("data_fim").value = data_atual;
                document.getElementById("situacao").value = 'aberto';
                document.getElementById("tipo_consulta").value = 6;
                document.getElementById("empresa_id").value = 2;
                document.getElementById('form_filt_os').submit();
            }
        </script>


    </div>
    </div>
    <div class="card-body">
        {{------------------------------teste pinta campo  tabela aberto-----------------------------}}
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                th {
                    background-color: #f2f2f2;
                }

                .bg-green {
                    background-color: #a3e6a3;
                }

                .bg-yellow {
                    background-color: #ffff99;
                }

                .bg-red {
                    background-color: #f08080;
                }
            </style>
        </head>
        <h6>Ordens</h6>

        <body>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:100px;">ID</th>
                        <th>Emissão</th>
                        <th>Previsão para início</th>
                        <th>Previsão para conclusão</th>
                        <th>Empresa</th>
                        <th>Patrimônio</th>
                        <th>Emissor</th>
                        <th>Responsável</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Projeto</th>
                        <th>Operações</th>
                        <th>check</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordens_servicos as $ordem_servico)
                    @php
                    // Definir o fuso horário para America/Sao_Paulo
                    date_default_timezone_set('America/Sao_Paulo');

                    // Obter o horário atual de Brasília
                    $dataAtual = \Illuminate\Support\Carbon::now();
                    //-------------------------------------------------//
                    $dataFim = \Carbon\Carbon::parse($ordem_servico->data_fim);
                    $horaFim = \Carbon\Carbon::parse($ordem_servico->hora_fim);
                    $dataAtual = \Carbon\Carbon::now();
                    $classData = '';
                    $classHora = '';
                    // Regras para data de fim verde//
                    if ($dataFim->greaterThan($dataAtual)) {
                    $classData = 'bg-green';
                    $classHora = 'bg-green';//seta para verde
                    }
                    // Regras para data de fim amarelo
                    if ($dataFim->isSameDay($dataAtual)) {
                    $classData = 'bg-yellow';
                    // -----------Regras para hora de fim
                    $horaFimSemSegundos = $horaFim->copy()->second(0); // Define os segundos como 0
                    $horaAtualSemSegundos = $dataAtual->copy()->second(0); // Define os segundos como 0
                    if ($horaFimSemSegundos->greaterThan($horaAtualSemSegundos)) {
                    $classHora = 'bg-green'; // seta para verde
                    } elseif ($horaFimSemSegundos->equalTo($horaAtualSemSegundos)) {
                    $classHora = 'bg-yellow'; // seta para amarelo
                    } elseif ($horaFimSemSegundos->lessThan($horaAtualSemSegundos)) {
                    $classHora = 'bg-red'; // seta para vermelho
                    }
                    // Regras para data de fim vermelho//
                    } elseif ($dataFim->lessThan($dataAtual)) {
                    $classData = 'bg-red';
                    // -----------Regras para hora de fim
                    $classHora = 'bg-red';//seta para vermelho
                    }
                    @endphp
                    <tr>
                        <td style="width:10px;">{{ $ordem_servico->id }}</td>
                        <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_emissao']))}}
                            {{ $ordem_servico->hora_emissao }}
                        </td>
                        <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}}
                            {{ $ordem_servico->hora_inicio }}
                        </td>
                        <td>
                            <div class="{{ $classData }}">
                                {{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}
                            </div>

                            <div class="{{ $classHora }}">
                                {{ $ordem_servico->hora_fim }}
                            </div>
                        </td>
                        <td>
                            {{ $ordem_servico->Empresa->razao_social}}
                        </td>
                        <td>{{ $ordem_servico->equipamento->nome}}</td>
                        <td>{{ $ordem_servico->emissor}}</td>
                        <td>{{ $ordem_servico->responsavel}}</td>
                        <td id="descricao">

                            {{ $ordem_servico->descricao}}

                        </td>
                        <td>{{ $ordem_servico->situacao}}
                            <div class="progress mb-3" role="progressbar" aria-label="Success example with label" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning">{{ $ordem_servico->status_servicos}}%</div>
                            </div>
                        </td>
                        <td>{{ $ordem_servico->projeto_id}}</td>
                        <!--Div operaçoes do registro da ordem des serviço-->
                        <td>
                            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                                <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                                    <i class="icofont-eye-alt"></i>
                                </a>

                                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">

                                    <i class="icofont-ui-edit"></i> </a>

                                <!--Condoçes para deletar a os-->
                                <form id="form_{{ $ordem_servico->id }}" method="post" action="{{route('ordem-servico.destroy', ['ordem_servico'=>$ordem_servico->id])}}">
                                    @method('DELETE')
                                    @csrf
                                    <input type="text" value="{{$ordem_servico->id}}" name="id_os" hidden>
                                </form>
                                <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                                    <i class="icofont-ui-delete"></i>
                                    <script>
                                        function DeletarOs() {
                                            var x;
                                            var r = confirm("Deseja deletar a ordem de serviço?");
                                            if (r == true) {

                                                document.getElementById('form_{{$ordem_servico->id }}').submit()
                                            } else {
                                                x = "Você pressionou Cancelar!";
                                            }
                                            document.getElementById("demo").innerHTML = x;
                                        }
                                    </script>
                                </a>
                                <!------------------------------>

                            </div>
                        <td>
                            <div class="col-md-2 mb-0">
                                <input type="checkbox" name="" id="">
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{----------------------------------------Fim tabela os pinta celula--------------------------------------}}
            <style>
                #tblOs {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                }

                thead {
                    background-color: rgb(169, 169, 169);
                }

                td,
                th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }

                tr:hover {
                    background-color: rgb(169, 169, 169);
                }
            </style>
            <table id="tblOs" hidden>
                <thead>
                    <tr>
                        <th scope="col" class="">ID</th>
                        <th scope="col" class="" hidden>Data emissao</th>
                        <th scope="col" class="" hidden>Hora</th>
                        <th scope="col" class="">Data prevista</th>
                        <th scope="col" class="">Hora prevista</th>
                        <th scope="col" class="">Data fim</th>
                        <th scope="col" class="">Hora fim</th>
                        <th scope="col" class="">Empresa</th>
                        <th scope="col" class="">Patrimônio</th>
                        <th scope="col" class="">id patr</th>
                        <th scope="col" class="">Emissor</th>
                        <th scope="col" class="">Responsável</th>
                        <th scope="col" class="">Executado</th>
                        <th>link foto</th>
                        <th>Status</th>
                        <th>ID Projeto</th>
                        <th>Operações</th>
                        <th>check</th>
                        <th hidden>G</th>
                        <th hidden>U</th>
                        <th hidden>T</th>

                    </tr>
                </thead>
                @foreach ($ordens_servicos as $ordem_servico)

                <tbody>

                    <tr>
                        <td>{{ $ordem_servico->id }}</td>
                        <td hidden>{{ $ordem_servico->data_emissao }}</td>
                        <td hidden>{{ $ordem_servico->hora_emissao }}</td>
                        <td>{{ $ordem_servico->data_inicio }}</td>
                        <td>{{ $ordem_servico->hora_inicio }}</td>
                        <td>{{ $ordem_servico->data_fim }}</td>
                        <td>{{ $ordem_servico->hora_fim }}</td>
                        <td>{{ $ordem_servico->Empresa->razao_social }}</td>
                        <td>{{ $ordem_servico->equipamento->nome }}</td>
                        <td>{{ $ordem_servico->equipamento->id }}</td>
                        <td>{{ $ordem_servico->emissor }}</td>
                        <td>{{ $ordem_servico->responsavel }}</td>
                        <td id="descricao">
                            {{ $ordem_servico->descricao }}
                        </td>

                        <td><a href="{{ $ordem_servico->link_foto }}" target="blank">link foto</a></td>
                        <td>{{ $ordem_servico->situacao }}
                            <input type="text" value="{{ $ordem_servico->status_servicos }}" id="progress-input" hidden>
                            <!--Exemplo de progressbar com um input texto-->
                            <div class="progress">
                                <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{ $ordem_servico->status_servicos }}%</div>
                            </div>
                            <script>
                                //document.addEventListener('DOMContentLoaded', function() {
                                var progressBar = document.getElementById('progress-bar');
                                var progressInput = document.getElementById('progress-input');

                                // Função para atualizar a barra de progresso
                                function updateProgressBar(value) {
                                    progressBar.style.width = value + '%';
                                    progressBar.setAttribute('aria-valuenow', value);
                                }

                                // Chama a função de atualização da barra de progresso com o valor inicial do input
                                updateProgressBar(progressInput.value);

                                // Adiciona um ouvinte de eventos para o input
                                progressInput.addEventListener('input', function() {
                                    var value = progressInput.value;
                                    updateProgressBar(value);
                                });
                                //});
                            </script>
                            <!--Fim Exemplo de progressbar com um input texto-->
                        </td>
                        <td>{{ $ordem_servico->projeto_id}}</td>
                        </td>
                        <!--Div operaçoes do registro da ordem des serviço-->
                        <td>
                            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('ordem-servico.show', ['ordem_servico' => $ordem_servico->id]) }}">
                                    <i class="icofont-eye-alt"></i>
                                </a>
                                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('ordem-servico.edit', ['ordem_servico' => $ordem_servico->id]) }}">

                                    <i class="icofont-ui-edit"></i> </a>

                                <!--Condoçes para deletar a os-->
                                <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                                    <i class="icofont-ui-delete"></i></a>
                        </td>
                        <script>
                            function DeletarOs() {
                                var x;
                                var r = confirm("Deseja deletar o registro os?");
                                if (r == true) {
                                    document.getElementById('form_{{ $ordem_servico->id }}').submit()
                                } else {
                                    x = "Você pressionou Cancelar!";
                                }
                                document.getElementById("demo").innerHTML = x;
                            }
                        </script>

                        <form id="form_{{ $ordem_servico->id }}" method="post" action="{{ route('ordem-servico.destroy', ['ordem_servico' => $ordem_servico->id]) }}">
                            @method('DELETE')
                            @csrf
                        </form>

    </div>
    <td>
        <div class="col-md-2 mb-0">
            <input type="checkbox" name="" id="">
        </div>
    </td>
    <td hidden>{{ $ordem_servico->gravidade}} </td>
    <td hidden>{{ $ordem_servico->urgencia}} </td>
    <td hidden>{{ $ordem_servico->tendencia}} </td>
    </tr>
    </tbody>
    @endforeach

    </table>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <div id="timeline" style="height:600px;">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <!--------------------------------------------------------------------->
        <!--Código que gera o gáfico de pizza-->
        <!--------------------------------------------------------------------->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-------------------------------------------------------------------------}}
    {{--Botão que gera gráficos pie chart  e tabela que gera está hidden--}}
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="agruparNumerosIguais1(),GerarGráficoLinhas()">
            Gráficos distribuição de ordens
        </button>
    </div>
    <table id="tabelaAgrupada" hidden>
        <caption>Tabela Agrupada</caption>
        <thead>
            <tr>
                <th>Nome do equipamento</th>
                <th>Id</th>
                <th>Quantidade de ordens geradas</th>
            </tr>
        </thead>
        <tbody id="corpoTabelaAgrupada">
            <!-- Aqui será preenchido dinamicamente com JavaScript -->
        </tbody>
    </table>
    <style>
        .container-chart {
            display: flex;
            height: 100%;
            width: 100%;
        }

        .item {
            flex: 1;
            border: 1px solid black;
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
        }
    </style>
    <div class="container-chart">
        <div class="item">
            <!-- Onde o gráfico será exibido -->
            <div id="graficoPizza"></div>
            <!-- Onde o gráfico será exibido -->
            <!--<div id="graficoPizza"></div>-->
            <canvas id="myChart" hidden></canvas>
        </div>
        <div class="item">
            <canvas id="myChart3"></canvas>
        </div>
        <div class="item">
            <canvas id="myChart2"></canvas>
        </div>
    </div>
    {{-------------------------------------------------------------------------}}
    {{--Importar a biblioteca do Google Charts para gerar um gráfico piechart---}}
    <script>
        function VerTabela() {
            agruparNumerosIguais() //chama criar tabela
            table1 = document.getElementById("tblOs");
            let totalColumnsTbOs = (table1.rows.length);

            for (var i = 1; i < table1.rows.length; i++) {
                let equipamentoId =
                    document.getElementById("tblOs").rows[i].cells[9].innerHTML;
                //FunAjaxGetcontEquip()
            };
            if (i = totalColumnsTbOs) {

            }
        }
        //Funçoes em ajax
        //$(document).ready(function()
        function FunAjaxGetcontEquip(url, sidinei, sucessoCallback, erroCallback) {
            let valorInput = $("#os1").val(); //pega o valor do input
            let date1 = $("#date1").val(); //pega o valor do input
            let date2 = $("#date2").val(); //pega o valor do input
            var linha = $("#tblOs tr:eq(1)"); // Pega a segunda linha da tabela (índice 1)
            var equipamentoId = linha.find("td:eq(8)").text(); // Pega o texto da segunda célula (índice 1) da linha
            var dataInicio = linha.find("td:eq(1)").text(); // Pega o texto da terceira célula (índice 2) da linha
            var dataFim = linha.find("td:eq(3)").text(); // Pega o texto da terceira célula (índice 2) da linha

            // Exibe um alerta com os valores obtidos
            alert("esta fução busca e conta registros de equipaento nesta data-Equipamento id: " + equipamentoId +
                "Datas: " + date1 + '...' + date2);
            $.ajax({

                // url: "route('get-cont-os-equip'", // Substitua 'pagina.php' pelo URL da sua página de destino
                type: "get", // Ou "GET" dependendo do tipo de requisição que você deseja fazer
                data: {

                    parametro1: date1,
                    parametro2: date2,
                    parametro3: equipamentoId
                }, // Se necessário, envie parâmetros para a página de destino
                success: function(response) {
                    // Executa essa função quando a requisição for bem-sucedida
                    alert("Requisição bem-sucedida! Resposta: " +
                        response); // Mostra um alerta com a resposta da requisição
                    document.getElementById('os1').value = response;
                    // Alterando a cor de fundo do input
                    $("#os1").css("background-color", "#ff0000");
                },
                error: function(xhr, status, error) {
                    // Executa essa função se houver um erro na requisição
                    // alert("Ocorreu um erro na requisição: " + xhr.responseText); // Mostra um alerta com a mensagem de erro
                }
            });
        };
    </script>
    </body>
</main>
@endsection
</body>
<script>
    function agruparNumerosIguais1() {
        var tabela = document.getElementById("tblOs");
        var numeros = {};

        for (var i = 1; i < tabela.rows.length; i++) {
            var nome = tabela.rows[i].cells[8].innerHTML;
            var numero = tabela.rows[i].cells[9].innerHTML;
            if (!numeros[nome]) {
                numeros[nome] = {};
            }
            if (!numeros[nome][numero]) {
                numeros[nome][numero] = 1;
            } else {
                numeros[nome][numero]++;
            }
        }

        var tabelaAgrupada = document.getElementById("tabelaAgrupada");
        var corpoTabelaAgrupada = document.getElementById("corpoTabelaAgrupada");
        corpoTabelaAgrupada.innerHTML = "";

        for (var nome in numeros) {
            for (var numero in numeros[nome]) {
                var row = corpoTabelaAgrupada.insertRow();
                var cellNome = row.insertCell(0);
                var cellNumero = row.insertCell(1);
                var cellQuantidade = row.insertCell(2);
                cellNome.innerHTML = nome;
                cellNumero.innerHTML = numero;
                cellQuantidade.innerHTML = numeros[nome][numero];

            }
        }
        // Criar gráfico de pizza
        // Obter os dados da tabela
        const table = document.getElementById('tabelaAgrupada');
        const rows = table.getElementsByTagName('tr');
        const data = {
            labels: [],
            values: []
        };

        // Iterar sobre as linhas da tabela e extrair os dados
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            data.labels.push(cells[0].innerText);
            const value1 = parseInt(cells[0].innerText);
            const value2 = parseInt(cells[2].innerText);
            data.values.push(value1 + value2);
        }
        GerarPieChart()
    }

    function GerarPieChart() {
        // Obter os dados da tabelaFF
        const table = document.getElementById('tabelaAgrupada');
        const rows = table.getElementsByTagName('tr');
        const data = {
            labels: [],
            values: []
        };

        // Iterar sobre as linhas da tabela e extrair os dados
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            data.labels.push(cells[0].innerText);
            const value1 = parseInt(cells[1].innerText);
            const value2 = parseInt(cells[2].innerText);
            data.values.push(value1 + value2);

        }

        // Criar o gráfico de pizza
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Valores Agrupados',
                    data: data.values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(255, 209, 86, 0.5)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const canvas = document.getElementById('myChart');
        canvas.width = 200;
        canvas.height = 200;
        GeraGraficoPizza() //chama gerar gráfico pe chart google
    }
    // fim gerar gráfico pie chart
</script>
{{-------------------------------------------------------------------------}}
{{--Importar Charts para gerar um gráfico piechart js não esta usando-------------------}}

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        function Gera() {
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                let n1
                let nome
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Pizza');
                data.addColumn('number', 'Populartiy');
                table1 = document.getElementById("tblOs");
                let totalColumnsTbOs = (table1.rows.length);

                for (var i = 1; i < table1.rows.length; i++) {
                    let equipamentoId =
                        document.getElementById("tblOs").rows[i].cells[16].innerHTML;


                    if (equipamentoId == 80) {
                        n1 = 30
                        nome = 'sidinei'
                        alert(equipamentoId)
                    }
                    if (equipamentoId == 120) {
                        n1 = 50
                        nome = 'sidinei rosa'
                        alert(equipamentoId)
                    }
                    data.addRows([
                        ['nome', n1],

                    ]);
                };
                var options = {
                    title: 'Popularity of Types of Pizza',
                    sliceVisibilityThreshold: .2
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        }
    </script>

</head>
</body>
{{--------------------------------------------------------------------------}}
{{--Importar a biblioteca do Google Charts para gerar um gráfico de linhas--}}
<script>
    function GerarGráficoLinhas() {
        // Extrai os dados da tabela HTML
        const table = document.getElementById('tblOs');
        const data = Array.from(table.querySelectorAll('tbody tr')).map(row => {
            const cells = Array.from(row.cells);
            return {
                data: cells[1].textContent,
                gasto: parseFloat(cells[16].textContent)
            };
        });

        // Prepara os dados para o gráfico
        const labels = data.map(item => item.data);
        const dataset = {
            label: 'Gráfico 2',
            data: data.map(item => item.gasto),
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1
        };

        // Cria o gráfico de linhas
        const ctx = document.getElementById('myChart2').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [dataset]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
</body>
{{-------------------------------------------------------------------------}}
{{--Importar a biblioteca do Google Charts para gerar um gráfico de barras--}}
<script>
    //Extrai dados de uma tabela tblos  para criar um gráfico de barras do chart.js
    document.addEventListener('DOMContentLoaded', (event) => {
        // Extrai os dados da tabela HTML
        const table = document.getElementById('tblOs');
        const data = Array.from(table.querySelectorAll('tbody tr')).map(row => {
            const cells = Array.from(row.cells);
            return {
                data: cells[1].textContent,
                gasto: parseFloat(cells[16].textContent)
            };
        });

        // Prepara os dados para o gráfico
        const labels = data.map(item => item.data);
        const dataset = {
            label: 'Gráfico 1',
            data: data.map(item => item.gasto),
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1
        };

        // Cria o gráfico de barras
        const ctx = document.getElementById('myChart3').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', // Altera o tipo de gráfico para barras
            data: {
                labels: labels,
                datasets: [dataset]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
</body>

</html>
{{------------------------------------------------------------------------------------------------------}}
{{--Importar a biblioteca do Google Charts para gerar um gráfico piechart para distribuição das ordens--}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    function GeraGraficoPizza() {

        // Carregar a biblioteca de visualização e preparar para desenhar o gráfico-
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(desenharGrafico);

        function desenharGrafico() {
            // Obter os dados da tabela
            var dadosTabela = [];
            var table = document.getElementById('tabelaAgrupada');
            var linhas = table.getElementsByTagName('tr');
            for (var i = 1; i < linhas.length; i++) { // Começar do índice 1 para pular a linha de cabeçalho
                var celulas = linhas[i].getElementsByTagName('td');
                if (celulas.length === 3) {
                    dadosTabela.push([celulas[0].textContent, parseFloat(celulas[2].textContent), parseFloat(celulas[1].textContent)]);
                }
            }

            // Criar e preencher a DataTable
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tarefa');
            data.addColumn('number', 'Horas por Dia');
            data.addColumn('number', 'Outro Valor'); // Adicionar um terceiro valor
            data.addRows(dadosTabela);

            // Configurar as opções do gráfico
            var options = {
                title: 'Distribuição das ordens',
                width: 500,
                height: 500
            };

            // Instanciar e desenhar o gráfico, passando os dados e opções
            var chart = new google.visualization.PieChart(document.getElementById('graficoPizza'));
            chart.draw(data, options);
        }
    }
</script>
</head>

<head>
    <script>
        function obterValorDaLinha(btn) {
            // Obter a linha pai do botão clicado
            var row = btn.parentNode.parentNode;
            // Obter o valor da segunda coluna (índice 1) da linha
            var valor = row.cells[0].innerText;
            // Exibir o valor em um alerta (você pode fazer o que quiser com o valor aqui)
            alert('Valor da coluna: ' + valor);
        }
    </script>
</head>
{{-------------------------------------------------------------------------------------}}
{{--intervalo correspondente a seman atual  função que filtra a semana atual-----------}}
<script>
    function exibirIntervaloSemanaAtual() {
        // Obtém a data atual
        var dataAtual = new Date();

        // Obtém o número da semana atual
        var semanaAtual = getWeekNumber(dataAtual);

        // Calcula a data do primeiro dia da semana
        var primeiroDiaSemana = new Date(dataAtual.getFullYear(), 0, (semanaAtual - 1) * 7 + 1);
        var diaIncSemana = String(primeiroDiaSemana.getDate()).padStart(2, '0');
        var mesIncSemana = String(primeiroDiaSemana.getMonth() + 1).padStart(2, '0');
        var anoIncSemana = primeiroDiaSemana.getFullYear();
        var dataInicSemana = anoIncSemana + '-' + mesIncSemana + '-' + diaIncSemana;
        document.getElementById("data_inicio").value = dataInicSemana;
        // Calcula a data do último dia da semana
        let ultimoDiaSemana = new Date(primeiroDiaSemana);
        ultimoDiaSemana.setDate(ultimoDiaSemana.getDate() + 6);
        var diaFimSemana = String(ultimoDiaSemana.getDate()).padStart(2, '0');
        var mesFimSemana = String(ultimoDiaSemana.getMonth() + 1).padStart(2, '0');
        var anoFimSemana = ultimoDiaSemana.getFullYear();
        var dataFimSemana = anoFimSemana + '-' + mesFimSemana + '-' + diaFimSemana;
        document.getElementById("data_fim").value = dataFimSemana;
        document.getElementById("situacao").value = 'aberto';
        document.getElementById("tipo_consulta").value = 6;
        document.getElementById("empresa_id").value = 2;
        document.getElementById('form_filt_os').submit();
    }

    // Função para obter o número da semana a partir de uma data
    function getWeekNumber(date) {
        var d = new Date(date);
        d.setHours(0, 0, 0, 0);
        d.setDate(d.getDate() + 4 - (d.getDay() || 7));
        var yearStart = new Date(d.getFullYear(), 0, 1);
        var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
        return weekNo;
    }

    // Função para formatar a data como "YYYY-MM-DD"
    function formatarData(date) {
        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        return year + "-" + month + "-" + day;
    }
    //-----------------------------------------------------//
    //-----Função que busca os em andamento---------------//
    function GetOsEmAndamento() {

        document.getElementById("data_inicio").value = '2000-01-01';
        document.getElementById("data_fim").value = '2030-01-01';
        document.getElementById("situacao").value = 'em andamento';
        document.getElementById("tipo_consulta").value = 6;
        document.getElementById("empresa_id").value = 2;
        document.getElementById('form_filt_os').submit();

    }
</script>