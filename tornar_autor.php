<?php
session_start();
include_once './config/config.php';

if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem'] = 'Acesso negado.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: lista_usuarios.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario_id'])) {
    $usuario_id = intval($_POST['usuario_id']);
    $stmt = $db->prepare('UPDATE usuarios SET tipo = ? WHERE id = ?');
    $stmt->execute(['autor', $usuario_id]);
    $_SESSION['mensagem'] = 'Usuário promovido a AUTOR com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Requisição inválida.';
    $_SESSION['tipo_mensagem'] = 'warning';
}
header('Location: lista_usuarios.php');
exit(); 