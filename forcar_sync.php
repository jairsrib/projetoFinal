<?php
require_once __DIR__ . '/classes/AnuncioManager.php';

$manager = new AnuncioManager();

// Usando Reflection para acessar o método privado syncToJson
$reflection = new ReflectionClass($manager);
$method = $reflection->getMethod('syncToJson');
$method->setAccessible(true);
$method->invoke($manager);

echo "Sincronização concluída! Abra ou recarregue a página do site."; 