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
    {{--Botão pulsante geen--}}
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
                <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">O.S. FECHADAS HOJE</h6>
                <div class="div-os-sm">
                    <table class="condensed-table">
                        <thead>
                            <tr>
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
                                    <a style="font-size: 17px;" class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordens_servicos_fech->id])}}">
                                        {{$ordens_servicos_fech->id}}
                                    </a>
                                </td>

                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($ordens_servicos_fech->data_fim)->format('d/m/y')}}
                                    {{ \Carbon\Carbon::parse($ordens_servicos_fech->hora_fim)->format('H:i') }}
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
                <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">O.S VENCIDAS E PENDENTES </h6>
                <div class="div-os-sm" style="background-color:rgb(251,170,153);">
                    <table class="condensed-table">
                        <thead>
                            <tr>

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

                                <td> <a style="font-size: 17px;" class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordens_servicos_venc->id])}}">
                                        {{$ordens_servicos_venc->id}}
                                    </a></td>
                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($ordens_servicos_venc->data_fim)->format('d/m/y') }}
                                    {{ \Carbon\Carbon::parse($ordens_servicos_venc->hora_fim)->format('h:i') }}
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
            <span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">O.S. EM EXECUÇÃO</span> &nbsp
            <button class="btn btn-outline-primary btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('ordem-servico.index') }}'">
                Filtrar O.S.
            </button>
            <button class="btn btn-outline-info btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('program_os') }}'">
                Distribuição O.S.
            </button>
            <button class="btn btn-outline-dark btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('equipamento.index', ['empresa'=>2]) }}'">
                Ativos/Nova O.S.
            </button>
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
                                    <a style="font-size: 17px;" class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico'=>$os_emandamento->id])}}">
                                        {{$os_emandamento->id}}
                                    </a>
                                </td>

                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($os_emandamento->data_fim)->format('d/m/y') }} {{ \Carbon\Carbon::parse($os_emandamento->hora_fim)->format('H:i') }}

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
                                    <th>Dados</th>
                                    <th>Descrição</th>
                                    <th>Patrimônio</th>
                                    <th>Tipo</th>
                                    <th>GUT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordens_servicos_aberta_hoje as $os_hoje)
                                @php
                                //---------------------------------------------//
                                // Comparador de data e horas aplicando cores
                                //---------------------------------------------//

                                $agora = \Carbon\Carbon::now();

                                // Data Início
                                if ($os_hoje->data_inicio) {
                                $dataInicio = \Carbon\Carbon::parse($os_hoje->data_inicio)->startOfDay();

                                if ($dataInicio->equalTo($agora->copy()->startOfDay())) {
                                $classeDataInicio = 'text-warning'; // amarelo
                                } elseif ($dataInicio->lessThan($agora)) {
                                $classeDataInicio = 'text-danger'; // vermelho
                                } else {
                                $classeDataInicio = 'text-primary'; // azul
                                }
                                } else {
                                $classeDataInicio = ''; // classe padrão caso data_inicio seja nula
                                }

                                // Hora Início (somente se a data for hoje e hora_inicio existir)
                                if ($os_hoje->hora_inicio && isset($dataInicio) && $dataInicio->equalTo($agora->copy()->startOfDay())) {
                                $horaInicio = \Carbon\Carbon::parse($os_hoje->hora_inicio);

                                if ($horaInicio->lessThan($agora)) {
                                $classeHoraInicio = 'text-danger';
                                } elseif ($horaInicio->equalTo($agora)) {
                                $classeHoraInicio = 'text-warning';
                                } else {
                                $classeHoraInicio = 'text-primary';
                                }
                                } else {
                                $classeHoraInicio = '';
                                }

                                // Data Fim
                                if ($os_hoje->data_fim) {
                                $dataFim = \Carbon\Carbon::parse($os_hoje->data_fim)->startOfDay();

                                if ($dataFim->equalTo($agora->copy()->startOfDay())) {
                                $classeDataFim = 'text-warning';
                                } elseif ($dataFim->lessThan($agora)) {
                                $classeDataFim = 'text-danger';
                                } else {
                                $classeDataFim = 'text-primary';
                                }
                                } else {
                                $classeDataFim = '';
                                }

                                // Hora Fim (somente se a data for hoje e hora_fim existir)
                                if ($os_hoje->hora_fim && isset($dataFim) && $dataFim->equalTo($agora->copy()->startOfDay())) {
                                $horaFim = \Carbon\Carbon::parse($os_hoje->hora_fim);

                                if ($horaFim->lessThan($agora)) {
                                $classeHoraFim = 'text-danger';
                                } elseif ($horaFim->equalTo($agora)) {
                                $classeHoraFim = 'text-warning';
                                } else {
                                $classeHoraFim = 'text-primary';
                                }
                                } else {
                                $classeHoraFim = '';
                                }


                                //---------------------------------------------//
                                // Cor da linha com base na especialidade
                                switch(strtolower($os_hoje->especialidade_do_servico)) {
                                case 'elétrica':
                                case 'eletrica':
                                $linhaClasse = 'linha-eletrica';
                                break;
                                case 'mecânica':
                                case 'mecanica':
                                $linhaClasse = 'linha-mecanica';
                                break;
                                default:
                                $linhaClasse = '';
                                }
                                @endphp
                                <tr class="{{ $linhaClasse }}">



                                    <td>
                                        <a style="font-size: 18px;" class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico'=>$os_hoje->id]) }}">
                                            {{ $os_hoje->id }}
                                        </a>
                                        <hr style="margin: 2px; color: gray" hidden>
                                        <div style="border: 1px solid rgba(0, 0, 0, 0.1);border-radius:3px;">
                                            <div style="flex-direction: row;display:flex;"> <span style="font-weight:300;" class="{{ $classeDataInicio }}">
                                                    {{ \Carbon\Carbon::parse($os_hoje->data_inicio)->format('d/m/y') }}
                                                </span>
                                                <span style="font-weight:300;" class="{{ $classeHoraInicio }}">
                                                    -{{ \Carbon\Carbon::parse($os_hoje->hora_inicio)->format('H:i') }}
                                                </span>
                                            </div>
                                            <hr style="margin: 2px; color: gray">
                                            <div style="flex-direction: row;display:flex;"> <span style="font-weight:300;" class="{{ $classeDataFim }}">
                                                    {{ \Carbon\Carbon::parse($os_hoje->data_fim)->format('d/m/y') }}
                                                </span>
                                                <span style="font-weight:300;" class="{{ $classeHoraFim }}">
                                                    -{{ \Carbon\Carbon::parse($os_hoje->hora_fim)->format('H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    </td>
                                    <td>{{$os_hoje->descricao}}</td>
                                    <td>
                                        <span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;font-stretch:extra-condensed;">
                                            {{$os_hoje->equipamento->nome}}</span>
                                    </td>
                                    <td style="font-stretch:condensed;">

                                        <span style="display: inline-flex; align-items: center; gap: 4px;">
                                            {{ Str::upper($os_hoje->especialidade_do_servico) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Valor GUT --}}
                                        @php
                                        $valorGUT = $os_hoje->valor_gut;

                                        // Determina a cor da barra de progresso
                                        if ($valorGUT <= 50) { $progressColor='blue' ; } elseif ($valorGUT> 50 && $valorGUT <= 80) { $progressColor='yellow' ; } else { $progressColor='orange' ; } @endphp <input type="text" value="{{ $valorGUT }}" id="progress-input-today" hidden>
                                                <div class="progress">
                                                    <div id="progress-bar-today" class="progress-bar" role="progressbar" aria-valuenow="{{ $valorGUT }}" aria-valuemin="0" aria-valuemax="125" style="width: {{ $valorGUT }}%; background-color: {{ $progressColor }}; color: black;">

                                                    </div>
                                                </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--Troca cor das linha d tabela acima-->
                        <style>
                            .linha-eletrica {
                                background-color: rgb(216, 216, 210);
                                /* verde claro */
                            }

                            .linha-mecanica {
                                background-color: #e0f0ff;
                                /* azul claro */
                            }
                        </style>
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
        </style>
        <div class="item">
            <h6 style="font-family:Arial,sanserif;font-weight:bold;">O.S. PARA AMANHÃ</h6>
            <div>
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
                        <div> <a style="font-size: 17px;" class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                                {{$ordem_servico->id}}
                            </a></div>
                        <div class="div-font-sm-conteudo">
                            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;" class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">

                                {{ \Carbon\Carbon::parse($ordem_servico->data_inicio)->format('d/m/y') }}
                                {{ \Carbon\Carbon::parse($ordem_servico->hora_inicio)->format('h:i') }}
                            </span>
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
                        <div style="font-family: Arial, sans-serif; font-size: 16px;color:darkblue;">Descrição</div>
                        <span style="font-family: Arial, sans-serif; font-size: 16px;"> {{$ordem_servico->descricao}}</span>
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
                <h6 style="font-family:Arial,sanserif;font-weight:bold;">
                    O.S. PARA DAQUI 2 DIAS ({{ \Carbon\Carbon::parse($seg_day_title->data_inicio)->locale('pt_BR')->isoFormat('dddd') }}):
                </h6>
                @else
                <!-- Outro conteúdo -->
                <h6 style="font-family:Arial,sanserif;font-weight:bold;">
                    NÃO HÀ O.S. PARA DAQUI 2 DIAS.
                </h6>
                @endif
                <hr style="margin:-2px;">
                @forelse($ordens_servicos_second_day as $seg_day)
                <div class="div-font-sm-conteudo" style="margin: 5px;">
                    <a style="font-size: 17px;" class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico'=>$seg_day->id])}}">
                        {{$seg_day->id}}
                    </a>&nbsp
                    <span style="font-family: Arial, Helvetica, sans-serif;font-weight:300;font-size:16px;">
                        {{ \Carbon\Carbon::parse($seg_day->data_inicio)->format('d/m/y') }}
                        às
                        {{ \Carbon\Carbon::parse($seg_day->hora_inicio)->format('h:i') }}
                        até
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif;font-weight:300;font-size:16px;">
                        {{ \Carbon\Carbon::parse($seg_day->data_fim)->format('d/m/y') }}
                        às
                        {{ \Carbon\Carbon::parse($seg_day->hora_fim)->format('h:i') }}
                    </span>
                    <span style="font-family: Arial, sans-serif, bold; font-size: 16px;font-weight: bold;float:right;">{{$seg_day->equipamento->nome}}</span>
                </div>
                <div class="div-font-sm-conteudo"><span style="font-family: Arial, sans-serif; font-size: 16px;">{{$seg_day->descricao}}</span></div>
                <hr>
                @empty
                @endforelse
                {{--//-----------------------------------------------------//--}}
                {{--//---- Para daqui 3 dias ------------------------------//--}}
                {{--//-----------------------------------------------------//--}}

                @if($ordens_servicos_third_day->isNotEmpty())
                @foreach($ordens_servicos_third_day as $terc_day_title)
                @endforeach
                <h6>O.S. PARA DAQUI 3 DIAS ({{ \Carbon\Carbon::parse($terc_day_title->data_inicio)->locale('pt_BR')->isoFormat('dddd') }}):</h6>
                @else
                <h6>NÃO HÀ O.S. PARA DAQUI 3 DIAS.</h6>
                @endif
                @forelse($ordens_servicos_third_day as $terc_day)
                <div>
                    <a style="font-size: 17px;" class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $terc_day->id])}}">
                        {{$terc_day->id}}
                    </a>&nbsp
                    <span style="font-family: Arial, Helvetica, sans-serif;font-weight:300;font-size:16px;">
                        {{ \Carbon\Carbon::parse($terc_day->data_inicio)->format('d/m/y') }}
                        às
                        {{ \Carbon\Carbon::parse($terc_day->hora_inicio)->format('h:i') }}
                        até
                        {{ \Carbon\Carbon::parse($terc_day->data_fim)->format('d/m/y') }}
                        às
                        {{ \Carbon\Carbon::parse($terc_day->hora_fim)->format('h:i') }}
                    </span>
                    <span style="font-family: Arial, sans-serif, bold; font-size: 16px;font-weight: bold;float:right;">{{$terc_day->equipamento->nome}}</span>
                </div>
                <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;">{{$terc_day->descricao}}</span>
                @empty
                @endforelse
            </div>
            <hr>
            <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">ORDENS FUTURAS</h6>
            @if(isset($ordens_servicos_next))
            @foreach($ordens_servicos_next as $ordem_servico_next)
            <a style="font-size: 17px;" class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}">
                {{$ordem_servico_next->id}}
            </a>&nbsp
            <span style="font-family: Arial, Helvetica, sans-serif;font-weight:300;font-size:16px;">
                {{ \Carbon\Carbon::parse($ordem_servico_next->data_inicio)->format('d/m/y') }}
                às
                {{ \Carbon\Carbon::parse($ordem_servico_next->hora_inicio)->format('h:i') }}
            </span>
            <span style="font-family: Arial, sans-serif, bold; font-size: 16px;font-weight: bold;float:right;">{{$ordem_servico_next->equipamento->nome}}</span>
            <br>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;">{{$ordem_servico_next->descricao}}</span> <br>
            <hr style="margin:5px;">
            @endforeach
            @endif
        </div>
        {{--Box 4--}}
        <div class="item" style="background-color: rgb(245, 246, 248);">
            <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">O.S. FECHADA POR MÁQUINA</h6> <!-- Ajuste a margem superior conforme necessário -->
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Div de alinhamento row dos cards-->
            <div style="display: flex;flex-direction:row;">
                <div style="display:flex;flex-direction:column;height:80px;width:150px;background-color:#FFFFFF; border-radius:5px;height:60px;box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);margin:5px;">
                    <div style="">
                        <Span style="font-size:12px;font-family: Arial, Helvetica, sans-serif;color: #333333; ">Fechadas últimos 2 dias</Span><br>
                    </div>
                    <hr style="margin-top: -2px; color:#ccc;">
                    <div style="display: flex; justify-content: center;">
                        <h6>
                            @if(isset($os_fechadas_2dias))
                            {{ $os_fechadas_2dias }}&nbsp <span style="font-family: Arial, Helvetica, sans-serif;color:blue;font-size:14;">O.S.</span>

                            @else
                            0
                            $os_fechadas_2dias=0;
                            @endif
                        </h6>
                        <input type="number" id="os_fechadas" value="{{$os_fechadas_2dias}}" hidden>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;height:80px;width:150px;background-color:#FFFFFF; border-radius:5px;height:60px;box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);margin:5px;">
                    <div style="">
                        <Span style="font-size:14px;font-family: Arial, Helvetica, sans-serif;color: #333333; ">Total Abertas </Span><br>
                    </div>
                    <hr style="margin-top: -2px; color:#ccc;">
                    <div style="display: flex; justify-content: center;">
                        <h6>
                            @if(isset($os_abertas))
                            {{$os_abertas}}&nbsp <span style="font-family: Arial, Helvetica, sans-serif;color:blue;font-size:14;">O.S.</span>
                            @else
                            0
                            @endif
                        </h6>
                        <input type="number" id="os_abertas" value="{{$os_abertas}}" hidden>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;height:80px;width:150px;background-color:#FFFFFF; border-radius:5px;height:60px;box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);margin:5px;">
                    <div style="">
                        <Span style="font-size:14px;font-family: Arial, Helvetica, sans-serif;color: #333333; ">Em andamento</Span><br>
                    </div>
                    <hr style="margin-top: -2px; color:#ccc;">
                    <div style="display: flex; justify-content: center;">
                        <h6>
                            @if(isset($os_em_andamento))
                            {{$os_em_andamento}}&nbsp <span style="font-family: Arial, Helvetica, sans-serif;color:blue;font-size:14;">O.S.</span>
                            @else
                            0
                            @endif
                        </h6>
                        <input type="number" id="os_em_andamento" value="{{$os_em_andamento}}" hidden>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;height:80px;width:150px;background-color:#FFFFFF; border-radius:5px;height:60px;box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);margin:5px;">
                    <div style="">
                        <Span style="font-size:14px;font-family: Arial, Helvetica, sans-serif;color: #333333; ">Neste intervalo</Span><br>
                    </div>
                    <hr style="margin-top: -2px; color:#ccc;">
                    <div style="display: flex; justify-content: center;">
                        <h6>
                            @if(isset($os_today))
                            {{$os_today}}&nbsp <span style="font-family: Arial, Helvetica, sans-serif;color:blue;font-size:14;">O.S.</span>
                            @else
                            0
                            @endif
                        </h6>
                        <input type="number" id="os_hoje" value="{{$os_today}}" hidden>
                    </div>
                </div>
            </div>
            <!--Chart   Gerado pelo Echart ------------------------------------------------------>

            <body style="height: 100%; margin: 0">
                <div id="container" style="height: 100%"></div>

                <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>

                <script type="text/javascript">
                    var dom = document.getElementById('container');
                    var myChart = echarts.init(dom, null, {
                        renderer: 'canvas',
                        useDirtyRect: false
                    });

                    // Supondo que esses valores sejam gerados no Blender

                    var os_em_andamento = document.getElementById('os_em_andamento').value; // Exemplo: valor da variável
                    var os_fechadas = document.getElementById('os_fechadas').value; // Exemplo: valor da variável
                    var os_abertas = document.getElementById('os_abertas').value; // Exemplo: valor da variável
                    var os_hoje = document.getElementById('os_hoje').value; // Exemplo: valor da variável

                    var option;

                    // Este exemplo requer ECharts v5.5.0 ou posterior
                    option = {
                        tooltip: {
                            trigger: 'item'
                        },
                        legend: {
                            top: '5%',
                            left: 'center'
                        },
                        series: [{
                            name: 'Status das Solicitações',
                            type: 'pie',
                            radius: ['40%', '70%'],
                            center: ['50%', '70%'],
                            // ajuste o ângulo inicial e final
                            startAngle: 180,
                            endAngle: 360,
                            data: [{
                                    value: os_abertas,
                                    name: 'Solicitações Abertas'
                                },
                                {
                                    value: os_em_andamento,
                                    name: 'Solicitações em Andamento'
                                },
                                {
                                    value: os_fechadas,
                                    name: 'Solicitações Fechadas'
                                },
                                {
                                    value: os_fechadas,
                                    name: 'Solicitações Hoje'
                                }
                            ],
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }]
                    };

                    if (option && typeof option === 'object') {
                        myChart.setOption(option);
                    }

                    window.addEventListener('resize', myChart.resize);
                </script>

                {{--//-------------------------------------------------//--}}
                {{--//--------------------------//--}}
                {{--//-------------------------------------------------//--}}
                @foreach($assets as $equipamentos)
                <div style="display:flex; align-items:center; flex-direction:row;font-family:Arial, Helvetica, sans-serif;" hidden>
                    {{$equipamentos->nome}}
                    <div style="flex-grow:1;"></div> <!-- Este div empurra o link para a direita -->
                    <a href="{{ route('equipamento.show', ['equipamento' => $equipamentos->id,'tipofiltro'=>1]) }}" style="display:flex; align-items:center; margin-left:auto;" hidden>
                        <span class="material-symbols-outlined">
                            open_in_new
                        </span>
                    </a>
                    <!-- resources/views/example.blade.php -->
                    <form action="{{ route('assets') }}" method="POST">
                        @csrf
                        <input type="text" name="asset_id" placeholder="Digite o histórico do equipamento" required value="{{$equipamentos->id}}" hidden>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Buscar</button>
                    </form>
                </div>
                @endforeach

                {{--//-------------------------------------------------//--}}
        </div>
        {{--Box 5--}}
        {{--Box que contém a lista de pedidos abertos--}}
        <div class="item">
            <span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">PEDIDOS</span> &nbsp&nbsp&nbsp&nbsp
            <button class="btn btn-outline-primary btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('pedido-compra.index') }}'">
                Pedidos de compra
            </button>
            <button class="btn btn-outline-info btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('equipamento.index', ['empresa'=>2]) }}'">
                Novo Pedido de compra
            </button>
            <button class="btn btn-outline-dark btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('pedido-saida.create', ['ordem_servico'=>0]) }}'">
                Novo Pedido de saída
            </button>
            <hr style="margin-bottom:2px;margin-top:2px;">
            <div class="card text-white mb-3" style="max-width:100%;background-color:#cbe7d0;">
                <div class="card-body">
                    <div class="container">
                        <table class="condensed-table" id="tb_pedidos_compra">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th hidden>Emissão</th>
                                    <th>Previsão</th>
                                    <th>Destino</th>
                                    <th>Satus</th>
                                    <th>Atualizado</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pedidos_compra as $pedido_compra)
                                @php
                                $dataPrevista = \Carbon\Carbon::parse($pedido_compra->data_prevista);

                                $dataAtual = \Carbon\Carbon::today();
                                $horaAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                                @endphp
                                <tr style="padding:10px;">
                                    <td>
                                        <a style="font-size: 17px;" class="txt-link" href="{{route('pedido-compra-lista.index', ['numpedidocompra'=>$pedido_compra->id ])}}">
                                            {{ $pedido_compra->id }}
                                        </a> &nbsp&nbsp <br>
                                    </td>
                                    <td hidden>
                                        {{ \Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/y') }} <br>
                                        {{ \Carbon\Carbon::parse($pedido_compra->hora_emissao)->format('h:i') }}
                                    </td>
                                    <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                        {{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/y') }}
                                        {{ \Carbon\Carbon::parse($pedido_compra->hora_prevista)->format('h:i') }}

                                    </td>
                                    <td >{{ $pedido_compra->equipamento->nome }}</td>
                                    <td hidden>{{ $pedido_compra->descricao}}</td>
                                    <td style="color: darkgray;">

                                        {{ $pedido_compra->status }}

                                    </td>
                                    <td style="color: darkgray;">{{ $pedido_compra->updated_at->format('d/m/y H:i') }}</td>
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
                font-weight: 300 !important;
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                font-stretch: ultra-condensed;
                color: black;
                border-radius: 5px;
                padding: 1px;
                margin: 1px;
                background-color: rgb(248, 248, 255, 0.7);

            }

            td {
                font-weight: 300 !important;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 15px !important;
                margin: 2px;
            }
        </style>
        <!-- continer products-->
        <div class="item">
            <span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">ESTOQUE ALMOXARIFADO</span>
            <button class="btn btn-outline-primary btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('produto.index') }}'">
                Produtos
            </button>
            <button class="btn btn-outline-Success btn-sm"
                style="font-family:Arial, Helvetica, sans-serif; font-weight:300;height:26px;"
                onclick="window.location.href='{{ route('Estoque-produto.index') }}'">
                Estoque de produtos
            </button>
            <hr style="margin-bottom:2px;margin-top:2px;">
            <div class="container" style="background-color: burlywood;">
                <table class="condensed-table" id="tb_pedidos_compra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Estoque Atual</th>
                            <th>Estoque Mínimo</th>
                            <th>Estoque Máximo</th>
                            <th>Pedido Compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos_estoque_critico as $produto_estoque_critico)
                        <tr>
                            <td>
                                <a style="font-size: 17px;" class="txt-link" href="{{ route('produto.show', ['produto' => $produto_estoque_critico->produto_id]) }}">

                                    {{$produto_estoque_critico->produto_id}}
                                </a>
                            </td>
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
                            </td>&nbsp
                            <td class="@if($produto_estoque_critico->quantidade <= 0) bg-danger @elseif($produto_estoque_critico->quantidade < $produto_estoque_critico->estoque_minimo) bg-warning @elseif($produto_estoque_critico->quantidade == $produto_estoque_critico->estoque_minimo) bg-light-warning @endif">
                                {{ $produto_estoque_critico->estoque_minimo }}
                            </td>
                            <td> {{$produto_estoque_critico->estoque_maximo}}</td>

                            <td style="height:10px;">
                                @if($produto_estoque_critico->nova_coluna > 0)
                                <form action="{{ route('pedido-compra.index') }}" style="height:15px;">
                                    <div class="form-row">
                                        <input type="text" name="produto_id" value="{{ $produto_estoque_critico->produto_id }}" hidden>
                                        <input type="text" name="situacao" id="situacao" value="Aberto" hidden>
                                        <input type="date" name="data_inicio" value="2000-01-01" hidden>
                                        <input type="date" name="data_fim" value="2030-01-01" hidden>
                                        <input class="btn btn-primary btn-sm" type="submit" value="{{ $produto_estoque_critico->nova_coluna }} Pedido" style="width: 100px; margin-top: 0px;font-size:12px;">
                                </form>
                                @else
                                <button class="btn btn-warning btn-sm" style="width: 100px; margin-top: 5px;font-size:12px;">
                                    Nenhum pedido
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{--fim do item 6--}}
    </div>
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
            font-size: 14px;
            border-bottom: 1px solid rgb(255, 255, 200, 0.3);
            /* Adiciona uma borda inferior de 1px sólida cinza */
            height: 28px;
            border-left: 1px;
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