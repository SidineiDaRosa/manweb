<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Grupos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            text-align: center;
        }

        .group {
            padding: 15px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .group a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .group a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<form action="{{ route('groups.store') }}" method="POST" aria-label="Formulário de criação de grupo" style="margin-bottom: 20px;">
    @csrf
    <input type="text" name="name" placeholder="Nome do grupo" required style="padding: 10px; font-size: 1rem; border-radius: 5px; border: 1px solid #ccc; width: 70%;">
    <input type="text" name="description" placeholder="Descrição (opcional)" style="padding: 10px; font-size: 1rem; border-radius: 5px; border: 1px solid #ccc; width: 70%; margin-top: 10px;">
    <button type="submit" style="background-color: #007bff; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer; margin-top: 10px;">
        Criar Grupo
    </button>
</form>
@if(isset($group))
<form action="{{ route('groups.attachUsers', $group->id) }}" method="POST">
    ...
</form>
@else
<p>Nenhum grupo selecionado para anexar usuários.</p>
@endif

<body>

    <h1>Grupos Cadastrados</h1>

    @foreach($groups as $group)
    <div class="group">
        <h2>{{ $group->name }}</h2>
        <p>{{ $group->description }}</p>
        <a href="{{ route('groups.show', $group->id) }}">Ver detalhes</a>
        <hr>
        <a href="{{ route('blog.painel', ['group_id' => $group->id]) }}">Chat
            &nbsp; <i class="icofont-wechat"></i>
        </a>

    </div>
    @endforeach

</body>

</html>