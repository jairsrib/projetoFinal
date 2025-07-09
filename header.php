<?php
include_once 'config/config.php';
initSession();
include_once 'config/theme_config.php';
?>
<!DOCTYPE html>
<html lang="pt-br" <?php echo getThemeDataAttribute(); ?>>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio</title>
  <link rel="stylesheet" href="assets/reset.css" />
  <link rel="stylesheet" href="assets/theme.css" />
  <link rel="stylesheet" href="assets/header.css" />
  <link rel="stylesheet" href="assets/previsao.css">
  <link rel="stylesheet" href="assets/cadastro-anuncio.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <script src="assets/js/theme.js"></script>
</head>

<body>

  <div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
      <img src="img/logo.png" alt="Logo">
    </div>
    <h2>Menu</h2>
    <ul>
      <li><a href="index.php"><i data-lucide="home"></i> Início</a></li>
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <li><a href="painel_usuario.php"><i data-lucide="user"></i>Painel de Usuário</a></li>
        <li><a href="lista_usuarios.php"><i data-lucide="users"></i>Lista de Usuários</a></li>
        <li><a href="contato.php"><i data-lucide="mail"></i> Contato</a></li>
        <li><a href="#" onclick="abrirModalCadastroAnuncio()"><i data-lucide="plus-circle"></i> Cadastrar Anúncio</a></li>
        <li><a href="logout.php"><i data-lucide="log-out"></i> Sair</a></li>
      <?php else: ?>
        <li><a href="contato.php"><i data-lucide="mail"></i> Contato</a></li>
        <li><a href="login.php"><i data-lucide="log-in"></i> Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

  <header>
    <div class="header-flex">
      <div class="btn-menu">
        <button class="btn-hamburger" id="btn-hamburguer" onclick="toggleSidebar()" aria-label="Abrir Menu">
          <svg width="24" height="24" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M1 14.9H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M1 8H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>

      <div class="theme-toggle-container">
        <!-- O botão de alternância de tema será inserido aqui manualmente pelo JS -->
      </div>


      <div class="logo-center">
        <img src="img/logo.png" alt="Logo">
        <div class="titulo">
          <h1>Caiu o <span>Servidor</span></h1>
          <h2>notícias do mundo do games</h2>
        </div>
      </div>

      <?php if (isset($_SESSION['usuario_id'])): ?>
        
      <?php else: ?>
        <a href="login.php" class="header-login-btn"><i data-lucide="log-in"></i> Login</a>
      <?php endif; ?>

      <div class="header-weather">
        <div class="card-time-cloud">
          <div class="card-time-cloud-content">
            <div class="card-time-cloud-info">
              <p class="card-time-cloud-day">Carregando...</p>
              <p class="card-time-cloud-day-number">--/--/----</p>
              <p class="card-time-cloud-hour">--:--</p>
              <p class="card-time-cloud-temp">--°C</p>
              <p class="card-time-cloud-desc">--</p>
            </div>
            <div class="card-time-cloud-icon">
              <div class="weather-icon" id="weather-icon">
                <!-- Ícone será carregado dinamicamente -->
              </div>
            </div>
          </div>
          <div class="card-time-cloud-background">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
              <path
                fill="#FFFFFF"
                d="M32.4,-41C45.2,-42.2,61,-38.6,63.9,-29.9C66.8,-21.2,56.8,-7.2,47.5,1.7C38.2,10.6,29.6,14.4,26.3,28.4C22.9,42.3,24.7,66.4,18.4,73C12,79.7,-2.5,68.8,-19.2,64.4C-35.9,60,-54.8,61.9,-56.2,52.9C-57.7,43.8,-41.7,23.7,-37.5,9.4C-33.3,-5,-41,-13.6,-44.4,-26.2C-47.8,-38.7,-47,-55.2,-38.9,-56.2C-30.7,-57.2,-15.4,-42.7,-2.8,-38.3C9.8,-34,19.6,-39.8,32.4,-41Z"
                transform="translate(100 100)"></path>
            </svg>
          </div>
        </div>
      </div>

    </div>
  </header>

  <script src="./assets/js/weather-config.js"></script>
  <script src="./assets/js/header.js"></script>
  <script src="./assets/js/weather.js"></script>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <div id="modal-cadastro-anuncio" class="modal-cadastro-anuncio">
      <div class="modal-cadastro-content">
        <div class="modal-cadastro-header">
          <h2>📢 Cadastrar Novo Anúncio</h2>
          <button class="modal-cadastro-close" onclick="fecharModalCadastroAnuncio()">
            <i data-lucide="x"></i>
          </button>
        </div>

        <form id="form-cadastro-anuncio" class="form-cadastro-anuncio">
          <div class="form-row">
            <div class="form-group">
              <label for="nome">Nome da Empresa *</label>
              <input type="text" id="nome" name="nome" required maxlength="100" placeholder="Digite o nome da empresa">
            </div>

            <div class="form-group">
              <label for="valorAnuncio">Valor do Anúncio (R$)</label>
              <input type="number" id="valorAnuncio" name="valorAnuncio" min="0" step="0.01" placeholder="0.00">
            </div>
          </div>

          <div class="form-group">
            <label for="imagem">Imagem/Banner do Anúncio *</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required>
            <small>Selecione uma imagem (JPG, PNG, GIF - Máx: 2MB)</small>
            <div class="image-preview hidden">
              <img src="" alt="Preview da imagem">
            </div>
          </div>

          <div class="form-group">
            <label for="link">URL de Destino *</label>
            <input type="url" id="link" name="link" required placeholder="https://exemplo.com/promocao">
            <small>Link para onde o usuário será direcionado ao clicar</small>
          </div>

          <div class="form-group">
            <label for="texto">Texto/Slogan *</label>
            <textarea id="texto" name="texto" required maxlength="200" placeholder="Digite o slogan ou mensagem do anúncio" rows="3"></textarea>
            <small>Máximo 200 caracteres</small>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="data_cadastro">Data de Cadastro *</label>
              <input type="datetime-local" id="data_cadastro" name="data_cadastro" required>
            </div>

            <div class="form-group">
              <label for="categoria">Categoria</label>
              <select id="categoria" name="categoria">
                <option value="geral">Geral</option>
                <option value="lançamento">Lançamento</option>
                <option value="promoção">Promoção</option>
                <option value="evento">Evento</option>
                <option value="sistema">Sistema</option>
                <option value="comunidade">Comunidade</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="prioridade">Prioridade</label>
              <select id="prioridade" name="prioridade">
                <option value="1">Alta (1)</option>
                <option value="2">Média (2)</option>
                <option value="3" selected>Baixa (3)</option>
              </select>
            </div>

            <div class="form-group">
              <label for="data_expiracao">Data de Expiração</label>
              <input type="datetime-local" id="data_expiracao" name="data_expiracao">
            </div>
          </div>

          <div class="form-checkboxes">
            <div class="form-checkbox">
              <input type="checkbox" id="ativo" name="ativo" checked>
              <label for="ativo">Ativo</label>
            </div>

            <div class="form-checkbox">
              <input type="checkbox" id="destaque" name="destaque">
              <label for="destaque">Destaque</label>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn-cancelar" onclick="fecharModalCadastroAnuncio()">
              Cancelar
            </button>
            <button type="submit" class="btn-salvar">
              <i data-lucide="save"></i>
              Cadastrar Anúncio
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Feedback de Sucesso/Erro -->
    <div id="feedback-message" class="feedback-message"></div>
  <?php endif; ?>

  <script src="./assets/js/header.js"></script>
  <?php if (isset($_SESSION['usuario_id'])): ?>
    <script src="./assets/js/cadastro-anuncio.js"></script>
  <?php endif; ?>
</body>

</html>