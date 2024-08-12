@extends('app.layouts.app')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<meta http-equiv="refresh" content="60">
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">

    {{--teste de botão pulsante--}}
    <style>
        /* ---------------------------------------//
        // Alerta de green de uma tarefa em curso*/
        .circle {
            width: 10px;
            height: 10px;
            background-color: green;
            border-radius: 50%;
            animation: pulse 1s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.2);
                opacity: 0.5;
            }
        }
    </style>
    {{--teste de botão pulsante--}}
    <div class="card">
        <div class="card-body" hidden>
            <table id="tblOs">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th hidden>Data emissao</th>
                        <th hidden>Hora</th>
                        <th>Data prevista</th>
                        <th>Hora prevista</th>
                        <th>Data fim</th>
                        <th>Hora fim</th>
                        <th>Empresa</th>
                        <th>Patrimônio</th>
                        <th>Emissor</th>
                        <th>Responsável</th>
                        <th>Descrição</th>
                        <th>Executado</th>
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
                        <td>

                            {{ $ordem_servico->Empresa->razao_social }}

                        </td>
                        <td>{{ $ordem_servico->equipamento->nome }}</td>
                        <td>{{ $ordem_servico->equipamento->id }}</td>
                        <td>{{ $ordem_servico->emissor }}</td>
                        <td>{{ $ordem_servico->responsavel }}</td>
                        <td id="descricao">

                            {{ $ordem_servico->descricao }}

                        </td>
                        <td>
                            {{ $ordem_servico->Executado }}

                        </td>
                    </tr>
                </tbody>
                @endforeach

            </table>
        </div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <!--------------------------------------------------------------------->
        <!--Código que gera o gáfico de pizza-->
        <!--------------------------------------------------------------------->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <!-------------------------------------------------------------------------->
    <table id="tabelaAgrupada2" hidden>
        <caption>Tabela Agrupada</caption>
        <thead>
            <tr>
                <th>Nome do equipamento</th>
                <th>Id</th>
                <th>Quantidade de ordens geradas</th>
            </tr>
        </thead>
        <tbody id="corpoTabelaAgrupada2">
            <!-- Aqui será preenchido dinamicamente com JavaScript -->
        </tbody>
    </table>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .container-chart {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            background-color: #f2f2f2;
        }

        .item {
            width: calc(33% - 5px);
            height: 400px;
            margin: 5px;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: auto;
            /* Impede que o conteúdo transborde */
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
    </style>
    {{-------------------------------------------------------------------------}}
    {{--Inicio do bloco que contém o container dos gráficos--------------------}}
    <div class="container-chart">
        {{--Box 1--}}
        <div class="item">
            <form action="" class="scrollable">
                <h6 class="title-md">O.S. FECHADAS HOJE</h6>
                <div class="div-os-sm">
                    <table class="condensed-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Finalização</th>
                                <th>Descrição</th>
                                <th>Patrimônio</th>
                                <th> executante</th>
                                <th>chk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordens_servicos_fech_hoje as $ordens_servicos_fech)
                            @php
                            $dataPrevista = \Carbon\Carbon::parse($ordens_servicos_fech->data_fim);

                            $dataAtual = \Carbon\Carbon::today();
                            $horaAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                            @endphp
                            <tr>
                                <td>
                                    <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordens_servicos_fech->id])}}">
                                        <span class="material-symbols-outlined">
                                            open_in_new
                                        </span>
                                    </a>
                                </td>
                                <td>{{$ordens_servicos_fech->id}}</td>
                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($ordens_servicos_fech->data_fim)->format('d/m/Y') }} {{$ordens_servicos_fech->hora_fim}}
                                </td>
                                <td>{{$ordens_servicos_fech->descricao}}</td>
                                <td>{{$ordens_servicos_fech->equipamento->nome}}</td>
                                <td>{{$ordens_servicos_fech->responsavel}}</td>
                                <td><img src="{{ asset('img/check-mark.png') }}" alt="" id="check"></td>
                                <style>
                                    #check {
                                        height: 15;
                                        width: 15;
                                    }
                                </style>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
            <form action="" class="scrollable">
                <h6 class="title-md">O.S VENCIDAS E PENDENTES </h6>
                <div class="div-os-sm" style="background-color:rgb(251,170,153);">
                    <table class="condensed-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Finalização prevista</th>
                                <th>Descrição</th>
                                <th>Patrimônio</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordens_servicos_abarta_vencidas as $ordens_servicos_venc)
                            @php
                            $dataPrevista = \Carbon\Carbon::parse($ordens_servicos_venc->data_fim);
                            $dataAtual = \Carbon\Carbon::today();
                            $horaAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                            @endphp
                            <tr>
                                <td>
                                    <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordens_servicos_venc->id])}}">
                                        <span class="material-symbols-outlined">
                                            open_in_new
                                        </span>
                                    </a>
                                </td>
                                <td>{{$ordens_servicos_venc->id}}</td>
                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($ordens_servicos_venc->data_fim)->format('d/m/Y') }} {{$ordens_servicos_venc->hora_fim}}

                                </td>
                                <td>{{$ordens_servicos_venc->descricao}}</td>
                                <td>{{$ordens_servicos_venc->equipamento->nome}}</td>
                                <td><img src="{{ asset('img/warning.png') }}" alt="" id="imgwarning"></td>
                                <style>
                                    #imgwarning {
                                        height: 15;
                                        width: 15;
                                        background-color: darkgrey;

                                    }
                                </style>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        {{--Box 2--}}
        {{-- Satus de Tarefas iniciadas, pausadas, e em excução--}}
        <style>
            .div-text-sm-row-15 {
                font-family: arial, sans-serif;
                font-size: 13px;
                font-weight: 100;
                display: flex;
                flex-direction: row;
            }

            .hr-sm {
                margin-top: -10px;
            }
        </style>
        <div class="item">
            <h6 class="title-md">O.S. EM EXECUÇÃO </h6>&nbsp&nbsp&nbsp&nbsp<a class="sidebar-submenu-expanded-a" href="{{ route('ordem-servico.index') }}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;">Filtrar Ordens</a> |
            <a class="sidebar-submenu-expanded-a" href="{{ route('empresas.index') }}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;">Unidades</a> |
            <a id="menu-ativos" class="sidebar-submenu-expanded-a" href="{{route('equipamento.index', ['empresa'=>2])}}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;" title="Clique para abrir o ativo, e selecione nova ordem de serviço.">Ativos/Nova O.S</a>
            <style>
                #menu-ativos {
                    font-size: 50px;
                }
            </style>
            <div class="" style="max-width:100%;background-color:rgb(255,255,224)">
                <div class="div-os-sm">
                    <table class="condensed-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Previsão de fim</th>
                                <th>Descrição</th>
                                <th>Patrimônio</th>
                                <th>Executante</th>
                                <th></th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach($ordens_servicos_emandamento as $os_emandamento)
                            @php
                            $dataPrevista = \Carbon\Carbon::parse($os_emandamento->data_fim);
                            $dataAtual = \Carbon\Carbon::today();
                            $horaAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                            @endphp
                            <tr>
                                <td>
                                    <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$os_emandamento->id])}}">
                                        <span class="material-symbols-outlined">
                                            open_in_new
                                        </span>
                                    </a>
                                </td>
                                <td>{{$os_emandamento->id}}</td>
                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($os_emandamento->data_fim)->format('d/m/Y') }} {{$os_emandamento->hora_fim}}

                                </td>
                                <td>{{$os_emandamento->descricao}}</td>
                                <td>{{$os_emandamento->equipamento->nome}}</td>
                                <td>{{$os_emandamento->responsavel}}</td>
                                <td>
                                    <div class="circle"></div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <span class="title-md" id="dataCompleta">
                    <script>
                        // Função para obter o dia da semana, dia do mês e o mês atual
                        function exibirDataCompleta() {
                            const diasSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
                            const mesesAno = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                            let dataAtual = new Date();
                            let diaSemana = diasSemana[dataAtual.getDay()];
                            let diaMes = dataAtual.getDate();
                            let mes = mesesAno[dataAtual.getMonth()];
                            let ano = dataAtual.getFullYear();

                            document.getElementById('dataCompleta').innerText = `O.S. PARA Hoje, ${diaSemana}, ${diaMes} de ${mes} de ${ano}`;
                        }

                        // Chama a função para exibir a data completa ao carregar a página
                        exibirDataCompleta();
                    </script>
                    <div class="div-os-sm">
                        <table class="condensed-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Previsão de início</th>
                                    <th>Previsão de fim</th>
                                    <th>Descrição</th>
                                    <th>Patrimônio</th>
                                    <th>GUT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordens_servicos_aberta_hoje as $os_hoje)
                                @php
                                $dataPrevista = \Carbon\Carbon::parse($os_hoje->data_fim);
                                $dataAtual = \Carbon\Carbon::today();
                                $horaAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                                $horaInicio = \Carbon\Carbon::parse($os_hoje->hora_inicio);
                                @endphp
                                <tr>
                                    <td>
                                        <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$os_hoje->id])}}">
                                            <span class="material-symbols-outlined">
                                                open_in_new
                                            </span>
                                        </a>
                                    </td>
                                    <td>{{$os_hoje->id}}</td>
                                    <td class="{{ $horaInicio->lt($horaAtual) ? 'text-danger' : ($horaInicio->eq($horaAtual) ? 'text-warning' : 'text-primary') }}">
                                        {{$os_hoje->hora_inicio}}
                                    </td>
                                    <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                        {{ \Carbon\Carbon::parse($os_hoje->data_fim)->format('d/m/Y') }}
                                        <span style="color:black;font-size:12px;font-family: 'Poppins', sans-serif;font-weight: 300;"> às </span>
                                        {{$os_hoje->hora_fim}}
                                    </td>
                                    <td>{{$os_hoje->descricao}}</td>
                                    <td>{{$os_hoje->equipamento->nome}}</td>
                                    <td>
                                        {{-- Valor GUT --}}
                                        @php
                                        $valorGUT = $os_hoje->valor_gut;

                                        // Determina a cor da barra de progresso
                                        if ($valorGUT <= 50) { $progressColor='blue' ; } elseif ($valorGUT> 50 && $valorGUT <= 80) { $progressColor='yellow' ; } else { $progressColor='orange' ; } @endphp <input type="text" value="{{ $valorGUT }}" id="progress-input-today" hidden>
                                                <div class="progress">
                                                    <div id="progress-bar-today" class="progress-bar" role="progressbar" aria-valuenow="{{ $valorGUT }}" aria-valuemin="0" aria-valuemax="125" style="width: {{ $valorGUT }}%; background-color: {{ $progressColor }}; color: black;">
                                                        {{ $valorGUT }}
                                                    </div>
                                                </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <hr>

            </div>

        </div>
        {{--Box 3--}}
        <style>
            .txt-conteudo-sm {
                font-size: 13px;
                font-family: 'Poppins', sans-serif;
                display: flex;
                flex-direction: row;
                font-weight: 300;

            }

            .hr-sm-shrt {}
        </style>
        <div class="item">
            <h6 class="title-md">O.S. PARA AMANHÃ</h6>
            <div class="div-os-sm">
                {{--div sm expan--}}
                <style>
                    /* estilização da div expandede*/
                    .div-tuggle-row {
                        font-size: 15px;
                        font-weight: 300;
                        font-family: 'Poppins', sans-serif;
                        cursor: pointer;
                    }

                    .div-tuggle {
                        display: flex;
                        flex-direction: row;
                    }

                    .hr-sm-tuggle {
                        margin-top: -4px;
                        margin-bottom: -4px;
                    }

                    .div-sm-cabecalho {
                        display: flex;
                        flex-direction: row;
                        justify-content: space-between;
                        width: 100%;
                    }

                    .div-font-sm-conteudo {
                        font-size: 13px !important;
                        font-weight: 300 !important;
                        font-family: 'Poppins', sans-serif !important;
                        margin: 10px;
                        text-align: left !important;
                        height: auto;
                    }

                    .title-md {
                        font-family: 'Poppins', sans-serif !important;
                        font-size: 18px !important;
                        font-weight: 300 !important;
                    }
                </style>
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
                {{--------------------------------------}}
                {{--Verifica se a variavel contém dados--}}
                {{--------------------------------------}}
                @if(empty($ordens_servicos_next_day) || $ordens_servicos_next_day->isEmpty())
                <div class="alert alert-info">
                    <div class="div-font-sm-conteudo">Nenhuma ordem de serviço prevista para o próximo dia.</div>
                </div>
                @else
                @foreach($ordens_servicos_next_day as $ordem_servico)
                @php
                $dataPrevista = \Carbon\Carbon::parse($ordem_servico->data_fim);
                $dataAtual = \Carbon\Carbon::today();
                $horaAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                $uniqueId = uniqid();
                @endphp
                <div class="div-tuggle-row" onclick="FunToggle('{{ $uniqueId }}')">
                    <div class="div-sm-cabecalho">
                        <div> <a href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                                <span class="material-symbols-outlined">
                                    open_in_new
                                </span>
                            </a></div>
                        <div class="div-font-sm-conteudo">{{$ordem_servico->id}}</div>
                        <div class="div-font-sm-conteudo">
                            <span class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">

                                {{ \Carbon\Carbon::parse($ordem_servico->data_inicio)->format('d/m/Y') }} {{$ordem_servico->hora_inicio}}</span>
                        </div>
                        <div class="div-font-sm-conteudo">{{$ordem_servico->equipamento->nome}}</div>
                        {{----------------------------------------------------------------------}}
                        {{-- Progress bar GUT --------------------------------------------------}}
                        <input type="text" value="{{ $ordem_servico->valor_gut }}" id="progress-input-{{ $ordem_servico->id }}" hidden>
                        <div class="progress">
                            <div id="progress-bar-{{ $ordem_servico->id }}" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="125" style="color:black">
                                {{ $ordem_servico->valor_gut }}
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var progressBar = document.getElementById('progress-bar-{{ $ordem_servico->id }}');
                                var progressInput = document.getElementById('progress-input-{{ $ordem_servico->id }}');

                                // Função para atualizar a barra de progresso
                                function updateProgressBar(value) {
                                    var numericValue = parseFloat(value);
                                    progressBar.style.width = numericValue + '%';
                                    progressBar.setAttribute('aria-valuenow', numericValue);
                                    progressBar.textContent = numericValue; // Atualiza o texto da barra de progresso
                                    updateProgressBarColor(numericValue);
                                }

                                // Função para atualizar a cor da barra de progresso
                                function updateProgressBarColor(value) {
                                    if (value <= 50) {
                                        progressBar.style.backgroundColor = 'blue';
                                    } else if (value > 50 && value <= 80) {
                                        progressBar.style.backgroundColor = 'yellow';
                                    } else {
                                        progressBar.style.backgroundColor = 'orange';
                                    }
                                }

                                // Chama a função de atualização da barra de progresso com o valor inicial do input
                                updateProgressBar(progressInput.value);

                                // Adiciona um ouvinte de eventos para o input
                                progressInput.addEventListener('input', function() {
                                    var value = parseFloat(progressInput.value);
                                    updateProgressBar(value);
                                });
                            });
                        </script>
                        <style>
                            .wide-progress {
                                width: 100%;
                                /* Ajuste esta largura conforme necessário */
                            }

                            .progress {
                                width: 50px;
                            }
                        </style>

                        {{--------------------------------Fim GUT------------------------------------}}
                        <div style="display:flex">
                            <span id="stat0-{{ $uniqueId }}" class="material-symbols-outlined" style="display:none;">
                                stat_1
                            </span>
                            <span id="stat1-{{ $uniqueId }}" class="material-symbols-outlined">
                                stat_minus_1
                            </span>
                        </div>
                    </div>
                    <hr style="width: 50%; margin-left: 0;margin:-10px;">
                    <div class="div-font-sm-conteudo" id="div-Toggle-{{ $uniqueId }}" style="height:auto; display:none;">
                        <div style="color: green;">Descrição</div>
                        {{$ordem_servico->descricao}}
                    </div>
                    <hr style="margin:8px;">
                </div>
                @endforeach
                @endif
                <script>
                    function FunToggle(uniqueId) {
                        let divToggle = document.getElementById('div-Toggle-' + uniqueId);
                        let stat0 = document.getElementById('stat0-' + uniqueId);
                        let stat1 = document.getElementById('stat1-' + uniqueId);

                        if (divToggle.style.display === 'none' || divToggle.style.display === '') {
                            divToggle.style.display = 'block';
                            stat0.style.display = 'inline';
                            stat1.style.display = 'none';
                        } else {
                            divToggle.style.display = 'none';
                            stat0.style.display = 'none';
                            stat1.style.display = 'inline';
                        }
                    }
                </script>
                {{--fim da div expan--}}
                {{--//-----------------------------------------------------//--}}
                {{--//---- O.S. Para segundo dia --------------------------//--}}
                {{--//-----------------------------------------------------//--}}
                @foreach($ordens_servicos_second_day as $seg_day_title)
                @endforeach
                @if(isset($seg_day_title))
                <!-- Algum conteúdo -->
                <h6 class="title-md">
                    O.S. PARA DAQUI 2 DIAS ({{ \Carbon\Carbon::parse($seg_day_title->data_inicio)->locale('pt_BR')->isoFormat('dddd') }}):
                </h6>
                @else
                <!-- Outro conteúdo -->
                <h6 class="title-md">
                    NÃO HÀ O.S. PARA DAQUI 2 DIAS.
                </h6>
                @endif
                <hr style="margin:-2px;">
                @forelse($ordens_servicos_second_day as $seg_day)
                <div class="div-font-sm-conteudo" style="margin: 5px;">
                    <a href="{{route('ordem-servico.show', ['ordem_servico'=>$seg_day->id])}}">
                        <span class="material-symbols-outlined">
                            open_in_new
                        </span>
                    </a>
                    {{$seg_day->id}}
                    {{$seg_day->data_inicio}} às {{$seg_day->hora_inicio}} até
                    {{$seg_day->data_fim}} às {{$seg_day->hora_fim}}
                    {{$seg_day->equipamento->nome}}
                </div>
                <div class="div-font-sm-conteudo" style="color: brown;">Descrição</div>
                <div class="div-font-sm-conteudo">{{$seg_day->descricao}}</div>
                @empty
                @endforelse
                <hr>
                {{--//-----------------------------------------------------//--}}
                {{--//---- Para daqui 3 dias ------------------------------//--}}
                {{--//-----------------------------------------------------//--}}

                @if($ordens_servicos_third_day->isNotEmpty())
                @foreach($ordens_servicos_third_day as $terc_day_title)
                @endforeach
                <h6 class="title-md">O.S. PARA DAQUI 3 DIAS ({{ \Carbon\Carbon::parse($terc_day_title->data_inicio)->locale('pt_BR')->isoFormat('dddd') }}):</h6>
                @else
                <h6 class="title-md">NÃO HÀ O.S. PARA DAQUI 3 DIAS.</h6>
                @endif
                @forelse($ordens_servicos_third_day as $terc_day)
                <div class="div-font-sm-conteudo">
                    <a href="{{route('ordem-servico.show', ['ordem_servico' => $terc_day->id])}}">
                        <span class="material-symbols-outlined">
                            open_in_new
                        </span>
                    </a>
                    {{$terc_day->id}}
                    {{$terc_day->data_inicio}} às {{$terc_day->hora_inicio}} até
                    {{$terc_day->data_fim}} às {{$terc_day->hora_fim}}
                    {{$terc_day->equipamento->nome}}
                </div>
                <div class="div-font-sm-conteudo" style="color: brown;">Descrição</div>
                <div class="div-font-sm-conteudo">{{$terc_day->descricao}}</div>
                <hr>
                @empty
                <hr>
                @endforelse
            </div>
        </div>
        {{--Box 4--}}
        <div class="item">
            <h6 class="title-md">O.S FECHADA POR MÁQUINA</h6> <!-- Ajuste a margem superior conforme necessário -->
            <div id="graficoPizza" class="box" hidden></div>
            {{--//-------------------------------------------------//--}}
            {{--//--------------------------//--}}
            {{--//-------------------------------------------------//--}}
            @foreach($equipamento as $equipamentos)
            <div style="display:flex; align-items:center; flex-direction:row;">
                {{$equipamentos->id}} {{$equipamentos->nome}}
                <div style="flex-grow:1;"></div> <!-- Este div empurra o link para a direita -->
                <a href="{{ route('equipamento.show', ['equipamento' => $equipamentos->id,'tipofiltro'=>1]) }}" style="display:flex; align-items:center; margin-left:auto;">
                    <span class="material-symbols-outlined">
                        open_in_new
                    </span>
                </a>
                <a href="{{ route('equipamento.show', ['equipamento' => $equipamentos->id,'tipofiltro'=>1]) }}" style="display:flex; align-items:center; margin-left:auto;">
                    <span class="material-symbols-outlined">
                        open_in_new
                    </span>
                </a>
            </div>
            <hr style="margin:4px;">
            @endforeach
            {{--//-------------------------------------------------//--}}
        </div>
        {{--Box 5--}}
        {{--Box que contém a lista de pedidos abertos--}}
        <div class="item">
            <span class="title-md">PEDIDOS</span> &nbsp&nbsp&nbsp&nbsp
            <a class="sidebar-submenu-expanded-a" href="{{route('pedido-compra.index')}}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;">Pedidos de compra</a> |
            <a id="menu-ativos" class="sidebar-submenu-expanded-a" href="{{route('equipamento.index', ['empresa'=>2])}}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;" title="Clique para abrir o ativo, e selecione novo pedido de compra.">Novo pedido de compra</a> |
            <a class="sidebar-submenu-expanded-a" href="{{route('pedido-saida.create', ['ordem_servico'=>0])}}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;">Criar novo pedido de saída</a>
            <hr>
            <div class="card text-white mb-3" style="max-width:100%;background-color:rgb(189,236,182);">
                <div class="card-body">
                    <div class="container">
                        <table class="condensed-table" id="tb_pedidos_compra">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Emissão</th>
                                    <th>Previsão</th>
                                    <th>Destino</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pedidos_compra as $pedido_compra)
                                @php
                                $dataPrevista = \Carbon\Carbon::parse($pedido_compra->data_prevista);

                                $dataAtual = \Carbon\Carbon::today();
                                $horaAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                                @endphp
                                <tr>
                                    <td>
                                        <a class="" href="{{route('pedido-compra-lista.index', ['numpedidocompra'=>$pedido_compra->id ])}}">
                                            <span class="material-symbols-outlined">open_in_new</span>
                                        </a>
                                    </td>
                                    <td>{{ $pedido_compra->id }}</td>
                                    <td>{{\Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/Y')}} {{ $pedido_compra->hora_emissao}}</td>
                                    <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                        {{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/Y') }} {{ $pedido_compra->hora_prevista}}

                                    </td>

                                    <td>{{ $pedido_compra->equipamento->nome }}</td>
                                    <td hidden>{{ $pedido_compra->descricao}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-----------------------------------------------}}
                        {{--Div script exibe informações sobre o pedido--}}
                        <style>
                            .info-box {
                                width: 500px;
                                display: none;
                                position: absolute;
                                background-color: aliceblue;
                                border: 1px solid #ccc;
                                padding: 10px;
                                opacity: 0;
                                transition: opacity 0.5s ease-in-out;
                                border-radius: 5px;
                                z-index: 9999;
                                /* Coloca a div acima de todos os outros elementos */
                            }
                        </style>
                        <script>
                            var tabela = document.getElementById('tb_pedidos_compra');
                            var infoBox = document.getElementById('info-box');
                            var timeoutId;

                            tabela.addEventListener('mouseover', function(event) {
                                if (event.target.tagName === 'TD') {
                                    timeoutId = setTimeout(function() {
                                        var row = event.target.parentNode;
                                        var cells = row.getElementsByTagName('td');
                                        var labels = ['ID', 'Emissão', 'Previsão de uso', 'Ativo', 'Descrição']; // Rótulos dos campos
                                        var info = '<div class="info-content" style="text-align: center;">' +
                                            '<h5 style="margin-bottom: 10px;">Pedido de compra</h5>'; // Adiciona margem inferior para separar do restante do conteúdo

                                        for (var i = 1; i < cells.length; i++) {
                                            info += '<p><strong>' + labels[i - 1] + ':</strong> ' + cells[i].textContent + '</p>';
                                        }

                                        info += '</div>';

                                        infoBox.innerHTML = info;
                                        infoBox.style.display = 'block';

                                        // Posição inicial
                                        var topPosition = event.clientY + 10;
                                        var leftPosition = event.clientX + 10;

                                        // Verifica se a posição da div excede a altura da janela
                                        var windowHeight = window.innerHeight;
                                        var infoBoxHeight = infoBox.clientHeight;
                                        if (topPosition + infoBoxHeight > windowHeight) {
                                            topPosition = windowHeight - infoBoxHeight - 20; // 20 pixels de margem
                                        }

                                        infoBox.style.top = topPosition + 'px';
                                        infoBox.style.left = leftPosition + 'px';
                                        infoBox.style.opacity = 1; // Altera a opacidade para 1 para mostrar a div gradualmente
                                    }, 300); // 2 segundos
                                }
                            });

                            tabela.addEventListener('mouseout', function() {
                                clearTimeout(timeoutId);
                                infoBox.style.opacity = 0; // Altera a opacidade para 0 para esconder a div gradualmente
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
        {{--Box 6--}}
        <style>
            .scrollable {
                max-height: 300px;
                overflow: auto;
                border: 1px solid #ccc;
                padding: 10px;
            }

            form {
                font-size: 15px;
                color: black;
                font-stretch: condensed;
                font-weight: 300;

            }

            .div-os-sm {
                font-size: 12px;
                font-weight: 400;
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                font-stretch: ultra-condensed;
                color: black;
                border-radius: 5px;
                padding: 1px;
                margin: 1px;
                background-color: rgb(248, 248, 255, 0.7);

            }
        </style>
        <div class="item">
            <span class="title-md">ESTOQUE ALMOXARIFADO</span>
            <a class="sidebar-submenu-expanded-a" href="{{route('produto.index')}}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;">Produtos</a> |
            <a class="sidebar-submenu-expanded-a" href="{{route('Estoque-produto.index')}}" style="text-decoration: underline; font-size: 17px;vertical-align: middle;">Estoque de produtos</a>
            <hr>
            <table class="condensed-table" id="tb_pedidos_compra" style="background-color: burlywood;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Produto_id</th>
                        <th>Estoque</th>
                        <th>Estoque_minimo</th>
                        <th>Estoque_máximo</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($produtos_estoque_critico as $produto_estoque_critico)
                    <tr>
                        <td>
                            <a class="" href="{{ route('produto.show', ['produto' => $produto_estoque_critico->produto_id]) }}">
                                <span class="material-symbols-outlined">open_in_new</span>
                            </a>
                        </td>
                        <td>{{ $produto_estoque_critico->id }}</td>
                        @php
                        $produtoNome = $produtos->firstWhere('id', $produto_estoque_critico->produto_id)->nome ?? 'Produto não encontrado';
                        @endphp
                        <style>
                            .bg-light-warning {
                                background-color: rgba(173, 255, 47, 0.5);
                                /* cor amarelo claro */
                            }
                        </style>
                        <td>{{ $produtoNome }}</td>
                        <td class="@if($produto_estoque_critico->quantidade <= 0) bg-danger @elseif($produto_estoque_critico->quantidade < $produto_estoque_critico->estoque_minimo) bg-warning @elseif($produto_estoque_critico->quantidade == $produto_estoque_critico->estoque_minimo) bg-light-warning @endif">
                            {{ $produto_estoque_critico->quantidade }}
                        </td>
                        <td class="@if($produto_estoque_critico->quantidade <= 0) bg-danger @elseif($produto_estoque_critico->quantidade < $produto_estoque_critico->estoque_minimo) bg-warning @elseif($produto_estoque_critico->quantidade == $produto_estoque_critico->estoque_minimo) bg-light-warning @endif">
                            {{ $produto_estoque_critico->estoque_minimo }}
                        </td>
                        <td> {{$produto_estoque_critico->estoque_maximo}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <canvas id="myChart2" class="box" hidden></canvas>
        </div>
    </div>

    {{--fim do item 6--}}
    </div>
    </div>
    <script>
        //-------------------------------------------------------------------------------------------------------
        function VerTabela() {
            agruparNumerosIguais() //chama criar tabela
            table1 = document.getElementById("tblOs");
            let totalColumnsTbOs = (table1.rows.length);

            for (var i = 1; i < table1.rows.length; i++) {
                let equipamentoId =
                    document.getElementById("tblOs").rows[i].cells[9].innerHTML;
                //FunAjaxGetcontEquip()
            };
            if (i = totalColumnsTbOs) {}
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

    <script>
        //Cria uma tabela que agrupa os registros iguais e conta quantos registros iguais.
        function agruparNumerosIguais1() {
            agruparNumerosIguais2() //chama para gerar a segunda tabela
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
            GeraGraficoPizza() //chama gerar gráfico pie chart google  após ter gerado a tebela agrupada
            //GerarGráficoLinhas() //chama função para gerar gráfico de linhas após ter gerado a tabela agrupada
        }
        //Fim da função que gera tabela agrupada

        //-----------------------------------------------------------------------------------//
        //gera uma tabela agrupada que conta mostra quantidade de ordens por data------------//
        function agruparNumerosIguais2() {
            var tabela = document.getElementById("tblOs");
            var numeros = {};

            for (var i = 1; i < tabela.rows.length; i++) {
                var nome = tabela.rows[i].cells[3].innerHTML;
                var numero = tabela.rows[i].cells[3].innerHTML;
                if (!numeros[nome]) {
                    numeros[nome] = {};
                }
                if (!numeros[nome][numero]) {
                    numeros[nome][numero] = 1;
                } else {
                    numeros[nome][numero]++;
                }
            }

            var tabelaAgrupada = document.getElementById("tabelaAgrupada2");
            var corpoTabelaAgrupada = document.getElementById("corpoTabelaAgrupada2");
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
            //GerarGráficoLinhas()
            GeraGraficoLinhaQntOsData()
        }
        //fim gera uma tabela agrupada que conta mostra quantidade de ordens por data------------//
        //-----------------------------------------------------------------------------------//
        function GerarGráficoLinhas() {
            // Extrai os dados da tabela HTML
            const table = document.getElementById('tblOs');
            const data = Array.from(table.querySelectorAll('tbody tr')).map(row => {
                const cells = Array.from(row.cells);
                return {
                    data: cells[2].textContent,
                    gasto: parseFloat(cells[1].textContent)
                };
            });
            // Prepara os dados para o gráfico
            const labels = data.map(item => item.data);
            const dataset = {
                label: 'Gasto',
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

    <script>
        //-------------------------------------------------------------------//
        //Evento so executa após ter carregado todo os elementos do Dom
        //-------------------------------------------------------------------//
        document.addEventListener('DOMContentLoaded', (event) => {
            agruparNumerosIguais1() //executa a função que gera uma tabela agrupada
            // Extrai os dados da tabela HTML
            //Gera um gráfico de barras apartir da biblioteca chart.js
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
                label: 'Gasto',
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
            })
        });
    </script>
    <!-- Importar a biblioteca do Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        //document.addEventListener("DOMContentLoaded", function() {
        function GeraGraficoPizza() {
            // Carregar a biblioteca de visualização e preparar para desenhar o gráfico
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
                data.addColumn('string', 'Total de O.S');
                data.addColumn('number', 'Horas por Dia');
                data.addColumn('number', 'Outro Valor'); // Adicionar um terceiro valor
                data.addRows(dadosTabela);

                // Configurar as opções do gráfico
                var options = {
                    title: 'Total de O.S',
                    width: 500,
                    height: 380,
                    is3D: true,
                    backgroundColor: 'darkgrey',
                };

                // Instanciar e desenhar o gráfico, passando os dados e opções
                var chart = new google.visualization.PieChart(document.getElementById('graficoPizza'));
                chart.draw(data, options);
            }
            // }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 100%;
            margin: 1px;
        }
    </style>
    <script>
        function GeraGraficoLinhaQntOsData() { //Gráfico gerado pelo google chart para contar os por periodo
            const table = document.getElementById('tabelaAgrupada2');
            const data = [];
            for (let i = 1; i < table.rows.length; i++) {
                const row = table.rows[i];
                data.push({
                    data: row.cells[0].textContent,
                    quantidade: parseInt(row.cells[2].textContent)
                });
            }

            // Extrair datas e quantidades da tabela
            const dates = data.map(item => item.data);
            const quantities = data.map(item => item.quantidade);

            // Criar gráfico
            const ctx = document.getElementById('myChart2').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Quantidade',
                        data: quantities,
                        borderColor: 'rgba(0, 51, 102, 1)', // Azul escuro
                        backgroundColor: 'rgba(0, 51, 102, 0.2)',
                        cubicInterpolationMode: 'default',
                        fill: true
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

        }
    </script>
    @endsection
    <style>
        table.condensed-table {
            line-height: 1;
            border-collapse: collapse;
            width: 100%;
        }

        table.condensed-table th,
        table.condensed-table td {
            padding: 2px;
            /* Define o padding como 0 para as células */
            font-size: 12px;
            border-bottom: 1px solid rgb(255, 255, 200, 0.3);
            /* Adiciona uma borda inferior de 1px sólida cinza */
        }

        /* Altera a cor de fundo da linha quando o mouse passar sobre ela */
        table.condensed-table tr:hover {
            background-color: rgb(255, 255, 255);
            /* Altera a cor de fundo para cinza claro */
            cursor: pointer;
            transition: 1.5s;
            opacity: 0.9;
        }
    </style>

</main>