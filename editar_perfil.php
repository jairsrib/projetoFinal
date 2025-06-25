<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para editar o perfil.';
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

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$fone = trim($_POST['fone'] ?? '');
$sexo = $_POST['sexo'] ?? '';

if (empty($nome) || empty($email) || empty($fone) || empty($sexo)) {
    $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: painel_usuario.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['mensagem'] = 'E-mail inválido.';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: painel_usuario.php');
    exit();
}

if (!in_array($sexo, ['M', 'F', 'O'])) {
    $_SESSION['mensagem'] = 'Valor inválido para sexo.';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: painel_usuario.php');
    exit();
}

try {
    $usuario = new Usuario($db);
    
    $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
    $stmt->execute([$email, $_SESSION['usuario_id']]);
    
    if ($stmt->fetch()) {
        $_SESSION['mensagem'] = 'Este e-mail já está sendo usado por outro usuário.';
        $_SESSION['tipo_mensagem'] = 'warning';
        header('Location: painel_usuario.php');
        exit();
    }
    
    $resultado = $usuario->atualizar($_SESSION['usuario_id'], $nome, $sexo, $fone, $email);
    
    if ($resultado) {
        $_SESSION['mensagem'] = 'Perfil atualizado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
    } else {
        $_SESSION['mensagem'] = 'Erro ao atualizar o perfil.';
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