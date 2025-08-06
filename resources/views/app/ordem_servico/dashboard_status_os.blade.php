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
    <!-- Notificação de Check list -->
    <div class="dropdown" id="checklist-count" style="margin-top:20px;margin-right:50px">
    </div>
    <div style="width: 100px;margin-left:300px;">
        <a href="" id="checklist-link" class="dropdown" style="color: black;margin-top:20px;">
            Check-lists <p></p>
            &nbsp <span style="margin-top:35px;" class="badge" id="checklist-badge">0</span>
        </a>

    </div>
    <div>
        <!-- Botão que abre a modal -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalExemplo" style="height:35px;">
            Criar O.S
        </button>

    </div>

    <!-- CSS -->
    <style>
        .badge {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: white;
            text-align: center;
            line-height: 24px;
            font-size: 14px;
            font-weight: bold;
            position: absolute;
            top: -10px;
            right: -10px;
            z-index: 1000;
        }

        .badge.zero {
            background-color: green;
        }

        .badge.non-zero {
            background-color: red;
        }

        .badge.warning {
            background-color: orange;
            /* Nova classe para laranja */
        }

        #solicitacoes-count,
        #checklist-count {
            position: relative;
            display: inline-block;
            margin-right: 100px;
            cursor: pointer;
        }

        /*  Estilização de cor de fundos de formulários */
        .backgrund-primary {
            background-color: rgb(245, 246, 248);

        }

        td {
            font-weight: 300 !important;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px !important;
            margin: 2px;
        }
    </style>

    <!-- JavaScript para atualização das contagens -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Função para atualizar a contagem de solicitações pendentes
            function atualizarContagemSolicitacoes() {
                fetch('/solicitacoes-pendentes')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('solicitacoes-badge');
                        badge.innerText = data.pendentes;

                        if (data.pendentes > 0) {
                            badge.classList.remove('zero');
                            badge.classList.add('non-zero');
                        } else {
                            badge.classList.remove('non-zero');
                            badge.classList.add('zero');
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            }

            // Função para atualizar a contagem de checklists pendentes
            function atualizarContagemChecklists() {
                fetch('/check-list-pendentes')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('checklist-badge');
                        badge.innerText = data.pendentes;

                        if (data.pendentes > 0) {
                            badge.classList.remove('zero');
                            badge.classList.remove('non-zero');
                            badge.classList.add('warning'); // Adiciona a classe warning
                        } else {
                            badge.classList.remove('non-zero');
                            badge.classList.remove('warning'); // Remove a classe warning
                            badge.classList.add('zero');
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            }

            // Atualiza as contagens a cada 30 segundos
            setInterval(atualizarContagemSolicitacoes, 30000);
            setInterval(atualizarContagemChecklists, 30000);

            // Atualiza as contagens imediatamente quando a página é carregada
            atualizarContagemSolicitacoes();
            atualizarContagemChecklists();
        });
    </script>
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
                        <tr style="border-bottom: 2px solid #F7E8C4;">

                            <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}"
                                style="font-size: 15px;width:40px;">
                                <span style="color: black;">ID: </span> <span style="font-weight: 800;color:blue;font-size:18px;">{{$os_emandamento->id}}</span>
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

                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    <span style="color: blue;">ID: {{$ordens_servicos_fech->id}} </span> <br>

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
                                <th style="width:90px;">Data e Hora</th>
                                <th style="word-break: break-word; white-space: normal; width: 300px; max-width: 500px;">Descrição</th>
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

                                <td class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}">
                                    <span style="color: blue;">{{$ordens_servicos_venc->id}}</span>
                                    {{ \Carbon\Carbon::parse($ordens_servicos_venc->data_fim)->format('d/m/y') }} <br>
                                    {{ \Carbon\Carbon::parse($ordens_servicos_venc->hora_fim)->format('H:i') }}
                                </td>
                                <td style="word-break: break-word; white-space: normal; width: 300px; max-width: 500px;">
                                    {{ $ordens_servicos_venc->descricao }}
                                </td>

                                <td style="text-align: right;">
                                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                        <span style="font-weight: bold;">{{ $ordens_servicos_venc->equipamento->nome }}</span><br>
                                        <span style="display: inline-flex; align-items: center; gap: 4px;">
                                            {{ Str::upper($ordens_servicos_venc->especialidade_do_servico) }}
                                            <!--  <img src="{{ asset('img/warning.png') }}" alt="" style="height: 20px;">-->
                                        </span>
                                    </div>
                                </td>

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
                        <table class="condensed-table" style="border-bottom:black;">
                            <thead>
                                <tr>
                                    <th>Dados</th>
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

                                <tr class="{{ $linhaClasse }}" style="border-bottom: 2px solid #F7E8C4;">

                                    <td>
                                        <div class="{{ $horaInicio->lt($horaAtual) ? 'text-danger' : ($horaInicio->eq($horaAtual) ? 'text-warning' : 'text-primary') }}"
                                            style="font-size:15px;font-family:Arial, Helvetica, sans-serif;">

                                            <span style="color: black;">ID: </span> <span style="font-weight: 800;color:blue;font-size:18px;"> {{$os_hoje->id}}</span>
                                            <div style="background-color:white;border-radius:4px;margin:2px;">
                                                {{ \Carbon\Carbon::parse($os_hoje->data_inicio)->format('d/m/y') }}
                                                <hr style="margin:1px;">
                                                {{ \Carbon\Carbon::parse($os_hoje->hora_inicio)->format('m:i') }}
                                            </div>
                                        </div>
                                        <div class="{{ $dataPrevista->lt($dataAtual) ? 'text-danger' : ($dataPrevista->eq($dataAtual) ? 'text-warning' : 'text-primary') }}"
                                            style="font-size:15px;font-family:Arial, Helvetica, sans-serif">
                                            <div style="background-color:white;border-radius:4px;margin:2px;">
                                                {{ \Carbon\Carbon::parse($os_hoje->data_fim)->format('d/m/y') }}
                                                <hr style="margin:1px;">
                                                {{ \Carbon\Carbon::parse($os_hoje->hora_fim)->format('m:i') }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{$os_hoje->descricao}}</td>
                                    <td style="font-family: Arial, Helvetica, sans-serif; font-weight: bold;font-stretch:extra-condensed;">
                                        {{$os_hoje->equipamento->nome}}
                                        <hr style="margin:4px;">
                                        {{ Str::upper($os_hoje->especialidade_do_servico) }}
                                    </td>

                                    <td>
                                        {{-- Valor GUT --}}
                                        @php
                                        $valorGUT = $os_hoje->valor_gut;

                                        // Determina a cor da barra de progresso
                                        if ($valorGUT <= 50) { $progressColor='blue' ; } elseif ($valorGUT> 50 && $valorGUT <= 80) { $progressColor='yellow' ; } else { $progressColor='orange' ; } @endphp <input type="text" value="{{ $valorGUT }}" id="progress-input-today" hidden>
                                                <div class="progress" style="width:35px;">
                                                    <div id="progress-bar-today" class="progress-bar" role="progressbar" aria-valuenow="{{ $valorGUT }}" aria-valuemin="0" aria-valuemax="125" style="width: {{ $valorGUT }}%; background-color: {{ $progressColor }}; color: black;">

                                                    </div>
                                                </div>
                                                <br>


                                                <button type="button" class="gerarPdfButton btn btn-outline-secondary mb-1" title="Imprimir O.S">
                                                    <i class="icofont-print"></i>
                                                </button>

                                                <form class="frm-pdf" action="{{ route('gerar.pdf') }}" method="POST" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="ordem_servico_id" value="{{ $os_hoje->id }}">
                                                </form>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <script>
                                document.querySelectorAll('.gerarPdfButton').forEach(function(button) {
                                    button.addEventListener('click', function() {
                                        const form = button.closest('td').querySelector('.frm-pdf');
                                        const id = form.querySelector('[name="ordem_servico_id"]').value;
                                        form.submit(); // Descomente para gerar o PDF
                                    });
                                });
                            </script>
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



    <!-- Bootstrap CSS (no <head>) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="modalExemplo" tabindex="-1" aria-labelledby="modalExemploLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg para mais espaço -->
            <div class="modal-content">

                <!-- Cabeçalho -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExemploLabel">Criar O.S.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <!-- Corpo do formulário -->
                <div class="modal-body">

                    <!-- Data e Hora de Emissão (oculto) -->
                    <div class="row mb-3" hidden>
                        <div class="col">
                            <input type="date" id="data_emissao" name="data_emissao" class="form-control" readonly>
                        </div>
                        <div class="col">
                            <input type="time" id="hora_emissao" name="hora_emissao" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Data e Hora de Início -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="data_inicio" class="form-label">Data de Início</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control">
                        </div>
                        <div class="col">
                            <label for="hora_inicio" class="form-label">Hora de Início</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control">
                        </div>
                    </div>

                    <!-- Data e Hora de Fim -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="data_fim" class="form-label">Data de Fim</label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control">
                        </div>
                        <div class="col">
                            <label for="hora_fim" class="form-label">Hora de Fim</label>
                            <input type="time" id="hora_fim" name="hora_fim" class="form-control">
                        </div>
                    </div>

                    <!-- Equipamento -->
                    <div class="mb-3">
                        <label for="equipamento_id" class="form-label">Equipamento</label>
                        <select name="equipamento_id" id="equipamento_id" class="form-select">
                            <option value="">-- Selecione --</option>
                            @foreach($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}">{{ $equipamento->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Responsável -->
                    <div class="mb-3">
                        <label for="funcionario_id" class="form-label">Responsável</label>
                        <select name="funcionario_id" id="funcionario_id" class="form-select">
                            <option value="">-- Selecione --</option>
                            @foreach($funcionarios as $funcionario)
                            <option value="{{ $funcionario->primeiro_nome}}">{{ $funcionario->primeiro_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-3">
                        <label for="campoTexto" class="form-label">Descrição</label>
                        <textarea id="campoTexto" name="descricao" class="form-control" placeholder="Digite aqui..." rows="3"></textarea>
                    </div>

                    <!-- Especialidade -->
                    <div class="mb-3">
                        <label for="especialidade_do_servico" class="form-label">Especialidade do Serviço</label>
                        <select class="form-select" id="especialidade_do_servico" name="especialidade_do_servico">
                            <option value="">-- Selecione --</option>
                            <option value="Mecânico">Mecânico</option>
                            <option value="Elétrico">Elétrico</option>
                        </select>
                    </div>

                    <!-- Natureza -->
                    <div class="mb-3">
                        <label for="natureza_do_servico" class="form-label">Natureza do Serviço</label>
                        <select class="form-select" id="natureza_do_servico" name="natureza_do_servico">
                            <option value="">-- Selecione --</option>
                            <option value="Preventiva">Preventiva</option>
                            <option value="Corretiva">Corretiva</option>
                            <option value="Preditiva">Preditiva</option>
                        </select>
                    </div>

                    <!-- Inputs ocultos -->
                    <input type="hidden" id="status_servicos" name="status_servicos" value="80">
                    <input type="hidden" id="link_foto" name="link_foto">
                    <input type="hidden" id="gravidade" name="gravidade" value="3">
                    <input type="hidden" id="urgencia" name="urgencia" value="3">
                    <input type="hidden" id="tendencia" name="tendencia" value="3">
                    <input type="hidden" id="empresa_id" name="empresa_id" value="2">
                    <input type="hidden" id="situacao" name="situacao" value="Aberto">
                    <input type="hidden" id="ss_id" name="ss_id" value="">
                </div>

                <!-- Rodapé -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="salvar()">Salvar</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS (de preferência no final do body) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function salvar() {
            const valor = document.getElementById('campoTexto').value;
            alert('Valor digitado: ' + valor);

            // Fechar a modal via JS (opcional)
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalExemplo'));
            modal.hide();
        }
    </script>
    <script>
        function salvar() {
            const formData = new FormData();

            // Campos do formulário
            formData.append('data_emissao', document.getElementById('data_emissao').value);
            formData.append('hora_emissao', document.getElementById('hora_emissao').value);
            formData.append('data_inicio', document.getElementById('data_inicio').value);
            formData.append('hora_inicio', document.getElementById('hora_inicio').value);
            formData.append('data_fim', document.getElementById('data_fim').value);
            formData.append('hora_fim', document.getElementById('hora_fim').value);
            formData.append('equipamento_id', document.getElementById('equipamento_id').value);
            formData.append('funcionario_id', document.getElementById('funcionario_id').value);
            formData.append('descricao', document.getElementById('campoTexto').value);
            formData.append('especialidade_do_servico', document.getElementById('especialidade_do_servico').value);
            formData.append('natureza_do_servico', document.getElementById('natureza_do_servico').value);

            // Hidden fields
            formData.append('status_servicos', document.getElementById('status_servicos').value);
            formData.append('link_foto', document.getElementById('link_foto').value); // ou use .files[0] se for file
            formData.append('gravidade', document.getElementById('gravidade').value);
            formData.append('urgencia', document.getElementById('urgencia').value);
            formData.append('tendencia', document.getElementById('tendencia').value);
            formData.append('empresa_id', document.getElementById('empresa_id').value);
            formData.append('situacao', document.getElementById('situacao').value);
            formData.append('ss_id', document.getElementById('ss_id').value);

            // Envio AJAX com fetch
            fetch("{{ route('ordem_servico.modal') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao salvar O.S.');
                    return response.json();
                })
                .then(data => {
                    alert("O.S. criada com sucesso!");
                    location.reload(); // ou feche a modal, etc.
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert("Erro ao criar O.S.");
                });
        }
    </script>

</main>