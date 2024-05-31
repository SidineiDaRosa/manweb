<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/comum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('img') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>&#x1F4F7; Título da Página</title>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <!---------------------------------------------------------->
    <script src="https://kit.fontawesome.com/6dda5f6271.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.flaticon.com/br/icones">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overlock+SC&family=Teko:wght@500&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
</head>
<div id="div-topbar">
    <header>
        <div class="container">
            <div class="menu">
                <a href="" class="title-menu">HOME</a>
                <a href="{{'e-comerce-show-produto'}}" class="title-menu">PRODUTOS & SERVIÇOS</a>
                <a href="{{ route('app.home') }}" class="title-menu">MANUWEB</a>
                <a href="https://webmail.manuweb.com.br/?_task=logout&_token=4m0BgjeEKoTjDuHVj7+FrWw8UTaffSeOHlw8MKJFMy4" class="title-menu">Webmail</a>
                <a href="{{ route('site.about') }}" class="title-menu">SOBRE NÓS</a>
                <style>
                    #div-topbar {
                        position: relative;
                        display: flex;
                        flex-direction: row;
                        height: 100px;
                        width: 100%;
                        background-color:black;
                    }

                    .container {
                        display: flex;
                        flex-direction: row;
                        width: 100%;
                        margin-top: 20PX;
                    }

                    .menu {
                        width: 100%;


                    }

                    .title-menu {
                        margin: 5px;
                        text-decoration: none;
                        color: white;

                    }

                    .logo,
                    .sociais {
                        border-radius: 20px;
                        font-family: 'Roboto Mono', monospace;

                    }

                    .sociais button {
                        background-color: rgb(255, 255, 255);
                        border-radius: 20px;
                        border-color: black;
                        padding: 10px;
                        text-align: center;
                    }

                    a.title-menu {
                        margin: 5%;

                    }
                </style>
            </div>
            <div class="sociais">
                <button>criar conta</button>
            </div>
        </div>
    </header>

</div>

<body id="body-home">
    <!----------------------------------------------------------------------------------------->
    <div id="carousel-example-generic" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel-example-generic" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carousel-example-generic" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carousel-example-generic" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <div class="btn-wrap">
            </div>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">

                <!--img src="img1.jpg" class="d-block w-100" alt="First slide-->
                <video autoplay muted loop>
                    <source src="{{ asset('img/video6.mp4') }}" type="video/mp4" class="d-block w-100" alt="...">
                </video>
                <div class="content">
                </div>
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
            <div class="carousel-caption d-none d-md-block">
                <h1>INVESTIMENTO E CONHECIMENTO!</h1>
            </div>
            <button class="carousel-control-prev" data-bs-target="#carousel-example-generic" type="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" data-bs-target="#carousel-example-generic" type="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>
        <!--fim-->

        <script src="../Carousel_dinamic/bootstrap-5.3.2/dist/js/bootstrap.bundle.js">
        </script>

        <script>
            let t0
            let t1
            const carousel = document.getElementById('carousel-example-generic')

            // Test to show that the carousel doesn't slide when the current tab isn't visible
            // Test to show that transition-duration can be changed with css
            carousel.addEventListener('slid.bs.carousel', event => {
                t1 = performance.now()
                console.log(`transition-duration took ${t1 - t0}ms, slid at ${event.timeStamp}`)
            })
            carousel.addEventListener('slide.bs.carousel', () => {
                t0 = performance.now()
            })
        </script>
        </head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>

</body>
<style>
    /*Configurações da div de fundo*/
    #div-body {
        height: 700px;
        width: 100%;
        background-image: url("{{ asset('img/automação-industrial-1.jpg') }}");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        background-attachment: fixed;
        text-align: center;


    }

    footer {

        height: 300px;
        position: relative;

    }

    #footer_main {
        display: flex;
        flex-direction: row;
        height: auto;
        background-color: rgb(235, 227, 227);
        position: relative;
        align-items: center;
        text-align: center;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
    }

    .divt {
        height: 200px;
        width: 30%;
        margin: 1%;
        background-color: rgb(119, 147, 172);
        position: relative;
    }

    @media only screen and (max-width: 600px) {}

    body {
        background-color: lightblue;


    }

    #div-topbar {
        display: flex;
        flex-direction: column;
        height: 100px;
        width: 100%;
        background-color: blueviolet;
    }

    #footer_main {
        display: flex;
        flex-direction: column;
        height: auto;
        background-color: rgb(245, 235, 235);
        position: relative;

    }

    .divt {
        height: 200px;
        width: 100%;
        padding: 10px;
        background-color: rgb(149, 175, 197);
        position: relative;
    }

    /*---------------------------------------------------*/
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500&display=swap');

    body {
        margin: 0;
        padding: 0;
        background-color: white;

    }

    /*carousel*/
    #carousel-example-generic {
        margin-block-end: 5%;

    }

    .carousel-item {
        min-height: 100px;
        max-height: 750px;

    }

    h1 {
        font-family: 'Rubik', sans-serif;
        min-height: 330px;
        max-height: 750px;
    }

    /*titulo*/
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;

    }

    .menu nav a {
        color: aliceblue;
        text-decoration: none;
        padding-right: 30px;
        font-size: 18px;
    }

    .elementos p {
        font-size: 90px;
        text-align: center;
        font-family: 'Roboto Mono', monospace;
    }

    .elementos h1 {
        text-align: center;

    }
</style>
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
        <a href="{{'e-comerce-show-produto'}}" class="title-footer">PRODUTOS & SERVIÇOS</a>|
        <a href="{{ route('site.about') }}" class="title-footer">SOBRE NÓS</a>|
        <a href="#" class="title-footer">DOWNLOADS</a>
        <a href="https://webmail.sysman8.com.br/?_task=logout&_token=4m0BgjeEKoTjDuHVj7+FrWw8UTaffSeOHlw8MKJFMy4" class="title-footer">Webmail</a>
        <a href="" class="title-menu"> <i class="icofont-home icofont-2x"></i>HOME</a>
    </div>
</footer>