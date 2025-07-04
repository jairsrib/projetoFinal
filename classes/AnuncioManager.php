<?php
require_once __DIR__ . '/Database.php';

class AnuncioManager {
    private $jsonFile;
    private $pdo;

    public function __construct($jsonFile = 'data/anuncios.json') {
        $this->jsonFile = $jsonFile;
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    /**
     * Sincroniza todos os anúncios do banco para o arquivo JSON
     */
    private function syncToJson() {
        $stmt = $this->pdo->query('SELECT * FROM anuncio');
        $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = [
            'anuncios' => $anuncios,
            'ultima_atualizacao' => date('c')
        ];
        $dir = dirname($this->jsonFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Cria um novo anúncio
     */
    public function create($dados) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $usuario_id = $_SESSION['usuario_id'] ?? null;
        if (!$usuario_id) throw new Exception('Usuário não autenticado');

        $sql = "INSERT INTO anuncio (nome, imagem, link, texto, ativo, destaque, data_cadastro, valor_anuncio, anunciante_id) VALUES (:nome, :imagem, :link, :texto, :ativo, :destaque, :data_cadastro, :valor_anuncio, :anunciante_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $dados['nome'] ?? '',
            ':imagem' => $dados['imagem'] ?? '',
            ':link' => $dados['link'] ?? '',
            ':texto' => $dados['texto'] ?? '',
            ':ativo' => !empty($dados['ativo']) ? 1 : 0,
            ':destaque' => !empty($dados['destaque']) ? 1 : 0,
            ':data_cadastro' => $dados['data_cadastro'] ?? date('c'),
            ':valor_anuncio' => $dados['valorAnuncio'] ?? 0.00,
            ':anunciante_id' => $usuario_id
        ]);
        $id = $this->pdo->lastInsertId();
        $anuncio = $this->readById($id);
        $this->syncToJson();
        return $anuncio;
    }

    /**
     * Busca todos os anúncios
     */
    public function read($filtros = []) {
        $sql = 'SELECT * FROM anuncio WHERE 1=1';
        $params = [];
        if (isset($filtros['ativo'])) {
            $sql .= ' AND ativo = :ativo';
            $params[':ativo'] = $filtros['ativo'] ? 1 : 0;
        }
        if (isset($filtros['destaque'])) {
            $sql .= ' AND destaque = :destaque';
            $params[':destaque'] = $filtros['destaque'] ? 1 : 0;
        }
        $sql .= ' ORDER BY destaque DESC, data_cadastro DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca um anúncio por ID
     */
    public function readById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM anuncio WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza um anúncio
     */
    public function update($id, $dados) {
        $campos = [];
        $params = [];
        foreach ([
            'nome', 'imagem', 'link', 'texto', 'ativo', 'destaque', 'data_cadastro', 'valorAnuncio'
        ] as $campo) {
            if (isset($dados[$campo])) {
                $col = $campo === 'valorAnuncio' ? 'valor_anuncio' : $campo;
                $campos[] = "$col = :$col";
                $params[":$col"] = $dados[$campo];
            }
        }
        if (!$campos) return null;
        $params[':id'] = $id;
        $sql = 'UPDATE anuncio SET ' . implode(', ', $campos) . ' WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $anuncio = $this->readById($id);
        $this->syncToJson();
        return $anuncio;
    }

    /**
     * Remove um anúncio
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM anuncio WHERE id = ?');
        $ok = $stmt->execute([$id]);
        $this->syncToJson();
        return $ok;
    }

    /**
     * Busca anúncios ativos para exibição
     */
    public function getAnunciosAtivos() {
        $agora = new DateTime();
        $anuncios = $this->read(['ativo' => true]);
        // Filtrar anúncios que já podem ser exibidos (data_cadastro <= agora)
        return array_filter($anuncios, function($anuncio) use ($agora) {
            if (empty($anuncio['data_cadastro'])) {
                return true;
            }
            $dataCadastro = new DateTime($anuncio['data_cadastro']);
            return $dataCadastro <= $agora;
        });
    }

    /**
     * Busca anúncios em destaque
     */
    public function getAnunciosDestaque() {
        return $this->read(['ativo' => true, 'destaque' => true]);
    }

    /**
     * Seleciona um anúncio aleatório ativo para popup
     */
    public function getAnuncioAleatorio() {
        $anunciosAtivos = $this->getAnunciosAtivos();
        if (empty($anunciosAtivos)) {
            return null;
        }
        // Prioriza anúncios em destaque
        $anunciosDestaque = array_filter($anunciosAtivos, function($anuncio) {
            return $anuncio['destaque'] == 1;
        });
        $base = !empty($anunciosDestaque) ? $anunciosDestaque : $anunciosAtivos;
        return $base[array_rand($base)];
    }

    /**
     * Valida dados do anúncio
     */
    public function validate($dados) {
        $errors = [];
        if (empty($dados['nome'])) {
            $errors[] = 'Nome da empresa é obrigatório';
        }
        if (empty($dados['imagem'])) {
            $errors[] = 'Imagem é obrigatória';
        }
        if (empty($dados['link'])) {
            $errors[] = 'URL de destino é obrigatória';
        }
        if (empty($dados['texto'])) {
            $errors[] = 'Texto/slogan é obrigatório';
        }
        if (empty($dados['data_cadastro'])) {
            $errors[] = 'Data de cadastro é obrigatória';
        }
        if (strlen($dados['nome']) > 100) {
            $errors[] = 'Nome deve ter no máximo 100 caracteres';
        }
        if (strlen($dados['texto']) > 200) {
            $errors[] = 'Texto deve ter no máximo 200 caracteres';
        }
        // Validar imagem (URL ou arquivo local)
        if (!empty($dados['imagem'])) {
            if (filter_var($dados['imagem'], FILTER_VALIDATE_URL)) {
                // ok
            } elseif (strpos($dados['imagem'], 'uploads/') === 0) {
                // ok
            } else {
                $errors[] = 'Imagem deve ser uma URL válida ou arquivo local';
            }
        }
        if (!empty($dados['link']) && !filter_var($dados['link'], FILTER_VALIDATE_URL)) {
            $errors[] = 'URL de destino deve ser válida';
        }
        if (isset($dados['valorAnuncio']) && (!is_numeric($dados['valorAnuncio']) || $dados['valorAnuncio'] < 0)) {
            $errors[] = 'Valor do anúncio deve ser um número positivo';
        }
        return $errors;
    }
}
?> 