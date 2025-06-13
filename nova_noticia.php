<?php
session_start();
include_once './classes/Usuario.php';
include_once './config/config.php';
include_once './classes/Noticia.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $noticia = new Noticia($db);
 $titulo = $_POST['titulo'];
 $texto = $_POST['texto'];
 $data = $_POST['data'];
 $autor_id = $_SESSION['usuario_id'] ?? null;
 $imagem = $_POST['imagem'];
 $noticia->criar($titulo, $texto, $data, $autor_id, $imagem);
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

  <label for="nome">titulo:</label>
  <input type="text" name="titulo" required>
  <br><br>
  <label for="fone">noticia:</label>
  <input type="text" name="not" required>
  <br><br>
  <label for="email">data:</label>
  <input type="date" name="data" required>
  <br><br>
  <label for="senha">imagem:</label>
  <input type="file" name="imagem" required>
  <br><br>
  <input type="submit" value="Adicionar">
 </form>
</body>
</html>