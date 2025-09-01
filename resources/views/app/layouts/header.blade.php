<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
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
    <title>Gestão de Manutenção Fapolpa</title>
</head>

<body>
    <header class="header">
        <div class="menu-toggle mx-3">
            <i class="icofont-navigation-menu"></i>
        </div>
        <div class="logo" id="logo">
            <i class="icofont-architecture-alt icofont-1x " style="color:lightgrey;"></i>
            <span style="font-family: Arial, Helvetica, sans-serif;color:lightgrey;font-size:20px;font-stretch:condensed;">Manutenção Fapolpa</span>
        </div>
        <style>
            @media (max-width: 900px) {
                #logo {
                    display: none;
                }
            }
        </style>

        <div class="spacer"></div>
        <!-- Notificação de Alarmes -->
        <div class="notifications">
            <div id="alarms-count" class="notification">
                <a href="{{ route('notificacoes.index') }}">Alarmes</a>
                <span class="badge" id="alarms-badge">0</span>
            </div>
            <div id="checklist-count" class="notification">
                <a href="/check-list-index">Check-list</a>
                <span class="badge" id="checklist-badge">0</span>
            </div>
            <div id="solicitacoes-count" class="notification">
                <a href="/solicitacoes-os">SS pendente</a>
                <span class="badge" id="solicitacoes-badge">0</span>
            </div>
            <div id="messages-count" class="notification">
                <a href="{{ route('groups.index') }}">
                    <i class="icofont-ui-messaging icofont-2x"></i>
                </a>
                <span class="badge" id="messages-badge">0</span>
            </div>
        </div>


        <!-- CSS -->
        <style>
            /* Container de todas as notificações */
            .notifications {
                display: flex;
                /* organiza os itens em linha */
                align-items: center;
                /* alinha verticalmente */
                gap: 20px;
                /* espaço entre os itens */
                flex-wrap: wrap;
                /* quebra linha em telas pequenas */
            }

            /* Cada item de notificação individual */
            .notification {
                position: relative;
                /* necessário para badges */
                cursor: pointer;
            }

            /* Badge */
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

            /* Badges com cores específicas */
            .badge.zero {
                background-color: green;
            }

            .badge.non-zero {
                background-color: red;
            }

            .badge.warning {
                background-color: orange;
            }

            .badge.yellow {
                background-color: gold;
            }

            /* Ajustes para telas pequenas */
            @media (max-width: 600px) {
                .badge {
                    top: -5px;
                    right: -5px;
                    width: 24px;
                    height: 24px;
                    font-size: 12px;
                }
            }
        </style>
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

                // Função para atualizar a contagem de Alarmes
                function UpdateAlarms() {
                    fetch('/alarms-count')
                        .then(response => response.json())
                        .then(data => {
                            const badge = document.getElementById('alarms-badge');
                            badge.innerText = data.pendentes;

                            if (data.pendentes > 0) {
                                badge.classList.remove('zero');
                                badge.classList.remove('non-zero');
                                badge.classList.add('yellow'); // Adiciona a classe warning
                            } else {
                                badge.classList.remove('non-zero');
                                badge.classList.remove('yellow'); // Remove a classe warning
                                badge.classList.add('zero');
                            }
                        })
                        .catch(error => console.error('Erro:', error));
                }
                // Função para atualizar a contagem de mensagens pendestes
                function UpdateMessages() {
                    fetch('/messages-count')
                        .then(response => response.json())
                        .then(data => {
                            const badge = document.getElementById('messages-badge');
                            badge.innerText = data.pendentes;

                            if (data.pendentes > 0) {
                                badge.classList.remove('zero');
                                badge.classList.remove('non-zero');
                                badge.classList.add('yellow'); // Adiciona a classe warning
                            } else {
                                badge.classList.remove('non-zero');
                                badge.classList.remove('yellow'); // Remove a classe warning
                                badge.classList.add('zero');
                            }
                        })
                        .catch(error => console.error('Erro:', error));
                }
                // Atualiza as contagens a cada 30 segundos
                setInterval(atualizarContagemSolicitacoes, 30000);
                setInterval(atualizarContagemChecklists, 30000);
                setInterval(UpdateAlarms, 30000); // adiciona atualização dos alarmes
                setInterval(UpdateMessages, 30000); // adiciona atualização das mensagens

                // Atualiza as contagens imediatamente quando a página é carregada
                atualizarContagemSolicitacoes();
                atualizarContagemChecklists();
                UpdateAlarms(); // chama o UpdateAlarms assim que a página carregar
                UpdateMessages(); // adiciona atualização das mensagens
            });
        </script>

        <!--Usuario logado-->
        <div class="dropdown">
            <div class="dropdown-button">
                {{ Auth::user()->name }}
                <span class="ml-3"
                    </span>
                    <i class="icofont-simple-down mx-2"></i>
            </div>
            <div class="dropdown-content">
                <ul class="nav-item">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('form_logout').submit();">
                            Saír
                        </a>

                        <form action="{{ route('logout') }}" method="POST" id="form_logout">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>


        </div>
    </header>

</body>