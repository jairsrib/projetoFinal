<?php
require_once './header.php';
include_once './config/config.php';
include_once './classes/Noticia.php';

$noticia = new Noticia($db);
$noticias = $noticia->buscarTodasOrdenadas(); // Função personalizada abaixo
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/dist/css/bootstrap-grid.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Dashboard</title>
</head>

<body>

  <div class="container-fluid">
    <div class="banner-container">
      <img class="banner" src="./img/banner.png" alt="Banner principal">
    </div>
  </div>
  <a href="index.php">Voltar para o Início</a> <!-- pagina de testes -->
  <div class="container-fluid">
    <div class="titulo-home">
      <h1>Ultimas Noticias</h1>
    </div>
    <section class="container my-5">
      <div class="row g-4">
        <?php foreach ($noticias as $index => $n): ?>
          <div class="col-md-<?= $index === 0 ? '6' : '12' ?>">
            <a href="noticia.php?id=<?= $n['id'] ?>" class="news-card text-white text-decoration-none">
              <div class="news-image" style="background-image: url('uploads/<?= $n['imagem'] ?>'); height: <?= $index === 0 ? '350px' : '160px' ?>;">
                <div class="news-overlay p-3 d-flex flex-column justify-content-end h-100">
                  <h<?= $index === 0 ? 2 : 5 ?> class="fw-bold"><?= htmlspecialchars($n['titulo']) ?></h<?= $index === 0 ? 2 : 5 ?>>
                  <p class="small"><?= htmlspecialchars(substr($n['texto'], 0, 80)) ?>...</p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
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


<style>
  body {
    width: 100%;
    height: 100%;

    background: #171717;
    --gap: 5em;
    --line: 1px;
    --color: rgba(255, 255, 255, 0.2);

    background-image: linear-gradient(-90deg,
        transparent calc(var(--gap) - var(--line)),
        var(--color) calc(var(--gap) - var(--line) + 1px),
        var(--color) var(--gap)),
      linear-gradient(0deg,
        transparent calc(var(--gap) - var(--line)),
        var(--color) calc(var(--gap) - var(--line) + 1px),
        var(--color) var(--gap));
    background-size: var(--gap) var(--gap);
  }

  .banner-container {
    width: 100%;
    max-height: 400px;
    overflow: hidden;
    border-radius: 20px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
  }

  .banner {
    width: 100%;
    height: auto;
    object-fit: cover;
    transition: transform 0.3s ease;
    display: block;
  }

  .banner:hover {
    transform: scale(1.02);
  }

  .titulo-home {
    color: #FF084B;
    font-family: DM Sans, sans-serif;
    font-size: 2em;
    display: flex;
    justify-content: center;
  }




  .carousel {
    position: relative;
    overflow: hidden;
    max-width: 600px;
    margin: 0 auto;
    border-radius: 10px;
  }

  .carousel__slides {
    display: flex;
    width: 500%;
    transition: margin-left 0.6s ease-in-out;
  }

  .carousel__slide {
    width: 100%;
    height: 750px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #171717;
  }

  .carousel__slide img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    border-radius: 10px;
  }



  .carousel__thumbnails {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 15px;
    padding: 0;
    list-style: none;
  }

  .carousel__thumbnails li {
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 5px;
    overflow: hidden;
    transition: border 0.3s;
  }

  .carousel__thumbnails li.active {
    border-color: #FF084B;
  }

  .carousel__thumbnails img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
  }

  @media (max-width: 700px) {
    .carousel__slide img {
      height: 180px;
    }

    .carousel__thumbnails img {
      width: 60px;
      height: 45px;
    }
  }

  .news-card .news-image {
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    transition: transform 0.3s ease;
  }

  .news-card:hover .news-image {
    transform: scale(1.02);
  }

  .news-overlay {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent 60%);
    border-radius: 10px;
    color: #fff;
  }
</style>

<script>
  let currentIndex = 0;
  const slides = document.getElementById("slides");
  const thumbnails = document.querySelectorAll("#thumbnails li");
  const totalSlides = thumbnails.length;

  function showSlide(index) {
    currentIndex = index;
    slides.style.marginLeft = `-${index * 100}%`;
    thumbnails.forEach((thumb, i) => {
      thumb.classList.toggle("active", i === index);
    });
  }

  thumbnails.forEach((thumb, index) => {
    thumb.addEventListener("click", () => {
      showSlide(index);
    });
  });

  setInterval(() => {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
  }, 5000);

  showSlide(0);
</script>