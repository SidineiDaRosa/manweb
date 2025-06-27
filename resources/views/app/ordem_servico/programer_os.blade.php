@extends('app.layouts.app')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
            background-color:rgb(246, 248, 213);
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
        <div  class="item-week {{ $today == 'Monday' ? 'highlight-today' : '' }}" id="box-2">
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
        <div id="box-3"  class="item-week {{ $today == 'Tuesday' ? 'highlight-today' : '' }}">
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
        <div id="box-4"  class="item-week {{ $today == 'Wednesday' ? 'highlight-today' : '' }}">
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
        <div id="box-6"  class="item-week {{ $today == 'Friday' ? 'highlight-today' : '' }}">
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
        <div id="box-7"  class="item-week {{ $today == 'Saturday' ? 'highlight-today' : '' }}">
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
        <div id="box-1"  class="item-week {{ $today == 'Sunday' ? 'highlight-today' : '' }}">
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
            height: 200px;
            margin: 5px;
            padding: 5px;
            background-color: aliceblue;
            overflow: auto;
            /* Impede que o conteúdo transborde */
        }

        .item-52-week {
            width: calc(14.28% - 20px);
            height: 100px;
            margin: 5px;
            padding: 5px;
            background-color: aliceblue;
            overflow: auto;
            /* Impede que o conteúdo transborde */
        }
    </style>

    <h3 style="font-family:Arial, Helvetica, sans-serif">52 Semanas</h3>

    <div class="container-month">
        @foreach($ordens_servicos_por_semana as $week => $ordens)
        {{-- Verifique se esta é a semana que deseja destacar --}}
        <div class="item-52-week {{ $week == now()->weekOfYear ? 'highlight' : '' }}">
            <h6 style="font-family: Arial, Helvetica, sans-serif;margin-left:-1px;">{{ $week }}</h6>

            @if($ordens->isEmpty())
            <p>...</p>
            @else
            <ul style="margin-left: -20px;">
                @foreach($ordens as $ordem)
                <li>
                    <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem->id])}}" title="Click para abrir a O.S.">{{ $ordem->id }}</a>
                    <span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">{{ \Carbon\Carbon::parse($ordem->data_inicio)->format('d/m/y') }}</span>
                    <span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:darkblue;">{{ $ordem->equipamento->nome}}</span>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
        @endforeach
    </div>

    <style>
        .container-month {
            display: flex;
            flex-wrap: wrap;
        }

        .item-52-week {
            width: 180px;
            height: 150px;
            margin: 2px;
            padding: 2px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            overflow: hidden;
            transition: all 0.5s ease;
            transition-delay: 0.5s;
            /* Atraso de 0.5s antes de iniciar a expansão */
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* Alinha o conteúdo no topo */
            position: relative;
        }

        .item-52-week.highlight {
            background-color: rgba(144, 238, 144, 0.5);
            /* Verde fraco em RGBA */
            /* Cor destaque para a semana correspondente */
        }

        .item-52-week:hover {
            width: 400px;
            height: 400px;
            background-color: #e0e0e0;
            overflow: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .item-52-week h4 {
            margin: 0;
            position: absolute;
            top: 10px;
            /* Mantém o número no topo */
            left: 50%;
            transform: translateX(-50%);
            /* Centraliza horizontalmente */
        }

        .item-52-week ul {
            margin: 10px 0 0;
            padding: 0;
            list-style-type: none;
            text-align: left;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weekItems = document.querySelectorAll('.item-52-week');

            weekItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Verifica se o item já está expandido
                    const isExpanded = item.classList.contains('expanded');

                    // Remove a classe expanded de todos os itens e redefine os tamanhos
                    weekItems.forEach(i => {
                        i.classList.remove('expanded');
                        i.style.width = '150px'; // Redefine a largura para o tamanho original
                        i.style.height = '150px'; // Redefine a altura para o tamanho original
                    });

                    // Se o item não estava expandido, expande-o; se estava, não faz nada
                    if (!isExpanded) {
                        item.classList.add('expanded');
                        item.style.width = '400px'; // Expande o item clicado
                        item.style.height = '400px'; // Expande o item clicado
                    }
                });
            });
        });
    </script>
    <h3 style="font-family: Arial, Helvetica, sans-serif;">Mês</h3>
    <div class="container-month">
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
</main>