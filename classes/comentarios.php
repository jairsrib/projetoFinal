<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/Database.php';

$db = new Database();
$conn = $db->getConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao conectar ao banco']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $noticia_id = isset($_GET['noticia_id']) ? intval($_GET['noticia_id']) : 0;
    if (!$noticia_id) {
        http_response_code(400);
        echo json_encode(['erro' => 'ID da notícia não informado']);
        exit;
    }
    $stmt = $conn->prepare("SELECT id, autor, texto, data, likes FROM comentarios WHERE noticia_id = :noticia_id ORDER BY data DESC");
    $stmt->bindParam(':noticia_id', $noticia_id, PDO::PARAM_INT);
    $stmt->execute();
    $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($comentarios);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $noticia_id = isset($input['noticia_id']) ? intval($input['noticia_id']) : 0;
    $texto = isset($input['texto']) ? trim($input['texto']) : '';
    $autor = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Anônimo';
    if (!$noticia_id || !$texto) {
        http_response_code(400);
        echo json_encode(['erro' => 'Dados obrigatórios ausentes']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO comentarios (noticia_id, autor, texto) VALUES (:noticia_id, :autor, :texto)");
    $stmt->bindParam(':noticia_id', $noticia_id, PDO::PARAM_INT);
    $stmt->bindParam(':autor', $autor, PDO::PARAM_STR);
    $stmt->bindParam(':texto', $texto, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $id = $conn->lastInsertId();
        $data = date('Y-m-d H:i:s');
        echo json_encode([
            'sucesso' => true,
            'comentario' => [
                'id' => $id,
                'autor' => $autor,
                'texto' => $texto,
                'data' => $data,
                'likes' => 0
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao salvar comentário']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['erro' => 'Método não suportado']); 