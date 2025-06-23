<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/dist/css/bootstrap-grid.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <?php
        require_once './header.php';
        ?>
    </header>
    <div class="container-fluid">
        <div class="banner-container">
            <img class="banner" src="./img/banner.png" alt="Banner principal">
        </div>
        </div>
    <div class="container-fluid">
        <div class="titulo-home">
        <h1>Ultimas Noticias</h1>
        </div>
  <section class="container my-5">
  <div class="row g-4">
    <div class="col-md-6" style="width: 400px; height: 500px;">
      <a href="#" class="news-card text-white text-decoration-none">
        <div class="news-image" style="background-image: url('./img/noticia3.jpg'); height: 100%; min-height: 350px;">
          <div class="news-overlay p-3 d-flex flex-column justify-content-end h-100">
            <h2 class="fw-bold">Teste</h2>
            <p class="small">Testando</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6">
      <div class="row g-4">

        <div class="col-12">
          <a href="#" class="news-card text-white text-decoration-none">
            <div class="news-image" style="background-image: url('./img/noticia2.jpg'); height: 260px;">
              <div class="news-overlay p-3 d-flex flex-column justify-content-end h-100">
                <h5>Capcom Fighters</h5>
                <p class="small">Street Fighter 6 Rouba a cena</p>
              </div>
            </div>
          </a>
        </div>

        <div class="col-12">
          <a href="#" class="news-card text-white text-decoration-none">
            <div class="news-image" style="background-image: url('./img/noticia.jpg'); height: 200px;">
              <div class="news-overlay p-3 d-flex flex-column justify-content-end h-100">
                <h5>GTA VI</h5>
                <p class="small">Jogo mais Esperado Do Ano</p>
              </div>
            </div>
          </a>
        </div>

      </div>
    </div>
  </div>
</section>
        <div class="row-3">
        <div class="col-12">
<section>
    <div class="container">
        <div class="carousel-wrapper">
            <div class="carousel" id="carousel">
                <div class="carousel__slides" id="slides">
                    <div class="carousel__slide">
                        <figure>
                            <img src="img/SobreE-Sports.png" alt="">
                            <figcaption><span class="credit"></span></figcaption>
                        </figure>
                    </div>
                    <div class="carousel__slide">
                        <figure>
                            <img src="img/profissionalismo.png" alt="">
                            <figcaption><span class="credit"></span></figcaption>
                        </figure>
                    </div>
                    <div class="carousel__slide">
                        <figure>
                            <img src="img/olimpiadas.png" alt="">
                            <figcaption><span class="credit"></span></figcaption>
                        </figure>
                    </div>
                    <div class="carousel__slide">
                        <figure>
                            <img src="img/lucrativo.png" alt="">
                            <figcaption><span class="credit"></span></figcaption>
                        </figure>
                    </div>
                    <div class="carousel__slide">
                        <figure>
                            <img src="img/competitivo.png" alt="">
                            <figcaption><span class="credit"></span></figcaption>
                        </figure>
                    </div>
                </div>
                <ul class="carousel__thumbnails" id="thumbnails">
                    <li data-index="0"><img src="img/SobreE-Sports.png" alt=""></li>
                    <li data-index="1"><img src="img/profissionalismo.png" alt=""></li>
                    <li data-index="2"><img src="img/olimpiadas.png" alt=""></li>
                    <li data-index="3"><img src="img/lucrativo.png" alt=""></li>
                    <li data-index="4"><img src="img/competitivo.png" alt=""></li>
                </ul>
            </div>
        </div>
    </div>
</section>

        </div>
        </div>
    </div>
<footer>
    <?php 
    require_once './footer.php';
    ?>
</footer>
</body>
</html>
<script src="./assets/js/carrosel.js"></script>