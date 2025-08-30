@extends('app.layouts.app')
@section('content')

<style>
    /* ===== Reset / base ===== */
    * {
        box-sizing: border-box;
    }


    /* ===== Títulos ===== */
    h1 {
        color: #222;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        font-size: 1.5rem;
    }

    /* ===== Container das mensagens ===== */
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
        overflow-y: auto;
    }

    /* ===== Mensagem ===== */
    .message {
        border: none;
        padding: 12px 18px;
        margin-bottom: 12px;
        border-radius: 20px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        max-width: 80%;
        word-wrap: break-word;
        align-self: flex-start;
        margin-right: auto;
        background-color: #fff;
        position: relative;
    }

    .message.my-message {
        background-color: #DCF8C6;
        margin-left: auto;
        margin-right: 0;
        align-self: flex-end;
    }

    /* ===== Textos da mensagem ===== */
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
        font-size: 1rem;
    }

    /* ===== Mensagem de sucesso ===== */
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
        font-size: 1rem;
    }

    /* ===== Formulário ===== */
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
        flex-wrap: nowrap;
    }

    form textarea {
        width: 90%;
        max-width: 810px;
        /* 90% de 900px */
        min-width: 90%;
        height: 100px;
        min-height: 80px;
        border-radius: 22px;
        padding: 10px 20px;
        font-size: 1rem;
        border: 1px solid #ddd;
        resize: vertical;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
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

    /* ===== Responsivo para telas até 900px ===== */
    @media (max-width: 900px) {
        body {
            padding: 0;
            font-size: 0.88rem;
        }

        h1 {
            font-size: 1.28rem;
        }

        .messages-container {
            max-height: 55vh;
            padding: 8px;
        }

        .message .header {
            font-size: 0.88rem;
        }

        .message .subject {
            font-size: 1.04rem;
        }

        .message .body {
            font-size: 0.8rem;
            line-height: 1.3;
        }

        form {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            border-radius: 0;
            padding: 12px;
            flex-wrap: nowrap;
        }

        form textarea {
            width: 90vw;
            min-width: 90vw;
            max-width: 90vw;
            height: 80px;
            font-size: 0.88rem;
        }

        form button {
            width: 36px;
            height: 36px;
            font-size: 1.12rem;
            align-self: flex-end;
        }

        .message {
            max-width: 90%;
        }

        .success {
            font-size: 0.8rem;
            padding: 15px;
        }
    }
</style>


@if(session('success'))
<p class="success" role="alert" aria-live="polite">{{ session('success') }}</p>
@endif

<div class="messages-container" id="messages-container">
    @foreach ($messages as $msg)
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

<form action="{{ route('messages.store') }}" method="POST" aria-label="Formulário de envio de mensagem">
    @csrf
    <textarea name="message" placeholder="Digite sua mensagem..." required>{{ old('message') }}</textarea>

    <input type="hidden" name="group_id" value="{{ $group->id ?? old('group_id') }}">

    @error('message')
    <div style="color: red; margin-top: 5px;">{{ $message }}</div>
    @enderror
    <button type="submit" aria-label="Enviar mensagem">&#10148;</button>
</form>


<a class="btn btn-outline-dark btn-bg" href="{{ route('app.home') }}">
    <i class="icofont-dashboard"></i> Dashboard
</a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const messagesContainer = document.getElementById('messages-container');
        if (!messagesContainer) return;

        // Scroll inicial
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Último ID da mensagem existente
        let lastId = @json($messages -> last() ? $messages -> last() -> id : 0);

        // ID do usuário logado
        const myId = @json(auth() -> check() ? auth() -> id() : null);

        // Função para criar div da mensagem
        function createMessageDiv(msg) {
            const div = document.createElement('div');
            div.classList.add('message');
            div.classList.add(msg.user_id === myId ? 'my-message' : 'other-message');
            div.innerHTML = `
            <div class="header">
                ${msg.user_name} (<span title="${msg.timestamp_full}">${msg.timestamp}</span>)
            </div>
            <div class="subject"><strong>Assunto:</strong> ${msg.subject}</div>
            <div class="body">${msg.message}</div>
        `;
            return div;
        }

        // Envio de mensagem
        const messageForm = document.getElementById('message-form');
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = document.getElementById('message').value;
            const group_id = document.getElementById('group_id').value;
            const token = document.querySelector('input[name="_token"]').value;

            fetch("{{ route('messages.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message,
                        group_id
                    })
                })
                .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
                .then(data => {
                    messagesContainer.appendChild(createMessageDiv(data));
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    document.getElementById('message').value = '';
                    lastId = data.id;
                })
                .catch(err => alert(err?.errors?.message?.[0] ?? 'Erro ao enviar a mensagem'));
        });

    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    if (!messagesContainer) return;

    // Scroll inicial
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Último ID da mensagem existente
    let lastId = @json($messages->last() ? $messages->last()->id : 0);

    // ID do usuário logado
    const myId = @json(auth()->check() ? auth()->id() : null);

    // Função para criar div da mensagem
    function createMessageDiv(msg) {
        const div = document.createElement('div');
        div.classList.add('message');
        div.classList.add(msg.user_id === myId ? 'my-message' : 'other-message');
        div.innerHTML = `
            <div class="header">
                ${msg.user_name} (<span title="${msg.timestamp_full}">${msg.timestamp}</span>)
            </div>
            <div class="subject"><strong>Assunto:</strong> ${msg.subject}</div>
            <div class="body">${msg.message}</div>
        `;
        return div;
    }

    // Token CSRF
    const token = document.querySelector('input[name="_token"]').value;

    // Função para buscar novas mensagens
    function fetchNewMessages() {
        fetch(`{{ route('messages.fetch', $group->id) }}?last_id=${lastId}`, {
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.length > 0) {
                data.forEach(msg => {
                    messagesContainer.appendChild(createMessageDiv(msg));
                    lastId = msg.id;
                });
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        })
        .catch(err => console.error('Erro ao buscar mensagens:', err));
    }

    // Busca inicial
    fetchNewMessages();

    // Atualização a cada 5 segundos
    setInterval(fetchNewMessages, 5000);
});
</script>


