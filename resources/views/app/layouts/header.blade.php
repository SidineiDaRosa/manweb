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
        <!-- HTML -->
        <div class="dropdown" id="solicitacoes-count">
            <a href="/solicitacoes-os" id="solicitacoes-link" class="dropdown" style="color: white;">
                Solicitação pendente
            </a>
            <span class="badge" id="badge">0</span>
        </div>

        <!-- CSS -->
        <style>
            /* Estiliza o balão (badge) */
            .badge {
                display: inline-block;
                width: 24px;
                height: 24px;
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
                /* Garante que o balão fique acima de outros elementos */
            }

            /* Estilo do balão quando não há solicitações pendentes */
            .badge.zero {
                background-color: green;
            }

            /* Estilo do balão quando há solicitações pendentes */
            .badge.non-zero {
                background-color: red;
            }

            /* Estiliza a posição da div de contagem */
            #solicitacoes-count {
                position: relative;
                display: inline-block;
                /* Ajusta o contêiner para se ajustar ao balão */
                margin-right: 100px;
                cursor: pointer;
            }
        </style>

        <!-- JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Função para atualizar a contagem de solicitações pendentes
                function atualizarContagem() {
                    fetch('/solicitacoes-pendentes')
                        .then(response => response.json())
                        .then(data => {
                            const badge = document.getElementById('badge');
                            badge.innerText = data.pendentes;

                            // Altera a classe do balão com base no número de solicitações
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

                // Atualiza a contagem a cada 30 segundos (30000 milissegundos)
                setInterval(atualizarContagem, 30000);

                // Atualiza a contagem imediatamente quando a página é carregada
                atualizarContagem();
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