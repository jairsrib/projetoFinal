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
  $stmt = $db->prepare("SELECT id, titulo FROM noticias WHERE autor_id = :id");
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

</head>

<body>
  <?php include_once './header.php' ?>
  <div class="container-fluid d-flex justify-content-center align-items-center text-white" style="min-height: 100vh;">
  <div class="d-flex flex-column flex-lg-row align-items-start w-100" style="max-width: 1200px;">

    <div class="d-flex flex-column align-items-center p-3 me-lg-4 mb-4 mb-lg-0 bg-black rounded-4 shadow profile-card">
      <input type="file" id="profileInput" accept="image/*" style="display: none;">
      <label for="profileInput" class="cursor-pointer">
        <img src="img/usuarioTeste.png" id="profilePic" alt="Foto de Perfil" class="profile-img mb-3">
      </label>
      <h5><?php echo htmlspecialchars($dados_usuario['nome']); ?></h5>
    </div>

    <div class="container">
      <div class="card card-custom flex-grow-1 shadow">
      <ul class="nav nav-tabs nav-justified" id="userTab" role="tablist">
          <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
              data-bs-target="#info">Informações</button></li>
           <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#Noticias">Minhas Notícias</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
              data-bs-target="#config">Configurações</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#noticia">Cadastrar
              Notícia</button></li>
        </ul>

         <div class="tab-content p-4">
          <div class="tab-pane fade show active" id="info">
            <h4 style="color: white">Informações do Usuário</h4>

            <label >Nome:</label><br>
            <span ><?php echo htmlspecialchars($dados_usuario['nome']); ?></span><br><br>

            <label >E-mail:</label><br>
            <span ><?php echo htmlspecialchars($dados_usuario['email']); ?></span><br><br>

            <label >Telefone:</label><br>
            <span ><?php echo htmlspecialchars($dados_usuario['fone']); ?></span><br><br>

            <label >Quantidade de Notícias Publicadas:</label><br>
            <span >
              <?php
              $stmtNoticias = $db->prepare("SELECT COUNT(*) FROM noticias WHERE autor_id = :id");
              $stmtNoticias->bindParam(':id', $_SESSION['usuario_id']);
              $stmtNoticias->execute();
              echo $stmtNoticias->fetchColumn();
              ?>
            </span>
          </div>
          <div class="tab-pane fade" id="Noticias">
          <h4>Minhas Notícias</h4>
          <table class="table table-dark table-hover table-bordered mt-3">
            <thead class="table-secondary text-dark">
              <tr>
                <th>Título</th>
                <th>Selecionar</th>
              </tr>
                </thead>
                <tbody>
                  <?php foreach ($noticiasDoUsuario as $noticia): ?>
                    <tr>
                      <td style="color: white;"><?php echo htmlspecialchars($noticia['titulo']); ?></td>
                      <td>
                        <label class="check">
                          <input type="checkbox" name="noticias_selecionadas[]" value="<?php echo $noticia['id']; ?>">
                          <div class="checkmark"></div>
                        </label>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

              <button class="btn btn-outline-light mt-2" onclick="abrirModalEditar()">Editar Notícia</button>
              <button class="btn btn-outline-light mt-2">Excluir Noticia</button>
            </form>
          </div>
          <div class="tab-pane fade" id="config">
            <h4>Configurações</h4>
          </div>
          <div class="tab-pane fade" id="noticia">
            <h4>Cadastrar Notícia</h4>
            <button class="btn btn-pink mt-3" onclick="abrirModalCadastrar()">Abrir Formulário</button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!------ Modal De Cadastrar Noticia ------>
  <div class="modal-custom" id="modalNoticia">
    <div class="modal-content-custom">
      <button class="close-modal-btn" onclick="fecharModalCadastrar()">&times;</button>

      <div class="form-container">
        <form class="form" method="post" action="noticia.php">
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
            <option value="noticia">Notícia</option>
            <option value="jogo">Jogo</option>
            <option value="evento">Evento</option>
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
              <input id="file" type="file" name="imagem">
            </label>
          </div>
          <button class="form-submit-btn" type="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <!------ Modal De Editar Noticia ------>
  <div class="modal-custom" id="modalEditar">
    <div class="modal-content-custom">
      <button class="close-modal-btn" onclick="fecharModalEditar()">&times;</button>

      <div class="form-container">
        <form class="form" method="post" action="editar_noticia.php" enctype="multipart/form-data">
          <!-- Campo oculto com o ID da notícia -->
          <input type="hidden" id="idsNoticiasSelecionadas" name="idsNoticiasSelecionadas">

          <div class="form-group">
            <label for="email">Título</label>
            <input type="text" id="email" name="titulo" required>
          </div>

          <div class="form-group">
            <label for="textarea">Descrição da Notícia</label>
            <textarea name="texto" id="textarea" rows="10" cols="50" required></textarea>
          </div>

          <select name="categoria" required>
            <option value="">Selecione a categoria</option>
            <option value="noticia">Notícia</option>
            <option value="jogo">Jogo</option>
            <option value="evento">Evento</option>
          </select>

          <div class="imagem-input">
            <label for="file" class="custum-file-upload">
              <!-- ícone e label -->
              <input id="file" type="file" name="imagem">
            </label>
          </div>

          <button class="form-submit-btn" type="submit">Enviar</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/painel_usuario.js"></script>

</body>

</html>