<?php
require_once './header.php';
include_once './config/config.php';
include_once './classes/Noticia.php';

$noticia = new Noticia($db);
$noticias = $noticia->buscarTodasOrdenadas();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/dist/css/bootstrap-grid.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Caiu o Servidor - Notícias de Games</title>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" defer></script>
  <script src="assets/js/carrosel.js" defer></script>
  <script src="assets/js/modal_noticia.js" defer></script>
</head>

<body>
  <div class="hero-section">
    <div class="container-fluid">
      <div class="banner-container">
        <div class="banner-overlay">
          <div class="banner-content">
            <h1 class="banner-title">
              <i class="fas fa-gamepad me-3"></i>
              Caiu o Servidor
            </h1>
            <p class="banner-subtitle">As melhores notícias do mundo dos games</p>
            <div class="banner-stats">
              <div class="stat-item">
                <i class="fas fa-newspaper"></i>
                <span><?= count($noticias) ?> Notícias</span>
              </div>
              <div class="stat-item">
                <i class="fas fa-users"></i>
                <span>Comunidade Ativa</span>
              </div>
              <div class="stat-item">
                <i class="fas fa-trophy"></i>
                <span>E-Sports</span>
              </div>
            </div>
          </div>
        </div>
        <img class="banner" src="./img/banner.png" alt="Banner principal">
      </div>
    </div>
  </div>

  <div class="quick-nav">
    <div class="container">
      <div class="quick-nav-content">
        <a href="portal.php" class="quick-nav-item">
          <i class="fas fa-home"></i>
          <span>Início</span>
        </a>
        <a href="painel_usuario.php" class="quick-nav-item">
          <i class="fas fa-user"></i>
          <span>Meu Perfil</span>
        </a>
        <a href="#latest-news" class="quick-nav-item">
          <i class="fas fa-newspaper"></i>
          <span>Últimas</span>
        </a>
        <a href="#more-news" class="quick-nav-item">
          <i class="fas fa-list"></i>
          <span>Todas</span>
        </a>
      </div>
    </div>
  </div>
  <?php
  // Limita às 5 primeiras notícias (últimas adicionadas)
  $ultimasNoticias = array_slice($noticias, 0, 5);
  ?>
  <section id="latest-news" class="latest-news-section">
    <div class="container">
      <div class="section-header">
        <div class="section-title">
          <i class="fas fa-fire text-danger me-3"></i>
          <h2>Últimas Notícias</h2>
        </div>
        <div class="section-subtitle">
          <p>Fique por dentro das novidades mais quentes do mundo dos games</p>
        </div>
      </div>

      <div class="row g-4">
        <?php foreach ($ultimasNoticias as $index => $n): ?>
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

          <div class="col-md-<?= $index === 0 ? '12' : '6' ?> col-lg-<?= $index === 0 ? '8' : '4' ?>">
            <div class="news-card-wrapper">
              <div class="news-card text-white text-decoration-none h-100 d-block"
                onclick="abrirModalNoticia(<?= $n['id'] ?>, '<?= htmlspecialchars($n['titulo'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['texto'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['categoria'] ?? 'E-Sports', ENT_QUOTES) ?>', '<?= htmlspecialchars($n['imagem'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['data'], ENT_QUOTES) ?>')">
                <div class="news-image position-relative d-flex flex-column justify-content-end"
                  style="background-image: url('uploads/<?= $n['imagem'] ?>'); height: <?= $index === 0 ? '400px' : '280px' ?>;">
                  <div class="news-overlay p-4">
                    <div class="news-meta mb-2">
                      <span class="news-category">
                        <i class="fas fa-tag me-1"></i>
                        <?= htmlspecialchars($n['categoria'] ?? 'E-Sports') ?>
                      </span>
                      <span class="news-time">
                        <i class="fas fa-clock me-1"></i>
                        <small class="text-secondary mt-2">
                          <?= $tempoFormatado ?> — em <?= htmlspecialchars($n['categoria'] ?? 'Esportes') ?>
                        </small>
                      </span>
                    </div>
                    <h5 class="news-title fw-bold mb-2"><?= htmlspecialchars($n['titulo']) ?></h5>
                    <p class="news-excerpt mb-0"><?= htmlspecialchars(substr($n['texto'], 0, 100)) ?>...</p>
                    <div class="news-read-more">
                      <i class="fas fa-arrow-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="more-news" class="more-news-section">
    <div class="container-fluid">
      <div class="section-header">
        <div class="section-title">
          <i class="fas fa-list-alt text-primary me-3"></i>
          <h2>Mais Notícias</h2>
        </div>
      </div>

      <div class="news-list">
        <?php foreach ($ultimasNoticias as $index => $n): ?>
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
          <div class="news-item">
            <div class="container">
              <div class="row g-4 align-items-center">
                <div class="col-md-4">
                  <div class="news-image-container">
                    <div class="news-item-image-wrapper"
                      onclick="abrirModalNoticia(<?= $n['id'] ?>, '<?= htmlspecialchars($n['titulo'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['texto'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['categoria'] ?? 'E-Sports', ENT_QUOTES) ?>', '<?= htmlspecialchars($n['imagem'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['data'], ENT_QUOTES) ?>')">
                      <img src="uploads/<?= $n['imagem'] ?>" alt="Imagem da notícia" class="news-item-image">
                      <div class="image-overlay">
                        <i class="fas fa-play"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="news-content">
                    <div class="news-meta-top mb-3">
                      <span class="news-category-badge">
                        <i class="fas fa-tag me-1"></i>
                        <?= htmlspecialchars($n['categoria'] ?? 'E-Sports') ?>
                      </span>
                      <span class="news-time">
                        <i class="fas fa-clock me-1"></i>
                        <small class="text-secondary mt-2"><?= $tempoFormatado ?> — em
                          <?= htmlspecialchars($n['categoria'] ?? 'Esportes') ?></small>
                      </span>
                    </div>

                    <h3 class="news-item-title"
                      onclick="abrirModalNoticia(<?= $n['id'] ?>, '<?= htmlspecialchars($n['titulo'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['texto'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['categoria'] ?? 'E-Sports', ENT_QUOTES) ?>', '<?= htmlspecialchars($n['imagem'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['data'], ENT_QUOTES) ?>')">
                      <?= htmlspecialchars($n['titulo']) ?>
                    </h3>

                    <p class="news-item-excerpt">
                      <?= htmlspecialchars(substr($n['texto'], 0, 200)) ?>...
                    </p>

                    <div class="news-actions">
                      <button class="btn-read-more"
                        onclick="abrirModalNoticia(<?= $n['id'] ?>, '<?= htmlspecialchars($n['titulo'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['texto'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['categoria'] ?? 'E-Sports', ENT_QUOTES) ?>', '<?= htmlspecialchars($n['imagem'], ENT_QUOTES) ?>', '<?= htmlspecialchars($n['data'], ENT_QUOTES) ?>')">
                        <i class="fas fa-arrow-right me-2"></i>
                        Ler Mais
                      </button>
                      <div class="news-stats">
                        <span class="stat">
                          <i class="fas fa-eye me-1"></i>
                          <?= rand(100, 5000) ?>
                        </span>
                        <span class="stat">
                          <i class="fas fa-comment me-1"></i>
                          <?= rand(5, 50) ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="carousel-section">
    <div class="container">
      <div class="section-header">
        <div class="section-title">
          <i class="fas fa-images text-warning me-3"></i>
          <h2>Destaques</h2>
        </div>
      </div>

      <div class="carousel-wrapper">
        <div class="carousel" id="carousel">
          <div class="carousel__slides" id="slides">
            <div class="carousel__slide">
              <figure>
                <img src="img/SobreE-Sports.png" alt="E-Sports">
                <figcaption><span class="credit">E-Sports</span></figcaption>
              </figure>
            </div>
            <div class="carousel__slide">
              <figure>
                <img src="img/profissionalismo.png" alt="Profissionalismo">
                <figcaption><span class="credit">Profissionalismo</span></figcaption>
              </figure>
            </div>
            <div class="carousel__slide">
              <figure>
                <img src="img/olimpiadas.png" alt="Olimpíadas">
                <figcaption><span class="credit">Olimpíadas</span></figcaption>
              </figure>
            </div>
            <div class="carousel__slide">
              <figure>
                <img src="img/lucrativo.png" alt="Lucrativo">
                <figcaption><span class="credit">Lucrativo</span></figcaption>
              </figure>
            </div>
            <div class="carousel__slide">
              <figure>
                <img src="img/competitivo.png" alt="Competitivo">
                <figcaption><span class="credit">Competitivo</span></figcaption>
              </figure>
            </div>
          </div>
          <ul class="carousel__thumbnails" id="thumbnails">
            <li data-index="0"><img src="img/SobreE-Sports.png" alt="E-Sports"></li>
            <li data-index="1"><img src="img/profissionalismo.png" alt="Profissionalismo"></li>
            <li data-index="2"><img src="img/olimpiadas.png" alt="Olimpíadas"></li>
            <li data-index="3"><img src="img/lucrativo.png" alt="Lucrativo"></li>
            <li data-index="4"><img src="img/competitivo.png" alt="Competitivo"></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <div class="modal-custom" id="modalNoticia">
    <div class="modal-content-custom modal-noticia">
      <button class="close-modal-btn" onclick="fecharModalNoticia()">&times;</button>

      <div class="modal-noticia-content">
        <div class="modal-noticia-image">
          <img id="modalNoticiaImg" src="" alt="Imagem da notícia">
        </div>

        <div class="modal-noticia-body">
          <div class="modal-noticia-meta">
            <span class="modal-category-badge" id="modalNoticiaCategoria">
              <i class="fas fa-tag me-1"></i>
              <span id="modalNoticiaCategoriaText"></span>
            </span>
            <span class="modal-time-badge" id="modalNoticiaTempo">
              <i class="fas fa-clock me-1"></i>
              <span id="modalNoticiaTempoText"></span>
            </span>
          </div>

          <h2 class="modal-noticia-title" id="modalNoticiaTitulo"></h2>

          <div class="modal-noticia-text" id="modalNoticiaTexto"></div>

          <div class="modal-noticia-actions">
            <div class="modal-noticia-stats">
              <span class="modal-stat">
                <i class="fas fa-eye me-1"></i>
                <span id="modalNoticiaViews"><?= rand(100, 5000) ?></span> visualizações
              </span>
              <span class="modal-stat">
                <i class="fas fa-comment me-1"></i>
                <span id="modalNoticiaComments"><?= rand(5, 50) ?></span> comentários
              </span>
              <span class="modal-stat">
                <i class="fas fa-heart me-1"></i>
                <span id="modalNoticiaLikes"><?= rand(10, 200) ?></span> curtidas
              </span>
            </div>

            <div class="modal-noticia-buttons">
              <button class="btn-share" onclick="compartilharNoticia()">
                <i class="fas fa-share me-2"></i>
                Compartilhar
              </button>
              <button class="btn-like" onclick="curtirNoticia()">
                <i class="fas fa-heart me-2"></i>
                Curtir
              </button>
            </div>
          </div>

          <!-- Seção de Comentários -->
          <div class="modal-comments-section">
            <h3 class="comments-title">
              <i class="fas fa-comments me-2"></i>
              Comentários (<span id="commentsCount">0</span>)
            </h3>

            <!-- Formulário de Comentário -->
            <div class="comment-form-container">
              <form id="commentForm" class="comment-form" onsubmit="enviarComentario(event)">
                <div class="comment-input-group">
                  <textarea 
                    id="commentText" 
                    name="commentText" 
                    placeholder="Escreva seu comentário..." 
                    required
                    maxlength="500"
                  ></textarea>
                  <div class="comment-input-footer">
                    <span class="char-count">
                      <span id="charCount">0</span>/500
                    </span>
                    <button type="submit" class="btn-comment-submit">
                      <i class="fas fa-paper-plane me-1"></i>
                      Comentar
                    </button>
                  </div>
                </div>
              </form>
            </div>

            <!-- Lista de Comentários -->
            <div class="comments-list" id="commentsList">
              <!-- Comentários serão carregados dinamicamente aqui -->
            </div>

            <!-- Template de comentário (oculto) -->
            <template id="commentTemplate">
              <div class="comment-item">
                <div class="comment-avatar">
                  <img src="" alt="Avatar do usuário" class="comment-avatar-img">
                </div>
                <div class="comment-content">
                  <div class="comment-header">
                    <span class="comment-author"></span>
                    <span class="comment-time"></span>
                  </div>
                  <div class="comment-text"></div>
                  <div class="comment-actions">
                    <button class="btn-comment-like" onclick="curtirComentario(this)">
                      <i class="fas fa-heart"></i>
                      <span class="likes-count">0</span>
                    </button>
                    <button class="btn-comment-reply" onclick="responderComentario(this)">
                      <i class="fas fa-reply"></i>
                      Responder
                    </button>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <?php require_once './footer.php'; ?>
  </footer>
</body>

</html>