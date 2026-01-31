@include('site.navigation_bar')

<section class="hero-manweb">
    <div class="hero-overlay"></div>

    <div class="hero-content container">
        <div class="row align-items-center">

            <!-- Texto -->
            <div class="col-lg-6 text-white">
                <h1 class="hero-title">
                    Gestão de<br>
                    Manutenção
                </h1>

                <p class="hero-text">
                    No Manweb, simplificamos e potencializamos a gestão de manutenção industrial
                    através de tecnologia CMMS inovadora, aumentando eficiência, reduzindo custos
                    e fortalecendo a confiabilidade dos seus ativos.
                </p>

                <div class="hero-links">
                    <a href="#missao">Missão</a>
                    <span>•</span>
                    <a href="#visao">Visão</a>
                    <span>•</span>
                    <a href="#valores">Valores</a>
                    <span>•</span>
                    <a href="#diferenciais">Diferenciais</a>
                </div>
            </div>

            <!-- Imagem -->


        </div>
    </div>
    <style>
        .hero-manweb {
            position: relative;
            min-height: 40vh;
            /* antes era 90vh */
            background: url('images/gestao.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            padding: 80px 0;
            /* garante um respiro interno */
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right,
                    rgba(5, 10, 25, 0.95) 0%,
                    rgba(5, 10, 25, 0.85) 45%,
                    rgba(5, 10, 25, 0.3) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .hero-text {
            font-size: 1.2rem;
            color: #d0d6e0;
            max-width: 520px;
            margin-bottom: 30px;
        }

        .hero-links {
            font-size: 0.95rem;
        }

        .hero-links a {
            color: #4da3ff;
            text-decoration: none;
            font-weight: 500;
        }

        .hero-links span {
            margin: 0 8px;
            color: #4da3ff;
        }

        .hero-links a:hover {
            text-decoration: underline;
        }

        .hero-image {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .hero-contrato {
            position: relative;
            width: 100%;
            min-height: 60vh;
            background: radial-gradient(circle at center, #ffffff 0%, #ffffff 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 20px;
            overflow: hidden;
        }

        .hero-contrato-overlay {
            position: absolute;
            inset: 0;

        }

        .hero-contrato-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            color: #1a376e;
        }

        .hero-contrato-content h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 25px;
        }

        .hero-contrato-content p {
            font-size: 1.2rem;
            color: #303030;
            line-height: 1.6;
        }

        .institucional-section {
            background: #f5f5f5;
            padding: 80px 40px;
        }

        .institucional-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
        }

        .institucional-card {
            display: flex;
            flex-direction: column;
        }

        .institucional-title span {
            font-size: 0.9rem;
            color: #1f3c88;
            letter-spacing: 1px;
        }

        .institucional-title h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1f3c88;
            margin: 5px 0 8px;
        }

        .institucional-title .line {
            width: 50px;
            height: 4px;
            background: #b6d43a;
            margin-bottom: 15px;
        }
    </style>
</section>

<section class="hero-contrato">
    <div class="hero-contrato-overlay"></div>

    <div class="hero-contrato-content">
        <h1>
            Sobre o Man Web
        </h1>

        <p>
            O Man Web é um software de gestão de manutenção desenvolvido para apoiar empresas na organização, controle e
            melhoria contínua de seus processos de manutenção. Trata-se de uma solução moderna baseada em tecnologia
            CMMS (Computerized Maintenance Management System), que permite gerenciar ativos, planejar intervenções e
            monitorar o desempenho operacional de forma integrada e eficiente
        </p>
    </div>
</section>
<section class="institucional-section">
    <div class="container">

        <div class="institucional-grid">

            <!-- Card 1 -->
            <div class="institucional-card">
                <div class="institucional-title">
                    <span>Conheça</span>
                    <h3>Graficos Modernos</h3>
                    <div class="line"></div>
                </div>
                <img src="images/fabrica.jpg" alt="A FAPOLPA">
            </div>

            <!-- Card 2 -->
            <div class="institucional-card">
                <div class="institucional-title">
                    <span>Os</span>
                    <h3>Estoques de gestao</h3>
                    <div class="line"></div>
                </div>
                <img src="images/produtos.jpg" alt="Produtos">
            </div>

            <!-- Card 3 -->
            <div class="institucional-card">
                <div class="institucional-title">
                    <span>Nosso</span>
                    <h3>Gerador de ordem de Serviço</h3>
                    <div class="line"></div>
                </div>
                <img src="images/ambiental.jpg" alt="Responsabilidade Ambiental">
            </div>

        </div>
    </div>
</section>
