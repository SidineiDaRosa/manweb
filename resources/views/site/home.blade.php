<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .navbar {
            background-color: #333;
            overflow: hidden;
            width: 100%;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar a.active {
            background-color: #04AA6D;
            color: white;
        }

        .navbar .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .navbar a:not(:first-child) {
                display: none;
            }

            .navbar a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .navbar.responsive {
                position: relative;
            }

            .navbar.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }

            .navbar.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        #myNavbar {
            display: flex;
            text-align: center;
            width: 50%;
            margin: 1%;

        }

    </style>

<body>
    </head>

        <div class="navbar" id="myNavbar">
            <a href="" class="title-menu">Home</a>
            <a href="{{'e-comerce-show-produto'}}">PRODUTOS</a>
            <a href="{{ route('app.home') }}" class="title-menu">MANTENÇÃO</a>
            <a href="#" class="title-menu">SOBRE NÓS</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                &#9776;
            </a>
        </div>
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

    <style>
        .carousel-item img {
            max-height: 300px;
            /* Ajuste a altura conforme necessário */
            width: 100%;
            object-fit: cover;
        }

        .carousel-caption {
            margin-bottom: 300px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
        }
    </style>

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <video autoplay muted loop>
                    <source src="{{ asset('img/video6.mp4') }}" type="video/mp4" class="d-block w-100" alt="...">
                </video>
            </div>
            <div class="carousel-item">
                <video autoplay muted loop>
                    <source src="{{ asset('img/video5.mp4') }}" type="video/mp4" class="d-block w-100" alt="...">

            </div>

            <div class="carousel-item">
                <video autoplay muted loop>
                    <source src="{{ asset('img/video1.mp4') }}" type="video/mp4" class="d-block w-100" alt="...">
                </video>
            </div>
            <div class="carousel-caption">
                <h1>Manutenção industrial</h1>
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
</body>
<footer>
    <!--inicio do rodapé da pagina-->
    <div>
        <style>
            footer {
                text-align: center;
                width: 100%;
            }

            .title-footer {
                color: black;
                margin: 1%;
            }
        </style>
        <a href="#" class="title-footer">HOME</a>|
        <a href="{{'e-comerce-show-produto'}}" class="title-footer">PRODUTOS</a>|
        <a href="#" class="title-footer">SOBRE NÓS</a>|
        <a href="#" class="title-footer">DOWNLOADS</a>
        <a href="#" class="title-footer">Webmail</a>
    </div>
</footer>

</html>