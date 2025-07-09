<?php
include_once './config/config.php';
initSession();

echo "Status da sessão: " . session_status() . "<br>";
echo "ID da sessão: " . session_id() . "<br>";

if (isset($_SESSION['usuario_id'])) {
    echo "Usuário logado: " . $_SESSION['usuario_id'] . "<br>";
} else {
    echo "Nenhum usuário logado<br>";
}

echo "Teste concluído com sucesso!";
?> 