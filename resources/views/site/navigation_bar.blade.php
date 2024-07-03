<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            align-items: center;
            background-color: #333;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: white;
        }

        .menu-item {
            background: transparent;
            color: black;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block;
        }

        .menu-item:hover {}

        .dropdown {
            top: 60px;
            left: 0;
            background: #fff;
            color: black;
            padding: 10px;
            width: 100vw;
            height: 400px;
            position: absolute;
            box-shadow: 0 8px 16px rgba(10, 8, 8, 0.2);
            opacity: 0;
            visibility: hidden;
            transition: visibility 0s linear 0.5s, opacity 0.5s linear 0s;
            z-index: 9999;
            /* Garantir que o dropdown fique por cima de tudo */

        }

        .menu-item:hover .dropdown {
            opacity: 1;
            visibility: visible;
            transition: visibility 0s linear 0s, opacity 0.5s linear 0s;

        }

        @media (max-width: 800px) {
            .menu {
                display: flex;
                flex-direction: column;
                width: 30%;
                margin: 5px;
                border: 1px chocolate;
            }

            .menu-item {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
        }

        .div-menu-item-column {}

        /*=====================================================*/
        .carousel-item {
            height: 100vh;
            /* Definindo a altura da div do carrossel como 100% da altura da viewport */
        }

        .carousel-item video {
            height: 100%;
            /* O vídeo ocupa 100% da altura da div do carrossel */
            width: 100%;
            /* O vídeo ocupa 100% da largura da div do carrossel */
            object-fit: cover;
            /* O vídeo será redimensionado para preencher a área do contêiner, mantendo a proporção */
        }
    </style>


    {{----------------------------------------------------------------------------}}
    {{--nav bar--}}
    {{----------------------------------------------------------------------}}
    {{--Continer box--}}
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
    </style>
    <nav class="navbar">
        <div class="menu" id="menu">
            <div class="menu-item">
                <a href="#">Home</a>
            </div>
            <div class="menu-item">
                <a href="#">Sobre nós</a>
                <div class="dropdown">
                    {{--------------Início continer box----------------------------------------}}
                    <div class="container-box">
                        {{--Box 1--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Instituição</div>
                                <div class="conteudo">
                                    <a href="#">história</a>
                                </div>
                            </div>
                        </div>
                        {{--Box 2--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Pessoas</div>
                                <div class="conteudo">
                                    <a href="">Nossa equipe</a>
                                </div>
                            </div>
                        </div>
                        {{--Box 3--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Sobre</div>
                                <div class="conteudo">
                                <a href="#">Sobre nós</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--------------fim continer box----------------------------------------}}
                </div>

            </div>
            <div class="menu-item">
                <a href="#">Produtos e serviços</a>
                <div class="dropdown">
                    {{--------------Início continer box----------------------------------------}}
                    <div class="container-box">
                        {{--Box 1--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Produtos</div>
                                <p></p>
                                <div class="conteudo">
                                    <a href="">Produtos</a>
                                </div>
                                <div class="titulo">Suporte</div>
                                <p></p>

                                <div class="conteudo">
                                    <a href="#">Suporte</a>
                                </div>
                            </div>
                        </div>
                        {{--Box 2--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Sistemas de Gestão</div>
                                <p></p>
                                <div class="conteudo">
                                    <a href="{{ route('app.home') }}" class="title-menu" caption="erp">Acesso ERP ManWEB</a>
                                </div>
                            </div>
                        </div>
                        {{--Box 3--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Consultorias</div>
                                <p></p>

                                <div class="conteudo">
                                    <a href="{{ route('site.sobre_nos') }}">Consultorias</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--------------fim continer box----------------------------------------}}
                </div>
            </div>
            <div class="menu-item">
                <a href="#">Contato</a>
                <div class="dropdown">
                    {{--------------Início continer box----------------------------------------}}
                    <div class="container-box">
                        {{--Box 1--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Localização Da Empresa</div>
                                <p></p>

                                <div class="conteudo">
                                    <span class="material-symbols-outlined">
                                        location_on
                                    </span>
                                    localização da Empresa
                                </div>
                            </div>
                        </div>
                        {{--Box 2--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Aqui história da empresa</div>
                                <p></p>
                                <div class="conteudo">
                                Aqui história da empresa
                                </div>
                            </div>
                        </div>
                        {{--Box 3--}}
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">Notícias</div>
                                <p></p>

                                <div class="conteudo">
                                    Revistas e lançamentos de produtos
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--------------fim continer box----------------------------------------}}
                </div>
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
    {{-----------------------------------------fim nav bar-------------------------}}

</head>