@extends('app.layouts.app')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<meta http-equiv="refresh" content="60">
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">

    {{--sinalizador pulsante verde--}}
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

        .container-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            background-color: #f2f2f2;
        }

        .item {
            width: calc(33% - 5px);
            /* Ocupa toda a altura disponível */
            height: 870px;
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
            height: 100%;
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
    <div class="container-box">
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
                                    <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordens_servicos_fech->id])}}" hidden>
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
                                    <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordens_servicos_venc->id])}}" hidden>
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
            <h6 class="title-md">O.S. EM EXECUÇÃO </h6>
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
                                    <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$os_emandamento->id])}}" hidden>
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

                            document.getElementById('dataCompleta').innerText = `O.S. Para Hoje, ${diaSemana}, ${diaMes} de ${mes} de ${ano}`;
                            document.getElementById('dataCompleta_semana').innerText = `${diaSemana}, ${diaMes} de ${mes} de ${ano}`;
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
                                        <a class="" href="{{route('ordem-servico.show', ['ordem_servico'=>$os_hoje->id])}}" hidden>
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
                font-size: 15px;
                font-family: 'Poppins', sans-serif;
                display: flex;
                flex-direction: row;
                font-weight: 300;

            }
        </style>
        <div class="item">
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
                        font-size: 14px !important;
                        font-weight: 300 !important;
                        font-family: 'Arial', sans-serif !important;
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
                {{--//-----------------------------------------------------//--}}
                {{--//---- O.S. Para amanha --------------------------//--}}
                {{--//-----------------------------------------------------//--}}
                @foreach($ordens_servicos_next_day as $ordens_servicos_next_day_title)
                @endforeach
                @if(isset($ordens_servicos_next_day_title))
                <!-- Algum conteúdo -->
                <h6 class="title-md">
                    O.S. PARA AMANHÃ ({{ \Carbon\Carbon::parse($ordens_servicos_next_day_title->data_inicio)->locale('pt_BR')->isoFormat('dddd') }}):
                </h6>
                @else
                <!-- Outro conteúdo -->
                <h6 class="title-md">
                    NÃO HÀ O.S. PARA AMANHÃ.
                </h6>
                @endif
                <hr style="margin:-2px;">
                @forelse($ordens_servicos_next_day as $next_day)
                <div class="div-font-sm-conteudo" style="margin: 5px;">
                    <span style="font-weight: 900; font-size:14px;"> {{$next_day->id}}</span>
                    <span style="font-size:14px;"> {{ \Carbon\Carbon::parse($ordens_servicos_next_day_title->data_inicio)->format('d/m/Y') }}</span>
                    <span style="color: green;font-size:14px;">às</span>
                    <span style="font-size:14px;">{{$next_day->hora_inicio}} </span>
                    <span style="color: green;font-size:14px;">até</span>
                    <span style="font-size:14px;">{{ \Carbon\Carbon::parse($ordens_servicos_next_day_title->data_fim)->format('d/m/Y') }}</span>
                    <span style="color: green;font-size:14px;">às</span>
                    <span style="font-size:14px;">{{$next_day->hora_fim}}</span>
                    <span style="margin-left:30px;font-size:16px;">{{$next_day->equipamento->nome}}</span>
                </div>
                <div class="div-font-sm-conteudo" style="color: brown;margin-top:-10px;">Descrição</div>
                <div class="div-font-sm-conteudo" style="margin-top:-10px;">{{$next_day->descricao}}</div>
                <hr>
                @empty
                @endforelse
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
                    <span style="font-weight: 900; font-size:14px;"> {{$seg_day->id}}</span>
                    {{$seg_day->data_inicio}} às {{$seg_day->hora_inicio}} até
                    {{$seg_day->data_fim}} às {{$seg_day->hora_fim}}
                    {{$seg_day->equipamento->nome}}
                </div>
                <div class="div-font-sm-conteudo" style="color: brown;margin-top:-10px;">Descrição</div>
                <div class="div-font-sm-conteudo" style="margin-top:-10px;">{{$seg_day->descricao}}</div>
                <hr>
                @empty
                @endforelse
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
                    <span style="font-weight: 900; font-size:14px;"> {{$terc_day->id}}</span>
                    {{$terc_day->data_inicio}} às {{$terc_day->hora_inicio}} até
                    {{$terc_day->data_fim}} às {{$terc_day->hora_fim}}
                    {{$terc_day->equipamento->nome}}
                </div>
                <div class="div-font-sm-conteudo" style="color: brown;margin-top:-10px;">Descrição</div>
                <div class="div-font-sm-conteudo" style="margin-top:-10px;">{{$terc_day->descricao}}</div>
                <hr>
                @empty
                <hr>
                @endforelse
            </div>
            <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">ORDENS FUTURAS</h6>
            @if(isset($ordens_servicos_next))
            @foreach($ordens_servicos_next as $ordem_servico_next)
            <a href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}">
                <span class="material-symbols-outlined">
                    open_in_new
                </span>
            </a> <span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">{{$ordem_servico_next->id}}</span>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;">({{ \Carbon\Carbon::parse($ordem_servico_next->data_inicio)->locale('pt_BR')->Format('d/m/yy') }})</span>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;">
                {{$ordem_servico_next->equipamento->nome}}</span>
            <br>

            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;">{{$ordem_servico_next->descricao}}</span> <br>
            <hr style="margin:5px;">
            @endforeach
            @endif
        </div>

        {{--fim do item 3--}}
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
    <style>
        .container-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            background-color: white;

        }

        .item-25 {
            width: calc(25% - 20px);
            height: auto;
            margin: 10px;
            padding: 15px;
            background-color: white;
            overflow: auto;
            /* Impede que o conteúdo transborde */
            font-weight: 100;
            font-family: Arial, sans-serif;
            font-stretch: expanded;
        }

        .item-week {
            width: calc(33% - 20px);
            height: 300px;
            margin: 5px;
            padding: 5px;
            background-color: ghostwhite;
            border: solid 1px rgb(255, 0, 0, 0.2);
            border-radius: 5px;
            overflow: auto;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-weight: 200;
            font-size: 15px;
            /* Impede que o conteúdo transborde */
        }

        .span-title-sm {
            font-size: 15px;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }

        .today {
            color: green;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
    <?php
    $today = \Carbon\Carbon::now()->format('l'); // Obtém o nome do dia da semana atual
    ?>
    <!--  Ao clicar na div week-->
    <style>
        .item-week {
            transition: all 0.3s ease-in-out;
        }

        .item-week.expanded {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 999;
            overflow: auto;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .item-week h4:hover {
            background-color: greenyellow;
            opacity: 0.5;
            /* Define a opacidade corretamente */
            cursor: pointer;
            transition: background-color 0.3s ease, opacity 0.3s ease;
            /* Suaviza tanto a cor de fundo quanto a opacidade */
        }

        .item-week h4 {
            cursor: pointer;

        }
    </style>
    <script>
        function toggleExpand(boxId) {
            const box = document.getElementById(boxId);

            // Alterna entre as classes para expandir/recolher
            box.classList.toggle('expanded');
        }
    </script>

    <!------------------------------------------------------------->
    <div class="container-month">
        {{--Box 2--}}
        <div class="item-week" id="box-2">
            <h4 class="{{ $today == 'Monday' ? 'today' : '' }}" style="font-weight:300;" onclick="toggleExpand('box-2')" title="Expandir/Recolher">Segunda-feira</h4>
            <div class="orders">
                @forelse ($mondayOrders as $order)
                <div style="display:flex;">
                    <div style="width:65%;">
                        ID: <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                        <span style="font-family:Arial, Helvetica, sans-serif;">, Data de Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/Y') }}</span>
                        <span style="font-family:Arial, Helvetica, sans-serif;">, Responsável: {{ $order->responsavel}}</span>
                    </div>
                    <div style="width:35%; text-align: right;">
                        <h6>{{ $order->equipamento->nome }} </h6>
                    </div>
                </div>
                <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;"> {{ $order->descricao}}</span>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta nesta segunda-feira.
                @endforelse
            </div>
        </div>

        {{--Box 3 terça feira--}}
        <div id="box-3" class="item-week">
            <h4 class="{{ $today == 'Tuesday' ? 'today' : '' }}" style="font-weight:300;" onclick="toggleExpand('box-3')" title="Expandir/Recolher">Terça-feira</h4>
            @forelse ($tuesdayOrders as $order)
            <div style="display:flex;">
                <div style="width:65%;"> ID: <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Data de Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/Y') }}</span>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Responsável: {{ $order->responsavel}}</span>
                </div>
                <div style="width:35%; text-align: right;">
                    <h6>{{ $order->equipamento->nome }} </h6>
                </div>
            </div>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;"> {{ $order->descricao}}</span>
            <hr style="color:green;margin:1px;">
            @empty
            Nenhuma ordem de serviço aberta nesta terça-feira.
            @endforelse
        </div>
        {{--Box 4 Quarta-feira--}}
        <div id="box-4" class="item-week">
            <h4 class="{{ $today == 'Wednesday' ? 'today' : '' }}" style="font-weight:300;" onclick="toggleExpand('box-4')" title="Expandir/Recolher">Quarta-feira</h4>
            @forelse ($wednesdayOrders as $order)
            <div style="display:flex;">
                <div style="width:65%;"> ID: <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Data de Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/Y') }}</span>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Responsável: {{ $order->responsavel}}</span>
                </div>
                <div style="width:35%; text-align: right;">
                    <h6>{{ $order->equipamento->nome }} </h6>
                </div>
            </div>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;"> {{ $order->descricao}}</span>
            <hr style="color:green;margin:1px;">
            @empty
            Nenhuma ordem de serviço aberta nesta quarta-feira.
            @endforelse
        </div>
        {{--Box 5 Quinta-feira--}}
        <div id="box-5" class="item-week">
            <h4 class="{{ $today == 'Thursday' ? 'today' : '' }}" style="font-weight:300;" onclick="toggleExpand('box-5')" title="Expandir/Recolher">Quinta-feira</h4>
            @forelse ($thursdayOrders as $order)
            <div style="display:flex;">
                <div style="width:65%;"> ID: <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Data de Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/Y') }}</span>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Responsável: {{ $order->responsavel}}</span>
                </div>
                <div style="width:35%; text-align: right;">
                    <h6>{{ $order->equipamento->nome }} </h6>
                </div>
            </div>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;"> {{ $order->descricao}}</span>
            <hr style="color:green;margin:1px;">
            @empty
            Nenhuma ordem de serviço aberta nesta quinta-feira.
            @endforelse
        </div>
        {{--Box 6 Sexta-feira--}}
        <div id="box-6" class="item-week">
            <h4 class="{{ $today == 'Friday' ? 'today' : '' }}" style="font-weight:300;" onclick="toggleExpand('box-6')" title="Expandir/Recolher">Sexta-feira</h4>

            @forelse ($fridayOrders as $order)
            <div style="display:flex;">
                <div style="width:65%;"> ID: <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Data de Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/Y') }}</span>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Responsável: {{ $order->responsavel}}</span>
                </div>
                <div style="width:35%; text-align: right;">
                    <h6>{{ $order->equipamento->nome }} </h6>
                </div>
            </div>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;"> {{ $order->descricao}}</span>
            <hr style="color:green;margin:1px;">
            @empty
            Nenhuma ordem de serviço aberta nesta sexta-feira.
            @endforelse
        </div>
        {{--Box 7 Sábado--}}
        <div id="box-7" class="item-week">
            <h4 class="{{ $today == 'Saturday' ? 'today' : '' }}" style="font-weight:300;" onclick="toggleExpand('box-7')" title="Expandir/Recolher">Sábado</h4>
            @forelse ($saturdayOrders as $order)
            <div style="display:flex;">
                <div style="width:65%;"> ID: <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Data de Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/Y') }}</span>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Responsável: {{ $order->responsavel}}</span>
                </div>
                <div style="width:35%; text-align: right;">
                    <h6>{{ $order->equipamento->nome }} </h6>
                </div>
            </div>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;"> {{ $order->descricao}}</span>
            <hr style="color:green;margin:1px;">
            @empty
            Nenhuma ordem de serviço aberta neste sábado.
            @endforelse
        </div>
        {{--Box 1 Domingo--}}
        <div id="box-1" class="item-week">
            <h4 class="{{ $today == 'Sunday' ? 'today' : '' }}" style="font-weight:300;" onclick="toggleExpand('box-1')" title="Expandir/Recolher">Domingo</h4>
            @forelse ($sundayOrders as $order)
            <div style="display:flex;">
                <div style="width:65%;"> ID: <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem_servico_next->id])}}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Data de Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/Y') }}</span>
                    <span style="font-family:Arial, Helvetica, sans-serif;">, Responsável: {{ $order->responsavel}}</span>
                </div>
                <div style="width:35%; text-align: right;">
                    <h6>{{ $order->equipamento->nome }} </h6>
                </div>
            </div>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;"> {{ $order->descricao}}</span>
            <hr style="color:green;margin:1px;">
            @empty
            Nenhuma ordem de serviço aberta neste domingo.
            <hr>
            @endforelse
        </div>
        {{--fim card--}}
    </div>
    {{--//----------------------------------------------------//---}}
    {{--//- Calendário mensal---------------------------------//---}}
    {{--//----------------------------------------------------//---}}
    <style>
        .container-month {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            /* Alinha os itens à esquerda */
            align-items: flex-start;
            background-color: white;
        }

        .item-month {
            width: calc(14.28% - 20px);
            height: 300px;
            margin: 5px;
            padding: 5px;
            background-color: aliceblue;
            overflow: auto;
            /* Impede que o conteúdo transborde */
        }
    </style>

    <div class="container-month" hidden>
        {{-- Box 1 --}}
        <div class="item-month">
            <h4>1</h4>
        </div>
        <div class="item-month">
            <h4>2</h4>
        </div>
        <div class="item-month">
            <h4>3</h4>
        </div>
        <div class="item-month">
            <h4>4</h4>
        </div>
        <div class="item-month">
            <h4>5</h4>
        </div>
        <div class="item-month">
            <h4>6</h4>
        </div>
        <div class="item-month">
            <h4>7</h4>
        </div>
        <div class="item-month">
            <h4>8</h4>
        </div>
        <div class="item-month">
            <h4>9</h4>
        </div>
        <div class="item-month">
            <h4>10</h4>
        </div>
        <div class="item-month">
            <h4>11</h4>
        </div>
        <div class="item-month">
            <h4>12</h4>
        </div>
        <div class="item-month">
            <h4>13</h4>
        </div>
        <div class="item-month">
            <h4>14</h4>
        </div>
        <div class="item-month">
            <h4>15</h4>
        </div>
        <div class="item-month">
            <h4>16</h4>
        </div>
        <div class="item-month">
            <h4>17</h4>
        </div>
        <div class="item-month">
            <h4>18</h4>
        </div>
        <div class="item-month">
            <h4>19</h4>
        </div>
        <div class="item-month">
            <h4>20</h4>
        </div>
        <div class="item-month">
            <h4>21</h4>
        </div>
        <div class="item-month">
            <h4>22</h4>
        </div>
        <div class="item-month">
            <h4>23</h4>
        </div>
        <div class="item-month">
            <h4>24</h4>
        </div>
        <div class="item-month">
            <h4>25</h4>
        </div>
        <div class="item-month">
            <h4>26</h4>
        </div>
        <div class="item-month">
            <h4>27</h4>
        </div>
        <div class="item-month">
            <h4>28</h4>
        </div>
        <div class="item-month">
            <h4>29</h4>
        </div>
        <div class="item-month">
            <h4>30</h4>
        </div>
        <div class="item-month">
            <h4>31</h4>
        </div>
    </div>
    @endsection
</main>