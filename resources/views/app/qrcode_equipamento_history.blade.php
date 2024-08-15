<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar QR Code</title>
    <style>
        /* Estilos para centralizar o conteúdo */
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .card-body {
            margin-bottom: 20px;
        }

        a,
        button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a:hover,
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        @foreach($dados_id as $dados_id_f)
        @endforeach
        Dados:{{$dados_id->nome}}
        <div class="card-body">
            {!! QrCode::size(300)->backgroundColor(255,255,255)->generate($qrCode) !!}
        </div>
    </div>
</body>

</html>