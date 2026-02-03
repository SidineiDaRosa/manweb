<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/comum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ===== BODY ===== */
        body {
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: url("{{ asset('images/telas.png') }}") no-repeat center right;
            background-size: cover;
        }

        /* ===== PAINEL BRANCO FIXO ===== */
        .form-login {
            position: fixed;
            top: 0;
            right: 0;
            width: 600px;
            height: 100vh;
            background: #ffffff;
            padding: 60px 40px;
            display: flex;
            border-radius: 20px;
            align-items: center;
            z-index: 10;
        }

        /* ===== CARD ===== */
        .login-card {
            width: 100%;
            border: none;
            box-shadow: none;
        }

        /* ===== HEADER ===== */
        .login-card .card-header {
            background: none;
            border: none;
            padding: 0;
            margin-bottom: 40px;
        }

        .login-card .card-header i {
            font-size: 1.9rem;
            color: #3b7a58;
            display: block;
            margin-bottom: 10px;
        }

        .login-card .card-header span {
            font-size: 1.9rem;
            font-weight: 700;
            color: #45474d;
        }

        /* ===== BODY ===== */
        .login-card .card-body {
            padding: 0;
        }

        /* ===== LABELS ===== */
        .login-card label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 6px;
        }

        /* ===== INPUT ===== */
        .login-card .form-control {
            height: 48px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 0.95rem;
        }

        .login-card .form-control:focus {
            border-color: #40755f;
            box-shadow: 0 0 0 3px rgba(10, 102, 255, 0.15);
        }

        /* ===== CHECKBOX ===== */
        .form-check {
            margin-top: 18px;
        }

        .form-check-label {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* ===== FOOTER ===== */
        .login-card .card-footer {
            background: none;
            border: none;
            padding: 30px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ===== BOTÃO ===== */
        .login-card .btn-primary {
            background: #28804c;
            border: none;
            border-radius: 6px;
            padding: 11px 26px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .login-card .btn-primary:hover {
            background: #307754;
        }

        /* ===== LINK ===== */
        .login-card .btn-link {
            font-size: 0.75rem;
            color: #357258;
            padding: 0;
        }

        /* ===== RESPONSIVO ===== */
        @media (max-width: 900px) {
            body {
                background-position: center;
            }

            .form-login {
                position: relative;
                width: 100%;
                height: auto;
                padding: 40px 25px;
            }
        }

        .login-card .card-header span .titulo1 {
            color: rgb(47, 160, 98);
        }
        p{
            color: gray;
            font-size: 17px;
        }
    </style>
    <title>Manutenção fapolpa- Login</title>
</head>

<body>

    <form action="{{ route('login') }}" method="POST" class="form-login">
        @csrf
        <div class="login-card card">
            <div class="card-header">


                <i class="fa-solid fa-user-helmet-safety"></i>
                <span class="font-wheight-light">MAN<span class="titulo1">WEB</span></span>
            </div>
            <p>Bem vindo ao login.</p>
            <div class="card-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control "
                        placeholder="Informe seu e-mail" autofocus value="">
                    <div class="invalid-feedback">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Informe sua senha">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Mantenha-me Conectado') }}
                        </label>

                    </div>

                    <div class="card-footer">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Esqueceu a senha?') }}
                            </a>
                        @endif
                        <button class="btn btn-lg btn-primary">Entrar</button>
                    </div>

                </div>

    </form>


</body>

</html>
