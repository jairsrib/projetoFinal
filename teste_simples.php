<?php
// Teste simples de sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "Teste de sessão funcionando!<br>";
echo "Status: " . session_status() . "<br>";
echo "ID: " . session_id() . "<br>";
?> 