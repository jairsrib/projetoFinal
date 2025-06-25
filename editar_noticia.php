<?php
session_start();

// Inclui os arquivos necessários
require_once __DIR__ . './Classes/Database.php';
require_once __DIR__ . './Classes/Noticia.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $noticia = new Noticia($db);
        
        $imagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
        } else {
            $noticiaExistente = $noticia->lerPorId($_POST['id']);
            $imagem = $noticiaExistente['imagem'] ?? null;
        }
        
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];
        $data = date('Y-m-d H:i:s');
        $autor_id = $_POST['autor_id'];
        $categoria_id = $_POST['categoria_id'];
        
        // Atualiza a notícia
        $resultado = $noticia->atualizar($id, $titulo, $texto, $data, $autor_id, $categoria_id, $imagem);
        
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