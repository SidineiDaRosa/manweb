<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção Fapolpa</title>
    <style>
        body {
            background-image: url('{{ asset("img/logo_fapolpa.png") }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            background-color: #f0f2f5;
            height: 50vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 30px;
            color: #0d6efd;
        }

        a {
            text-decoration: none;
            padding: 12px 25px;
            background-color: #0d6efd;
            color: white;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <h1>Manutenção Fapolpa</h1>
    @if (Auth::check())
        <a href="{{ route('app.home') }}">Acessar</a>
    @else
        <a href="{{ route('login') }}">Login</a>
    @endif
</body>
</html>
