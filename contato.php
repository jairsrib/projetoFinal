<?php
require_once './header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Contato</title>
    <link rel="stylesheet" href="./assets/contato.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="contato-container">

        <div class="card-autor">
            <img src="./img/jair.png" alt="Autor 1">
            <div class="card-info">
                <h3>Jair de Souza</h3>
                <p><i class="fas fa-code"></i> Backend Developer</p>
                <p><i class="fas fa-envelope"></i> jair.ribeiro.souza@gmail.com</p>
                <p><i class="fab fa-github"></i> github.com/jairsrib</p>
            </div>
        </div>

        <div class="card-autor">
            <img src="./img/soteldo.png" alt="Autor 2">
            <div class="card-info">
                <h3>Leonardo Moura</h3>
                <p><i class="fas fa-paint-brush"></i> Frontend & UI/UX Designer</p>
                <p><i class="fas fa-envelope"></i> leonardomoura080904@gmail.com</p>
                <p><i class="fab fa-github"></i> github.com/leoverardo</p>
            </div>
        </div>

        <div class="form-card">
            <h3>Formulário de Contato</h3>
            <form action="enviar.php" method="post" class="form-contato">
                <input type="text" name="nome" placeholder="Seu nome" required>
                <input type="email" name="email" placeholder="Seu e-mail" required>
                <textarea name="mensagem" rows="5" placeholder="Digite sua mensagem" required></textarea>
                <button type="submit"><i class="fas fa-paper-plane"></i> Enviar Mensagem</button>
            </form>
        </div>

        <a href="dashboard.php" class="voltar-link"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>

    </div>

</body>

</html>