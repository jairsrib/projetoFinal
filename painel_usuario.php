<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
  exit();
}

$usuario = new Usuario($db);
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
?>
<?php


$noticiasDoUsuario = [];

if (isset($_SESSION['usuario_id'])) {
$stmt = $db->prepare("SELECT id, titulo, texto, categoria, imagem, data FROM noticias WHERE autor_id = :id ORDER BY data DESC");

  $stmt->bindParam(':id', $_SESSION['usuario_id']);
  $stmt->execute();
  $noticiasDoUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Painel de Usuário</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/nova_noticia.css">
  <link rel="stylesheet" href="assets/painel_usuario.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
  <?php include_once './header.php' ?>
  
  <?php if (isset($_SESSION['mensagem'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo_mensagem']; ?> alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
      <?php echo $_SESSION['mensagem']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php 
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
    ?>
  <?php endif; ?>
  
  <div class="container-fluid d-flex justify-content-center align-items-center text-white" style="min-height: 100vh;">
    <div class="d-flex flex-column flex-lg-row align-items-start w-100" style="max-width: 1400px;">

      <div class="d-flex flex-column align-items-center p-4 me-lg-4 mb-4 mb-lg-0 bg-black rounded-4 shadow profile-card">
        <div class="position-relative">
          <form id="formProfilePic" method="post" action="upload_perfil.php" enctype="multipart/form-data">
            <input type="file" id="profileInput" name="imagem_perfil" accept="image/*" style="display: none;" onchange="this.form.submit()">
            <label for="profileInput" class="cursor-pointer">
              <img src="<?php echo $dados_usuario['imagem_perfil'] ? 'uploads/' . htmlspecialchars($dados_usuario['imagem_perfil']) : 'img/usuarioTeste.png'; ?>" id="profilePic" alt="Foto de Perfil" class="profile-img mb-3">
              <div class="profile-edit-overlay">
                <i class="fas fa-camera"></i>
              </div>
            </label>
          </form>
        </div>
        <h5 class="mb-2"><?php echo htmlspecialchars($dados_usuario['nome']); ?></h5>
        <p class="text-muted mb-0"><i class="fas fa-user-circle me-2"></i>Usuário</p>
      </div>

      <div class="container flex-grow-1">
        <div class="card card-custom flex-grow-1 shadow">
          
          <ul class="nav nav-tabs nav-justified" id="userTab" role="tablist">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info">
                <i class="fas fa-info-circle me-2"></i>Informações
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Noticias">
                <i class="fas fa-newspaper me-2"></i>Minhas Notícias
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#config">
                <i class="fas fa-cog me-2"></i>Configurações
              </button>
            </li>
            <?php if (in_array($_SESSION['usuario_tipo'] ?? '', ['admin', 'autor'])): ?>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#noticia">
                <i class="fas fa-plus-circle me-2"></i>Nova Notícia
              </button>
            </li>
            <?php endif; ?>
          </ul>

          <div class="tab-content p-4">
            
            <div class="tab-pane fade show active" id="info">
              <div class="d-flex align-items-center mb-4">
                <i class="fas fa-user-circle text-primary me-3" style="font-size: 2rem;"></i>
                <h4 class="mb-0">Informações do Usuário</h4>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="info-card mb-3">
                    <div class="info-icon">
                      <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                      <label class="info-label">Nome Completo</label>
                      <span class="info-value"><?php echo htmlspecialchars($dados_usuario['nome']); ?></span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="info-card mb-3">
                    <div class="info-icon">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                      <label class="info-label">E-mail</label>
                      <span class="info-value"><?php echo htmlspecialchars($dados_usuario['email']); ?></span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="info-card mb-3">
                    <div class="info-icon">
                      <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-content">
                      <label class="info-label">Telefone</label>
                      <span class="info-value"><?php echo htmlspecialchars($dados_usuario['fone']); ?></span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="info-card mb-3">
                    <div class="info-icon">
                      <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="info-content">
                      <label class="info-label">Notícias Publicadas</label>
                      <span class="info-value">
                        <?php
                        $stmtNoticias = $db->prepare("SELECT COUNT(*) FROM noticias WHERE autor_id = :id");
                        $stmtNoticias->bindParam(':id', $_SESSION['usuario_id']);
                        $stmtNoticias->execute();
                        echo $stmtNoticias->fetchColumn();
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="Noticias">
              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                  <i class="fas fa-newspaper text-primary me-3" style="font-size: 2rem;"></i>
                  <h4 class="mb-0">Minhas Notícias</h4>
                </div>
                <div class="d-flex gap-2">
                  <?php if (in_array($_SESSION['usuario_tipo'] ?? '', ['admin', 'autor'])): ?>
                    <button class="btn btn-outline-light" onclick="abrirModalEditar()">
                      <i class="fas fa-edit me-2"></i>Editar
                    </button>
                    <button class="btn btn-outline-danger" onclick="excluirNoticias()">
                      <i class="fas fa-trash me-2"></i>Excluir
                    </button>
                  <?php endif; ?>
                  <button class="btn btn-outline-info" onclick="selecionarTodas()">
                    <i class="fas fa-check-double me-2"></i>Selecionar Todas
                  </button>
                </div>
              </div>

              <?php if (empty($noticiasDoUsuario)): ?>
                <div class="text-center py-5">
                  <i class="fas fa-newspaper text-muted" style="font-size: 4rem;"></i>
                  <h5 class="text-muted mt-3">Nenhuma notícia encontrada</h5>
                  <p class="text-muted">Comece criando sua primeira notícia!</p>
                  <?php if (in_array($_SESSION['usuario_tipo'] ?? '', ['admin', 'autor'])): ?>
                    <button class="btn btn-pink" onclick="document.querySelector('[data-bs-target=\'#noticia\']').click()">
                      <i class="fas fa-plus me-2"></i>Criar Notícia
                    </button>
                  <?php endif; ?>
                </div>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-dark table-hover table-bordered">
                    <thead class="table-secondary text-dark">
                      <tr>
                        <th><i class="fas fa-hashtag me-2"></i>ID</th>
                        <th><i class="fas fa-image me-2"></i>Imagem</th>
                        <th><i class="fas fa-heading me-2"></i>Título</th>
                        <th><i class="fas fa-tag me-2"></i>Categoria</th>
                        <th><i class="fas fa-calendar me-2"></i>Data</th>
                        <th><i class="fas fa-check me-2"></i>Selecionar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($noticiasDoUsuario as $noticia): ?>
                        <tr>
                          <td style="color: white;">#<?php echo $noticia['id']; ?></td>
                          <td>
                            <?php if (!empty($noticia['imagem'])): ?>
                              <img src="uploads/<?php echo htmlspecialchars($noticia['imagem']); ?>" 
                                   alt="Imagem da notícia" 
                                   style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                              <i class="fas fa-image text-muted" style="font-size: 1.5rem;"></i>
                            <?php endif; ?>
                          </td>
                          <td style="color: white;"><?php echo htmlspecialchars($noticia['titulo']); ?></td>
                          <td>
                            <span class="badge bg-primary"><?php echo htmlspecialchars($noticia['categoria']); ?></span>
                          </td>
                          <td style="color: white;">
                            <?php 
                            $data = new DateTime($noticia['data']);
                            echo $data->format('d/m/Y H:i');
                            ?>
                          </td>
                          <td>
                            <label class="check">
                              <input 
                                type="checkbox" 
                                name="noticias_selecionadas[]" 
                                value="<?= $noticia['id'] ?>"
                                data-titulo="<?= htmlspecialchars($noticia['titulo'], ENT_QUOTES) ?>"
                                data-texto="<?= htmlspecialchars($noticia['texto'], ENT_QUOTES) ?>"
                                data-categoria="<?php echo $noticia['categoria'] ?>"
                              >
                              <div class="checkmark"></div>
                            </label>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
            </div>

            <div class="tab-pane fade" id="config">
              <div class="d-flex align-items-center mb-4">
                <i class="fas fa-cog text-primary me-3" style="font-size: 2rem;"></i>
                <h4 class="mb-0">Configurações</h4>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="config-card">
                    <h5><i class="fas fa-user-edit me-2"></i>Editar Perfil</h5>
                    <p class="text-muted">Atualize suas informações pessoais</p>
                    <button class="btn btn-outline-light" onclick="abrirModalEditarPerfil()">
                      <i class="fas fa-edit me-2"></i>Editar
                    </button>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="config-card">
                    <h5><i class="fas fa-lock me-2"></i>Alterar Senha</h5>
                    <p class="text-muted">Mantenha sua conta segura</p>
                    <button class="btn btn-outline-light" onclick="abrirModalAlterarSenha()">
                      <i class="fas fa-key me-2"></i>Alterar
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="noticia">
              <div class="d-flex align-items-center mb-4">
                <i class="fas fa-plus-circle text-primary me-3" style="font-size: 2rem;"></i>
                <h4 class="mb-0">Criar Nova Notícia</h4>
              </div>
              
              <div class="text-center py-5">
                <i class="fas fa-plus-circle text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Criar Nova Notícia</h5>
                <p class="text-muted">Compartilhe suas notícias com a comunidade</p>
                <button class="btn btn-pink" onclick="abrirModalCadastrar()">
                  <i class="fas fa-plus me-2"></i>Abrir Formulário
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-custom" id="modalNoticia">
    <div class="modal-content-custom">
      <button class="close-modal-btn" onclick="fecharModalCadastrar()">&times;</button>

      <div class="form-container">
        <form class="form" method="post" action="nova_noticia.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="email">Titulo</label>
            <input type="text" id="email" name="titulo" required="">
          </div>
          <div class="form-group">
            <label for="textarea">Descrição da Notícia</label>
            <textarea name="texto" id="textarea" rows="10" cols="50" required=""></textarea>
          </div>
          <select name="categoria" required>
            <option value="">Selecione a categoria</option>
            <option value="E-Sports">E-Sports</option>
            <option value="Speed-Run">Speed-Run</option>
            <option value="Battle-Royale">Battle-Royale</option>
            <option value="RPG">RPG</option>
          </select>
          <div class="imagem-input">
            <label for="file" class="custum-file-upload">
              <div class="icon">
                <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10 1C9.7 1 9.5 1.1 9.3 1.3L3.3 7.3C3.1 7.5 3 7.7 3 8V20C3 21.7 4.3 23 6 23H7C7.6 23 8 22.6 8 22C8 21.4 7.6 21 7 21H6C5.4 21 5 20.6 5 20V9H10C10.6 9 11 8.6 11 8V3H18C18.6 3 19 3.4 19 4V9C19 9.6 19.4 10 20 10C20.6 10 21 9.6 21 9V4C21 2.3 19.7 1 18 1H10ZM9 7H6.4L9 4.4V7Z" />
                </svg>
              </div>
              <div class="text"><span>inserir Imagem</span></div>
              <input id="file" type="file" name="imagem" required>
            </label>
          </div>
          <button class="form-submit-btn" type="submit">Criar Notícia</button>
        </form>
      </div>
    </div>
  </div>

  <div class="modal-custom" id="modalEditar">
    <div class="modal-content-custom">
      <button class="close-modal-btn" onclick="fecharModalEditar()">&times;</button>

      <div class="form-container">
        <form class="form" method="post" action="editar_noticia.php" enctype="multipart/form-data">
          <input type="hidden" id="idsNoticiasSelecionadas" name="id">
          <input type="hidden" name="autor_id" value="<?php echo $_SESSION['usuario_id']; ?>">

          <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" required>
          </div>

          <div class="form-group">
            <label for="textarea">Descrição da Notícia</label>
            <textarea name="texto" id="texto" rows="10" cols="50" required></textarea>
          </div>

          <select name="categoria">
            <option value="">Selecione a categoria</option>
            <option value="E-Sports">E-Sports</option>
            <option value="Speed-Run">Speed-Run</option>
            <option value="Battle-Royale">Battle-Royale</option>
            <option value="RPG">RPG</option>
          </select>

          <div class="imagem-input">
            <label for="file" class="custum-file-upload">
              <input id="file" type="file" name="imagem">
            </label>
          </div>

          <button class="form-submit-btn" type="submit">Atualizar Notícia</button>
        </form>
      </div>
    </div>
  </div>

  <div class="modal-custom" id="modalEditarPerfil">
    <div class="modal-content-custom">
      <button class="close-modal-btn" onclick="fecharModalEditarPerfil()">&times;</button>

      <div class="form-container">
        <form class="form" method="post" action="editar_perfil.php">
          <h3 class="form-title">Editar Perfil</h3>
          
          <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($dados_usuario['nome']); ?>" required>
          </div>

          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($dados_usuario['email']); ?>" required>
          </div>

          <div class="form-group">
            <label for="fone">Telefone</label>
            <input type="text" id="fone" name="fone" value="<?php echo htmlspecialchars($dados_usuario['fone']); ?>" required>
          </div>

          <div class="form-group">
            <label for="sexo">Sexo</label>
            <select name="sexo" id="sexo" required>
              <option value="M" <?php echo ($dados_usuario['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
              <option value="F" <?php echo ($dados_usuario['sexo'] == 'F') ? 'selected' : ''; ?>>Feminino</option>
              <option value="O" <?php echo ($dados_usuario['sexo'] == 'O') ? 'selected' : ''; ?>>Outro</option>
            </select>
          </div>

          <button class="form-submit-btn" type="submit">Atualizar Perfil</button>
        </form>
      </div>
    </div>
  </div>

  <div class="modal-custom" id="modalAlterarSenha">
    <div class="modal-content-custom">
      <button class="close-modal-btn" onclick="fecharModalAlterarSenha()">&times;</button>

      <div class="form-container">
        <form class="form" method="post" action="alterar_senha.php">
          <h3 class="form-title">Alterar Senha</h3>
          
          <div class="form-group">
            <label for="senha_atual">Senha Atual</label>
            <input type="password" id="senha_atual" name="senha_atual" required>
          </div>

          <div class="form-group">
            <label for="nova_senha">Nova Senha</label>
            <input type="password" id="nova_senha" name="nova_senha" required>
          </div>

          <div class="form-group">
            <label for="confirmar_senha">Confirmar Nova Senha</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required>
          </div>

          <button class="form-submit-btn" type="submit">Alterar Senha</button>
        </form>
      </div>
    </div>
  </div>

  <form id="formExcluir" method="post" action="excluir_noticias.php" style="display: none;">
    <input type="hidden" name="noticias_ids" id="noticiasIds">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/painel_usuario.js"></script>

</body>

</html>