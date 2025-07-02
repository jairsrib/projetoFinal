<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_tipo'] ?? '', ['admin', 'autor'])) {
    $_SESSION['mensagem'] = 'Acesso restrito: apenas ADMIN ou AUTOR podem excluir notícias.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: index.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';
$usuario = new Usuario($db);
if (isset($_GET['id'])) {
 $id = $_GET['id'];
 $usuario->deletar($id);
 header('Location: portal.php');
 exit();
}
?>