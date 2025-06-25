<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem'] = 'Acesso negado.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: lista_usuarios.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $fone = trim($_POST['fone'] ?? '');
    $sexo = $_POST['sexo'] ?? '';
    $tipo = $_POST['tipo'] ?? 'usuario';
    
    if ($id && $nome && $email && $fone && in_array($sexo, ['M','F','O']) && in_array($tipo, ['usuario','autor','admin'])) {
        try {
            $usuario = new Usuario($db);
            
            $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            $stmt->execute([$email, $id]);
            
            if ($stmt->fetch()) {
                $_SESSION['mensagem'] = 'Este e-mail já está sendo usado por outro usuário.';
                $_SESSION['tipo_mensagem'] = 'warning';
            } else {
                $stmt = $db->prepare('UPDATE usuarios SET nome=?, email=?, fone=?, sexo=?, tipo=? WHERE id=?');
                $resultado = $stmt->execute([$nome, $email, $fone, $sexo, $tipo, $id]);
                
                if ($resultado) {
                    $_SESSION['mensagem'] = 'Usuário atualizado com sucesso!';
                    $_SESSION['tipo_mensagem'] = 'success';
                } else {
                    $_SESSION['mensagem'] = 'Erro ao atualizar usuário.';
                    $_SESSION['tipo_mensagem'] = 'danger';
                }
            }
        } catch (Exception $e) {
            $_SESSION['mensagem'] = 'Erro: ' . $e->getMessage();
            $_SESSION['tipo_mensagem'] = 'danger';
        }
    } else {
        $_SESSION['mensagem'] = 'Dados inválidos.';
        $_SESSION['tipo_mensagem'] = 'warning';
    }
}

header('Location: lista_usuarios.php');
exit(); 