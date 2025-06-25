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
  <link rel="stylesheet" href="assets/dashboard.css">
  <title>Dashboard</title>
</head>

<body>

  <div class="container-fluid">
    <div class="banner-container">
      <img class="banner" src="./img/banner.png" alt="Banner principal">
    </div>
  </div>
  <a href="portal.php">Voltar para o Início</a> <!-- pagina de testes -->
  <div class="container-fluid">
    <div class="titulo-home">
      <h1>Ultimas Noticias</h1>
    </div>

    <?php
    // Limita às 5 primeiras notícias (últimas adicionadas)
    $ultimasNoticias = array_slice($noticias, 0, 5);
    ?>

    <section class="container my-5">
      <div class="row g-4">
        <?php foreach ($ultimasNoticias as $index => $n): ?>
          <div class="col-md-<?= $index === 0 ? '12' : '6' ?> col-lg-<?= $index === 0 ? '8' : '4' ?>">
            <a href="noticia.php?id=<?= $n['id'] ?>" class="news-card text-white text-decoration-none h-100 d-block">
              <div class="news-image d-flex flex-column justify-content-end"
                style="background-image: url('uploads/<?= $n['imagem'] ?>'); height: <?= $index === 0 ? '360px' : '240px' ?>;">
                <div class="news-overlay">
                  <h5><?= htmlspecialchars($n['titulo']) ?></h5>
                  <p><?= htmlspecialchars(substr($n['texto'], 0, 80)) ?>...</p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>


    <section class="container-fluid my-5 px-5">
      <h2 class="text-white mb-4">Mais Notícias</h2>

      <?php foreach ($noticias as $n): ?>
        <?php
        // Cria o objeto DateTime com a data da notícia e fuso horário de São Paulo
        $dataNoticia = new DateTime($n['data'], new DateTimeZone('America/Sao_Paulo'));
        $agora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $intervalo = $agora->diff($dataNoticia);

        // Formata o tempo decorrido
        if ($intervalo->d >= 1) {
          $tempoFormatado = 'Há ' . $intervalo->d . ' dia' . ($intervalo->d > 1 ? 's' : '');
        } elseif ($intervalo->h >= 1) {
          $tempoFormatado = 'Há ' . $intervalo->h . ' hora' . ($intervalo->h > 1 ? 's' : '');
        } elseif ($intervalo->i >= 1) {
          $tempoFormatado = 'Há ' . $intervalo->i . ' minuto' . ($intervalo->i > 1 ? 's' : '');
        } else {
          $tempoFormatado = 'Agora mesmo';
        }
        ?>

        <!-- Exibição da notícia -->
        <div class="row noticia-bloco g-3 align-items-center mb-4 p-3 rounded">
          <div class="col-md-4">
            <a href="noticia.php?id=<?= $n['id'] ?>">
              <div class="noticia-img" style="background-image: url('uploads/<?= $n['imagem'] ?>');"></div>
            </a>
          </div>
          <div class="col-md-8 text-light d-flex flex-column justify-content-between">
            <h4 class="fw-bold mb-2">
              <a href="noticia.php?id=<?= $n['id'] ?>" class="text-white text-decoration-none">
                <?= htmlspecialchars($n['titulo']) ?>
              </a>
            </h4>
            <p class="noticia-resumo mb-2">
              <?= htmlspecialchars(substr($n['texto'], 0, 250)) ?>...
            </p>
            <small class="text-secondary mt-2"><?= $tempoFormatado ?> — em <?= htmlspecialchars($n['categoria'] ?? 'Esportes') ?></small>
          </div>
        </div>
      <?php endforeach; ?>
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
