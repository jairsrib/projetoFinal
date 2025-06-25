<?php
session_start();
include_once './config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_rec'])) {
    $email = trim($_POST['email_rec']);
    $stmt = $db->prepare('SELECT id FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $nova_senha = substr(bin2hex(random_bytes(4)), 0, 8);
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $db->prepare('UPDATE usuarios SET senha = ? WHERE id = ?');
        $stmt->execute([$senha_hash, $user['id']]);
        echo '<div style="max-width:400px;margin:10vh auto;background:#fff;padding:2rem;border-radius:12px;text-align:center;">';
        echo '<h2 style="color:#FF084B;">Senha redefinida!</h2>';
        echo '<p>Sua nova senha é:</p>';
        echo '<div style="font-size:1.5rem;font-weight:bold;margin:1rem 0;">' . htmlspecialchars($nova_senha) . '</div>';
        echo '<p>Faça login e altere sua senha imediatamente.</p>';
        echo '<a href="login.php" style="color:#FF084B;font-weight:bold;">Voltar ao Login</a>';
        echo '</div>';
        exit();
    } else {
        echo '<div style="max-width:400px;margin:10vh auto;background:#fff;padding:2rem;border-radius:12px;text-align:center;">';
        echo '<h2 style="color:#FF084B;">E-mail não encontrado</h2>';
        echo '<p>Verifique o e-mail digitado ou cadastre-se.</p>';
        echo '<a href="login.php" style="color:#FF084B;font-weight:bold;">Voltar ao Login</a>';
        echo '</div>';
        exit();
    }
}
header('Location: login.php');
exit(); 