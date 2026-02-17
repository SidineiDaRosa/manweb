@extends('app.layouts.app')

@section('content')
<main class="content">

    <!-- ============================= -->
    <!-- 🔹 TAMANHO PADRÃO (BG) -->
    <!-- ============================= -->

    <button class="btn-inf btn-inf-warning">Warning</button>
    <button class="btn-inf btn-inf-orange">Orange</button>
    <button class="btn-inf btn-inf-green">Green</button>
    <button class="btn-inf btn-inf-blue-light">Blue Light</button>
    <button class="btn-inf btn-inf-blue-dark">Blue Dark</button>
    <button class="btn-inf btn-inf-purple">Purple</button>
    <button class="btn-inf btn-inf-red">Red</button>
    <button class="btn-inf btn-inf-gray">Gray</button>
    <button class="btn-inf btn-inf-brown">Brown</button>

    <br><br>

    <!-- ============================= -->
    <!-- 🔹 TAMANHO MD -->
    <!-- ============================= -->

    <button class="btn-inf btn-inf-md btn-inf-warning">Warning MD</button>
    <button class="btn-inf btn-inf-md btn-inf-orange">Orange MD</button>
    <button class="btn-inf btn-inf-md btn-inf-green">Green MD</button>
    <button class="btn-inf btn-inf-md btn-inf-blue-light">Blue Light MD</button>
    <button class="btn-inf btn-inf-md btn-inf-blue-dark">Blue Dark MD</button>
    <button class="btn-inf btn-inf-md btn-inf-purple">Purple MD</button>
    <button class="btn-inf btn-inf-md btn-inf-red">Red MD</button>
    <button class="btn-inf btn-inf-md btn-inf-gray">Gray MD</button>
    <button class="btn-inf btn-inf-md btn-inf-brown">Brown MD</button>

    <br><br>

    <!-- ============================= -->
    <!-- 🔹 TAMANHO SM -->
    <!-- ============================= -->

    <button class="btn-inf btn-inf-sm btn-inf-warning">Warning SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-orange">Orange SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-green">Green SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-blue-light">Blue Light SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-blue-dark">Blue Dark SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-purple">Purple SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-red">Red SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-gray">Gray SM</button>
    <button class="btn-inf btn-inf-sm btn-inf-brown">Brown SM</button>

    <style>
        .card-inf-md {
            width: 250px;
            aspect-ratio: 2 / 1;
            box-sizing: border-box;
            background: #ffffff;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            border: 1px solid rgba(189, 194, 197, 0.3);
            border-radius: 14px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            /* 🔥 alterado */
            gap: 6px;
            /* 🔥 controla o espaço */
        }

        .card-inf-md:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
        }

        /* HEADER */
        .card-inf-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* TITLE */
        .card-title {
            font-size: 15px;
            font-weight: 600;
            color: #8a9099;
            letter-spacing: 0.5px;
        }

        /* ICON */
        .card-inf-ico {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(138, 43, 226, 0.1);
            padding: 8px;
            border-radius: 12px;
        }

        /* NUMBER */
        .card-data {
            font-size: 32px;
            font-weight: 700;
            color: #2f2f2f;
            margin-top: 10px;
        }

        /* DESCRIPTION */
        .card-description {
            font-size: 14px;
            color: rgba(85, 79, 79, 0.7);
            margin-top: 4px;
        }
    </style>

    <div class="card-inf-md">

        <div class="card-inf-header">
            <div class="card-title">
                Total de Alertas
            </div>

            <div class="card-inf-ico">
                <i class="bi bi-exclamation-triangle" style="font-size: 22px; color:blueviolet;"></i>
            </div>
        </div>

        <div class="card-data">
            23.456
        </div>

        <div class="card-description">
            9 dados obtidos hoje
        </div>

    </div>




</main>