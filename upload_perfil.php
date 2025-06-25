<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem_perfil'])) {
    $usuario = new Usuario($db);
    
    $arquivo = $_FILES['imagem_perfil'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($extensao, $extensoes_permitidas)) {
        $_SESSION['mensagem'] = 'Formato de imagem não suportado. Use: JPG, PNG, GIF ou WEBP.';
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: painel_usuario.php');
        exit();
    }
    
    if ($arquivo['size'] > 5 * 1024 * 1024) {
        $_SESSION['mensagem'] = 'Imagem muito grande. Máximo 5MB.';
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: painel_usuario.php');
        exit();
    }
    
    $nome_arquivo = uniqid() . '_perfil.' . $extensao;
    $caminho_destino = 'uploads/' . $nome_arquivo;
    
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }
    
    if (move_uploaded_file($arquivo['tmp_name'], $caminho_destino)) {
        $resultado = $usuario->atualizarImagemPerfil($_SESSION['usuario_id'], $nome_arquivo);
        
        if ($resultado) {
            $_SESSION['mensagem'] = 'Foto de perfil atualizada com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
        } else {
            $_SESSION['mensagem'] = 'Erro ao atualizar foto no banco de dados.';
            $_SESSION['tipo_mensagem'] = 'danger';
            unlink($caminho_destino);
        }
    } else {
        $_SESSION['mensagem'] = 'Erro ao fazer upload da imagem.';
        $_SESSION['tipo_mensagem'] = 'danger';
    }
} else {
    $_SESSION['mensagem'] = 'Nenhuma imagem foi enviada.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: painel_usuario.php');
exit();
?> 