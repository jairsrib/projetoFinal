<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/reset.css" />
    <link rel="stylesheet" href="assets/header.css" />
    <title>Header</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="#">Início</a></li>
            <li><a href="#">Notícias</a></li>
            <li><a href="#">Painel Usuario</a></li>
            <li><a href="#">Contato</a></li>
        </ul>
    </div>

    <!-- Overlay para fechar o menu ao clicar fora -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <header>
        <div class="container">
            <div class="btn-menu">
                <button class="btn-hamburger btn-toggle-menu" onclick="toggleSidebar()" aria-label="Abrir Menu">
                    <svg width="32" height="32" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 14.9H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 8H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <div class="logo">
                <img src="img/logo.png" alt="">
                <div class="titulo">
                    <h1>Caiu o <span>Servidor</span></h1>
                    <h2>notícias do mundo do games</h2>
                </div>
            </div>
        </div>
    </header>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        }
    </script>
</body>
</html>
