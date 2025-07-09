<?php
include_once './config/config.php';
initSession();

// Inclui os arquivos necessários
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Noticia.php';

// Função para salvar a imagem
function salvarImagem($campo)
{
    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === 0) {
        $tmp = $_FILES[$campo]['tmp_name'];
        $extensao = pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION);
        $nome = uniqid() . "_img." . $extensao;
        $pasta = "uploads";
        $destino = $pasta . "/" . $nome;

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        if (move_uploaded_file($tmp, $destino)) {
            return $nome;
        }
    }
    return null;
}

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_tipo'] ?? '', ['admin', 'autor'])) {
    $_SESSION['mensagem'] = 'Acesso restrito: apenas ADMIN ou AUTOR podem editar notícias.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: index.php');
    exit();
}

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $noticia = new Noticia($db);
        
        $imagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem = salvarImagem('imagem');
        } else {
            $noticiaExistente = $noticia->lerPorId($_POST['id']);
            $imagem = $noticiaExistente['imagem'] ?? null;
        }
        
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];
        $data = date('Y-m-d H:i:s');
        $autor_id = $_POST['autor_id'];
        $categoria = $_POST['categoria'];
        
        $resultado = $noticia->atualizar($id, $titulo, $texto, $data, $autor_id, $categoria, $imagem);
        
        if ($resultado) {
            $_SESSION['mensagem'] = "Notícia atualizada com sucesso!";
            $_SESSION['tipo_mensagem'] = "success";
        } else {
            $_SESSION['mensagem'] = "Erro ao atualizar a notícia.";
            $_SESSION['tipo_mensagem'] = "danger";
        }
        
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro de banco de dados: " . $e->getMessage();
        $_SESSION['tipo_mensagem'] = "danger";
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro: " . $e->getMessage();
        $_SESSION['tipo_mensagem'] = "danger";
    }
    
    header("Location: painel_usuario.php");
    exit();
} else {
    header("Location: painel_usuario.php");
    exit();
}
?>