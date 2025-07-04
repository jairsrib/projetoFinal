<?php
session_start();

// Verificar se o usuário está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['nivel'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

require_once '../classes/AnuncioManager.php';

$anuncioManager = new AnuncioManager();
$mensagem = '';
$tipoMensagem = '';

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'criar':
                $dados = [
                    'nome' => $_POST['nome'] ?? '',
                    'texto' => $_POST['texto'] ?? '',
                    'imagem' => $_POST['imagem_url'] ?? '',
                    'link' => $_POST['link'] ?? '',
                    'valorAnuncio' => (float)($_POST['valorAnuncio'] ?? 0.00),
                    'ativo' => isset($_POST['ativo']),
                    'destaque' => isset($_POST['destaque']),
                    'categoria' => $_POST['categoria'] ?? 'geral',
                    'prioridade' => (int)($_POST['prioridade'] ?? 3),
                    'data_cadastro' => $_POST['data_cadastro'] ?? '',
                    'data_expiracao' => $_POST['data_expiracao'] ?? ''
                ];
                
                // Processar upload de arquivo se existir
                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/anuncios/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $file = $_FILES['imagem'];
                    $fileName = time() . '_' . basename($file['name']);
                    $targetPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        $dados['imagem'] = $targetPath;
                    }
                }
                
                $errors = $anuncioManager->validate($dados);
                if (empty($errors)) {
                    $anuncioManager->create($dados);
                    $mensagem = 'Anúncio criado com sucesso!';
                    $tipoMensagem = 'sucesso';
                } else {
                    $mensagem = 'Erro: ' . implode(', ', $errors);
                    $tipoMensagem = 'erro';
                }
                break;
                
            case 'atualizar':
                $id = (int)$_POST['id'];
                $dados = [
                    'nome' => $_POST['nome'] ?? '',
                    'texto' => $_POST['texto'] ?? '',
                    'imagem' => $_POST['imagem_url'] ?? '',
                    'link' => $_POST['link'] ?? '',
                    'valorAnuncio' => (float)($_POST['valorAnuncio'] ?? 0.00),
                    'ativo' => isset($_POST['ativo']),
                    'destaque' => isset($_POST['destaque']),
                    'categoria' => $_POST['categoria'] ?? 'geral',
                    'prioridade' => (int)($_POST['prioridade'] ?? 3),
                    'data_cadastro' => $_POST['data_cadastro'] ?? '',
                    'data_expiracao' => $_POST['data_expiracao'] ?? ''
                ];
                
                // Processar upload de arquivo se existir
                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/anuncios/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $file = $_FILES['imagem'];
                    $fileName = time() . '_' . basename($file['name']);
                    $targetPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        $dados['imagem'] = $targetPath;
                    }
                }
                
                $errors = $anuncioManager->validate($dados);
                if (empty($errors)) {
                    $anuncioManager->update($id, $dados);
                    $mensagem = 'Anúncio atualizado com sucesso!';
                    $tipoMensagem = 'sucesso';
                } else {
                    $mensagem = 'Erro: ' . implode(', ', $errors);
                    $tipoMensagem = 'erro';
                }
                break;
                
            case 'excluir':
                $id = (int)$_POST['id'];
                if ($anuncioManager->delete($id)) {
                    $mensagem = 'Anúncio excluído com sucesso!';
                    $tipoMensagem = 'sucesso';
                } else {
                    $mensagem = 'Erro ao excluir anúncio!';
                    $tipoMensagem = 'erro';
                }
                break;
        }
    }
}

// Buscar todos os anúncios
$anuncios = $anuncioManager->read();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Anúncios - Admin</title>
    <link rel="stylesheet" href="../assets/reset.css">
    <link rel="stylesheet" href="../assets/theme.css">
    <link rel="stylesheet" href="../assets/anuncios.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .admin-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }
        
        .admin-titulo {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-color);
        }
        
        .btn-novo {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-novo:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(var(--primary-color-rgb), 0.4);
        }
        
        .mensagem {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .mensagem.sucesso {
            background: rgba(76, 175, 80, 0.1);
            color: #4caf50;
            border: 1px solid #4caf50;
        }
        
        .mensagem.erro {
            background: rgba(244, 67, 54, 0.1);
            color: #f44336;
            border: 1px solid #f44336;
        }
        
        .anuncios-tabela {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .tabela-header, .tabela-row {
            display: grid;
            grid-template-columns: 50px 2fr 1fr 100px 100px 100px 150px;
            gap: 1rem;
            align-items: center;
        }
        
        .tabela-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem;
            font-weight: 600;
        }
        
        .tabela-row {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .tabela-row:hover {
            background: var(--bg-secondary);
        }
        
        .tabela-row:last-child {
            border-bottom: none;
        }
        
        .status-ativo {
            background: #4caf50;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-inativo {
            background: #f44336;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-destaque {
            background: #ff9800;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .btn-acoes {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-editar, .btn-excluir {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-editar {
            background: var(--accent-color);
            color: var(--text-color);
        }
        
        .btn-excluir {
            background: #f44336;
            color: white;
        }
        
        .btn-editar:hover, .btn-excluir:hover {
            transform: translateY(-2px);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .modal-titulo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-color);
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-color);
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-secondary);
            color: var(--text-color);
            font-size: 1rem;
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .form-checkbox input {
            width: auto;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }
        
        .btn-salvar, .btn-cancelar {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-salvar {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-cancelar {
            background: var(--bg-secondary);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }
        
        .btn-salvar:hover, .btn-cancelar:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 1100px) {
            .tabela-header, .tabela-row {
                grid-template-columns: 40px 1.5fr 1fr 80px 80px 80px 120px;
                gap: 0.5rem;
            }
        }
        @media (max-width: 900px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .tabela-header, .tabela-row {
                grid-template-columns: 30px 1fr 1fr 60px 60px 60px 80px;
                font-size: 0.95rem;
            }
        }
        @media (max-width: 700px) {
            .admin-container {
                padding: 0 0.2rem;
            }
            .tabela-header, .tabela-row {
                grid-template-columns: 1fr 1fr 1fr;
                gap: 0.3rem;
                font-size: 0.92rem;
            }
            .tabela-header > div:nth-child(n+4), .tabela-row > div:nth-child(n+4) {
                display: none;
            }
        }
        @media (max-width: 480px) {
            .admin-titulo {
                font-size: 1.1rem;
            }
            .btn-novo {
                width: 100%;
                padding: 0.7rem 0.5rem;
                font-size: 1rem;
            }
            .tabela-header, .tabela-row {
                grid-template-columns: 1fr 1fr;
                font-size: 0.9rem;
            }
        }
        
        /* Se houver exibição de imagem, garantir responsividade */
        .admin-anuncio-imagem img {
            max-width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-titulo">Gerenciar Anúncios</h1>
            <button class="btn-novo" onclick="abrirModalCriar()">+ Novo Anúncio</button>
        </div>
        
        <?php if ($mensagem): ?>
            <div class="mensagem <?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        
        <!-- Tabela responsiva de anúncios -->
        <div class="anuncios-tabela">
            <div class="tabela-header">
                <div>#</div>
                <div>Anúncio</div>
                <div>Categoria</div>
                <div>Status</div>
                <div>Destaque</div>
                <div>Valor</div>
                <div>Ações</div>
            </div>
            <?php foreach ($anuncios as $anuncio): ?>
                <!-- Linha responsiva -->
                <div class="tabela-row">
                    <div><?php echo $anuncio['id']; ?></div>
                    <div>
                        <strong><?php echo htmlspecialchars($anuncio['nome']); ?></strong>
                        <br>
                        <small><?php echo htmlspecialchars(substr($anuncio['texto'], 0, 50)) . '...'; ?></small>
                    </div>
                    <div>-</div>
                    <div>
                        <span class="<?php echo $anuncio['ativo'] ? 'status-ativo' : 'status-inativo'; ?>">
                            <?php echo $anuncio['ativo'] ? 'Ativo' : 'Inativo'; ?>
                        </span>
                    </div>
                    <div>
                        <?php if ($anuncio['destaque']): ?>
                            <span class="status-destaque">Destaque</span>
                        <?php endif; ?>
                    </div>
                    <div>R$ <?php echo number_format($anuncio['valor_anuncio'], 2, ',', '.'); ?></div>
                    <div class="btn-acoes">
                        <!-- Botões de ação -->
                        <button class="btn-editar" data-id="<?php echo $anuncio['id']; ?>">Editar</button>
                        <button class="btn-excluir" data-id="<?php echo $anuncio['id']; ?>">Excluir</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Modal para criar/editar anúncio -->
    <div id="modal-anuncio" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-titulo" id="modal-titulo">Novo Anúncio</h2>
                <button class="modal-close" onclick="fecharModal()">&times;</button>
            </div>
            
            <form id="form-anuncio" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="acao" id="form-acao" value="criar">
                <input type="hidden" name="id" id="form-id" value="">
                
                <div class="form-group">
                    <label class="form-label" for="nome">Nome da Empresa *</label>
                    <input type="text" id="nome" name="nome" class="form-input" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="texto">Texto/Slogan *</label>
                    <textarea id="texto" name="texto" class="form-textarea" required maxlength="200"></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="imagem">Imagem</label>
                    <input type="file" id="imagem" name="imagem" class="form-input" accept="image/*">
                    <small>Selecione uma imagem ou insira uma URL</small>
                    <input type="text" id="imagem_url" name="imagem_url" class="form-input" placeholder="Ou insira URL da imagem" style="margin-top: 0.5rem;">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="valorAnuncio">Valor do Anúncio (R$)</label>
                    <input type="number" id="valorAnuncio" name="valorAnuncio" class="form-input" min="0" step="0.01">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="link">Link</label>
                    <input type="url" id="link" name="link" class="form-input">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" class="form-select">
                        <option value="geral">Geral</option>
                        <option value="lançamento">Lançamento</option>
                        <option value="promoção">Promoção</option>
                        <option value="evento">Evento</option>
                        <option value="sistema">Sistema</option>
                        <option value="comunidade">Comunidade</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="prioridade">Prioridade</label>
                    <select id="prioridade" name="prioridade" class="form-select">
                        <option value="1">Alta (1)</option>
                        <option value="2">Média (2)</option>
                        <option value="3" selected>Baixa (3)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="data_cadastro">Data de Cadastro *</label>
                    <input type="datetime-local" id="data_cadastro" name="data_cadastro" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="data_expiracao">Data de Expiração</label>
                    <input type="datetime-local" id="data_expiracao" name="data_expiracao" class="form-input">
                </div>
                
                <div class="form-checkbox">
                    <input type="checkbox" id="ativo" name="ativo" checked>
                    <label for="ativo">Ativo</label>
                </div>
                
                <div class="form-checkbox">
                    <input type="checkbox" id="destaque" name="destaque">
                    <label for="destaque">Destaque</label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn-salvar">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Formulário para exclusão -->
    <form id="form-excluir" method="POST" style="display: none;">
        <input type="hidden" name="acao" value="excluir">
        <input type="hidden" name="id" id="excluir-id">
    </form>
    
    <script>
        function abrirModalCriar() {
            document.getElementById('modal-titulo').textContent = 'Novo Anúncio';
            document.getElementById('form-acao').value = 'criar';
            document.getElementById('form-id').value = '';
            document.getElementById('form-anuncio').reset();
            document.getElementById('ativo').checked = true;
            document.getElementById('modal-anuncio').style.display = 'flex';
        }
        
        function editarAnuncio(anuncio) {
            document.getElementById('modal-titulo').textContent = 'Editar Anúncio';
            document.getElementById('form-acao').value = 'atualizar';
            document.getElementById('form-id').value = anuncio.id;
            document.getElementById('nome').value = anuncio.nome;
            document.getElementById('texto').value = anuncio.texto;
            document.getElementById('imagem_url').value = anuncio.imagem;
            document.getElementById('link').value = anuncio.link;
            document.getElementById('valorAnuncio').value = anuncio.valorAnuncio || '';
            document.getElementById('categoria').value = anuncio.categoria;
            document.getElementById('prioridade').value = anuncio.prioridade;
            document.getElementById('ativo').checked = anuncio.ativo;
            document.getElementById('destaque').checked = anuncio.destaque;
            
            // Converter data de cadastro para formato local
            if (anuncio.data_cadastro) {
                const dataCadastro = new Date(anuncio.data_cadastro);
                const dataCadastroLocal = dataCadastro.toISOString().slice(0, 16);
                document.getElementById('data_cadastro').value = dataCadastroLocal;
            } else {
                document.getElementById('data_cadastro').value = '';
            }
            
            // Converter data de expiração para formato local
            if (anuncio.data_expiracao) {
                const data = new Date(anuncio.data_expiracao);
                const dataLocal = data.toISOString().slice(0, 16);
                document.getElementById('data_expiracao').value = dataLocal;
            } else {
                document.getElementById('data_expiracao').value = '';
            }
            
            document.getElementById('modal-anuncio').style.display = 'flex';
        }
        
        function fecharModal() {
            document.getElementById('modal-anuncio').style.display = 'none';
        }
        
        function excluirAnuncio(id) {
            if (confirm('Tem certeza que deseja excluir este anúncio?')) {
                document.getElementById('excluir-id').value = id;
                document.getElementById('form-excluir').submit();
            }
        }
        
        // Fechar modal ao clicar fora
        document.getElementById('modal-anuncio').addEventListener('click', function(e) {
            if (e.target === this) {
                fecharModal();
            }
        });
    </script>
</body>
</html> 