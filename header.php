<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sidebar Responsiva</title>
  <link rel="stylesheet" href="assets/reset.css" />
  <link rel="stylesheet" href="assets/header.css" />
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>

<div class="sidebar" id="sidebar">
  <h2>Menu</h2>
  <ul>
    <li><a href="#"><i data-lucide="home"></i> Início</a></li>
    <li><a href="#"><i data-lucide="newspaper"></i> Notícias</a></li>
    <li><a href="#"><i data-lucide="mail"></i> Contato</a></li>
    <li><a href="#"><i data-lucide="log-out"></i> Sair</a></li>
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
  </div>
</header>
<script src="./assets/js/header.js"></script>
</body>
</html>
