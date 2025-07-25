<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários do Grupo</title>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            padding: 30px;
            max-width: 800px;
            margin: auto;
        }

        h2 {
            font-size: 1.6rem;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 1rem;
            margin-bottom: 20px;
            color: #666;
        }

        .group-user-form {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 20px;
        }

        .group-user-form label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        #users {
            width: 100%;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 5px;
            min-height: 44px;
            font-size: 0.95rem;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            font-weight: 600;
        }

        .submit-btn {
            margin-top: 16px;
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h2>{{ $group->name }}</h2>
    <p>{{ $group->description }}</p>
    <hr>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('groups.attachUsers', $group->id) }}" method="POST" class="group-user-form">
        @csrf

        <label for="users">Selecionar usuários:</label>

        <select name="users[]" id="users" multiple>
            @foreach ($users as $user)
                <option 
                    value="{{ $user->id }}"
                    {{ $group->users->contains($user->id) ? 'selected' : '' }}
                >
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="submit-btn">Anexar Usuários</button>
    </form>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#users').select2({
                placeholder: 'Selecione usuários',
                width: '100%',
                language: {
                    noResults: function () {
                        return "Nenhum usuário encontrado";
                    }
                }
            });
        });
    </script>

</body>
</html>
