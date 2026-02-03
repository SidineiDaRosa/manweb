@include('site.navigation_bar')




<style>
    /* INVESTORS */
    .investors {
        max-width: 1200px;
        margin: 100px auto;
        padding: 0 20px;
    }

    .investors h2 {
        text-align: center;
        font-size: 32px;
        margin-bottom: 60px;
    }

    .investor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 40px;
    }

    .investor-card {
        text-align: center;
    }



    .investor-card img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 16px;
    }

    .investor-card h3 {
        font-size: 18px;
        margin-bottom: 4px;
    }

    .role {
        font-size: 14px;
        color: #6b7280;
    }

    .quote {
        font-size: 14px;
        margin-top: 16px;
        color: #374151;
        line-height: 1.5;
        font-style: italic;
    }

    .founder {
        text-align: center;
        margin-bottom: 60px;
    }

    .founder img {
        width: 180px;
        height: 180px;
        object-fit: cover;
        margin-bottom: 16px;
        border-radius: 50%;
    }

    .founder h3 {
        font-size: 22px;
        margin-bottom: 4px;
    }

    .founder span {
        font-size: 14px;
        color: #6b7280;
    }

    .section-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        padding: 60px;
        max-width: 1100px;
        margin: auto;
    }

    .texto {
        flex: 1;
    }

    .texto h2 {
        font-size: 32px;
        margin-bottom: 15px;
    }

    .texto p {
        font-size: 18px;
        color: #555;
        line-height: 1.5;
    }

    .imagem {
        flex: 1;
    }

    .imagem img {
        width: 100%;

    }

    .hero-manweb {
        background: linear-gradient(135deg, #1f8842, #329768);
        color: #fff;
        padding: 120px 20px;
    }

    .hero-content {
        max-width: 900px;
        margin: auto;
        text-align: center;
    }

    .hero-content h1 {
        font-size: 44px;
        margin-bottom: 20px;
    }

    .hero-content p {
        font-size: 20px;
        opacity: 0.9;
        margin-bottom: 32px;
    }

    .hero-btn {
        display: inline-block;
        background: #fff;
        color: #1f8860;
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
    }

    .section-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        padding: 100px 20px;
        max-width: 1100px;
        margin: auto;
        align-items: center;
    }

    .texto h2 {
        font-size: 34px;
        margin-bottom: 20px;
        color: #2e742e
    }

    .texto p {
        font-size: 18px;
        color: #3d413dc0;
    }

    @media (max-width: 900px) {
        .section-container {
            grid-template-columns: 1fr;
            text-align: center;
        }
    }

    .founder {
        max-width: 600px;
        margin: 0 auto 80px;
        text-align: center;
    }

    .founder img {
        width: 160px;
        height: 160px;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .founder p {
        margin-top: 16px;
        color: #359661;
    }

    .investor-card {
        background: #ffffff;
        padding: 32px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .investor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }



    .investors h2 {
        color: #1f8842
    }

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
</style>


<!-- INVESTORS -->
<section class="investors">
    <h2>Criador</h2>

    <!-- FOTO DO FUNDADOR -->
    <div class="founder">
        <img src="images/sidinei.jpg" alt="Sidinei da Rosa">
        <h3>Sidinei da Rosa</h3>
        <span>Eng. Eletricista</span>
    </div>

    <!-- CONTEÚDO -->
    <div class="investor-grid">

        <div class="investor-card">
            <div class="logo">MANWEB</div>
            <h3>A Empresa</h3>
            <p class="quote">
                A Manweb nasceu da vontade de resolver problemas reais com tecnologia simples, eficiente e acessível.
            </p>
        </div>

        <div class="investor-card">
            <div class="logo">ORIGEM</div>
            <h3>Visão Inicial</h3>
            <p class="quote">
                A plataforma Manweb surgiu com o objetivo de oferecer soluções digitais sob medida. Inicialmente, a ideia nasceu a partir da necessidade de gerenciar a prestação de serviços na área de manutenção industrial, onde atuávamos. Para isso, foi desenvolvido um aplicativo simples no Microsoft Access 2003.

                No entanto, como essa plataforma não oferecia recursos tecnológicos modernos nem escalabilidade adequada, surgiu a ideia de reescrever o sistema em formato web. Assim, optou-se pelo uso do PHP, e posteriormente a aplicação passou a ser desenvolvida utilizando o framework Laravel.
            </p>
        </div>

        <div class="investor-card">
            <div class="logo">EXPERIÊNCIA</div>
            <h3>“26 anos de experiência na área de manutenção industrial.”</h3>
            <p class="quote">
                Sidinei reúne sólida experiência técnica, visão estratégica e dedicação à inovação em tecnologia aplicada à indústria.
            </p>
        </div>

        <div class="investor-card">
            <div class="logo">PROPÓSITO</div>
            <h3>Missão Manweb</h3>
            <p class="quote">
                Transformar ideias em sistemas funcionais, ajudando empresas a crescerem com tecnologia confiável.
            </p>
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