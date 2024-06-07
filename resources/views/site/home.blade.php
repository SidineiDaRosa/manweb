<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            background-color:white;
        }

        .menu-item {
            background: transparent;
            color: black;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block;
        }

        .dropdown {
        top: 100px;
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
        z-index: 9999; /* Garantir que o dropdown fique por cima de tudo */
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

        /*=====================================================*/
        #myNavbar {
            display: flex;
            text-align: center;
            width: 50%;
            margin: 1%;
        }

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
</head>

<body>

    {{----------------------------------------------------------------------------}}
    {{--nav bar--}}

    <nav class="navbar">
        <div class="menu" id="menu">
            <div class="menu-item">
                <a href="#">Home</a>
            </div>
            <div class="menu-item">
                <a href="#">Sobre nós</a>
                <div class="dropdown">
                    <a href="#">Nossa história</a>
                    <hr>
                    <a href="#">Nossa equipe</a>
                    <hr>
                    <a href="#">Nossa missão</a>
                </div>
            </div>
            <div class="menu-item">
                <a href="#">Produtos e serviços</a>
                <div class="dropdown">
                    <a href="#">Consultorias</a>
                    <hr>
                    <a href="#">Vendas</a>
                    <hr>
                    <a href="#">Suporte</a>
                    <hr>
                    <a href="{{'e-comerce-show-produto'}}">Produtos</a>
                    <hr>
                    <a href="{{ route('app.home') }}" class="title-menu" caption="erp" >ERP ManWEB</a>
                </div>
            </div>
            <div class="menu-item">
                <a href="#">Contato</a>
                <div class="dropdown">
                    <a href="#">Email Us</a>
                    <hr>
                    <a href="#">Onde estamos</a>
                </div>
            </div>
        </div>
    </nav>
    {{-----------------------------------------fim nav bar-------------------------}}
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

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/apresentacao/industria.mp4') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <div class="carousel-item">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/video5.mp4') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <div class="carousel-item">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/apresentacao/video1.mp4') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <!--Div imagem fosca-->
            <div id="overlay"></div>
            <div class="carousel-caption">
                <h1>ManWeb</h1>
                Sistema para gestão de manutenção.
                <input type="button" value="saber mais...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--inicio do rodapé da pagina-->
    <footer>
        <div>
            <style>
                footer {
                    text-align: center;
                    width: 100%;
                }

                .title-footer {
                    color: black;
                    margin: 10px;
                }
            </style>
            <a href="#" class="title-footer">HOME</a>|
            <a href="{{'e-comerce-show-produto'}}" class="title-footer">PRODUTOS</a>|
            <a href="#" class="title-footer">SOBRE NÓS</a>|
            <a href="#" class="title-footer">DOWNLOADS</a>
            <a href="#" class="title-footer">Webmail</a>
        </div>
    </footer>
</body>

</html>