@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Área de Gerenciamento de Usuários</h2>

        <!-- Link para login -->
        <p><a href="{{ route('login') }}">Login</a></p>

        <!-- Link para registro -->
        <p><a href="{{ route('register') }}">Registrar</a></p>

        <!-- Link para pedido de reset de senha (Esqueci a senha) -->
        <p><a href="{{ route('password.request') }}">Esqueci minha senha</a></p>

        <!-- Link para logout (via form POST) -->
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-danger mt-2">Sair</button>
        </form>
    </div>
@endsection
