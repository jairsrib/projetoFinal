<?php
session_start();
include_once './classes/Usuario.php';
include_once './config/config.php';
include_once './classes/Noticia.php';

// Função para salvar a imagem
function salvarImagem($campo) {
    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === 0) {
        $tmp = $_FILES[$campo]['tmp_name'];
        $extensao = pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION);
        $nome = uniqid() . "_img." . $extensao;
        $pasta = "uploads";
        $destino = $pasta . "/" . $nome;

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        if (move_uploaded_file($tmp, $destino)) {
            return $nome;
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    date_default_timezone_set('America/Sao_Paulo');
    $noticia = new Noticia($db);

    $titulo = $_POST['titulo'];
    $texto = $_POST['texto']; 
    $data =  date('Y-m-d H:i:s'); 
    $autor_id = $_SESSION['usuario_id'] ?? null;
    $categoria = $_POST['categoria'] ?? 'noticia';
    $imagem = salvarImagem('imagem'); 

    $noticia->criar($titulo, $texto, $data, $autor_id, $categoria, $imagem);
    header('Location: dashboard.php');
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
    <form method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>
        <br><br>

        <label for="texto">Texto da notícia:</label>
        <input type="text" name="texto" required>
        <br><br>

        

        <label for="categoria">Categoria:</label>
        <select name="categoria" required>
            <option value="noticia">Notícia</option>
            <option value="jogo">Jogo</option>
            <option value="evento">Evento</option>
        </select>
        <br><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem">
        <br><br>

        <input type="submit" value="Adicionar">
    </form>
</body>
</html>
