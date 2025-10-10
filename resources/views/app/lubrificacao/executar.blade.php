<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar Lubrificação</title>
    <style>
        body {
            background-color: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .form-container h2 {
            margin-bottom: 5px;
            color: #0d6efd;
        }

        .form-container h3 {
            margin-bottom: 25px;
            color: #495057;
            font-weight: 400;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-submit {
            background: linear-gradient(90deg, #0d6efd, #0b5ed7);
            color: #fff;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            padding: 10px 0;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(90deg, #0b5ed7, #0a58ca);
        }

        .mb-3 {
            margin-bottom: 20px !important;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Iniciar Lubrificação</h2>
        <h3>{{ $equipamento->nome }}</h3>

        <form action="{{ route('open.lubrificacao', ['equipamento' => $equipamento->id]) }}" method="POST">
            @csrf

            <!-- Envia todos os dados do equipamento como hidden inputs -->
            <input type="hidden" name="equipamento_id" value="{{ $equipamento->id }}">
            <input type="hidden" name="nome" value="{{ $equipamento->nome }}">
            <input type="hidden" name="modelo" value="{{ $equipamento->modelo ?? '' }}">
            <input type="hidden" name="patrimonio" value="{{ $equipamento->patrimonio ?? '' }}">
            <!-- Adicione outros campos que quiser enviar -->

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="number" id="password" name="password" class="form-control"
                    placeholder="Digite sua senha" required>
            </div>

            <div class="mb-3">
                <label for="funcionario_id" class="form-label">Funcionário</label>
                <select name="funcionario_id" id="funcionario_id" class="form-select" required>
                    <option value="">Selecione um funcionário</option>
                    @foreach($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}"
                        {{ old('funcionario_id', $selecionado ?? '') == $funcionario->id ? 'selected' : '' }}>
                        {{ $funcionario->primeiro_nome }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit">Confirmar</button>
        </form>
        <script>
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const senha = document.getElementById('password').value;
                if (senha !== '123456') {
                    e.preventDefault(); // impede envio do formulário
                    alert('Senha incorreta!');
                }
            });
        </script>

    </div>
</body>

</html>