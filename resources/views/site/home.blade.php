@include('site.navigation_bar')

<body>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/horizonte_fundo.jpg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/fapolpa1.jpeg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/slide-home/3.jpg') }}" class="d-block w-100" alt="...">
                </div>

                <div id="overlay"></div>
                <div class="carousel-caption">
                    <h1>ManWEB</h1>
                    Sistema para gestão de manutenção.
                    <input type="button" value="saber mais...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Início do rodapé da página -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }



            .content {
                flex: 1;
                padding: 40px;
                text-align: center;
            }

            footer {
                background: linear-gradient(135deg, #2c3e50, #1a2530);
                color: #fff;
                padding: 50px 0 20px;
                margin-top: auto;
            }

            .footer-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .footer-content {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                margin-bottom: 40px;
            }

            .footer-section {
                flex: 1;
                min-width: 250px;
                margin-bottom: 30px;
                padding: 0 15px;
            }

            .footer-section h3 {
                font-size: 1.4rem;
                margin-bottom: 20px;
                position: relative;
                padding-bottom: 10px;
            }

            .footer-section h3::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: 0;
                width: 50px;
                height: 2px;
                background-color: #3498db;
            }

            .footer-section.about p {
                line-height: 1.6;
                margin-bottom: 20px;
                color: #bbb;
            }

            .footer-section.links ul {
                list-style: none;
            }

            .footer-section.links li {
                margin-bottom: 10px;
            }

            .footer-section.links a {
                color: #bbb;
                text-decoration: none;
                transition: all 0.3s ease;
                display: inline-block;
            }

            .footer-section.links a:hover {
                color: #3498db;
                transform: translateX(5px);
            }

            .footer-section.contact span {
                display: block;
                margin-bottom: 10px;
                color: #bbb;
            }

            .footer-section.contact i {
                margin-right: 10px;
                color: #3498db;
            }

            .social-links {
                display: flex;
                gap: 15px;
                margin-top: 20px;
            }

            .social-links a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                color: #fff;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .social-links a:hover {
                background-color: #3498db;
                transform: translateY(-5px);
            }

            .footer-bottom {
                text-align: center;
                padding-top: 20px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                color: #bbb;
                font-size: 0.9rem;
            }

            .footer-nav {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                margin-bottom: 20px;
            }

            .footer-link {
                color: #fff;
                text-decoration: none;
                margin: 0 15px;
                font-weight: 500;
                transition: color 0.3s;
                position: relative;
            }

            .footer-link:hover {
                color: #3498db;
            }

            .footer-link::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: -5px;
                left: 0;
                background-color: #3498db;
                transition: width 0.3s ease;
            }

            .footer-link:hover::after {
                width: 100%;
            }

            .back-to-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background-color: #3498db;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
                opacity: 0;
                visibility: hidden;
                z-index: 1000;
            }

            .back-to-top.active {
                opacity: 1;
                visibility: visible;
            }

            .back-to-top:hover {
                background-color: #2980b9;
                transform: translateY(-5px);
            }

            /* Responsividade */
            @media (max-width: 768px) {
                .footer-content {
                    flex-direction: column;
                }

                .footer-section {
                    margin-bottom: 30px;
                }

                .footer-nav {
                    flex-direction: column;
                    align-items: center;
                    gap: 10px;
                }

                .footer-link {
                    margin: 5px 0;
                }
            }
        </style>

        <footer hidden>
            <div class="footer-container">
                <nav class="footer-nav">
                    <a href="#" class="footer-link">HOME</a>
                    <a href="#" class="footer-link">PRODUTOS</a>
                    <a href="#" class="footer-link">SOBRE NÓS</a>
                    <a href="#" class="footer-link">DOWNLOADS</a>
                    <a href="#" class="footer-link">WEBMAIL</a>
                </nav>

                <div class="footer-content">
                    <div class="footer-section about">
                        <h3>Sobre Nós</h3>
                        <p>Somos uma empresa inovadora focada em oferecer as melhores soluções para nossos clientes. Nossa missão é transformar ideias em realidade.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <div class="footer-section links">
                        <h3>Links Úteis</h3>
                        <ul>
                            <li><a href="#">Política de Privacidade</a></li>
                            <li><a href="#">Termos de Uso</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Suporte</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>

                    <div class="footer-section contact">
                        <h3>Contato</h3>
                        <span><i class="fas fa-map-marker-alt"></i> Av. Gov Pedro Viriato Parigot de Souza, 2184 - Palmas, PR CEP 85692-392</span>
                        <span>
                            <i class="fas fa-phone"></i> (46) 99110-4509
                        </span>
                        <span>
                            <i class="fab fa-whatsapp"></i> (46) 99110-4509
                        </span>
                        <span><i class="fas fa-envelope"></i> gerencia@manweb.com.br</span>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; 2025 Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>

        <a href="#" class="back-to-top" id="backToTop">
            <i class="fas fa-arrow-up"></i>
        </a>

        <script>
            // Botão "Voltar ao Topo"
            const backToTopButton = document.getElementById('backToTop');

            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('active');
                } else {
                    backToTopButton.classList.remove('active');
                }
            });

            backToTopButton.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        </script>
</body>

</html>

</body>

</html>