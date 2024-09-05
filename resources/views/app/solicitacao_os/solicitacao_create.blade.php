<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <title>Document</title>
</head>

<body>

    <!-- Incluindo o JavaScript do Bootstrap -->

    <style>
        body {
            justify-content: center;
            text-align: center;
        }
    </style>
    <div style="display: flex; justify-content: center; align-items: flex-start; height:auto; margin-top:-20px;">
        <img src="{{ asset('img/logo_fapolpa.jpeg') }}" alt="Logo Fapolpa" style="width:200px;height:100px">
    </div>
    <div style="display: flex; justify-content: center; align-items: flex-start;margin-top:-1px;background-color:antiquewhite;">
        <h5 style="font-size:25px;font-family:'Arial', Times, serif;color:darkgrey;font-weight:300;margin-top:1px;">Solicitação de serviço</h5>
    </div>

    <form action="{{ route('solicitacao-os.store') }}" method="post">
        @csrf
        <input type="datetime-local" class="form-control-template" name="datatime" id="datatime" style="width:250px;height:30px;font-size:20px;" readonly> <br>
        <select class="form-control-template" name="emissor" id="emissor" style="width:250px;height:30px;font-size:15px;" required>
            <option value="">--Selecione o emissor</option>
            @foreach ($funcionarios as $funcionario)
            <option value="{{ $funcionario->id }}">
                {{ $funcionario->id }} - {{ $funcionario->primeiro_nome }}
            </option>
            @endforeach
        </select> <br>
        <textarea name="descricao" id="" rows="5" cols="50" style="font-size:18px;margin:5px; width:auto;" minlength="100" required></textarea> <br>
        <button type="submit" class="btn btn-primary" style="width: 30%;">Enviar solicitação</button>
    </form>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Função para obter a data e hora em São Paulo
        function getSaoPauloDateTime() {
            // Hora de São Paulo está no fuso horário GMT-3
            const saoPauloOffset = -3; // Horário de São Paulo em relação ao GMT
            const now = new Date();
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const saoPauloTime = new Date(utc + (3600000 * saoPauloOffset));
            const year = saoPauloTime.getFullYear();
            const month = String(saoPauloTime.getMonth() + 1).padStart(2, '0');
            const day = String(saoPauloTime.getDate()).padStart(2, '0');
            const hours = String(saoPauloTime.getHours()).padStart(2, '0');
            const minutes = String(saoPauloTime.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        // Definindo o valor do campo de data e hora para o horário de São Paulo
        const datetimeInput = document.getElementById('datatime');
        datetimeInput.value = getSaoPauloDateTime();
    });
</script>
</html: