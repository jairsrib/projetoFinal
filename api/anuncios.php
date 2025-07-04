<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../classes/AnuncioManager.php';

$anuncioManager = new AnuncioManager();

// Tratar requisições OPTIONS (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));

// Extrair ID da URL se existir
$id = null;
if (count($pathParts) > 2 && is_numeric($pathParts[2])) {
    $id = (int)$pathParts[2];
}

try {
    switch ($method) {
        case 'GET':
            if ($id) {
                // Buscar anúncio específico
                $anuncio = $anuncioManager->readById($id);
                if ($anuncio) {
                    echo json_encode(['success' => true, 'data' => $anuncio]);
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Anúncio não encontrado']);
                }
            } else {
                // Listar anúncios com filtros
                $filtros = [];
                
                if (isset($_GET['ativo'])) {
                    $filtros['ativo'] = $_GET['ativo'] === 'true';
                }
                
                if (isset($_GET['destaque'])) {
                    $filtros['destaque'] = $_GET['destaque'] === 'true';
                }
                
                if (isset($_GET['categoria'])) {
                    $filtros['categoria'] = $_GET['categoria'];
                }
                
                $anuncios = $anuncioManager->read($filtros);
                echo json_encode(['success' => true, 'data' => $anuncios]);
            }
            break;

        case 'POST':
            // Criar novo anúncio
            $input = [];
            
            // Verificar se é FormData (upload de arquivo) ou JSON
            if (isset($_FILES['imagem'])) {
                // Processar FormData com upload de arquivo
                $input = $_POST;
                
                // Processar upload da imagem
                $uploadDir = '../uploads/anuncios/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $file = $_FILES['imagem'];
                $fileName = time() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                
                // Validar arquivo
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($file['type'], $allowedTypes)) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido']);
                    break;
                }
                
                if ($file['size'] > 2 * 1024 * 1024) { // 2MB
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Arquivo muito grande (máximo 2MB)']);
                    break;
                }
                
                // Mover arquivo
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $input['imagem'] = 'uploads/anuncios/' . $fileName;
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Erro ao fazer upload do arquivo']);
                    break;
                }
                
                // Converter tipos de dados
                $input['ativo'] = isset($input['ativo']) && $input['ativo'] === 'true';
                $input['destaque'] = isset($input['destaque']) && $input['destaque'] === 'true';
                $input['valorAnuncio'] = floatval($input['valorAnuncio'] ?? 0);
                $input['prioridade'] = intval($input['prioridade'] ?? 3);
                
            } else {
                // Processar JSON
                $input = json_decode(file_get_contents('php://input'), true);
                
                if (!$input) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
                    break;
                }
            }
            
            // Log para debug
            error_log('Dados recebidos: ' . json_encode($input));
            
            $errors = $anuncioManager->validate($input);
            if (!empty($errors)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dados inválidos', 'errors' => $errors]);
                break;
            }
            
            $anuncio = $anuncioManager->create($input);
            http_response_code(201);
            echo json_encode(['success' => true, 'data' => $anuncio, 'message' => 'Anúncio criado com sucesso']);
            break;

        case 'PUT':
            // Atualizar anúncio
            if (!$id) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID do anúncio é obrigatório']);
                break;
            }
            
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
                break;
            }
            
            $anuncio = $anuncioManager->update($id, $input);
            if ($anuncio) {
                echo json_encode(['success' => true, 'data' => $anuncio, 'message' => 'Anúncio atualizado com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Anúncio não encontrado']);
            }
            break;

        case 'DELETE':
            // Remover anúncio
            if (!$id) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID do anúncio é obrigatório']);
                break;
            }
            
            $success = $anuncioManager->delete($id);
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Anúncio removido com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Anúncio não encontrado']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro interno do servidor: ' . $e->getMessage()]);
}
?> 