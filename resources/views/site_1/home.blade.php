@include('site.navigation_bar')
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManWEB</title>

    <style>
        :root {
            --azul: #2f7c4c;
            --escuro: #0b132b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ================= HERO VIDEO CAROUSEL ================= */
        .video-hero {
            position: relative;
            width: 100%;
            height: 60vh;
            /* ← DIMINUI A ALTURA */
            min-height: 500px;
            /* garante boa aparência em telas grandes */
            overflow: hidden;
        }

        /* Slides */
        .video-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.2s ease-in-out;
        }

        .video-slide video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Slide ativo */
        .video-slide.active {
            opacity: 1;
        }

        /* Overlay profissional com gradiente */
        #overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.6),
                    rgba(0, 0, 0, 0.2),
                    rgba(0, 0, 0, 0.8));
        }

        /* Texto central estilo site moderno */
        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            max-width: 900px;
        }

        .hero-text h1 {
            font-size: 70px;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .hero-text p {
            font-size: 20px;
            margin-bottom: 25px;
        }

        /* Botão elegante */
        .hero-btn {
            padding: 12px 35px;
            border: none;
            background: #3d8057;
            color: white;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s;
        }

        .hero-btn:hover {
            background: #346856;
            transform: scale(1.05);
        }

        /* Botões laterais */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            padding: 15px;
            font-size: 22px;
            cursor: pointer;
            border-radius: 50%;
        }

        .prev {
            left: 20px;
        }

        .next {
            right: 20px;
        }

        /* Dots (bolinhas) de navegação */
        .dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
        }

        .dot.active {
            background: var(--azul);
        }

        /* Barra de progresso do vídeo */
        .progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 5px;
            width: 0%;
            background: var(--azul);
            transition: width 6s linear;
        }

        /* Botão voltar ao topo */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--azul);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
        }

        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }

        /* ===== SETAS MODERNAS ===== */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0);
            /* efeito vidro */
            backdrop-filter: blur(5px);
            border: 1px solid rgba(218, 216, 216, 0.925);
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Ícone da seta */
        .nav-btn svg {
            width: 28px;
            height: 28px;
            fill: rgb(255, 255, 255);
            transition: 0.3s;
        }

        /* Posição */
        .prev {
            left: 25px;
        }

        .next {
            right: 25px;
        }

        /* Efeito hover */
        .nav-btn:hover {
            transform: translateY(-50%) scale(1.1);
            color: rgb(255, 255, 255)
        }

        .nav-btn:hover svg {
            fill: white;
        }

        /* ============ RESPONSIVIDADE PARA CELULAR ============ */
        @media (max-width: 768px) {

            /* Ajusta altura do vídeo para caber melhor no celular */

            .video-hero {
                height: 85vh;
            }

            /* Reduz tamanho do título */
            .hero-text h1 {
                font-size: 42px;
            }

            /* Reduz tamanho do texto */
            .hero-text p {
                font-size: 16px;
                padding: 0 20px;
            }

            /* Botão menor e mais confortável para toque */
            .hero-btn {
                padding: 10px 28px;
                font-size: 14px;
            }

            /* Deixa setas menores no celular */
            .nav-btn {
                width: 45px;
                height: 45px;
            }

            .nav-btn svg {
                width: 22px;
                height: 22px;
            }

            /* Aproxima setas da borda para não atrapalhar o centro */
            .prev {
                left: 10px;
            }

            .next {
                right: 10px;
            }

            /* Dots um pouco menores */
            .dot {
                width: 10px;
                height: 10px;
            }

            /* Sobe um pouco as bolinhas no celular */
            .dots {
                bottom: 40px;
            }

            /* Botão voltar ao topo um pouco menor */
            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
            }
        }

        /* Tela muito pequena (celular antigo) */
        @media (max-width: 480px) {

            .hero-text h1 {
                font-size: 36px;
            }

            .hero-text p {
                font-size: 14px;
            }

            .nav-btn {
                width: 40px;
                height: 40px;
            }

            .nav-btn svg {
                width: 20px;
                height: 20px;
            }
        }

        /* ============ SEÇÃO SOBRE ============ */
        .sobre {
            background: #f4f6f8;
            padding: 80px 20px;
        }

        .sobre-container {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        /* Texto */
        .sobre-texto h2 {
            font-size: 40px;
            color: var(--escuro);
            margin-bottom: 20px;
        }

        .sobre-texto p {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        /* Imagem */
        .sobre-imagem img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .sobre-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .sobre-imagem {
                margin-top: 20px;
            }
        }

        /* ====== SEÇÃO DESTAQUES (SÓ ESTATÍSTICAS) ====== */
        /* ===== SEÇÃO DESTAQUES (ESTILO LIMPO E PROFISSIONAL) ===== */
        .destaques {
            background: #f4f6f8;
            padding: 80px 20px;
            text-align: center;
        }

        .titulo-destaques {
            font-size: 40px;
            color: #0b132b;
            margin-bottom: 15px;
        }

        .subtitulo {
            max-width: 900px;
            margin: 0 auto 50px;
            font-size: 18px;
            color: #555555;
        }

        /* CONTAINER DAS ESTATÍSTICAS */
        .estatisticas {
            max-width: 1000px;
            margin: auto;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        /* CARDS SIMPLES (como você gostou antes) */
        .stat {
            background: white;
            padding: 30px 25px;
            border-radius: 12px;
            width: 260px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        /* NÚMERO GRANDE */
        .stat h4 {
            font-size: 36px;
            color: #3c614b;
            margin-bottom: 5px;
        }

        /* TEXTO */
        .stat p {
            font-size: 16px;
            color: #444;
        }

        /* Efeito leve ao passar o mouse */
        .stat:hover {
            transform: translateY(-6px);
        }

        /* Responsivo */
        @media (max-width: 900px) {
            .estatisticas {
                flex-direction: column;
                align-items: center;
            }
        }

        /* ======== FOOTER ======== */
        /* ============ FOOTER MODERNO (NÃO PRETO) ============ */
        .footer-novo {
            background: linear-gradient(180deg, #203f16, #2a4e30);
            color: white;
            padding: 80px 20px 20px;
            position: relative;
        }

        /* Efeito de onda no topo (fica muito bonito) */
        .footer-wave {
            position: absolute;
            top: -60px;
            left: 0;
            width: 100%;
            height: 60px;
            background: url('https://svgshare.com/i/pK4.svg') center/cover no-repeat;
        }

        /* Container principal */
        .footer-container {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 50px;
        }

        /* Colunas */
        .footer-col h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #4a9e42;
        }

        .footer-col p {
            color: #e1f0ff;
            line-height: 1.6;
        }

        /* Marca ManWEB maior */
        .footer-col.brand h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        /* Lista de links */
        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            color: #e1f0ff;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-col ul li a:hover {
            color: #32532b;
        }

        /* Ícones sociais (só visual) */
        .social-icons {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        /* Linha final */
        .footer-bottom {
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
            color: #cfdfff;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 20px;
        }

        /* Responsivo */
        @media (max-width: 900px) {
            .footer-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .social-icons {
                justify-content: center;
            }
        }


        /* ===== BANNER CORPORATIVO ESTILO IMAGEM ===== */
        .banner-corporativo {
            background: #167a50;
            /* azul corporativo */
            padding: 90px 20px;
        }

        .banner-container {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
        }

        /* TEXTO ESQUERDA */
        .banner-texto h3 {
            color: #ffffff;
            font-weight: 400;
            letter-spacing: 2px;
        }

        .banner-texto h2 {
            color: white;
            font-size: 42px;
            margin-bottom: 15px;
        }

        .banner-texto p {
            color: #d6e0f0;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        /* BOTÃO */
        .banner-btn {
            padding: 10px 28px;
            background: transparent;
            color: white;
            border: 1px solid white;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .banner-btn:hover {
            background: white;
            color: #386e50;
        }

        /* PAINEL DIREITA */
        .banner-visual {
            display: flex;
            justify-content: center;
        }

        /* painel branco com borda arredondada tipo “bolha” */
        .painel-branco {
            background: white;
            border-radius: 120px 20px 20px 120px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            width: 100%;
            max-width: 600px;
        }

        /* números */
        .dados {
            padding: 40px;
        }

        .dado-item h4 {
            color: #2f704f;
            font-size: 36px;
            margin-bottom: 5px;
        }

        .dado-item span {
            color: #2f3f30;
        }

        /* imagem */
        .foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* RESPONSIVO */
        @media (max-width: 900px) {
            .banner-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .painel-branco {
                grid-template-columns: 1fr;
                border-radius: 20px;
            }
        }

        .manutencao {
            position: relative;
            height: 40vh;
            background: url("images/manu.jpg") center/cover no-repeat;
            display: flex;
            align-items: center;
            padding: 0 8%;
            color: white;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        /* Degradê azul escuro por cima da imagem */
        .manutencao .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right,
                    rgba(6, 15, 40, 0.95),
                    rgba(6, 15, 40, 0.7),
                    rgba(6, 15, 40, 0.2));
            z-index: 1;
        }

        .manutencao .conteudo {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .manutencao .numero {
            color: #38853e;
            font-weight: bold;
            font-size: 18px;
        }

        .manutencao h1 {
            font-size: 48px;
            line-height: 1.2;
            margin: 15px 0;
        }

        .manutencao p {
            font-size: 18px;
            color: #d0d8ff;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .manutencao {
                height: auto;
                padding: 60px 5%;
            }

            .manutencao h1 {
                font-size: 32px;
            }
        }

        .controle {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
            text-align: center;
        }

        .controle h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #167a50
        }

        .subtitle {
            font-size: 16px;
            color: #435a4b;
            margin-bottom: 48px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 32px 24px;
            text-align: left;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            border-color: #43aa1b;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1);
            transform: translateY(-4px);
        }

        .icon {
            font-size: 32px;
            margin-bottom: 16px;
        }

        .card h2 {
            font-size: 22px;
            margin-bottom: 12px;
        }

        .card p {
            font-size: 15px;
            color: #4f634b;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .card a {
            color: #356e4f;
            font-weight: 500;
            text-decoration: none;
        }

        .card a:hover {
            text-decoration: underline;
        }

        .icon {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
        }

        .icon svg {
            width: 100%;
            height: 100%;
            stroke: #529176;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>
</head>

<body>

    <div class="video-hero">

        <div class="video-slide active">
            <video autoplay muted loop>
                <source src="{{ asset('images/industria.mp4') }}" type="video/mp4">
            </video>
        </div>

        <div class="video-slide">
            <video autoplay muted loop>
                <source src="{{ asset('images/video2.mp4') }}" type="video/mp4">
            </video>
        </div>

        <div class="video-slide">
            <video autoplay muted loop>
                <source src="{{ asset('images/video3.mp4') }}" type="video/mp4">
            </video>
        </div>

        <div id="overlay"></div>

        <div class="hero-text">
            <h1>ManWEB</h1>
            <p>Sistema inteligente para gestão de manutenção industrial e preventiva.</p>
            <button class="hero-btn">Saiba mais</button>
        </div>

        <button class="nav-btn prev" onclick="mudarSlide(-1)">
            <svg viewBox="0 0 24 24">
                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6z" />
            </svg>
        </button>

        <button class="nav-btn next" onclick="mudarSlide(1)">
            <svg viewBox="0 0 24 24">
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z" />
            </svg>
        </button>


        <div class="dots">
            <span class="dot active" onclick="irPara(0)"></span>
            <span class="dot" onclick="irPara(1)"></span>
            <span class="dot" onclick="irPara(2)"></span>
        </div>

        <div class="progress-bar" id="progress"></div>
    </div>

    <a href="#" class="back-to-top" id="backToTop">↑</a>
    <section class="banner-corporativo">
        <div class="banner-container">

            <!-- LADO ESQUERDO (texto) -->
            <div class="banner-texto">
                <h3>BEM-VINDO</h3>
                <h2>AO MANWEB</h2>

                <p>
                    Nosso sistema apoia equipes de manutenção em indústrias de todos os portes,
                    ajudando a organizar processos, reduzir paradas e aumentar a produtividade.
                    Presente em diversos segmentos, o ManWEB conecta pessoas, dados e equipamentos.
                </p>

                <button class="banner-btn">SAIBA MAIS</button>
            </div>
            <!--Bem vindo-->
            <!-- LADO DIREITO (painel visual) -->
            <div class="banner-visual">
                <div class="painel-branco">
                    <div class="dados">
                        <div class="dado-item">
                            <h4>+3000</h4>
                            <span>Ordens de Serviço</span>
                        </div>
<div class="dado-item">
                            <h4>+2500</h4>
                            <span>Checklists Verificados</span>
                        </div>
                        <div class="dado-item">
                            <h4>+85</h4>
                            <span>Equipamentos</span>
                        </div>
                    </div>

                    <div class="foto">
                        <img src="{{ asset('images/propagandas.png') }}" alt="Equipe ManWEB">
                    </div>
                </div>
            </div>

        </div>
    </section>
    <style>
        .hero-section {
            background: #f3f5f7;
            padding: 80px 40px;
        }

        .hero-container {
            display: flex;
            max-width: 1150px;
            margin: auto;
            gap: 50px;
            align-items: center;
        }

        .hero-left {
            flex: 1;
        }

        .badges {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .badges img {
            height: 45px;
        }

        .hero-title {
            font-size: 38px;
            color: #0b1f3a;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .hero-subtitle {
            font-size: 17px;
            color: #555;
            margin-bottom: 25px;
        }

        .buttons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-primary {
            background: #1fb141;
            /* VERDE PRINCIPAL */
            color: white;
            padding: 12px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        .phone {
            color: #0b1f3a;
            font-weight: 600;
        }

        .hero-right {
            flex: 1;
            text-align: center;
        }

        .hero-right img {
            width: 100%;
            max-width: 480px;
        }

        /* Responsivo */
        @media (max-width: 900px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }

            .buttons {
                justify-content: center;
            }
        }
    </style>

    <section class="hero-section">
        <div class="hero-container">

            <!-- ESQUERDA (TEXTO) -->
            <div class="hero-left">

                <h1 class="hero-title">
                    Manutenção e Confiabilidade:<br>
                    Maximize seus resultados<br>
                    com a Manweb
                </h1>

                <p class="hero-subtitle">
                    Antecipe falhas, digitalize o chão de fábrica e aumente a disponibilidade
                    com monitoramento online e gestão de ativos baseada em IA.
                </p>

                <div class="buttons">
                    <a href="#" class="btn-primary">Ver como funciona</a>
                    <span class="phone">Ligue agora ☎ 46 991104509</span>
                </div>

            </div>

            <!-- DIREITA (IMAGEM) -->
            <div class="hero-right">
                <img src="images/tablet.png" alt="IA Manweb">
            </div>

        </div>
    </section>

    <section class="controle">
        <h1>Central de controle unificada para sua indústria</h1>
        <p class="subtitle">
            Uma só visão para planejar manutenção, monitorar ativos e otimizar a produção.
        </p>

        <div class="cards">
            <div class="card">
                <div class="icon">
                    <!-- Sensor -->
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M12 2v4M4.9 4.9l2.8 2.8M2 12h4M4.9 19.1l2.8-2.8M12 18v4M19.1 19.1l-2.8-2.8M18 12h4M19.1 4.9l-2.8 2.8" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </div>
                <h2>Sensores</h2>
                <p>
                    Monitore a condição dos ativos: antecipe falhas, evite paradas inesperadas e reduza custos.
                </p>
                <a href="#">Monitore máquinas →</a>
            </div>

            <div class="card">
                <div class="icon">
                    <!-- Software -->
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="4" width="18" height="14" rx="2" />
                        <path d="M8 20h8M12 18v2" />
                    </svg>
                </div>
                <h2>Software</h2>
                <p>
                    CMMS inteligente para operações confiáveis: registre tarefas, acompanhe dados em tempo real e
                    garanta rastreabilidade.
                </p>
                <a href="#">Gerencie ativos →</a>
            </div>

            <div class="card">
                <div class="icon">
                    <!-- OEE / Gráfico -->
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 19V5M10 19V9M16 19V3M22 19H2" />
                    </svg>
                </div>
                <h2>OEE</h2>
                <p>
                    Inteligência de Dados e Eficiência Operacional: transforme dados de processos em lucro.
                </p>
                <a href="#">Otimize processos →</a>
            </div>
        </div>
    </section>
    <section class="sobre">
        <div class="sobre-container">

            <div class="sobre-texto">
                <h2>Sobre o ManWEB</h2>
                <p>
                    O ManWEB é um sistema moderno desenvolvido para auxiliar empresas na gestão
                    da manutenção industrial e preventiva. Ele permite acompanhar equipamentos,
                    ordens de serviço, intervenções técnicas e indicadores de desempenho em tempo real.
                </p>

                <p>
                    Com uma interface intuitiva e focada no usuário, o ManWEB ajuda sua equipe a reduzir
                    paradas inesperadas, organizar processos e aumentar a eficiência operacional.
                </p>

                <button class="hero-btn">Conheça mais</button>
            </div>

            <div class="sobre-imagem">
                <video controls preload="none" width="100%" poster="{{ asset('images/capa-video.png') }}">
                    <source src="{{ asset('images/manutecao.mp4') }}" type="video/mp4">
                    Seu navegador não suporta vídeos HTML5.
                </video>
            </div>

        </div>
    </section>

    <section class="destaques">
        <h2 class="titulo-destaques">Por que usar o ManWEB?</h2>

        <p class="subtitulo">
            Uma plataforma completa para gestão de manutenção industrial, com gráficos inteligentes,
            controle de ordens de serviço e ferramentas avançadas como gestão de estoque e monitoramento de
            equipamentos.
        </p>

        <div class="estatisticas">
            <div class="stat">
                <h4>+3000</h4>
                <p>Ordens de Serviço</p>
            </div>

            <div class="stat">
                <h4>+85</h4>
                <p>Equipamentos Monitorados</p>
            </div>

            <div class="stat">
                <h4>98%</h4>
                <p>Disponibilidade Operacional</p>
            </div>
        </div>
    </section>

    <footer class="footer-novo">
        <div class="footer-wave"></div>

        <div class="footer-container">

            <div class="footer-col brand">
                <h2>ManWEB</h2>
                <p>
                    Plataforma inteligente para gestão de manutenção industrial,
                    controle de ordens de serviço, indicadores em tempo real e
                    gestão completa de estoque e equipamentos.
                </p>


            </div>

            <div class="footer-col">
                <h3>Links Rápidos</h3>
                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Funcionalidades</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Contato</h3>
                <p>contato@manweb.com</p>
                <p>(49) 99110-4509</p>
                <p>Brasil</p>
            </div>

        </div>

        <div class="footer-bottom">
            © <?php echo date('Y'); ?> ManWEB — Todos os direitos reservados.
        </div>
    </footer>





    <script>
        let index = 0;
        const slides = document.querySelectorAll(".video-slide");
        const dots = document.querySelectorAll(".dot");
        const progress = document.getElementById("progress");

        function mostrarSlide(n) {
            slides.forEach(s => s.classList.remove("active"));
            dots.forEach(d => d.classList.remove("active"));

            index = (n + slides.length) % slides.length;

            slides[index].classList.add("active");
            dots[index].classList.add("active");

            progress.style.width = "0%";
            setTimeout(() => progress.style.width = "100%", 100);
        }

        function mudarSlide(n) {
            mostrarSlide(index + n);
        }

        function irPara(n) {
            mostrarSlide(n);
        }

        setInterval(() => mudarSlide(1), 6000);

        // Botão voltar ao topo
        const backToTopButton = document.getElementById("backToTop");

        window.addEventListener("scroll", () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add("active");
            } else {
                backToTopButton.classList.remove("active");
            }
        });

        backToTopButton.addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>
    <script>
        document.querySelectorAll(".card").forEach(card => {
            card.addEventListener("click", () => {
                console.log("Card clicado:", card.querySelector("h2").innerText);
            });
        });
    </script>

</body>

</html>
