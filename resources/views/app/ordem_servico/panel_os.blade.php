<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="60">
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
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
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
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            width: 100%;
        }

        .os-card {
            background: white;
            padding: 5px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;

            border: 1px solid #eef2f7;
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
            color: #2d3748;
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
</head>

<body>

    <div class="header">
        <div class="header-title">
            <h1>📋 Painel de Ordens de Serviço <div class="refresh-info">
                    ⏱️ Atualiza a cada 60 segundos •
                    <span id="lastUpdate">{{ now()->format('H:i:s') }}</span>
                </div>
            </h1>


        </div>

        <div class="toolbar-marquee">
            <div class="marquee-track" id="marqueeTrack">
                <!-- Mensagens serão inseridas via JS -->
            </div>
        </div>


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
                .header-mecanica {
                    background-color: rgba(59, 80, 100, 0.6);
                    /* azul escuro mais leve */
                    color: white;
                }

                .header-eletrica {
                    background-color: rgba(40, 167, 69, 0.3);
                    /* verde claro mais suave */
                    color: black;
                }
            </style>
            <div class="card-header {{ $headerClass }}">




                <div class="os-info">
                    <div class="os-id">
                        {{ $ordem_servico->id }}
                        @if($ordem_servico->check == 1)
                        <span class="status-badge badge-verificado">✅ Verificada</span>
                        @else
                        <span class="status-badge badge-pendente">⚠️ Pendente</span>
                        @endif

                    </div>

                    <div class="equipamento">{{ $ordem_servico->equipamento->nome }}</div>
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

                <div class="info-group">
                    <span class="info-label">Descrição</span>
                    <div class="info-value">{{ $ordem_servico->descricao }}</div>
                </div>
                <div class="imagem-container {{ (!$ordem_servico->ss || !$ordem_servico->ss->imagem) ? 'sem-imagem' : '' }}">

                    @if($ordem_servico->ss && $ordem_servico->ss->imagem)
                    <img src="{{ asset('img/request_os/' . $ordem_servico->ss->imagem) }}"
                        alt="Foto da Ordem de Serviço"
                        class="imagem-os">
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


                <!--  <button class="btn-falar btnFalarOS" data-os-id="{{ $ordem_servico->id }}" hidden>
                    🗣️ Falar esta OS
                </button>-->
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
            const osId = card.querySelector('.os-id').textContent.split('OS #')[1].split(' ')[0];
            const equipamento = card.querySelector('.equipamento').textContent;
            const periodoItems = card.querySelectorAll('.periodo-item span:last-child');
            const periodoText = Array.from(periodoItems).map(span => span.textContent).join('. ');
            const descricao = card.querySelector('.info-group:nth-child(2) .info-value').textContent.trim();

            const temAlerta = card.querySelector('.alerta-container');
            const status = temAlerta ? 'NÃO VERIFICADA' : 'VERIFICADA';

            // Preparar texto para fala
            const texto = `
                Ordem de Serviço número ${osId}.
                Equipamento: ${equipamento}.
                Status: ${status}.
                ${periodoText}.
                Descrição: ${descricao}.
                ${temAlerta ? 'ATENÇÃO: Esta ordem de serviço requer verificação imediata!' : ''}
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
        });

        // Auto-fala para primeira OS pendente
        window.addEventListener('load', async function() {
            await new Promise(resolve => setTimeout(resolve, 1000));

            const primeiraOSPendente = document.querySelector('.alerta-container');
            if (primeiraOSPendente) {
                const btnFalar = primeiraOSPendente.closest('.os-card').querySelector('.btnFalarOS');
                if (btnFalar) {
                    await new Promise(resolve => setTimeout(resolve, 500));
                    btnFalar.click();
                }
            }
        });

        // Expansão de imagens
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('imagem-os')) {
                const img = e.target;
                if (!img.classList.contains('expanded')) {
                    img.style.maxHeight = '400px';
                    img.style.cursor = 'zoom-out';
                    img.classList.add('expanded');
                } else {
                    img.style.maxHeight = '180px';
                    img.style.cursor = 'zoom-in';
                    img.classList.remove('expanded');
                }
            }
        });

        // Atualização automática da página
        setTimeout(() => {
            location.reload();
        }, 60000); // 60 segundos
    </script>

</body>

</html>