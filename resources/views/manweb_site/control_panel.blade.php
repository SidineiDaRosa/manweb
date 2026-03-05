@extends('app.layouts.app')
@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div> Painel de controle</div>

        </div>
        <div id="statusLoop">Carregando status do loop...</div>

        <script>
            console.log('JS está rodando');
            document.getElementById('statusLoop').innerText = 'JS está funcionando!';
        </script>
        <script>
            function atualizarStatusLoop() {
                fetch('{{ route("loop.form") }}')
                    .then(response => response.json())
                    .then(data => {
                        const statusDiv = document.getElementById('statusLoop');
                        if (data.loopAtivo) {
                            statusDiv.innerText = "Loop está ATIVADO";
                            statusDiv.style.color = "blue";
                        } else {
                            statusDiv.innerText = "Loop está DESATIVADO";
                            statusDiv.style.color = "red";
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar status do loop:', error);
                    });
            }

            // Atualiza ao carregar a página
            atualizarStatusLoop();

            // Atualiza a cada 5 segundos
            setInterval(atualizarStatusLoop, 5000);
        </script>
        @if(session('success'))
        <div style="color:green;" hidden>{{ session('success') }}</div> <br>
        @endif

        <form action="{{ route('loop.ativar') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-success btn-bg" style="width: 200px; display: inline-block;">Ativar Loop</button>
        </form><br>

        <form action="{{ route('loop.desativar') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-bg" style="width: 200px; display: inline-block;">Desativar Loop</button>
        </form> <br>
        <div style="background-color: #454d66;">
            #454d66
        </div>
        <div style="background-color: #309975;">
            #454d66
        </div>
        <div style="background-color: #58b368;">
            #58b368
        </div>
        <div style="background-color:#dca63b;">
            #dca63b
        </div>
        <div style="background-color:#efeeb4;">
            #efeeb4
        </div>
        <div style="background-color:#efeeb4;">
            #efeeb4
        </div>
        <!--Atualiza peças pelo botão-->
        @foreach($ordens_servicos as $ordem_servico_r)
        @endforeach
        <a class="btn btn-warning btn-bg" style="width: 200px; display: inline-block;"
            href="{{ route('Peca-equipamento.index', ['equipamento' => $ordem_servico_r->equipamento]) }}">
            Peças equipamentos
            <i class="icofont-search-document"></i>
        </a>
        <a href="{{ route('users.management') }}">Gerenciar Usuários</a>
        <div class="card-body">

            <body onload="checkCookies()">
                <p id="demo"></p>
                <script>
                    let data_atual = new Date();
                    var dia = String(data_atual.getDate()).padStart(2, '0');
                    var mes = String(data_atual.getMonth() + 1).padStart(2, '0');
                    var ano = data_atual.getFullYear();
                    data_atual = ano + '-' + mes + '-' + dia;
                    const element = document.getElementById("demo");
                    setInterval(function() {
                        //element.innerHTML += "Hello"
                        //document.getElementById('busca').click();
                        PegaDataHoraPhp() //executa a função 
                        document.getElementById('timer_interval').value = 0;
                        // btn.addEventListener("click", exibirMensagem);

                    }, 600000);

                    function calcula() {
                        //formata datas pegando ano dias mes e hora
                        let data_inicial3 = document.getElementById('data_inicial').value
                        let data_atual = new Date()
                        let dataInicial = new Date(data_inicial)
                        let ano = dataInicial.getFullYear()
                        let dia = dataInicial.getDate()
                        let hora = dataInicial.getHours()
                        let dia_atual = data_atual.getDate()
                        ///https://www.treinaweb.com.br/blog/trabalhando-com-data-no-javascript?gclid=Cj0KCQiAtvSdBhD0ARIsAPf8oNmQO6WInMUWZ5oZB094L6ktEKAh_wAv4L39MlFsYgtnUIvffNkShuwaAtA4EALw_wcB

                    }
                    setInterval(function() {
                        document.getElementById('timer').value = new Date()
                        let interval = document.getElementById('timer_interval').value
                        interval1 = (interval++)
                        document.getElementById('timer_interval').value = interval1 + 1;
                        //document.getElementById('timer_interval').value = interval1

                    }, 1000);
                </script>
                <style>
                    #timer {
                        height: 50px;
                        width: auto;
                        font-size: 30px;
                        float: right;
                        background: none;
                        border: none;
                    }

                    #timer_interval {
                        height: 50px;
                        width: auto;
                        font-size: 30px;
                        background: none;
                        border: none;

                    }

                    body {
                        background-color: rgb(211, 211, 211);
                    }

                    #spn1 {
                        color: red;
                    }
                </style>
                <!-- Bloco que mostra o timer-->
                <div hidden>
                    <input type="text" id="timer" readonly>
                    <p></p>
                    <h3>Tempo setado em 60s para atualização dos registros</h3>
                    <input type="number" id="timer_interval" readonly>
                    <p></p>
                    <form id="form" action="{{route('control-panel.index')}}" method="get">
                        @method('POST')
                        @csrf
                        <input id="btn1" type="submit" value="get" hidden>
                        <input type="text" value="" id="horas_proxima_manutencao" name="horas_proxima_manutencao" placeholder="Digite o intervalo...">
                        <label for="Data inicial">Data inicial</label>
                        <input type="date" value="" id="data_inicial">
                        <label for="data_final">Data final</label>
                        <input type="date" value="" id="data_final">
                        <select id="categoria" name="categoria">

                            <option value="Lubrificação">Lubrificação</option>
                            <option value="Componente">Componente</option>
                            <option value="mensalidade">mensalidade</option>
                        </select>
                    </form>
                </div>
                <!--fim Bloco que mostra o timer  está desativado-->
                <input hidden type="button" value="Força atualização do intervalo de manutenção" onclick="PegaDataHoraPhp()" class="btn btn-primary btn-bg" style="width: 200px; display: inline-block;">
                <script>
                    function PegaDataHoraPhp() {
                        //document.getElementById('busca').click();
                        document.getElementById('form').submit();
                    }
                </script>
                <hr>
                <style>
                    .divtxt {
                        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        color: blue;
                        font-size: 20px;
                    }
                </style>

            </body>
        </div>
    </div>

</main>
@endsection