<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel OS Grid</title>
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/comum.css') }}">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="{{ asset('js/date_time.js') }}"></script>
    <script src="{{ asset('js/update_datatime.js') }}" defer></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Bootstrap Icons (FALTAVA ESTE) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Icofont -->
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/comum.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 10px;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* HEADER COMPACTO */
        .header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 5px;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .header-title {
            flex: 1;
            min-width: 200px;
        }

        .header-title h1 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .refresh-info {
            font-size: 13px;
            opacity: 0.9;

            display: flex;
            align-items: center;
            gap: 8px;
        }

        #lastUpdate {
            background: rgba(255, 255, 255, 0.2);
            padding: 3px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        /* ESTATÍSTICAS NO HEADER */
        .header-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }

        .stat-item {
            text-align: center;
            min-width: 80px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .stat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* GRID DE CARDS */
        .grid-os {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(333px, 1fr));
            gap: 5px;
            width: 100%;

        }

        .os-card {
            background: white;
            padding: 3px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #eef2f7;
        }

        .card-content {
            overflow-y: auto;
        }

        .os-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            border-color: #d1e3ff;
        }

        /* CARD HEADER */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2px;
            padding-bottom: 2px;
        }

        .os-info {
            flex: 1;
        }

        .os-id {
            color: #0c274e;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .equipamento {
            color: #063991;
            font-size: 16px;
            font-weight: 500;
        }

        .indicador-urgencia {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }

        /* CARD CONTENT */
        .card-content {
            flex-grow: 1;
            margin-bottom: 20px;
        }

        .info-group {
            margin-bottom: 2px;
        }

        .info-label {
            display: block;
            font-size: 12px;
            color: #718096;
            font-weight: 600;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #2d3748;
            font-size: 14px;
            line-height: 1.5;
        }

        .periodo-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 3px;
        }

        .periodo-icon {
            color: #718096;
            font-size: 12px;
        }

        /* IMAGEM */
        .imagem-container {
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .imagem-container:hover {
            border-color: #0d6efd;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
        }

        .imagem-os {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .imagem-os:hover {
            transform: scale(1.02);
        }

        /* CARD FOOTER */
        .card-footer {
            margin-top: auto;
        }

        .alerta-container {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffd43b;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(255, 212, 59, 0.4);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(255, 212, 59, 0);
            }
        }

        .alerta-texto {
            color: #856404;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .btn-checar {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-checar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .btn-falar {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-falar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        /* BADGES DE STATUS */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .badge-pendente {
            background: #ffc107;
            color: #856404;
        }

        .badge-verificado {
            background: rgb(40, 167, 69, 0.6);
            color: white;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 1200px) {
            .grid-os {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .header-title {
                min-width: 100%;
            }

            .header-stats {
                justify-content: center;
                width: 100%;
            }

            .stat-item {
                flex: 1;
                min-width: 70px;
            }

            .grid-os {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 8px;
            }

            .os-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 20px;
            }
        }

        /* CORES DE URGÊNCIA */
        .urgencia-5 {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
        }

        .urgencia-4 {
            background: linear-gradient(135deg, #ffd93d 0%, #ffc107 100%);
        }

        .urgencia-3 {
            background: linear-gradient(135deg, #6bc5ff 0%, #4d96ff 100%);
        }

        .urgencia-2 {
            background: linear-gradient(135deg, #4d96ff 0%, #1e7af0 100%);
        }

        .urgencia-1 {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }

        /*  Mensagem toolbar*/
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeLoop 20s linear infinite;
        }

        .marquee-track span {
            padding-right: 50px;
            white-space: nowrap;
            color: #fff;
            font-weight: 600;
        }

        @keyframes marqueeLoop {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }
    </style>
    <script>
        let cardsLiberados = [];
        let indiceFala = 0;

        // Monta a lista de botões liberados
        function montarListaLiberada() {
            cardsLiberados = [];

            document.querySelectorAll('.os-card').forEach(card => {
                const botaoFalar = card.querySelector('.btnFalarOS');
                const botaoAlarme = card.querySelector('.btnAtualizarAlarm');

                if (botaoAlarme && botaoAlarme.dataset.situacao !== "1") {
                    cardsLiberados.push(botaoFalar);
                }
            });

            indiceFala = 0;
        }

        // Função para falar uma OS
        async function falarOS(botao) {
            return new Promise((resolve) => {
                const card = botao.closest('.os-card');

                const osId = card.querySelector('.os-id').textContent.trim();
                const equipamento = card.querySelector('.equipamento').textContent;
                const descricao = card.querySelector('.info-group:nth-child(2) .info-value').textContent.trim();
                const alarm = card.querySelector('.btnAtualizarAlarm').dataset.situacao;

                if (alarm === "1") {
                    // Ignora se alarme desligado
                    resolve();
                    return;
                } else {

                    const texto = `Atenção! Nova Ordem. Número: ${osId}. Para: ${equipamento}., ,${descricao}`;

                    const vozes = speechSynthesis.getVoices();
                    const vozPT = vozes.find(v => v.lang.startsWith('pt')) || vozes[0];

                    const fala = new SpeechSynthesisUtterance(texto);
                    fala.lang = 'pt-BR';
                    fala.rate = 1.0;
                    fala.pitch = 1.0;
                    fala.volume = 1.0;
                    if (vozPT) fala.voice = vozPT;

                    // Feedback visual
                    botao.innerHTML = '🔊 Falando...';
                    botao.style.opacity = '0.8';
                    botao.disabled = true;

                    fala.onend = fala.onerror = () => {
                        botao.innerHTML = '🗣️ Falar esta OS';
                        botao.style.opacity = '1';
                        botao.disabled = false;
                        resolve(); // permite ir para a próxima
                    };

                    speechSynthesis.speak(fala);

                }
            });

        }

        // Função sequencial
        async function falarSequenciaCompleta() {
            for (indiceFala = 0; indiceFala < cardsLiberados.length; indiceFala++) {
                await falarOS(cardsLiberados[indiceFala]); // espera a fala terminar
            }
        }

        // Espera carregar tudo
        window.addEventListener('load', () => {
            setTimeout(() => {
                montarListaLiberada();
                falarSequenciaCompleta();
            }, 1000); // 1s para garantir que o DOM carregou
        });
    </script>


</head>

<body>

    <div class="header">
        <div class="header-title">
            <h1>📋 Painel de Ordens de Serviço <div class="refresh-info">
                    ⏱️ Atualiza a cada 60 segundos •
                    <span id="lastUpdate">{{ now()->format('H:i:s') }}</span>
                    <!-- Botão que abre a modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalExemplo" style="height:35px;margin-top:5px;">
                        Criar O.S
                    </button>
                    <!-- Notificação de Check list -->
                    <div class="dropdown" id="checklist-count" style="margin-top:15px;margin-right:50px">
                    </div>
                    <div id="checklist-count" class="notification" style="margin-top:20px;">
                        <span class="badge" id="checklist-badge">0</span>
                        <div style="margin-right:25px;">Checklists pendentes</div>
                    </div>

                    <div id="lubrificacao-count" class="notification" style="margin-top:2px;">
                        <span id="lubrificacao-badge" style="width:30px;">0</span>
                        <div style="margin-right:25px;">Lubrificação</div>
                    </div>

                </div>
            </h1>
            <!-- CSS para o tollbar contagens notificaçoões-->
            <style>
                .badge {
                    display: inline-block;
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    color: white;
                    text-align: center;
                    line-height: 24px;
                    font-size: 14px;
                    font-weight: bold;
                    position: absolute;
                    top: -10px;
                    right: -10px;
                    z-index: 1000;
                }

                .badge.zero {
                    background-color: green;
                }

                .badge.non-zero {
                    background-color: red;
                }

                .badge.warning {
                    background-color: orange;
                    /* Nova classe para laranja */
                }

                #solicitacoes-count,
                #checklist-count {
                    position: relative;
                    display: inline-block;
                    margin-right: 100px;
                    cursor: pointer;
                }
            </style>

            <!-- JavaScript para atualização das contagens -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    // Função para atualizar a contagem de checklists pendentes
                    function atualizarContagemChecklists() {
                        fetch('/check-list-pendentes')
                            .then(response => response.json())
                            .then(data => {
                                const badge = document.getElementById('checklist-badge');
                                badge.innerText = data.pendentes;

                                if (data.pendentes > 0) {
                                    badge.classList.remove('zero', 'non-zero');
                                    badge.classList.add('warning'); // Adiciona a classe warning
                                    document.getElementById('lubrificacao-badge').style.background = 'yellow'
                                } else {
                                    badge.classList.remove('non-zero', 'warning');
                                    badge.classList.add('zero');

                                }
                            })
                            .catch(error => console.error('Erro:', error));
                    }
                    // Função para atualizar a contagem de lubrificações
                    function atualizarContagemLubrificacao() {
                        fetch('/lubrificacao-count')
                            .then(response => response.json())
                            .then(data => {
                                const badge = document.getElementById('lubrificacao-badge');

                                // Atualiza o número
                                badge.innerText = data.pendentes;
                                badge.style.display = 'inline-block';

                                // Atualiza a cor diretamente
                                if (data.pendentes > 0) {
                                    badge.style.backgroundColor = 'yellow'; // cor quando houver pendentes
                                    badge.style.color = 'black'; // cor do texto para contraste
                                } else {
                                    badge.style.backgroundColor = 'green'; // cor quando 0
                                    badge.style.color = 'white';
                                }
                            })
                            .catch(error => console.error('Erro:', error));
                    }

                    // Atualiza a cada 30 segundos
                    setInterval(() => {
                        atualizarContagemChecklists();
                        atualizarContagemLubrificacao();
                    }, 30000);

                    // Atualiza imediatamente quando a página carrega
                    atualizarContagemChecklists();
                    atualizarContagemLubrificacao();

                });
            </script>

            <script>
                //Recarrega a págian automaticamante -1
                let refreshTimeout;

                function startAutoRefresh() {
                    stopAutoRefresh(); // garante que não haja timers duplicados
                    refreshTimeout = setTimeout(() => {
                        location.reload();
                    }, 60000); // 60 segundos
                }

                function stopAutoRefresh() {
                    clearTimeout(refreshTimeout);
                }

                document.addEventListener('DOMContentLoaded', () => {
                    const modal = document.getElementById('modalExemplo');

                    if (modal) {
                        // Para o timer quando a modal abrir
                        modal.addEventListener('show.bs.modal', stopAutoRefresh);

                        // Reinicia o timer quando a modal fechar
                        modal.addEventListener('hidden.bs.modal', startAutoRefresh);
                    }

                    // Inicia o auto-refresh ao carregar a página
                    startAutoRefresh();
                });
            </script>



        </div>

        <div class="toolbar-marquee">
            <div class="marquee-track" id="marqueeTrack">
                <!-- Mensagens serão inseridas via JS -->
            </div>
        </div>

        <!--Fala a os  automaticamente-->
        <script>
            async function atualizarMensagens() {
                try {
                    const response = await fetch('/mensagens-ativas');
                    const mensagens = await response.json();

                    const track = document.getElementById('marqueeTrack');
                    track.innerHTML = ''; // limpa mensagens antigas

                    mensagens.forEach(msg => {
                        const span = document.createElement('span');
                        let emoji = 'ℹ️';
                        if (msg.tipo === 'alerta') emoji = '⚠️';
                        if (msg.tipo === 'urgente') emoji = '❗';
                        span.textContent = `${emoji} ${msg.mensagem}`;
                        track.appendChild(span);
                    });
                } catch (err) {
                    console.error('Erro ao carregar mensagens:', err);
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                atualizarMensagens();
                setInterval(atualizarMensagens, 30000);
            });
        </script>


    </div>
    <div class="header-stats" hidden>
        <div class="stat-item" title="Total de Ordens de Serviço">
            <div class="stat-number">{{ count($ordens_servicos) }}</div>
            <div class="stat-label">Total OS</div>
        </div>
        <div class="stat-item" title="Ordens com urgência alta (4-5)">
            <div class="stat-number">{{ $ordens_servicos->where('urgencia', '>=', 4)->count() }}</div>
            <div class="stat-label">Urgentes</div>
        </div>
        <div class="stat-item" title="Ordens não verificadas">
            <div class="stat-number">{{ $ordens_servicos->where('check', 0)->count() }}</div>
            <div class="stat-label">Pendentes</div>
        </div>
        <div class="stat-item" title="Ordens verificadas">
            <div class="stat-number">{{ $ordens_servicos->where('check', 1)->count() }}</div>
            <div class="stat-label">Verificadas</div>
        </div>
    </div>
    <div class="grid-os">
        @foreach($ordens_servicos as $ordem_servico)
        <div class="os-card">
            @php
            $headerClass = '';
            if ($ordem_servico->especialidade_do_servico == 'mecanica') {
            $headerClass = 'header-mecanica';
            } elseif ($ordem_servico->especialidade_do_servico == 'eletrica') {
            $headerClass = 'header-eletrica';
            }
            @endphp
            <style>
                .os-card .card-header.header-mecanica {
                    background-color: rgba(59, 80, 100, 0.6) !important;
                    color: white;
                }

                .os-card .card-header.header-eletrica {
                    background-color: rgba(40, 167, 69, 0.3) !important;
                    color: black;
                }
            </style>
            <!------------------------->
            <!--Bloco que do card  os-->

            <div class="card-header {{ $headerClass }}">

                <div class="os-info">
                    <div style="flex-direction: row;display:flex;">
                        <div class="os-id">
                            {{ $ordem_servico->id }}

                        </div>
                        <div>
                            @if($ordem_servico->check == 1)
                            <span class="status-badge badge-verificado">✅ Verificada</span>
                            @else
                            <span class="status-badge badge-pendente">⚠️ Pendente</span>
                            @endif
                        </div>
                    </div>



                    <!--Bloco do Status da os-->
                    <div style="display:flex; flex-direction:row; gap:10px; margin-bottom:3px">
                        <div class="equipamento">{{ $ordem_servico->equipamento->nome }} </div>
                        <div>
                            <span style="color: white;">{{$ordem_servico->situacao}}</span>
                        </div>

                        <button type="button"
                            class="btn btn-sm btnAtualizarOS 
    {{ strtolower($ordem_servico->situacao) === 'aberto'
        ? 'btn-success'
        : (strtolower($ordem_servico->situacao) === 'pausado'
            ? 'btn-danger'
            : 'btn-primary') }}"

                            data-id="{{ $ordem_servico->id }}"
                            data-situacao="{{ $ordem_servico->situacao }}"
                            style="height:30px;width:50px;border-radius:5px;">

                            @switch(strtolower($ordem_servico->situacao))

                            @case('pausado')
                            <i class="bi bi-question-circle"></i>
                            @break

                            @case('em andamento')
                            <i class="bi bi-pause-circle"></i>
                            @break

                            @case('aberto')
                            <i class="bi bi-play-circle"></i>
                            @break

                            @default
                            <i class="bi bi-circle"></i>
                            @endswitch
                        </button>

                        <!--Bloco do Status da alarme-->
                        <button type="button"
                            class="btn btn-sm btnAtualizarAlarm 
           {{ $ordem_servico->alarm === '0' || $ordem_servico->alarm ===null? 'btn-warning' : 'btn-primary' }}"
                            data-id="{{ $ordem_servico->id }}"
                            data-situacao="{{ $ordem_servico->alarm }}"
                            style="height:30px;width:50px;border-radius:5px;">

                            @if($ordem_servico->alarm === 1)
                            <i class="icofont-volume-mute "></i>
                            @else
                            <i class="icofont-volume-up"></i>
                            @endif
                        </button>
                    </div>



                </div>

                <div class="indicador-urgencia urgencia-{{ $ordem_servico->urgencia }}"
                    title="Nível de urgência: {{ $ordem_servico->urgencia }}/5">
                    {{ $ordem_servico->urgencia }}
                </div>
                <!--Botão imprimir-->
                <button type="button" class="gerarPdfButton btn btn-outline-secondary mb-1" title="Imprimir O.S">
                    <i class="icofont-print"></i>
                </button>

                <form class="frm-pdf" action="{{ route('gerar.pdf') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="ordem_servico_id" value="{{ $ordem_servico->id }}">
                </form>
                <script>
                    document.querySelectorAll('.gerarPdfButton').forEach(button => {
                        button.addEventListener('click', function() {
                            const card = button.closest('.os-card');
                            const form = card.querySelector('.frm-pdf');

                            if (form) {
                                form.submit();
                            } else {
                                console.error('Formulário de PDF não encontrado');
                            }
                        });
                    });
                </script>

            </div>

            <div class="card-content">
                <div class="info-group">
                    <div class="info-value">
                        <div class="periodo-item">
                            <span class="periodo-icon">📅</span>
                            <span>Início: {{ \Carbon\Carbon::parse($ordem_servico->data_inicio)->format('d/m/Y') }} às {{ $ordem_servico->hora_inicio }}</span>
                            <span class="periodo-icon">⏰</span>
                            <span>Término: {{ \Carbon\Carbon::parse($ordem_servico->data_fim)->format('d/m/Y') }} às {{ $ordem_servico->hora_fim }}</span>
                        </div>
                    </div>
                </div>

                <div class="info-group" style="margin-bottom:1px;">
                    <span class="info-label">Descrição</span>
                    <div class="info-value">{{ $ordem_servico->descricao }}</div>
                </div>
                <div class="imagem-container {{ (!$ordem_servico->ss || !$ordem_servico->ss->imagem) ? 'sem-imagem' : '' }}">

                    @if($ordem_servico->ss && $ordem_servico->ss->imagem)
                    <img src="{{ asset('img/request_os/' . $ordem_servico->ss->imagem) }}"
                        alt="Foto da Ordem de Serviço"
                        class="imagem-os">
                    @else
                    @if(!empty($ordem_servico->link_foto))
                    <img src="/{{ $ordem_servico->link_foto }}"
                        id="imagem"
                        alt="Imagem anexada"
                        class="imagem-os">
                    @endif
                    @endif

                    @if ($ordem_servico->check != 1)
                    <div class="alerta-overlay">
                        <div class="alerta-texto">
                            ⚠️ Ordem não verificada
                        </div>
                        <form action="{{ route('check.odem.servico') }}" method="get">
                            <input type="hidden" name="id_os" value="{{ $ordem_servico->id }}">
                            <button type="submit" class="btn-checar">
                                ✅ Verificar
                            </button>
                        </form>
                    </div>
                    @endif

                </div>

                <style>
                    .imagem-container {
                        position: relative;
                        border-radius: 8px;
                        overflow: hidden;
                    }

                    /* quando TEM imagem → overlay */
                    .imagem-container:not(.sem-imagem) .alerta-overlay {
                        position: absolute;
                        inset: 0;
                        background: rgba(0, 0, 0, 0.55);
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        gap: 10px;
                    }

                    /* quando NÃO TEM imagem → layout normal */
                    .imagem-container.sem-imagem .alerta-overlay {
                        position: relative;
                        background: #fff3cd;
                        border: 1px solid #ffd43b;
                        padding: 15px;
                        border-radius: 8px;
                    }

                    /* texto */
                    .alerta-texto {
                        font-weight: bold;
                        text-align: center;
                    }

                    /* botão */
                    .alerta-overlay .btn-checar {
                        padding: 8px 14px;
                    }
                </style>
            </div>

            <div class="card-footer" hidden>
                <button class="btn-falar btnFalarOS" data-os-id="{{ $ordem_servico->id }}">
                    🗣️ Falar esta OS
                </button>
            </div>

        </div>
        @endforeach
    </div>

    <script>
        // Atualizar timestamp
        function atualizarTimestamp() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('lastUpdate').textContent = timeString;
        }
        setInterval(atualizarTimestamp, 1000);

        // Sistema de voz
        let vozAtual = null;

        async function inicializarVoz() {
            return new Promise((resolve) => {
                const vozes = speechSynthesis.getVoices();
                if (vozes.length > 0) {
                    resolve(vozes);
                } else {
                    speechSynthesis.onvoiceschanged = () => {
                        resolve(speechSynthesis.getVoices());
                    };
                }
            });
        }

        document.addEventListener('click', async function(e) {
            if (!e.target.classList.contains('btnFalarOS')) return;

            // Parar fala atual
            speechSynthesis.cancel();

            const card = e.target.closest('.os-card');
            if (!card) return;

            // Coletar dados da OS
            // const osId = card.querySelector('.os-id').textContent.split('OS #')[1].split(' ')[0];
            const osId = card.querySelector('.os-id').textContent.trim();
            const equipamento = card.querySelector('.equipamento').textContent;
            const periodoItems = card.querySelectorAll('.periodo-item span:last-child');
            // const periodoText = Array.from(periodoItems).map(span => span.textContent).join('. ');
            const periodoText = card.querySelector('.periodo-item').textContent.trim();
            const descricao = card.querySelector('.info-group:nth-child(2) .info-value').textContent.trim();
            const temAlerta = card.querySelector('.alerta-container');
            const alarm = card.querySelector('.btnAtualizarAlarm').dataset.situacao;

            // Preparar texto para fala

            // BLOQUEIO DE FALA SE ALARM = 1
            if (alarm === "1") {
                alert("Esta OS está com o alarme desativado — fala bloqueada.");
                return;
            } else {

                const texto = `
                Atenção!, 
                Nova Ordem, 
                Número: ${osId}.
                Para: ${equipamento}.
                , ${descricao}
            `;
                // Configurar e iniciar fala
                const vozes = await inicializarVoz();
                const vozPT = vozes.find(v => v.lang.startsWith('pt')) || vozes[0];

                const fala = new SpeechSynthesisUtterance(texto);
                fala.lang = 'pt-BR';
                fala.rate = 1.0;
                fala.pitch = 1.0;
                fala.volume = 1.0;
                if (vozPT) fala.voice = vozPT;

                // Feedback visual durante a fala
                e.target.innerHTML = '🔊 Falando...';
                e.target.style.opacity = '0.8';
                e.target.disabled = true;

                fala.onend = fala.onerror = () => {
                    e.target.innerHTML = '🗣️ Falar esta OS';
                    e.target.style.opacity = '1';
                    e.target.disabled = false;
                };

                speechSynthesis.speak(fala);
            }

        });
    </script>


    <!-- Bootstrap CSS (no <head>) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="modalExemplo" tabindex="-1" aria-labelledby="modalExemploLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg para mais espaço -->
            <div class="modal-content">
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Campos de data
                        const inputDataInicio = document.getElementById('data_inicio');
                        const inputDataFim = document.getElementById('data_fim');

                        // Campos de hora
                        const inputHoraInicio = document.getElementById('hora_inicio');
                        const inputHoraFim = document.getElementById('hora_fim');

                        // Data e hora atuais
                        const agora = new Date();

                        // Formatar data no padrão yyyy-mm-dd
                        const ano = agora.getFullYear();
                        const mes = String(agora.getMonth() + 1).padStart(2, '0');
                        const dia = String(agora.getDate()).padStart(2, '0');
                        const dataFormatada = `${ano}-${mes}-${dia}`;

                        // hora_inicio = agora - 1 hora
                        const horaInicioDate = new Date(agora.getTime() - (60 * 60 * 1000));
                        const horaInicio = String(horaInicioDate.getHours()).padStart(2, '0');
                        const minutosInicio = String(horaInicioDate.getMinutes()).padStart(2, '0');
                        const horaFormatadaInicio = `${horaInicio}:${minutosInicio}`;

                        // Formatar hora no padrão hh:mm (sem segundos)
                        const hora = String(agora.getHours()).padStart(2, '0');
                        const minutos = String(agora.getMinutes()).padStart(2, '0');
                        const horaFormatada = `${hora}:${minutos}`;

                        // Aplicar nos campos
                        inputDataInicio.value = dataFormatada;
                        inputDataFim.value = dataFormatada;

                        inputHoraInicio.value = horaFormatadaInicio;
                        inputHoraFim.value = horaFormatada;
                    });
                </script>

                <!-- Cabeçalho -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExemploLabel">Criar O.S.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <!-- Corpo do formulário -->
                <div class="modal-body">

                    <!-- Data e Hora de Emissão (oculto) -->
                    <div class="row mb-3" hidden>
                        <div class="col">
                            <input type="date" id="data_emissao" name="data_emissao" class="form-control" readonly>
                        </div>
                        <div class="col">
                            <input type="time" id="hora_emissao" name="hora_emissao" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Data e Hora de Início -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="data_inicio" class="form-label">Data de Início</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="hora_inicio" class="form-label">Hora de Início</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
                        </div>
                    </div>

                    <!-- Data e Hora de Fim -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="data_fim" class="form-label">Data de Fim</label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control" required>
                        </div>
                        <div class="col">
                            <label for="hora_fim" class="form-label">Hora de Fim</label>
                            <input type="time" id="hora_fim" name="hora_fim" class="form-control" required>
                        </div>
                    </div>

                    <!-- Equipamento -->
                    <div class="mb-3">
                        <label for="equipamento_id" class="form-label">Equipamento</label>
                        <select name="equipamento_id" id="equipamento_id" class="form-select" required>
                            <option value="">-- Selecione --</option>
                            @foreach($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}">{{ $equipamento->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Responsável -->
                    <div class="mb-3">
                        <label for="funcionario_id" class="form-label">Responsável</label>
                        <select name="funcionario_id" id="funcionario_id" class="form-select" required>
                            <option value="">-- Selecione --</option>
                            @foreach($funcionarios as $funcionario)
                            <option value="{{ $funcionario->primeiro_nome}}">{{ $funcionario->primeiro_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-3">
                        <label for="campoTexto" class="form-label">Descrição</label>
                        <textarea id="campoTexto" name="descricao" class="form-control" placeholder="Digite aqui..." rows="3" minlength="30" required></textarea>
                    </div>

                    <!-- Especialidade -->
                    <div class="mb-3">
                        <label for="especialidade_do_servico" class="form-label">Especialidade do Serviço</label>
                        <select class="form-select" id="especialidade_do_servico" name="especialidade_do_servico" required>
                            <option value="">-- Selecione --</option>
                            <option value="mecanica">Mecânico</option>
                            <option value="eletrica">Elétrico</option>
                        </select>
                    </div>

                    <!-- Natureza -->
                    <div class="mb-3">
                        <label for="natureza_do_servico" class="form-label">Natureza do Serviço</label>
                        <select class="form-select" id="natureza_do_servico" name="natureza_do_servico" required>
                            <option value="">-- Selecione --</option>
                            <option value="Preventiva">Preventiva</option>
                            <option value="Corretiva">Corretiva</option>
                            <option value="Preditiva">Preditiva</option>
                        </select>
                    </div>

                    <!-- Inputs ocultos -->
                    <input type="hidden" id="status_servicos" name="status_servicos" value="80">
                    <input type="hidden" id="link_foto" name="link_foto">
                    <input type="hidden" id="gravidade" name="gravidade" value="3">
                    <input type="hidden" id="urgencia" name="urgencia" value="3">
                    <input type="hidden" id="tendencia" name="tendencia" value="3">
                    <input type="hidden" id="empresa_id" name="empresa_id" value="2">
                    <input type="hidden" id="situacao" name="situacao" value="Aberto">
                    <input type="hidden" id="ss_id" name="ss_id" value="">
                </div>

                <!-- Rodapé -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="salvar()">Salvar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle JS (de preferência no final do body) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function salvar() {
            const formData = new FormData();

            // Campos do formulário
            formData.append('data_emissao', document.getElementById('data_emissao').value);
            formData.append('hora_emissao', document.getElementById('hora_emissao').value);
            formData.append('data_inicio', document.getElementById('data_inicio').value);
            formData.append('hora_inicio', document.getElementById('hora_inicio').value);
            formData.append('data_fim', document.getElementById('data_fim').value);
            formData.append('hora_fim', document.getElementById('hora_fim').value);
            formData.append('equipamento_id', document.getElementById('equipamento_id').value);
            formData.append('funcionario_id', document.getElementById('funcionario_id').value);
            formData.append('descricao', document.getElementById('campoTexto').value);
            formData.append('especialidade_do_servico', document.getElementById('especialidade_do_servico').value);
            formData.append('natureza_do_servico', document.getElementById('natureza_do_servico').value);

            // Hidden fields
            formData.append('status_servicos', document.getElementById('status_servicos').value);
            formData.append('link_foto', document.getElementById('link_foto').value); // ou use .files[0] se for file
            formData.append('gravidade', document.getElementById('gravidade').value);
            formData.append('urgencia', document.getElementById('urgencia').value);
            formData.append('tendencia', document.getElementById('tendencia').value);
            formData.append('empresa_id', document.getElementById('empresa_id').value);
            formData.append('situacao', document.getElementById('situacao').value);
            formData.append('ss_id', document.getElementById('ss_id').value);

            // Envio AJAX com fetch
            fetch("{{ route('ordem_servico.modal') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao salvar O.S.');
                    return response.json();
                })
                .then(data => {
                    alert("O.S. criada com sucesso!");
                    location.reload(); // ou feche a modal, etc.
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert("Erro ao criar O.S.");
                });
        }
    </script>
    <div class="modal fade" id="modalStatusOS" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Alterar Status da OS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="osId">

                    <label class="form-label">Selecione o novo status</label>
                    <select id="novoStatus" class="form-select">
                        <option value="aberto">Aberto</option>
                        <option value="em_andamento">Em andamento</option>
                        <option value="pausado">Pausado</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="confirmarStatus">Confirmar</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        let modalStatus = new bootstrap.Modal(document.getElementById('modalStatusOS'));
        let osSelecionada = null;

        // Abre a modal ao clicar no botão atual
        document.querySelectorAll('.btnAtualizarOS').forEach(btn => {
            btn.addEventListener('click', function() {
                osSelecionada = this.dataset.id;
                document.getElementById('osId').value = osSelecionada;
                modalStatus.show();
            });
        });

        // Confirma e envia
        document.getElementById('confirmarStatus').addEventListener('click', function() {
            let novoStatus = document.getElementById('novoStatus').value;
            let id = document.getElementById('osId').value;

            fetch(`/ordem-servico/${id}/start-stop`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: novoStatus,
                        observacao: 'Alterado via modal'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    modalStatus.hide();
                    location.reload();
                })
                .catch(err => alert('Erro: ' + err));
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.btnAtualizarAlarm').forEach(btn => {

                btn.addEventListener('click', function() {

                    const osId = this.dataset.id;
                    const botao = this; // GUARDA REFERÊNCIA DO BOTÃO CLICADO

                    fetch('{{ route("update_alarm") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id: osId,
                                alarm: 1
                            })
                        })
                        .then(response => response.json())
                        .then(res => {

                            if (res.success) {

                                // 🔹 Atualiza VISUAL do botão correto
                                botao.classList.remove('btn-success');
                                botao.classList.add('btn-primary');

                                // 🔹 Atualiza ÍCONE dentro deste botão
                                const icon = botao.querySelector('i');
                                if (icon) {
                                    icon.className = 'icofont-volume-mute';
                                }

                                alert(res.message);

                            } else {
                                alert(res.message);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Erro ao atualizar o alarme.');
                        });
                });
            });
        });
    </script>

</body>

</html>