<?php
/**
 * Configuração do Sistema de Temas
 * Inclui os arquivos CSS e JS necessários para o sistema de temas
 */

// Função para incluir os arquivos de tema
function includeThemeFiles() {
    echo '<link rel="stylesheet" href="assets/theme.css" />' . "\n";
    echo '<script src="assets/js/theme.js"></script>' . "\n";
}

// Função para obter o tema atual do localStorage (para SSR)
function getCurrentTheme() {
    return isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
}

// Função para definir o tema inicial no HTML
function getThemeDataAttribute() {
    $theme = getCurrentTheme();
    return 'data-theme="' . htmlspecialchars($theme) . '"';
}
?> 