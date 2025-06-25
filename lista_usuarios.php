<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario = new Usuario($db);
$usuarios = $usuario->ler()->fetchAll(PDO::FETCH_ASSOC);

$total_usuarios = count($usuarios);
$usuarios_ativos = count(array_filter($usuarios, function($u) {
    return !empty($u['email']); 
}));
$usuarios_masculinos = count(array_filter($usuarios, function($u) {
    return $u['sexo'] === 'M';
}));
$usuarios_femininos = count(array_filter($usuarios, function($u) {
    return $u['sexo'] === 'F';
}));
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários - Caiu o Servidor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/reset.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/footer.css">
    <link rel="stylesheet" href="assets/lista_usuarios.css">
</head>

<body>
    <?php include_once './header.php'; ?>
    
    <div class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <i class="fas fa-users me-3"></i>
                    Lista de Usuários
                </h1>
                <p class="hero-subtitle">Gerencie todos os usuários da plataforma</p>
                
                <div class="stats-container">
                    <div class="stat-card">
                        <i class="fas fa-users stat-icon"></i>
                        <div class="stat-content">
                            <span class="stat-number"><?= $total_usuarios ?></span>
                            <span class="stat-label">Total de Usuários</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-user-check stat-icon"></i>
                        <div class="stat-content">
                            <span class="stat-number"><?= $usuarios_ativos ?></span>
                            <span class="stat-label">Usuários Ativos</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-mars stat-icon"></i>
                        <div class="stat-content">
                            <span class="stat-number"><?= $usuarios_masculinos ?></span>
                            <span class="stat-label">Masculino</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-venus stat-icon"></i>
                        <div class="stat-content">
                            <span class="stat-number"><?= $usuarios_femininos ?></span>
                            <span class="stat-label">Feminino</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="table-section">
        <div class="container">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-table me-3"></i>
                    <h2>Usuários Cadastrados</h2>
                </div>
                <div class="table-actions">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" placeholder="Buscar usuário..." class="search-input">
                    </div>
                    <!-- <button class="btn-export" onclick="exportarUsuarios()">
                        <i class="fas fa-download me-2"></i>
                        Exportar
                    </button> -->
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover" id="usuariosTable">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-hashtag me-2"></i>
                                    ID
                                </th>
                                <th>
                                    <i class="fas fa-user me-2"></i>
                                    Usuário
                                </th>
                                <th>
                                    <i class="fas fa-image me-2"></i>
                                    Foto
                                </th>
                                <th>
                                    <i class="fas fa-envelope me-2"></i>
                                    Email
                                </th>
                                <th>
                                    <i class="fas fa-phone me-2"></i>
                                    Telefone
                                </th>
                                <th>
                                    <i class="fas fa-venus-mars me-2"></i>
                                    Sexo
                                </th>
                                <th>
                                    <i class="fas fa-newspaper me-2"></i>
                                    Notícias
                                </th>
                                <th>
                                    <i class="fas fa-user-tag me-2"></i>
                                    Tipo
                                </th>
                                <th>
                                    <i class="fas fa-cog me-2"></i>
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $user): ?>
                                <?php
                                $stmt = $db->prepare("SELECT COUNT(*) FROM noticias WHERE autor_id = ?");
                                $stmt->execute([$user['id']]);
                                $num_noticias = $stmt->fetchColumn();
                                ?>
                                <tr>
                                    <td>
                                        <span class="user-id">#<?= $user['id'] ?></span>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="user-details">
                                                <span class="user-name"><?= htmlspecialchars($user['nome']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-avatar">
                                            <?php if (!empty($user['imagem_perfil'])): ?>
                                                <img src="uploads/<?= htmlspecialchars($user['imagem_perfil']) ?>" alt="Foto de Perfil" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                            <?php else: ?>
                                                <i class="fas fa-user" style="font-size: 1.2rem; color: #666;"></i>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="user-email"><?= htmlspecialchars($user['email']) ?></span>
                                    </td>
                                    <td>
                                        <span class="user-phone"><?= htmlspecialchars($user['fone']) ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $sexo_icon = '';
                                        $sexo_class = '';
                                        switch($user['sexo']) {
                                            case 'M':
                                                $sexo_icon = 'fas fa-mars';
                                                $sexo_class = 'sexo-masculino';
                                                $sexo_text = 'Masculino';
                                                break;
                                            case 'F':
                                                $sexo_icon = 'fas fa-venus';
                                                $sexo_class = 'sexo-feminino';
                                                $sexo_text = 'Feminino';
                                                break;
                                            default:
                                                $sexo_icon = 'fas fa-genderless';
                                                $sexo_class = 'sexo-outro';
                                                $sexo_text = 'Outro';
                                        }
                                        ?>
                                        <span class="sexo-badge <?= $sexo_class ?>">
                                            <i class="<?= $sexo_icon ?> me-1"></i>
                                            <?= $sexo_text ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="noticias-count">
                                            <i class="fas fa-newspaper me-1"></i>
                                            <?= $num_noticias ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="user-role badge bg-secondary text-uppercase" style="font-size:0.9em;letter-spacing:1px;">
                                            <?= htmlspecialchars($user['tipo'] ?? 'usuario') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action btn-view" onclick="verUsuario(<?= $user['id'] ?>)" title="Ver detalhes">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
                                            <button class="btn-action btn-edit" onclick="abrirModalEditarUsuario(<?= $user['id'] ?>)" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php endif; ?>
                                            <button class="btn-action btn-delete" onclick="excluirUsuario(<?= $user['id'] ?>)" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin' && ($user['tipo'] ?? 'usuario') === 'usuario'): ?>
                                                <form method="post" action="tornar_autor.php" style="display:inline;">
                                                    <input type="hidden" name="usuario_id" value="<?= $user['id'] ?>">
                                                    <button type="submit" class="btn-action btn-promote" title="Tornar Autor">
                                                        <i class="fas fa-user-edit"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pagination-container">
                <div class="pagination-info">
                    <span>Mostrando <?= $total_usuarios ?> usuários</span>
                </div>
                <div class="pagination-controls">
                    <button class="btn-pagination" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="page-info">Página 1 de 1</span>
                    <button class="btn-pagination" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="modal-custom" id="modalUsuario">
        <div class="modal-content-custom">
            <button class="close-modal-btn" onclick="fecharModalUsuario()">&times;</button>
            <div class="modal-body">
                <div class="usuario-profile-pic mb-3">
                    <img id="modalUsuarioFoto" src="" alt="Foto de Perfil" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #FF084B;">
                </div>
                <h3 id="modalUsuarioNome"></h3>
                <div class="usuario-details">
                    <div class="detail-item">
                        <i class="fas fa-envelope"></i>
                        <span id="modalUsuarioEmail"></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-phone"></i>
                        <span id="modalUsuarioTelefone"></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-venus-mars"></i>
                        <span id="modalUsuarioSexo"></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-newspaper"></i>
                        <span id="modalUsuarioNoticias"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
    <div class="modal-custom" id="modalEditarUsuario">
        <div class="modal-content-custom">
            <button class="close-modal-btn" onclick="fecharModalEditarUsuario()">&times;</button>
            <div class="modal-body">
                <h3>Editar Usuário</h3>
                <form id="formEditarUsuario" method="post" action="editar_usuario_admin.php">
                    <input type="hidden" name="id" id="editUsuarioId">
                    <div class="mb-3">
                        <label for="editNome" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" id="editNome" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="fone" id="editFone" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSexo" class="form-label">Sexo</label>
                        <select class="form-control" name="sexo" id="editSexo" required>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                            <option value="O">Outro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTipo" class="form-label">Tipo</label>
                        <select class="form-control" name="tipo" id="editTipo" required>
                            <option value="usuario">Usuário</option>
                            <option value="autor">Autor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php include_once './footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/lista_usuarios.js"></script>
</body>
</html>
