@extends('app.layouts.app')
@section('content')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">

    <!--mensagem de erro caso datas erradas-->
    @if(session('erro'))
    <div id="alerta-erro" style="padding:20px; background:#f8d7da; color:#842029; border:1px solid #f5c2c7; border-radius:4px; margin-bottom:15px; position: relative;">
        {{ session('erro') }}
        <button
            onclick="document.getElementById('alerta-erro').style.display='none'"
            style="position: absolute; top: 5px; right: 10px; background: transparent; border: none; font-weight: bold; font-size: 20px; line-height: 20px; cursor: pointer; color: #842029;"
            aria-label="Fechar mensagem">
            &times;
        </button>
    </div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    @foreach($ordem_servico_gantt as $ordem_servico_gantt_gnt)
    <span hidden>{{$ordem_servico_gantt_gnt->equipamento->nome}} <br></span>

    @endforeach

    <div style="display:flex; justify-content:center;width:100%;gap:10px;">
        <div>
            <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> Dashboard
            </a>
        </div>
        <div id="intervalo">

            <form style="display:flex;flex-direction:row;gap:5px;" action="{{ route('gantt.os.timeline') }}" method="GET">
                <label for="inicio">Início:</label>
                <input class="form-control w-50" type="datetime-local" id="inicio" name="inicio" />

                <label for="fim">Fim:</label>
                <input class="form-control w-50" type="datetime-local" id="fim" name="fim" />
                <select name="projeto_id" id="projeto_id" class="form-control" aria-placeholder="Selecione o projeto" style="background-color: #e6f1e7ff;">
                    <option value="0">Nenhum</option>
                    @foreach($projetos as $projeto)
                    <option value="{{ $projeto->id }}">{{ $projeto->nome }}</option>
                    @endforeach
                </select>
                <select class="form-control w-50" name="situacao" id="situacao">
                    <option value="padrao">Não finalizada</option>
                    <option value="aberto">Aberto</option>
                    <option value="fechado">Fechado</option>
                    <option value="indefinido">Indefinido</option>
                    <option value="em andamento">Em andamento</option>
                    <option value="pausado">Pausado</option>
                </select>

                &nbsp;
                <button class="btn btn-danger" type="submit">Gerar Gantt</button>
            </form>
        </div>
    </div>
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
                Segunda-feira - {{ \Carbon\Carbon::now()->startOfWeek()->translatedFormat('d \d\e F') }} <i class="bi bi-arrows-angle-expand"></i>
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

</main>
@include('app.ordem_servico.52week')