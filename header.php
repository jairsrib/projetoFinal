<?php include_once 'config/theme_config.php'; ?>
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
    <li><a href="painel_usuario.php"><i data-lucide="user"></i>Painel de Usuário</a></li>
    <li><a href="lista_usuarios.php"><i data-lucide="users"></i>Lista de Usuários</a></li>
    <li><a href="contato.php"><i data-lucide="mail"></i> Contato</a></li>
    <li><a href="#" onclick="abrirModalCadastroAnuncio()"><i data-lucide="plus-circle"></i> Cadastrar Anúncio</a></li>
    <li><a href="logout.php"><i data-lucide="log-out"></i> Sair</a></li>
  </ul>
</div>
<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
<header>
  <div class="container">
    <div class="btn-menu">
      <button class="btn-hamburger" id="btn-hamburguer" onclick="toggleSidebar()" aria-label="Abrir Menu">
        <svg width="32" height="32" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1 1H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M1 14.9H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M1 8H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>

    <div class="logo">
      <img src="img/logo.png" alt="Logo">
      <div class="titulo">
        <h1>Caiu o <span>Servidor</span></h1>
        <h2>notícias do mundo do games</h2>
      </div>
    </div>

    <div class="previsao-do-tempo">
      <div class="card-time-cloud">
        <div class="card-time-cloud-content">
          <div class="card-time-cloud-info">
            <p class="card-time-cloud-day">Segunda</p>
            <p class="card-time-cloud-day-number">3/5/2025</p>
            <p class="card-time-cloud-hour">20:54</p>
          </div>
          <div class="card-time-cloud-icon">
            <svg
              stroke-width="0.6"
              stroke="#d3d3d3"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              height="30px"
              width="30px"
            >
              <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
              <g
                stroke-linejoin="round"
                stroke-linecap="round"
                id="SVGRepo_tracerCarrier"
              ></g>
              <g id="SVGRepo_iconCarrier">
                <path
                  fill="#88878d"
                  d="M11 1C11 0.447715 11.4477 0 12 0C12.5523 0 13 0.447715 13 1V2C13 2.00987 12.9998 2.0197 12.9996 2.0295C16.1756 2.22087 18.4004 3.3248 19.9306 4.79921C21.5936 6.40161 22.3489 8.35675 22.6948 9.79114C23.1389 11.6327 21.6012 13 20 13H13V21C13 21.9197 12.6197 22.6707 12.0152 23.1745C11.4335 23.6592 10.6963 23.875 9.99999 23.875C9.30366 23.875 8.56643 23.6592 7.9848 23.1745C7.38023 22.6707 6.99999 21.9197 6.99999 21C6.99999 20.4477 7.4477 20 7.99999 20C8.55227 20 8.99999 20.4477 8.99999 21C8.99999 21.3303 9.11975 21.5168 9.26517 21.638C9.43354 21.7783 9.69631 21.875 9.99999 21.875C10.3037 21.875 10.5664 21.7783 10.7348 21.638C10.8802 21.5168 11 21.3303 11 21V13H3.99999C2.3988 13 0.861067 11.6327 1.30514 9.79114C1.65104 8.35675 2.40634 6.40161 4.06938 4.79921C5.59958 3.3248 7.82434 2.22087 11.0004 2.0295C11.0001 2.0197 11 2.00987 11 2V1ZM5.4571 6.23943C4.1618 7.4875 3.54236 9.04514 3.24941 10.26C3.20177 10.4576 3.25294 10.6163 3.36905 10.7448C3.49589 10.885 3.71738 11 3.99999 11H7.04749C7.26886 8.65522 8.22736 6.59747 9.14833 5.1009C9.35244 4.76922 9.5565 4.4622 9.75302 4.18255C7.76882 4.52782 6.40673 5.32442 5.4571 6.23943ZM14.9415 11C14.7273 9.14779 13.9554 7.46058 13.1483 6.1491C12.7398 5.48519 12.3309 4.93174 12 4.51917C11.6691 4.93174 11.2602 5.48519 10.8516 6.1491C10.0446 7.46058 9.2727 9.14779 9.05845 11H14.9415ZM14.247 4.18255C16.2311 4.52782 17.5932 5.32442 18.5429 6.23943C19.8382 7.4875 20.4576 9.04514 20.7506 10.26C20.7982 10.4576 20.747 10.6163 20.6309 10.7448C20.5041 10.885 20.2826 11 20 11H16.9525C16.7311 8.65522 15.7726 6.59747 14.8516 5.1009C14.6475 4.76922 14.4435 4.4622 14.247 4.18255Z"
                  clip-rule="evenodd"
                  fill-rule="evenodd"
                ></path>
              </g>
            </svg>
          </div>
        </div>
        <div class="card-time-cloud-background">
          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path
              fill="#FFFFFF"
              d="M32.4,-41C45.2,-42.2,61,-38.6,63.9,-29.9C66.8,-21.2,56.8,-7.2,47.5,1.7C38.2,10.6,29.6,14.4,26.3,28.4C22.9,42.3,24.7,66.4,18.4,73C12,79.7,-2.5,68.8,-19.2,64.4C-35.9,60,-54.8,61.9,-56.2,52.9C-57.7,43.8,-41.7,23.7,-37.5,9.4C-33.3,-5,-41,-13.6,-44.4,-26.2C-47.8,-38.7,-47,-55.2,-38.9,-56.2C-30.7,-57.2,-15.4,-42.7,-2.8,-38.3C9.8,-34,19.6,-39.8,32.4,-41Z"
              transform="translate(100 100)"
            ></path>
          </svg>
        </div>
        <div class="card-time-cloud-rain-group">
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
          <div class="card-time-cloud-rain"></div>
        </div>
      </div>
    </div>

  </div>
</header>

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

<script src="./assets/js/header.js"></script>
<script src="./assets/js/cadastro-anuncio.js"></script>
</body>
</html>
