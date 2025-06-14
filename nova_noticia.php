<?php
session_start();
include_once './classes/Usuario.php';
include_once './config/config.php';
include_once './classes/Noticia.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    date_default_timezone_set(timezoneId: 'America/Sao_Paulo');
    $noticia = new Noticia($db);
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];
    $data = $_POST['data'];
    $autor_id = $_SESSION['usuario_id'] ?? null;
    $imagem = $_POST['imagem'];
    $currentDateTime = date('Y-m-d H:i:s');
    $noticia->criar($titulo, $texto, $currentDateTime, $autor_id, $imagem);
    header('Location: portal.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Notícia</title>
</head>

<body>
    <h1>Adicionar Notícia</h1>
    <form method="POST">

        <label for="titulo">titulo:</label>
        <input type="text" name="titulo" required>
        <br><br>
        <label for="noticia">noticia:</label>
        <input type="text" name="not" required>
        <br><br>
        <label for="categoria">categoria</label>
        <select name="categoria" required>
            <option value="noticia">noticia</option>
            <option value="jogo">jogo</option>
            <option value="evento">evento</option>
            <br><br>
            <label for="imagem">imagem:</label>
            <input type="file" name="imagem">
            <br><br>
            <input type="submit" value="Adicionar">
    </form>
</body>

</html>