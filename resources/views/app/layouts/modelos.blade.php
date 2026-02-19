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

    <div class="card-inf-sm">
        <div class="card-inf-header">
            <span class="card-title">OS</span>
            <div class="card-inf-ico">
                <i class="bi bi-gear" style="font-size:12px;"></i>
            </div>
        </div>

        <div class="card-data">12</div>
        <div class="card-description">Abertas</div>
    </div>


    <!--Mesagem de confirmação de verificação da APR-->
    @if(session('success'))
    <div class="alert alert-success custom-alert position-relative">
        {!! session('success') !!}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;">
            &times;
        </button>
    </div>
    @endif
    <script>
        function recarrega() {
            window.location.reload();
        }
    </script>

    @if(session('error'))
    <div class="alert alert-danger custom-alert d-flex align-items-start gap-2 position-relative">
        <!-- Ícone de alerta -->
        <i class="bi bi-exclamation-triangle-fill fs-4 mt-1"></i>

        <!-- Mensagem -->
        <div class="flex-fill">
            <strong>Existem pendências na análise:</strong>
            <ul class="mb-0 mt-1" style="padding-left:20px;">
                @foreach(explode('<br>➤ ', session('error')) as $item)
                @if(str_contains($item, 'Medida:'))
                <li style="color:wite;">{{ $item }}</li>
                @else
                <li style="color:red; font-weight:400;">{{ $item }}</li>
                @endif
                @endforeach
            </ul>
        </div>
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;"> &times; </button>
    </div>
    @endif
</main>