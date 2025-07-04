@extends('app.layouts.app')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    @foreach($ordem_servico_gantt as $ordem_servico_gantt_gnt)
    <span hidden>{{$ordem_servico_gantt_gnt->equipamento->nome}} <br></span>

    @endforeach
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

        .hover-alt:hover {
            background-color: greenyellow;
            opacity: 0.5;
            /* Define a opacidade corretamente */
            cursor: pointer;
            transition: background-color 0.3s ease, opacity 0.3s ease;
            /* Suaviza tanto a cor de fundo quanto a opacidade */
        }

        .item-week span {
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
    <style>
        .highlight-today {
            background-color: rgb(246, 248, 213);
            /* amarelo claro, por exemplo */
            border: 1px solidrgb(65, 63, 58);
            /* borda amarela para destacar */
            border-radius: 6px;
            padding: 10px;
            transition: background-color 0.3s ease;
        }
    </style>
    <!------------------------------------------------------------->
    <!--O.S Semanal -->
    <!------------------------------------------------------------->
    @php
    \Carbon\Carbon::setLocale('pt_BR');
    @endphp
    <div class="container-month">
        {{--Box 2--}}
        @php
        \Carbon\Carbon::setLocale('pt_BR');
        @endphp
        <div class="item-week {{ $today == 'Monday' ? 'highlight-today' : '' }}" id="box-2">
            <span class="{{ $today == 'Monday' ? 'today' : '' }}" style="font-weight:600;color:blue;" onclick="toggleExpand('box-2')" title="Expandir/Recolher">
                Segunda-feira - {{ \Carbon\Carbon::now()->startOfWeek()->translatedFormat('d \d\e F') }}
            </span>
            <div class="orders">
                @forelse ($mondayOrders as $order)
                <div class="hover-alt" style="background-color:#C8E6C9; padding:1px; margin-bottom:5px; border-radius:4px;">
                    <div style="display:flex; flex-direction:row;">
                        <div style="width:65%;">
                            <a class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico' => $order->id]) }}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/y') }}
                                {{ \Carbon\Carbon::parse($order->hora_inicio)->format('H:i') }}
                            </span>
                            <span style="font-family:Arial, Helvetica, sans-serif;font-weight:600;">{{ $order->responsavel }}</span>
                        </div>
                        <div style="width:35%; text-align: right;">
                            <h6>{{ $order->equipamento->nome }}</h6>
                        </div>
                    </div>
                    <div style="margin-top:-2px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:15px;">
                            {{ $order->descricao }}
                        </span>
                    </div>
                </div>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta nesta segunda-feira.
                @endforelse
            </div>
        </div>

        <!--fim-->
        {{--Box 3 terça feira--}}
        <div id="box-3" class="item-week {{ $today == 'Tuesday' ? 'highlight-today' : '' }}">
            <span class="{{ $today == 'Tuesday' ? 'today' : '' }}" style="font-weight:600;color:blue;" onclick="toggleExpand('box-3')" title="Expandir/Recolher">
                Terça-feira - {{ \Carbon\Carbon::now()->startOfWeek()->addDays(1)->translatedFormat('d \d\e F') }}
            </span>
            <div class="orders">
                @forelse ($tuesdayOrders as $order)
                <div class="hover-alt" style="background-color:#C8E6C9; padding:1px; margin-bottom:5px; border-radius:4px;">
                    <div style="display:flex; flex-direction:row;">
                        <div style="width:65%;">
                            <a class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico' => $order->id]) }}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/y') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> {{ \Carbon\Carbon::parse($order->hora_inicio)->format('H:i') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif; font-weight:600;">{{ $order->responsavel }}</span>
                        </div>
                        <div style="width:35%; text-align: right;">
                            <h6>{{ $order->equipamento->nome }}</h6>
                        </div>
                    </div>
                    <div style="margin-top:-2px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:15px;">
                            {{ $order->descricao }}
                        </span>
                    </div>
                </div>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta nesta terça-feira.
                @endforelse
            </div>
        </div>

        {{--Box 4 Quarta-feira--}}
        <div id="box-4" class="item-week {{ $today == 'Wednesday' ? 'highlight-today' : '' }}">
            <span class="{{ $today == 'Wednesday' ? 'today' : '' }}" style="font-weight:600;color:blue;" onclick="toggleExpand('box-4')" title="Expandir/Recolher">
                Quarta-feira - {{ \Carbon\Carbon::now()->startOfWeek()->addDays(2)->translatedFormat('d \d\e F') }}
            </span>
            <div class="orders">
                @forelse ($wednesdayOrders as $order)
                <div class="hover-alt" style="background-color:#C8E6C9; padding:1px; margin-bottom:5px; border-radius:4px;">
                    <div style="display:flex; flex-direction:row;">
                        <div style="width:65%;">
                            <a class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico' => $order->id]) }}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/y') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> {{ \Carbon\Carbon::parse($order->hora_inicio)->format('H:i') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif; font-weight:600;">{{ $order->responsavel }}</span>
                        </div>
                        <div style="width:35%; text-align: right;">
                            <h6>{{ $order->equipamento->nome }}</h6>
                        </div>
                    </div>
                    <div style="margin-top:-2px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:15px;">
                            {{ $order->descricao }}
                        </span>
                    </div>
                </div>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta nesta quarta-feira.
                @endforelse
            </div>
        </div>

        {{--Box 5 Quinta-feira--}}
        <div id="box-5"
            class="item-week {{ $today == 'Thursday' ? 'highlight-today' : '' }}">
            <span class="{{ $today == 'Thursday' ? 'today' : '' }}"
                style="font-weight:600;color:blue;"
                onclick="toggleExpand('box-5')"
                title="Expandir/Recolher">
                Quinta-feira - {{ \Carbon\Carbon::now()->startOfWeek()->addDays(3)->translatedFormat('d \d\e F') }}
            </span>
            <div class="orders">
                @forelse ($thursdayOrders as $order)
                <div class="hover-alt" style="background-color:#C8E6C9; padding:1px; margin-bottom:5px; border-radius:4px;">
                    <div style="display:flex; flex-direction:row;">
                        <div style="width:65%;">
                            <a class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico' => $order->id]) }}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/y') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> {{ \Carbon\Carbon::parse($order->hora_inicio)->format('H:i') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif; font-weight:600;">{{ $order->responsavel }}</span>
                        </div>
                        <div style="width:35%; text-align: right;">
                            <h6>{{ $order->equipamento->nome }}</h6>
                        </div>
                    </div>
                    <div style="margin-top:-2px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:15px;">
                            {{ $order->descricao }}
                        </span>
                    </div>
                </div>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta nesta quinta-feira.
                @endforelse
            </div>
        </div>


        {{--Box 6 Sexta-feira--}}
        <div id="box-6" class="item-week {{ $today == 'Friday' ? 'highlight-today' : '' }}">
            <span class="{{ $today == 'Friday' ? 'today' : '' }}" style="font-weight:600;color:blue;" onclick="toggleExpand('box-6')" title="Expandir/Recolher">
                Sexta-feira - {{ \Carbon\Carbon::now()->startOfWeek()->addDays(4)->translatedFormat('d \d\e F') }}
            </span>
            <div class="orders">
                @forelse ($fridayOrders as $order)
                <div class="hover-alt" style="background-color:#C8E6C9; padding:1px; margin-bottom:5px; border-radius:4px;">
                    <div style="display:flex; flex-direction:row;">
                        <div style="width:65%;">
                            <a class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico' => $order->id]) }}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/y') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> {{ \Carbon\Carbon::parse($order->hora_inicio)->format('H:i') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif; font-weight:600;">{{ $order->responsavel }}</span>
                        </div>
                        <div style="width:35%; text-align: right;">
                            <h6>{{ $order->equipamento->nome }}</h6>
                        </div>
                    </div>
                    <div style="margin-top:-2px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:15px;">
                            {{ $order->descricao }}
                        </span>
                    </div>
                </div>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta nesta sexta-feira.
                @endforelse
            </div>
        </div>

        {{--Box 7 Sábado--}}
        <div id="box-7" class="item-week {{ $today == 'Saturday' ? 'highlight-today' : '' }}">
            <span class="{{ $today == 'Saturday' ? 'today' : '' }}" style="font-weight:600;color:blue;" onclick="toggleExpand('box-7')" title="Expandir/Recolher">
                Sábado - {{ \Carbon\Carbon::now()->startOfWeek()->addDays(5)->translatedFormat('d \d\e F') }}
            </span>
            <div class="orders">
                @forelse ($saturdayOrders as $order)
                <div class="hover-alt" style="background-color:#C8E6C9; padding:1px; margin-bottom:5px; border-radius:4px;">
                    <div style="display:flex; flex-direction:row;">
                        <div style="width:65%;">
                            <a class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico' => $order->id]) }}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/y') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> {{ \Carbon\Carbon::parse($order->hora_inicio)->format('H:i') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif; font-weight:600;">{{ $order->responsavel }}</span>
                        </div>
                        <div style="width:35%; text-align: right;">
                            <h6>{{ $order->equipamento->nome }}</h6>
                        </div>
                    </div>
                    <div style="margin-top:-2px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:15px;">
                            {{ $order->descricao }}
                        </span>
                    </div>
                </div>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta neste sábado.
                @endforelse
            </div>
        </div>

        {{--Box 1 Domingo--}}
        <div id="box-1" class="item-week {{ $today == 'Sunday' ? 'highlight-today' : '' }}">
            <span class="{{ $today == 'Sunday' ? 'today' : '' }}" style="font-weight:600;color:blue;" onclick="toggleExpand('box-1')" title="Expandir/Recolher">
                Domingo - {{ \Carbon\Carbon::now()->startOfWeek()->addDays(6)->translatedFormat('d \d\e F') }}
            </span>
            <div class="orders">
                @forelse ($sundayOrders as $order)
                <div class="hover-alt" style="background-color:#C8E6C9; padding:1px; margin-bottom:5px; border-radius:4px;">
                    <div style="display:flex; flex-direction:row;">
                        <div style="width:65%;">
                            <a class="txt-link" href="{{ route('ordem-servico.show', ['ordem_servico' => $order->id]) }}" title="Click para abrir a O.S.">{{ $order->id }}</a>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> Início: {{ \Carbon\Carbon::parse($order->data_inicio)->format('d/m/y') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif;"> {{ \Carbon\Carbon::parse($order->hora_inicio)->format('H:i') }}</span>
                            <span style="font-family:Arial, Helvetica, sans-serif; font-weight:600;">{{ $order->responsavel }}</span>
                        </div>
                        <div style="width:35%; text-align: right;">
                            <h6>{{ $order->equipamento->nome }}</h6>
                        </div>
                    </div>
                    <div style="margin-top:-2px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size:15px;">
                            {{ $order->descricao }}
                        </span>
                    </div>
                </div>
                <hr style="color:green;margin:1px;">
                @empty
                Nenhuma ordem de serviço aberta neste domingo.
                <hr>
                @endforelse
            </div>
        </div>

        {{--fim card--}}
    </div>

    <!------------------------------------------------------------->
    <!----  Gráfico de gantt-->
    <!------------------------------------------------------------->

    <head>
        <meta charset="UTF-8" />
        <style>
            body {
                font-family: sans-serif;
                padding: 20px;
                margin: 0;
            }

            .gantt-months,

            .gantt-rows {
                display: grid;
                grid-template-columns: 150px repeat(var(--meses), 1fr);
                width: 100vw;
                max-width: 100vw;
                box-sizing: border-box;
                overflow-x: hidden;
            }

            .gantt-months div,
            .gantt-rows div {
                border-left: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
                height: 30px;
                line-height: 30px;
                text-align: center;
                font-size: 12px;
                font-family: Arial, Helvetica, sans-serif;
              font-weight: 300;
                box-sizing: border-box;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                user-select: none;
            }

            .gantt-months div:first-child,
            .gantt-rows div:first-child {
                border-left: none;
                font-weight: bold;
                background: #f5f5f5;
            }

            .gantt-months div {
                background: #e6e6e6;
                font-weight: bold;
            }

            .task-name {
                background: #f5f5f5;
                padding: 4px 8px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                text-align: left;
                border-right: 1px solid #ddd;

            }

            .bar {
                height: 10px;
                margin-top: 10px;
                border-radius: 0;
                position: relative;
                cursor: pointer;
                transition: opacity 0.2s;
            }

            .bar:hover {
                opacity: 0.7;
            }

            #modal {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            
            }

            #modalContent {
                background: white;
                padding: 20px;
                border-radius: 6px;
                width: 320px;
                box-sizing: border-box;
            }

            #modalContent label {
                display: block;
                margin-top: 10px;
                font-weight: bold;
            }

            #modalContent input {
                width: 100%;
                padding: 6px;
                margin-top: 4px;
                box-sizing: border-box;
            }

            #modalContent button {
                margin-top: 15px;
                padding: 8px 15px;
                cursor: pointer;
            }

            #modalContent .actions {
                text-align: right;
            }

            /* Botão toggle */
            #btnToggle {
                margin-bottom: 10px;
                padding: 8px 15px;
                cursor: pointer;
                font-size: 14px;
            }
        </style>
    </head>
    <!--mensagem de erro ou sucesso de alteração de os-->
    <script>
        function mostrarFeedback(mensagem, tipo) {
            const feedback = document.getElementById('feedbackMensagem');
            feedback.innerText = mensagem;
            feedback.style.display = 'block';
            feedback.style.padding = '10px';
            feedback.style.borderRadius = '5px';
            feedback.style.fontWeight = 'bold';
            feedback.style.marginTop = '10px';

            if (tipo === 'success') {
                feedback.style.backgroundColor = '#d4edda';
                feedback.style.color = '#155724';
                feedback.style.border = '1px solid #c3e6cb';
            } else {
                feedback.style.backgroundColor = '#f8d7da';
                feedback.style.color = '#721c24';
                feedback.style.border = '1px solid #f5c6cb';
            }

            // Oculta após 5 segundos
            setTimeout(() => {
                feedback.style.display = 'none';
            }, 5000);
        }
    </script>
    <div id="feedbackMensagem" style="display:none; margin-top:10px;"></div>

    <body>
        <h5>Gantt Dinâmico</h5>
        <label>Início: <input class="form-control" type="month" id="inputInicio" value="2025-01"></label>
        <label>Fim: <input class="form-control" type="month" id="inputFim" value="2025-12"></label>
        <button class="btn btn-outline-success mb-1" onclick="aplicarFiltro()">Aplicar</button>
        <script>
            function aplicarFiltro() {
                const inicioVal = document.getElementById("inputInicio").value;
                const fimVal = document.getElementById("inputFim").value;

                const [anoInicio, mesInicio] = inicioVal.split('-').map(Number);
                const [anoFim, mesFim] = fimVal.split('-').map(Number);

                dataInicio = new Date(anoInicio, mesInicio - 1, 1);
                dataFim = new Date(anoFim, mesFim, 0); // último dia do mês fim

                totalMeses = diffMonths(dataInicio, dataFim) + 1;
                elMeses.style.setProperty('--meses', totalMeses);

                renderGantt();
            }
        </script>
        <!-- Botão para alternar visualização -->
        <button class="btn btn-outline-success mb-1" id="btnToggle">Exibir: Semestral</button>

        <div class="gantt-months" id="gantt-meses"></div>
        <div id="gantt-tarefas"></div>

        <!-- Meta tag CSRF obrigatória -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Modal Para atualizar a OS -->
        <div id="modal" style="display:none;">
            <div id="modalContent">
                <h3>Editar O.S.</h3>
                <form id="formEdit" data-id="123"> <!-- exemplo de data-id -->
                    <label for="id">ID:</label>
                    <input class="btn btn-outline-primary mb-1" type="text" id="id" name="nome" required />
                    <div style="display:flex; flex-direction:row">
                        <label for="inicio">Início:</label>
                    </div>

                    <div style="display:flex; flex-direction:row">
                        <input class="form-control" style="width:140px;" type="date" id="inicio" name="inicio" required />
                        <input class="form-control" style="width:140px;" type="date" id="fim" name="fim" required />
                    </div>
                    <div class="actions">
                        <div class="actions">
                            <button class="btn btn-outline-primary mb-1" type="button" id="cancelBtn">Cancelar
                                <i class="icofont-delete"></i>
                            </button>
                            <button class="btn btn-outline-success mb-1" type="submit">Salvar
                                <i class="icofont-save"></i>
                            </button>
                        </div>
                </form>

                <p id="respostaServidor"></p> <!-- para mostrar a resposta -->
            </div>
        </div>
        <script>
            // botão ir para os
            document.getElementById('id').addEventListener('click', function() {
                const osId = document.getElementById('id').value;
                if (osId) {
                    window.location.href = `/ordem-servico/${osId}`;
                } else {
                    alert('Informe o ID da O.S. no campo "nome".');
                }
            });
        </script>
        <script>
            // Abrir modal para testes (você pode adaptar para sua lógica)
            // document.getElementById('modal').style.display = 'block';

            // Cancelar botão fecha o modal
            document.getElementById('cancelBtn').addEventListener('click', () => {
                document.getElementById('modal').style.display = 'none';
            });

            // Submit do formulário
            document.getElementById('formEdit').addEventListener('submit', function(event) {
                event.preventDefault(); // previne recarregamento

                const id = document.getElementById('id').value;
                const inicio = document.getElementById('inicio').value;
                const fim = document.getElementById('fim').value;

                // Pode pegar o id do registro a partir do data-id do form (se quiser)
                const osId = this.getAttribute('data-id');

                // Montar objeto para enviar
                const dadosParaEnviar = {
                    id: id,
                    inicio: inicio,
                    fim: fim
                };

                fetch('{{ route("update.os.interval") }}', { // ou outra rota de update
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(dadosParaEnviar)
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('respostaServidor').textContent = 'Resposta do servidor: ' + data.retorno;
                        // Aqui você pode fechar o modal, atualizar a tela, etc
                        // Exemplo: fechar modal após sucesso
                        // document.getElementById('modal').style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Erro ao enviar:', error);
                        document.getElementById('respostaServidor').textContent = 'Erro ao enviar a requisição.';
                    });
            });
        </script>


        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!--------------------------------------------->
        <script>
            function diffMonths(d1, d2) {
                return (d2.getFullYear() - d1.getFullYear()) * 12 + (d2.getMonth() - d1.getMonth());
            }

            function diasNoMes(ano, mes) {
                return new Date(ano, mes + 1, 0).getDate();
            }

            // Variáveis globais
            let periodo = 'semestral'; // Começa mostrando semestral
            let dataInicio, dataFim, totalMeses;

            const cores = ["#3fa9f5", "#ff9800", "#8bc34a"];
            const meses = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];

            const elMeses = document.getElementById("gantt-meses");
            const elTarefas = document.getElementById("gantt-tarefas");
            const modal = document.getElementById("modal");
            const formEdit = document.getElementById("formEdit");
            const inputNome = document.getElementById("id");
            const inputInicio = document.getElementById("inicio");
            const inputFim = document.getElementById("fim");
            const cancelBtn = document.getElementById("cancelBtn");
            const btnToggle = document.getElementById("btnToggle");

            // Recebe array PHP convertido para JS (substitua $ordem_servico_gantt pela sua variável real)
            const ordensServicos = @json($ordem_servico_gantt);

            // Mapeia ordens para formato tarefas do gráfico
            let tarefas = ordensServicos.map(os => {

                return {
                    id: os.id,
                    nome: `${os.id}`,
                    inicio: os.data_inicio.substr(0, 10),
                    fim: os.data_fim.substr(0, 10),
                    responsavel: os.responsavel,
                    equipamento: os.equipamento.nome
                };
            });

            // Função para atualizar datas conforme período
            function atualizarDatas() {
                const hoje = new Date();
                const anoAtual = hoje.getFullYear();
                const mesAtual = hoje.getMonth(); // 0 a 11

                if (periodo === 'anual') {
                    dataInicio = new Date(anoAtual, mesAtual, 1); // Início do mês atual
                    dataFim = new Date(anoAtual + 1, mesAtual, 0); // Último dia do mesmo mês do ano seguinte
                    btnToggle.innerText = "Exibir: Semestral";
                } else {
                    dataInicio = new Date(anoAtual, mesAtual, 1); // Início do mês atual
                    dataFim = new Date(anoAtual, mesAtual + 6, 0); // Último dia do 6º mês a partir de hoje
                    btnToggle.innerText = "Exibir: Anual";
                }

                totalMeses = diffMonths(dataInicio, dataFim) + 1;
                elMeses.style.setProperty('--meses', totalMeses);
            }
            // Função para renderizar gráfico
            function renderGantt() {
                elMeses.innerHTML = '';
                elTarefas.innerHTML = '';

                // Cabeçalho meses
                const firstCol = document.createElement("div");
                firstCol.innerText = "Mês";
                elMeses.appendChild(firstCol);

                for (let i = 0; i < totalMeses; i++) {
                    const d = new Date(dataInicio.getFullYear(), dataInicio.getMonth() + i, 1);
                    const monthName = meses[d.getMonth()];
                    const cell = document.createElement("div");
                    cell.innerText = monthName + " " + d.getFullYear();
                    elMeses.appendChild(cell);
                }

                // Renderiza tarefas
                tarefas.forEach((tarefa, i) => {
                    const row = document.createElement("div");
                    row.className = "gantt-rows";
                    row.style.gridTemplateColumns = `150px repeat(${totalMeses}, 1fr)`;
                    //aplica os dadsodentro da celula
                    const nameCell = document.createElement("div");
                    nameCell.className = "task-name";
                    nameCell.innerText = `#${tarefa.id} - ${tarefa.responsavel}-${tarefa.equipamento}`; // ← Aqui junta os dois/////////////////////////////////
                    //nameCell.innerText = tarefa.nome;
                    row.appendChild(nameCell);

                    const inicio = new Date(tarefa.inicio);
                    const fim = new Date(tarefa.fim);

                    // Se a tarefa está fora do período, não mostrar barra (pode ajustar)
                    if (fim < dataInicio || inicio > dataFim) {
                        // preenche as células vazias da linha inteira
                        for (let k = 0; k < totalMeses; k++) {
                            const empty = document.createElement("div");
                            row.appendChild(empty);
                        }
                        elTarefas.appendChild(row);
                        return;
                    }

                    // Ajusta inicio/fim da barra para o período exibido
                    const start = inicio < dataInicio ? dataInicio : inicio;
                    const end = fim > dataFim ? dataFim : fim;

                    const diffInicio = diffMonths(dataInicio, start);
                    const duracao = diffMonths(start, end) + 1;

                    // Células vazias antes da barra
                    for (let j = 0; j < diffInicio; j++) {
                        const empty = document.createElement("div");
                        row.appendChild(empty);
                    }

                    // Barra mês a mês
                    for (let m = 0; m < duracao; m++) {
                        const mesIndex = start.getMonth() + m;
                        const ano = start.getFullYear() + Math.floor(mesIndex / 12);
                        const mes = mesIndex % 12;
                        const diasMes = diasNoMes(ano, mes);

                        const cell = document.createElement("div");

                        const barra = document.createElement("div");
                        barra.className = "bar";
                        barra.style.backgroundColor = cores[i % cores.length];
                        //Exibe uma mensagem com os dados da os
                        barra.title = `${tarefa.nome} (${tarefa.inicio} → ${tarefa.fim})`;

                        if (duracao === 1) {
                            const diaIni = start.getDate();
                            const diaFim = end.getDate();
                            const margemEsq = ((diaIni - 1) / diasMes) * 100;
                            const larguraBarra = ((diaFim - diaIni + 1) / diasMes) * 100;
                            barra.style.marginLeft = margemEsq + "%";
                            barra.style.width = larguraBarra + "%";
                        } else {
                            if (m === 0) {
                                const diaIni = start.getDate();
                                const margemEsq = ((diaIni - 1) / diasMes) * 100;
                                const larguraBarra = 100 - margemEsq;
                                barra.style.marginLeft = margemEsq + "%";
                                barra.style.width = larguraBarra + "%";
                            } else if (m === duracao - 1) {
                                const diaFim = end.getDate();
                                barra.style.marginLeft = "0%";
                                barra.style.width = ((diaFim) / diasMes) * 100 + "%";
                            } else {
                                barra.style.marginLeft = "0%";
                                barra.style.width = "100%";
                            }
                        }

                        barra.addEventListener("click", () => abrirModal(i));

                        cell.appendChild(barra);
                        row.appendChild(cell);
                    }

                    // Células vazias depois da barra
                    const restantes = totalMeses - diffInicio - duracao;
                    for (let j = 0; j < restantes; j++) {
                        const empty = document.createElement("div");
                        row.appendChild(empty);
                    }

                    elTarefas.appendChild(row);
                });
            }

            // Modal funções
            function abrirModal(index) {
                const tarefa = tarefas[index];
                inputNome.value = tarefa.nome;
                inputInicio.value = tarefa.inicio;
                inputFim.value = tarefa.fim;
                formEdit.dataset.index = index;
                modal.style.display = "flex";
            }

            function fecharModal() {
                modal.style.display = "none";
            }

            cancelBtn.addEventListener("click", fecharModal);

            formEdit.addEventListener("submit", e => {
                e.preventDefault();
                const index = formEdit.dataset.index;
                tarefas[index].nome = inputNome.value.trim();
                tarefas[index].inicio = inputInicio.value;
                tarefas[index].fim = inputFim.value;
                fecharModal();
                renderGantt();
            });

            // Evento toggle botão
            btnToggle.addEventListener('click', () => {
                periodo = (periodo === 'anual') ? 'semestral' : 'anual';
                atualizarDatas();
                renderGantt();
            });

            // Inicializa datas e desenha
            atualizarDatas();
            renderGantt();
        </script>

    </body>
    <!------------------------------------------------------------------------>
    <!-- nova Gantt----------------------------------------------------------->
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Gantt com DIVs</title>
        <style>
            :root {
                --task-width: 250px;
                --cell-width: 60px;
            }

            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            .gantt-container {
                width: 100%;
                overflow-x: auto;
                border: 1px solid #ccc;
            }

            .gantt-header,
            .gantt-row {
                display: grid;
                grid-template-columns: var(--task-width) repeat(12, var(--cell-width));
                align-items: center;
            }

            .gantt-task-header,
            .gantt-task {
                padding: 8px;
                background: #f5f5f5;
                font-weight: bold;
                border-right: 1px solid #ccc;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .gantt-timeline-header {
                display: contents;
            }

            .gantt-time-cell {
                padding: 8px;
                text-align: center;
                background: #e0e0e0;
                border-left: 1px solid #ccc;
                font-size: 12px;
                border-bottom: 1px solid #ccc;
            }

            .gantt-body {
                border-top: 1px solid #ccc;
            }

            .gantt-bar {
                height: 24px;
                background-color: steelblue;
                border-radius: 4px;
                margin: 4px;
                grid-column: span 1;
                transition: background-color 0.3s ease;
            }

            .gantt-bar:hover {
                background-color: dodgerblue;
                cursor: pointer;
            }

            /* Grade (colunas visuais) */
            .gantt-row>div:not(.gantt-task) {
                border-left: 1px solid #eee;
                height: 32px;
            }
        </style>
    </head>

    <body>
        <div class="gantt-container">
            <div class="gantt-header">
                <div class="gantt-task-header">Tarefa</div>
                <div class="gantt-timeline-header" id="gantt-meses"></div>
            </div>

            <div class="gantt-body" id="gantt-corpo">
                <!-- Linhas de tarefas são geradas via JS -->
            </div>
        </div>

        <script>
            const meses = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];

            const tarefas = [{
                    id: 1,
                    responsavel: "João",
                    equipamento: "Trator",
                    inicio: 1,
                    duracao: 3
                },
                {
                    id: 2,
                    responsavel: "Maria",
                    equipamento: "Caminhão",
                    inicio: 4,
                    duracao: 2
                },
                {
                    id: 3,
                    responsavel: "Carlos",
                    equipamento: "Colheitadeira",
                    inicio: 6,
                    duracao: 5
                }
            ];

            const ganttMeses = document.getElementById("gantt-meses");
            const ganttCorpo = document.getElementById("gantt-corpo");

            // Renderiza cabeçalho de meses
            meses.forEach(mes => {
                const cell = document.createElement("div");
                cell.className = "gantt-time-cell";
                cell.innerText = mes;
                ganttMeses.appendChild(cell);
            });

            // Renderiza tarefas
            tarefas.forEach(tarefa => {
                const row = document.createElement("div");
                row.className = "gantt-row";

                const taskCell = document.createElement("div");
                taskCell.className = "gantt-task";
                taskCell.innerText = `#${tarefa.id} - ${tarefa.responsavel} - ${tarefa.equipamento}`;
                row.appendChild(taskCell);

                // Cria 12 células para a grade visual
                for (let i = 1; i <= 12; i++) {
                    const emptyCell = document.createElement("div");
                    row.appendChild(emptyCell);
                }

                // Cria a barra da tarefa e posiciona corretamente
                const bar = document.createElement("div");
                bar.className = "gantt-bar";
                bar.style.gridColumn = `${tarefa.inicio + 1} / span ${tarefa.duracao}`;
                bar.title = `Início: ${meses[tarefa.inicio - 1]} - Duração: ${tarefa.duracao} meses`;
                row.appendChild(bar);

                ganttCorpo.appendChild(row);
            });
        </script>
    </body>

    </html>
</main>
@include('app.ordem_servico.52week')