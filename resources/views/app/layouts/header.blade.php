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
        <div class="logo">
            <i class="icofont-architecture-alt icofont-2x wite"></i>
            <span class="font-wheight-light">Manutenção Fapolpa</span>
        </div>
        <div class="spacer"></div>
        <!-- Notificação de Check list -->
        <!-- Notificação de Check list -->
        <div class="dropdown" id="checklist-count">
            <a href="/check-list-index" id="checklist-link" class="dropdown" style="color: white;">
                Check-list
            </a>&nbsp&nbsp
            <span style="margin-top:-5px;"  class="badge" id="checklist-badge">0</span>
        </div>

        <!-- Notificação de SS -->
        <div class="dropdown" id="solicitacoes-count">
            <a href="/solicitacoes-os" id="solicitacoes-link" class="dropdown" style="color: white;">
                SS pendente
            </a>&nbsp&nbsp
            <span style="margin-top:-5px;"  class="badge" id="solicitacoes-badge">0</span>
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
                            Sair
                        </a>
                        <form action="{{ route('logout') }}" method="POST" id="form_logout">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>