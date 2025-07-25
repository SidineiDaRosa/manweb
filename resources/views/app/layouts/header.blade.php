<!DOCTYPE html>
<html lang="en">

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
        <div class="dropdown" id="alarms-count" style="margin-top:20px;margin-right:20px;">
            <a href="{{ route('notificacoes.index') }}" id="alarmes-link" class="dropdown" style="color: white;">
                Alarmes
            </a>&nbsp&nbsp&nbsp&nbsp
            <span style="margin-top:-5px;" class="badge" id="alarms-badge">0</span>
        </div>
        <!-- Notificação de Check list -->
        <div class="dropdown" id="checklist-count" style="margin-top:20px;">
            <a href="/check-list-index" id="checklist-link" class="dropdown" style="color: white;">
                Check-list
            </a>&nbsp&nbsp
            <span style="margin-top:-5px;" class="badge" id="checklist-badge">0</span>
        </div>

        <!-- Notificação de SS -->
        <div class="dropdown" id="solicitacoes-count" style="margin-top:20px;">
            <a href="/solicitacoes-os" id="solicitacoes-link" class="dropdown" style="color: white;">
                SS pendente
            </a>&nbsp&nbsp
            <span style="margin-top:-5px;" class="badge" id="solicitacoes-badge">0</span>
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

            .badge.yellow {
                background-color: gold;
                /* Nova classe para amarelo */
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

                // Atualiza as contagens a cada 30 segundos
                setInterval(atualizarContagemSolicitacoes, 30000);
                setInterval(atualizarContagemChecklists, 30000);
                setInterval(UpdateAlarms, 30000); // adiciona atualização dos alarmes

                // Atualiza as contagens imediatamente quando a página é carregada
                atualizarContagemSolicitacoes();
                atualizarContagemChecklists();
                UpdateAlarms(); // chama o UpdateAlarms assim que a página carregar
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
                       
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                        </svg>
                        <form action="{{ route('logout') }}" method="POST" id="form_logout">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>


        </div>
    </header>