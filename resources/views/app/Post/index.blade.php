<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            color: #333;
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            min-height: 95vh;
        }

        h1 {
            color: #222;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .messages-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
            background-color: #E5DDD5;
            border-radius: 8px;
            margin-bottom: 20px;
            flex-grow: 1;
            max-height: 65vh;
            /* Responsivo: altura proporcional à tela */
            overflow-y: auto;
        }

        .message {
            border: none;
            padding: 12px 18px;
            margin-bottom: 12px;
            border-radius: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            position: relative;
            word-wrap: break-word;
            align-self: flex-start;
            margin-right: auto;
            background-color: #fff;
        }

        .message.my-message {
            background-color: #DCF8C6;
            margin-left: auto;
            margin-right: 0;
            align-self: flex-end;
        }

        .message .header {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 5px;
            text-align: left;
            font-weight: normal;
        }

        .message.my-message .header {
            text-align: right;
            color: #4CAF50;
        }

        .message .subject {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .message .body {
            white-space: pre-wrap;
            line-height: 1.5;
            color: #444;
        }

        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        form {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #f0f2f5;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.05);
            margin-top: auto;
        }

        form textarea {
            flex-grow: 1;
            width: 600px;
            height: 100px;
            min-height: 100px;
            max-height: 250px;
            border-radius: 22px;
            padding: 10px 20px;
            font-size: 1rem;
            border: 1px solid #ddd;
            resize: vertical;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        form textarea:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        form button {
            background-color: #25D366;
            color: white;
            font-size: 1.5rem;
            padding: 0;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #1DA851;
        }

        @media (max-width: 900px) {
            body {
                padding: 0;
                font-size: 1.6rem;
                /* Tamanho base maior para todo o corpo */
            }

            h1 {
                font-size: 2.4rem;
                /* Título grande */
            }

            .messages-container {
                max-height: 55vh;
                padding: 8px;
            }

            .message .header {
                font-size: 1.6rem;
            }

            .message .subject {
                font-size: 1.8rem;
            }

            .message .body {
                font-size: 1.8rem;
                line-height: 1.6;
            }

            form {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                border-radius: 0;
                padding: 12px;
            }

            form textarea {
                height: 80px;
                min-height: 80px;
                font-size: 1.6rem;
                width: 100%;
            }

            form button {
                width: 55px;
                height: 55px;
                font-size: 2rem;
                align-self: flex-end;
            }

            .message {
                max-width: 90%;
            }

            .success {
                font-size: 1.5rem;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    @if(session('success'))
    <p class="success" role="alert" aria-live="polite">{{ session('success') }}</p>
    @endif

    <div class="messages-container" id="messages-container">
        @foreach($messages as $msg)
        @php
        $isMyMessage = (auth()->check() && auth()->id() == $msg->user_id);
        @endphp

        <div class="message {{ $isMyMessage ? 'my-message' : 'other-message' }}">
            <div class="header">
                {{ $msg->user ? $msg->user->name : $msg->name }}
                (<span title="{{ $msg->created_at ? $msg->created_at->format('d/m/Y H:i:s') : 'Sem data' }}">
                    {{ $msg->created_at ? $msg->created_at->format('d/m/Y H:i') : 'Sem data' }}
                </span>)
            </div>
            <div class="subject"><strong>Assunto:</strong> {{ $msg->subject }}</div>
            <div class="body">{{ $msg->message }}</div>
        </div>
        @endforeach
    </div>

    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <textarea name="message" placeholder="Digite sua mensagem..." required>{{ old('message') }}</textarea>
        @error('message')
        <div style="color: red; margin-top: 5px;">{{ $message }}</div>
        @enderror
        <button type="submit" aria-label="Enviar mensagem">&#10148;</button>
    </form>
    <a class="btn btn-outline-dark btn-bg" href="{{ route('app.home') }}">
        <i class="icofont-dashboard"></i> Dashboard
    </a>
    <script>
        // Scroll para o fim da lista de mensagens quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            var messagesContainer = document.getElementById('messages-container');
            messagesContainer.scrollTo({
                top: messagesContainer.scrollHeight,
                behavior: 'smooth'
            });
        });
    </script>

</body>

</html>