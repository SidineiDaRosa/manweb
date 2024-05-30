<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="myProjects/webProject/icofont/css/icofont.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<main class="content">
    <div class="card">
        <div class="card-header-template">

            <form id="formSearchingProducts" action="{{'Produtos-filtro-e-comerce'}}" method="POST">
                @csrf
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">

                        <option value="2">Busca Pelas inicias</option>
                        <option value="1">Busca pelo ID</option>
                        <option value="3">Busca pelo Código do Fabricante</option>
                        <option value="4">Busca por categoria</option>
                        <option value="0">Busca Pelo estoque minimo</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="categoria_id" id="categoria_id" class="form-control">
                        <option value=""> --Selecione a Categoria--</option>
                        @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                        @endforeach
                    </select>
                    {{ $errors->has('categoria_id') ? $errors->first('categoria_id') : '' }}
                </div>
                <!--input box filtro buscar produto--------->

                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search"></i>
                </button>

                <a href="#" class="btn btn-sm btn-primary">

                    <span class="material-symbols-outlined">
                        shopping_cart_checkout
                    </span>

                    Meu carrinho
                </a>
            </form>

            <div>


            </div>
        </div>
    </div>
    <!---estilização do input box buscar produtos---->
    <style>
        .btn-primary {
            color: #fff;
            background-color: #0d6efd;
            border-color: blue;
            margin: 10%;
            transition: 0.5s;


        }

        #tipofiltro.form-control {
            margin: 10px;
            margin-top: 6px;

        }

        .form-control-template {
            margin: 15px;
        }

        .col-md-4 {
            margin: 30px;
            font-size: 18px;
        }

        .card-header-template div {
            color: white;
            margin: 5px;
            font-size: 20px;
            text-align: center;
        }

        .icofont-cart {
            padding: 0px;
            width: 0;
            padding: 10px;
            min-width: 100px;
            max-width: 200px;

        }


        .card-header-template {
            background-color: black;
        }

        .placeholder {
            background-color: white;

        }

        input#query {
            background-color: rgb(211, 211, 211);
            border-radius: 10px;
            padding: 2px;
            min-width: 600px;
            max-width: 2000px;
            margin:5%;
            border-color: black;

        }



        #formSearchingProducts {
            background-color: black;
            width: 900px;
            height: 44px;
            border-radius: 20px;
            display: flex;
            flex-direction: row;
            align-items: center;
            font-size: 15px;
            margin: 20px;
        }

        input {
            all: unset;
            font: 15px system-ui;
            color: black;
            height: 100%;
            width: 100%;
            padding: 6px 10px;
            font-family: 'Oswald', sans-serif;
        }

        ::placeholder {
            color: black;
            opacity: 0.9;
            font-family: 'Oswald', sans-serif;
            font: 20px system-ui;
        }


        button {
            all: unset;
            cursor: pointer;
            width: 44px;
            height: 44px;
            background-color: white;
        }

        a {
            color: black;
            text-decoration: underline;
            text-decoration: none;
            font-size: 18px;

        }
    </style>
    <!-------------------------------------------------------------------------->
    <!--Criando um modelo com divs para que ao executar a query, estes venha dentro de uma div,-->
    <!--mostrando os produtos dentro delas e coms suas respectivas descrições-->
    <div class="card-body">
        @foreach ($produtos as $produto)
        <div id="div-card-parts">
            <div id="div-card-parts-children">

                <div class="continer-img">
                    <img src="/img/produtos/{{ $produto->image}}" alt="imagem" class="preview-image" onclick="ActionSuibmitformGoProduct();" >

                </div>
                <div id="continer-description-parts">
                    <p></p>
                    <h4>Código:{{ $produto->cod_fabricante }}</h4>
                    <ul>
                        <li>{{ $produto->nome }}</li>
                        <li> {{ $produto->descricao }}</li>
                    </ul>
                    <form id="formGoProduct" action="{{'comerce-show-produto'}}" method="POST">
                        @csrf
                        <input type="submit" value="VER" onclick="ActionSuibmitformGoProduct()">
                        <input type="number" value="{{ $produto->id }}" name="idProduto" hidden>
                        <script>
                            function ActionSuibmitformGoProduct() {
                                //document.getElementById('busca').click();
                                document.getElementById('formGoProduct').submit();
                            }
                        </script>
                    </form>
                </div>
            </div>
            <hr>
        </div>

        <style>
            .preview-image {
                width: 150px;
                height: 150px;
                object-fit: cover;
                margin: 0 5px;
                cursor: pointer;
            }

            #submit_ver {
                cursor: pointer;
                width: 20px;
                transition: 0.5s;
                color: white;
            }


            .div-op {
                width: 20px;

            }



            .card-body {
                display: flex;
                flex-direction: column;
                align-items: center;
                background-color: rgb(233, 233, 233);
            }

            #div-card-parts {
                height: auto;
                width: 50%;
                background-color: transparent;
                display: flex;
                flex-direction: column;
                padding: 10px;
                margin-left: 15%;

            }

            .continer-img {
                display: flex;
                float: left;
            }

            #continer-description-parts {
                display: flex;
                float: right;
                padding: 10px;
            }

            #div-card-parts-children {
                display: flex;
                float: right;
                flex-direction: row;
            }

            li {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                font-size: 20px;
                font-weight: 200;
                font-style: normal;
                color: black;
            }
        </style>
        @endforeach
    </div>

    </div>


    </div>
</main>

</html>