<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_tipo'] ?? '', ['admin', 'autor'])) {
    $_SESSION['mensagem'] = 'Acesso restrito: apenas ADMIN ou AUTOR podem adicionar notícias.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: index.php');
    exit();
}
include_once './classes/Usuario.php';
include_once './config/config.php';
include_once './classes/Noticia.php';

function salvarImagem($campo)
{
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
    $data = date('Y-m-d H:i:s');
    $autor_id = $_SESSION['usuario_id'] ?? null;
    $categoria = $_POST['categoria'] ?? 'E-Sports';
    $imagem = salvarImagem('imagem');

    if ($imagem) {
        $noticia->criar($titulo, $texto, $data, $autor_id, $categoria, $imagem);
        
        $_SESSION['mensagem'] = 'Notícia criada com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        header('Location: painel_usuario.php');
        exit();
    } else {
        $_SESSION['mensagem'] = 'Erro ao fazer upload da imagem.';
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: painel_usuario.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Notícia</title>
    <link rel="stylesheet" href="assets/nova_noticia.css">
</head>

<body>
    <div class="form-container">
        <form class="form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="textarea">Descrição da Notícia</label>
                <textarea name="texto" id="textarea" rows="10" cols="50" required></textarea>
            </div>

            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select name="categoria" required>
                    <option value="">Selecione a categoria</option>
                    <option value="E-Sports">E-Sports</option>
                    <option value="Speed-Run">Speed-Run</option>
                    <option value="Battle-Royale">Battle-Royale</option>
                    <option value="RPG">RPG</option>
                </select>
            </div>

            <div class="imagem-input">
                <label for="file" class="custum-file-upload">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                fill=""></path>
                        </svg>
                    </div>
                    <div class="text">
                        <span>Inserir Imagem</span>
                    </div>
                    <input id="file" type="file" name="imagem" required>
                </label>
            </div>

            <button class="form-submit-btn" type="submit">Enviar</button>
        </form>
    </div>
</body>

</html>