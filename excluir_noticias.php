<?php
include_once './config/config.php';
initSession();
include_once './classes/Noticia.php';

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para excluir notícias.';
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

if (!isset($_POST['noticias_ids']) || empty($_POST['noticias_ids'])) {
    $_SESSION['mensagem'] = 'Nenhuma notícia foi selecionada para exclusão.';
    $_SESSION['tipo_mensagem'] = 'warning';
    header('Location: painel_usuario.php');
    exit();
}

$noticia = new Noticia($db);
$noticias_ids = $_POST['noticias_ids'];
$ids_array = explode(',', $noticias_ids);
$sucessos = 0;
$erros = 0;

foreach ($ids_array as $id) {
    $id = trim($id);
    if (!empty($id) && is_numeric($id)) {
        $noticia_dados = $noticia->lerPorId($id);
        
        if ($noticia_dados && $noticia_dados['autor_id'] == $_SESSION['usuario_id']) {
            try {
                $noticia->deletar($id);
                $sucessos++;
            } catch (Exception $e) {
                $erros++;
            }
        } else {
            $erros++;
        }
    }
}

if ($sucessos > 0 && $erros == 0) {
    $_SESSION['mensagem'] = "{$sucessos} notícia(s) excluída(s) com sucesso!";
    $_SESSION['tipo_mensagem'] = 'success';
} elseif ($sucessos > 0 && $erros > 0) {
    $_SESSION['mensagem'] = "{$sucessos} notícia(s) excluída(s) com sucesso. {$erros} notícia(s) não puderam ser excluída(s).";
    $_SESSION['tipo_mensagem'] = 'warning';
} else {
    $_SESSION['mensagem'] = "Nenhuma notícia foi excluída. Verifique se você tem permissão para excluir essas notícias.";
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: painel_usuario.php');
exit();
?> 