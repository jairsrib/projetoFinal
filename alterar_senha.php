<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para alterar a senha.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['mensagem'] = 'Método inválido.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: painel_usuario.php');
    exit();
}

$senha_atual = $_POST['senha_atual'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
    $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: painel_usuario.php');
    exit();
}

if ($nova_senha !== $confirmar_senha) {
    $_SESSION['mensagem'] = 'A nova senha e a confirmação não coincidem.';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: painel_usuario.php');
    exit();
}

if (strlen($nova_senha) < 6) {
    $_SESSION['mensagem'] = 'A nova senha deve ter pelo menos 6 caracteres.';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: painel_usuario.php');
    exit();
}

try {
    $usuario = new Usuario($db);
    
    $stmt = $db->prepare("SELECT senha FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario_atual = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario_atual) {
        $_SESSION['mensagem'] = 'Usuário não encontrado.';
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: painel_usuario.php');
        exit();
    }
    
    if (!password_verify($senha_atual, $usuario_atual['senha'])) {
        $_SESSION['mensagem'] = 'Senha atual incorreta.';
        $_SESSION['tipo_mensagem'] = 'warning';
        header('Location: painel_usuario.php');
        exit();
    }
    
    if (password_verify($nova_senha, $usuario_atual['senha'])) {
        $_SESSION['mensagem'] = 'A nova senha deve ser diferente da senha atual.';
        $_SESSION['tipo_mensagem'] = 'warning';
        header('Location: painel_usuario.php');
        exit();
    }
    
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    
    $stmt = $db->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    $resultado = $stmt->execute([$senha_hash, $_SESSION['usuario_id']]);
    
    if ($resultado) {
        $_SESSION['mensagem'] = 'Senha alterada com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
    } else {
        $_SESSION['mensagem'] = 'Erro ao alterar a senha.';
        $_SESSION['tipo_mensagem'] = 'danger';
    }
    
} catch (PDOException $e) {
    $_SESSION['mensagem'] = 'Erro de banco de dados: ' . $e->getMessage();
    $_SESSION['tipo_mensagem'] = 'danger';
} catch (Exception $e) {
    $_SESSION['mensagem'] = 'Erro inesperado: ' . $e->getMessage();
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: painel_usuario.php');
exit();
?> 