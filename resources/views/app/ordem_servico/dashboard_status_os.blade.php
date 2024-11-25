@extends('app.layouts.footer')

</html>
<meta charset="utf-8">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<meta http-equiv="refresh" content="60">
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('css/comum.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/template.css') }}">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<script src="{{ asset('js/date_time.js') }}"></script>{{--arquivo de atualização de datas e hora--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<div style="display: flex; justify-content: center; text-align: center;">
    <h4>Painel de Visualização de O.S.</h4>
</div>
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
                    <tr style="border: solid 2px red;">
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
            background-color: gray;
            /* Cor cinza */
            /* Cor dark */
            color: inherit;
            /* Preserva a cor do texto, caso seja definida */
            mix-blend-mode: normal;
            /* Altera a cor do texto para ser visível em fundos escuros */
        }

        .item {
            width: calc(33% - 5px);
            /* Ocupa toda a altura disponível */
            height: 870px;
            margin: 5px;
            padding: 10px;
            background-color: aliceblue;
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

        .scrollable {
            border: 1px solid #ccc;
            /* Borda do formulário */
            padding: 10px;
            /* Espaçamento interno */
            border-radius: 5px;
            /* Bordas arredondadas */
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
              <!--Os em excução-->
              <h6 class="title-md">O.S. EM EXECUÇÃO </h6>
            <div class="div-os-sm">
                <table class="condensed-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Previsão de fim</th>
                            <th>Descrição</th>
                            <th>Patrimônio</th>
                            <th>Executante</th>

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
                            <td>{{$os_emandamento->id}}</td>
                            <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                {{ \Carbon\Carbon::parse($os_emandamento->data_fim)->format('d/m/y') }} <br>
                                {{ \Carbon\Carbon::parse($os_emandamento->hora_fim)->format('m:i') }}

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
            <form action="" class="scrollable">
                <h6 class="title-md">O.S. FECHADAS HOJE</h6>
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
                                <td>{{$ordens_servicos_fech->id}}</td>
                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($ordens_servicos_fech->data_fim)->format('d/m/y') }} <br>

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
            <form action="" class="scrollable" style="max-height:auto; overflow-y: auto;">
                <h6 class="title-md">O.S VENCIDAS E PENDENTES</h6>
                <div class="div-os-sm">
                    <table class="condensed-table" style="background-color:rgb(251,170,153); width: 100%; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width:50px;">ID</th>
                                <th style="width:90px;">Data e Hora</th>
                                <th>Descrição</th>
                                <th>Patrimônio</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordens_servicos_abarta_vencidas as $ordens_servicos_venc)
                            @php
                            $dataPrevista = \Carbon\Carbon::parse($ordens_servicos_venc->data_fim);
                            $dataAtual = \Carbon\Carbon::today();
                            @endphp
                            <tr>
                                <td style="color: blue;">{{$ordens_servicos_venc->id}}</td>
                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    {{ \Carbon\Carbon::parse($ordens_servicos_venc->data_fim)->format('d/m/y') }} <br>
                                    {{ \Carbon\Carbon::parse($ordens_servicos_venc->hora_fim)->format('H:i') }}
                                </td>
                                <td style="word-wrap: break-word; white-space: normal; border-right: 10px;">
                                    {{$ordens_servicos_venc->descricao}}
                                </td>
                                <td>{{$ordens_servicos_venc->equipamento->nome}}<img src="{{ asset('img/warning.png') }}" alt="" id="imgwarning" style="float: right;"> </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>

            <style>
                #imgwarning {
                    height: 15px;
                    /* Corrigido para incluir 'px' */
                    width: 15px;
                    /* Corrigido para incluir 'px' */
                    background-color: darkgrey;
                }
            </style>

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
            <style>
                #menu-ativos {
                    font-size: 50px;
                }
            </style>
            <div class="" style="max-width:100%;background-color:rgb(255,255,224)">

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

                                    <td>{{$os_hoje->id}}</td>
                                    <td class="{{ $horaInicio->lt($horaAtual) ? 'text-danger' : ($horaInicio->eq($horaAtual) ? 'text-warning' : 'text-primary') }}">
                                        {{ \Carbon\Carbon::parse($os_hoje->data_inicio)->format('d/m/y') }}
                                        {{ \Carbon\Carbon::parse($os_hoje->hora_inicio)->format('m:i') }}
                                    </td>
                                    <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                        {{ \Carbon\Carbon::parse($os_hoje->data_fim)->format('d/m/y') }} <br>

                                        {{ \Carbon\Carbon::parse($os_hoje->hora_fim)->format('m:i') }}
                                    </td>
                                    <td>{{$os_hoje->descricao}}</td>
                                    <td style="font-family: Arial, Helvetica, sans-serif; font-weight: bold;font-stretch:extra-condensed;">
                                        {{$os_hoje->equipamento->nome}}
                                    </td>
                                    <td>
                                        {{-- Valor GUT --}}
                                        @php
                                        $valorGUT = $os_hoje->valor_gut;

                                        // Determina a cor da barra de progresso
                                        if ($valorGUT <= 50) { $progressColor='blue' ; } elseif ($valorGUT> 50 && $valorGUT <= 80) { $progressColor='yellow' ; } else { $progressColor='orange' ; } @endphp <input type="text" value="{{ $valorGUT }}" id="progress-input-today" hidden>
                                                <div class="progress" style="width:35px;">
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
                    .div-font-sm-conteudo {
                        font-size: 20px !important;
                        font-weight: 300 !important;
                        font-family: 'Arial', sans-serif !important;
                        margin: 10px;
                        text-align: left !important;
                        height: auto;
                    }

                    .title-md {
                        font-family: 'Arial', sans-serif !important;
                        font-size: 25px !important;
                        font-weight: 300 !important;
                    }
                </style>
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
                {{--------------------------------------}}
                {{--Verifica se a variavel contém dados--}}
                {{--------------------------------------}}
                @if(isset($ordem_servico))
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
                @endif
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
            </a> <span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;">{{$ordem_servico_next->id}}</span>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size:15px;">({{ \Carbon\Carbon::parse($ordem_servico_next->data_inicio)->format('d/m/Y') }})</span>
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
            font-size: 20px;
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

</main>