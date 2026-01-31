<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="https://manweb.com.br/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <meta name="google-site-verification" content="sPnm1Efi9wRNCBh49qTNrGGnKU1r2zCkwoqgh8KtCC0" />
    <style>
        /* ======= HEADER ESTILO AZUL (sem apagar seus links) ======= */
        .navbar {
            background-color: #0b1b3d;
            /* azul igual ao exemplo */
            width: 100%;
            padding: 0;
        }

        /* Centraliza tudo como no layout profissional */
        .nav-wrapper {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            width: 100%;
        }

        /* LOGO À ESQUERDA */
        .logo {
            color: white;
            font-size: 22px;
            font-weight: 700;
        }

        /* MENU CENTRAL */
        .menu {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        /* ITENS DO MENU */
        .menu-item a {
            color: white !important;
            font-weight: 600;
            text-decoration: none;
        }

        /* DROPDOWN (seu mesmo funcionamento, só com visual melhor) */
        .menu-item {
            position: relative;
        }

        .dropdown {
            top: 50px;
            left: 0;
            background: #fff;
            color: black;
            padding: 20px;
            width: 100vw;
            height: 400px;
            position: fixed;
            box-shadow: 0 8px 16px rgba(10, 8, 8, 0.2);
            opacity: 0;
            visibility: hidden;
            transition: .3s ease;
            z-index: 9999;
        }

        .dropdown a {
            color: #4974d1 !important;
            /* azul escuro para aparecer no fundo branco */
            text-decoration: none;
            font-weight: 500;
        }

        /* título dentro do dropdown */
        .dropdown .titulo {
            color: #0b1b3d;
            margin-bottom: 5px;
        }

        /* conteúdo do dropdown */
        .dropdown .conteudo {
            color: #333;
        }


        /* Aparece ao passar o mouse (igual ao seu) */
        .menu-item:hover .dropdown {
            opacity: 1;
            visibility: visible;
        }

        /* BOTÃO À DIREITA (igual ao print) */
        .btn-contato {
            background: #3b5bff;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        /* IDIOMA */
        .idioma {
            color: white;
            font-size: 14px;
        }

        @media (max-width: 900px) {

            .nav-wrapper {
                position: relative;
            }

            #btnMenu {
                display: flex;
            }

            /* ESCONDE MENU POR PADRÃO NO CELULAR */
            .menu {
                display: none;
                flex-direction: column;
                background: #0b1b3d;
                width: 100%;
                position: absolute;
                top: 60px;
                left: 0;
                padding: 16px;
                gap: 10px;
                z-index: 99999;
            }

            /* APARECE QUANDO CLICAR NO ☰ */
            .menu.active {
                display: flex;
            }

            .menu-item {
                width: 100%;
                padding: 6px 0;
            }
        }

        @media (max-width: 900px) {

            .menu-item .dropdown {
                position: static;
                width: 100%;
                height: auto;
                box-shadow: none;
                display: none;
                /* fechado por padrão */
                opacity: 1;
                /* <<< MUITO IMPORTANTE */
                visibility: visible;
                /* <<< MUITO IMPORTANTE */
                padding: 10px 0;
            }

            .menu-item.active .dropdown {
                display: block;
                /* aparece quando clicar */
            }
        }
    </style>


    {{-- ------------------------------------------------------------------------ --}}
    {{-- nav bar --}}
    {{-- ------------------------------------------------------------------ --}}
    {{-- Continer box --}}
    <style>
        .container-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            background-color: white;
            margin: -1;

        }

        .item {
            width: calc(33% - 20px);
            height: auto;
            margin: 10px;
            padding: 15px;
            background-color: white;
            overflow: auto;
            /* Impede que o conteúdo transborde */
            font-weight: 500;
        }

        .box {
            display: flex;
            width: 100%;
            height: auto;
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

        hr {
            margin: -5px;
        }

        .box-conteudo {
            margin-left: 2px;
            justify-content: flex-start;
        }

        .titulo {
            display: flex;
            font-size: 25px;
            font-family: 'Poppins', sans-serif;

        }

        .conteudo {
            display: flex;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            color: #007b00;
            margin-bottom: 5px;
        }

        #patrimonio {
            color: #2174d4;
        }

        .input-text {
            margin-top: 5px;
            width: 50%;
            border: none;
            color: #2174d4;
            margin-right: 2px;
        }

        .relatorios-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            /* espaço entre colunas */
            max-width: 1100px;
        }

        .relatorios-grid a {
            color: #0b1b3d;
            text-decoration: none;
            display: block;
            line-height: 1.4;
        }

        #btnMenu {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            font-size: 26px;
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: none;
            /* aparece só no mobile */
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .3s ease;
        }

        /* efeito hover */
        #btnMenu:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* efeito ao clicar */
        #btnMenu:active {
            transform: scale(0.95);
        }

        /* RESPONSIVO - mostra só no celular */
        @media (max-width: 900px) {
            #btnMenu {
                display: flex;
                margin-left: auto;
            }
        }
    </style>

    <nav class="navbar">
        <div class="nav-wrapper">

            <!-- LOGO -->
            <div class="logo">MANWEB</div>

            <button id="btnMenu">☰</button>


            <!-- SEU MENU ORIGINAL (mantido) -->
            <div class="menu" id="menu">

                <div class="menu-item">
                    <a href="#">Home <span class="arrow"><i class="icofont-rounded-down"></i></span></a>
                </div>

                <div class="menu-item">
                    <a href="#">Sobre nós <span class="arrow"><i class="icofont-rounded-down"></i></span></a>

                    <!-- SEU DROPDOWN INTACTO -->
                    <div class="dropdown">
                        <div class="container-box">
                            <div class="item">
                                <div class="titulo">Instituição</div>
                                <div class="conteudo">
                                    <a href="#">história</a>
                                </div>
                            </div>

                            <div class="item">
                                <div class="titulo">Pessoas</div>
                                <div class="conteudo">
                                    <a href="">Nossa equipe</a>
                                </div>
                            </div>

                            <div class="item">
                                <div class="titulo">Sobre</div>
                                <div class="conteudo">
                                    <a href="{{ route('about') }}">Sobre</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <a href="#">Produtos e serviços <span class="arrow"><i
                                class="icofont-rounded-down"></i></span></a>

                    <div class="dropdown">
                        <div class="container-box">

                            <div class="item">
                                <div class="titulo">Produtos</div>
                                <div class="conteudo"><a href="">Produtos</a></div>

                                <div class="titulo">Suporte</div>
                                <div class="conteudo"><a href="#">Suporte</a></div>
                            </div>

                            <div class="item">
                                <div class="titulo">Sistemas de Gestão</div>
                                <div class="conteudo">
                                    @if (Auth::check())
                                        <a href="{{ route('app.home') }}">CMMS ManWEB</a>
                                    @else
                                        <a href="{{ route('login') }}">Login</a>
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="titulo">Consultorias</div>
                                <div class="conteudo">
                                    <a href="{{ route('site.sobre_nos') }}">Consultorias</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <a href="#">Manutenção <span class="arrow"><i class="icofont-rounded-down"></i></span></a>

                    <div class="dropdown">
                        <div class="container-box">

                            <div class="item">
                                <div class="titulo">Normas e Regulamentos</div>
                                <div class="conteudo">
                                    <a href="{{ route('documentos.normas') }}">NRs</a>
                                </div>
                            </div>

                            <div class="item">
                                <div class="titulo">Guias e Procedimentos</div>
                                <div class="conteudo">
                                    <a href="{{ route('manutencao.preventiva') }}">🛠 Preventiva</a><br>
                                    <a href="{{ route('manutencao.corretiva') }}">⚙️ Corretiva</a><br>
                                    <a href="{{ route('manutencao.preditiva') }}">📊 Preditiva</a><br>
                                    <a href="{{ route('manutencao.lubrificacao') }}">💧 Lubrificação</a>
                                </div>
                            </div>

                            <div class="item">
                                <div class="titulo">Relatórios e Estudos</div>

                                <div class="conteudo relatorios-grid">
                                    <div>
                                        <a href="#">Relatórios de</a><br>
                                        <a href="#">Manutenção Realizados</a>
                                    </div>

                                    <div>
                                        <a href="#">Estudos de Confiabilidade de</a><br>
                                        <a href="#">Equipamentos</a>
                                    </div>

                                    <div>
                                        <a href="#">Artigos sobre</a><br>
                                        <a href="#">Gestão de Ativos</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- IDIOMA + BOTÃO (igual ao print) -->
                <span class="idioma">🌐 PT-BR ▾</span>


            </div>
        </div>
    </nav>

    <script>
        function myFunction() {
            var x = document.getElementById("myNavbar");
            if (x.className === "navbar") {
                x.className += " responsive";
            } else {
                x.className = "navbar";
            }
        }
    </script>


    <script>
        document.getElementById("btnMenu").addEventListener("click", function() {
            document.getElementById("menu").classList.toggle("active");
        });

        // Abre/fecha dropdown ao tocar no celular
        document.querySelectorAll(".menu-item > a").forEach(item => {
            item.addEventListener("click", function(e) {

                if (window.innerWidth <= 900) {
                    e.preventDefault();

                    let parent = this.parentElement;
                    parent.classList.toggle("active");

                    document.querySelectorAll(".menu-item").forEach(el => {
                        if (el !== parent) el.classList.remove("active");
                    });
                }
            });
        });
    </script>
    {{-- ---------------------------------------fim nav bar----------------------- --}}

</head>
