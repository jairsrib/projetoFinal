<?php
/**
 * Configuração do FormSubmit
 * 
 * Este arquivo contém as configurações para o sistema de email usando FormSubmit
 */

// Email de destino para mensagens de contato
define('FORMSUBMIT_EMAIL', 'jair.ribeiro.souza@gmail.com');

// URL de redirecionamento após envio
define('FORMSUBMIT_REDIRECT', 'http://localhost/projetoFinal/contato.php');

// Assunto padrão dos emails
define('FORMSUBMIT_SUBJECT', 'Nova mensagem de contato do site');

// Configurações adicionais
define('FORMSUBMIT_CAPTCHA', false); // Desabilitar captcha
define('FORMSUBMIT_HONEYPOT', true); // Proteção contra spam

/**
 * Função para obter a URL do FormSubmit
 */
function getFormSubmitUrl() {
    return 'https://formsubmit.co/' . FORMSUBMIT_EMAIL;
}

/**
 * Função para obter os campos hidden do formulário
 */
function getFormSubmitHiddenFields() {
    $fields = array();
    
    $fields['_next'] = FORMSUBMIT_REDIRECT;
    $fields['_subject'] = FORMSUBMIT_SUBJECT;
    $fields['_captcha'] = FORMSUBMIT_CAPTCHA ? 'true' : 'false';
    
    if (FORMSUBMIT_HONEYPOT) {
        $fields['_honey'] = ''; // Campo honeypot para proteção contra spam
    }
    
    return $fields;
}
?> 