<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio</title>
  <link rel="stylesheet" href="assets/reset.css" />
  <link rel="stylesheet" href="assets/header.css" />
  <link rel="stylesheet" href="assets/previsao.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>

<div class="sidebar" id="sidebar">
  <h2>Menu</h2>
  <ul>
    <li><a href="index.php"><i data-lucide="home"></i> Início</a></li>
    <li><a href="painel_usuario.php"><i data-lucide="user"></i>Painel de Usuário</a></li>
    <li><a href="lista_usuarios.php"><i data-lucide="users"></i>Lista de Usuários</a></li>
    <li><a href="contato.php"><i data-lucide="mail"></i> Contato</a></li>
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
              transform="translate(100 100)"
            ></path>
          </svg>
        </div>

      </div>
    </div>

  </div>
</header>
<script src="./assets/js/weather-config.js"></script>
<script src="./assets/js/header.js"></script>
<script src="./assets/js/weather.js"></script>
</body>
</html>
