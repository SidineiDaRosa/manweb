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
            document.getElementById('busca').click();
            document.getElementById('timer_interval').value = 0;
            // btn.addEventListener("click", exibirMensagem);

        }, 60000);

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
    </style>
    <input type="text" id="timer" readonly>
    <p></p>
    <h3>Tempo setado em 60s para atualização dos registros</h3>
    <input type="number" id="timer_interval" readonly>
    <p></p>
    <form id="form" action="{{route('control-panel.index')}}" method="get">
        @method('POST')
        @csrf
        <input id="btn1" type="submit" value="get">
        <input type="text" value="" id="horas_proxima_manutencao" placeholder="Digite o intervalo...">
        <label for="Data inicial">Data inicial</label>
        <input type="date" value="" id="data_inicial">
        <label for="data_final">Data final</label>
        <input type="date" value="" id="data_final">
    </form>
    <input type="button" value="Força atualização do intervalo de manutenção" onclick="PegaDataHoraPhp()">
    <script>
        function PegaDataHoraPhp() {
            document.getElementById('busca').click();
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
    @foreach($equipamento as $equipamento_f)
    @endforeach"
    <table class="table-template table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col" class="th-title">Id</th>
                <th scope="col" class="th-title">Data programada</th>
                <th scope="col" class="th-title">Produto</th>
                <th scope="col" class="th-title">Equipamento</th>
                <th scope="col" class="th-title">Intervalo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordens_servicos as $ordem_servico_f)
            <tr>
                <th scope="row"> {{$ordem_servico_f->id}}</td>
                <td>{{ $ordem_servico_f->data_proxima_manutencao}}</td>
                <td>{{ $ordem_servico_f->produto_id->descricao}}</td>
                <td>{{$equipamento_f['nome']}}</td>
                <td>{{ $ordem_servico_f->equipamento}}</td>
                <td>{{ $ordem_servico_f->intervalo_manutencao}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>