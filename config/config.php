<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'projeto_final';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit();
}

// Função helper para iniciar sessão de forma segura
function initSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
?> 