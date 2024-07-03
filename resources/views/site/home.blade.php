@include('site.navigation_bar')

<body>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/apresentacao/industria.mp4') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <div class="carousel-item">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/video5.mp4') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <div class="carousel-item">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/apresentacao/video1.mp4') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <!--Div imagem fosca-->
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

    <!--inicio do rodapé da pagina-->
    <footer>
        <div>
            <style>
                footer {
                    text-align: center;
                    width: 100%;
                }

                .title-footer {
                    color: black;
                    margin: 10px;
                }
            </style>
            <a href="#" class="title-footer">HOME</a>|
            <a href="" class="title-footer">PRODUTOS</a>|
            <a href="#" class="title-footer">SOBRE NÓS</a>|
            <a href="#" class="title-footer">DOWNLOADS</a>
            <a href="#" class="title-footer">Webmail</a>
        </div>
    </footer>
</body>

</html>