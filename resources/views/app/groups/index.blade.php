@extends('app.layouts.app')
@section('content')

<style>
   
    h1,
    h2,
    h4 {
        margin: 0.5em 0;
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

    /* Responsivo para telas pequenas (celular) */
    @media (max-width: 900px) {
        body {
            font-size: 18px;
            /* aumenta a fonte no celular para melhor leitura */
            max-width: 100%;
            /* largura total */
            margin: 20px 10px;
            padding: 0 10px;
        }

        .group {
            padding: 10px;
            margin-bottom: 15px;
        }

        input[type="text"],
        button {
            width: 100% !important;
            /* faz inputs e botão ocuparem toda a largura disponível */
            font-size: 1.2rem;
            padding: 12px;
        }
    }
</style>
<main class="content">
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

@endif


<h4> Grupos</h4>

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
<main>