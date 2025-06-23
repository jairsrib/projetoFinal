<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
 header('Location: index.php');
 exit();

}
include_once './config/config.php';
include_once './classes/Noticia.php';
$usuario = new Usuario($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $id = $_POST['id'];
 $nome = $_POST['nome'];
 $sexo = $_POST['sexo'];
 $fone = $_POST['fone'];
 $email = $_POST['email'];
 $usuario->atualizar($id, $nome, $sexo, $fone, $email);
 header('Location: portal.php');
 exit();
}
if (isset($_GET['id'])) {
 $id = $_GET['id'];
 $row = $usuario->lerPorId($id);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="assets/nova_noticia.css">
 <title>Editar Usuário</title>
</head>
<body>
 <h1>Editar Usuário</h1>
 <form method="POST">
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  <label for="nome">Nome:</label>
  <input type="text" name="nome" value="<?php echo $row['nome'];
?>" required>
  <br><br>
  <label>Sexo:</label>
  <label for="masculino_editar">
   <input type="radio" id="masculino_editar" name="sexo"
value="M" <?php echo ($row['sexo'] === 'M') ? 'checked' : ''; ?>
required> Masculino
  </label>
  <label for="feminino_editar">
   <input type="radio" id="feminino_editar" name="sexo"
value="F" <?php echo ($row['sexo'] === 'F') ? 'checked' : ''; ?>
required> Feminino
  </label>
  <br><br>

  <label for="fone">Fone:</label>
  <input type="text" name="fone" value="<?php echo $row['fone'];
?>" required>
  <br><br>
  <label for="email">Email:</label>
  <input type="email" name="email" value="<?php echo $row['email'];
?>" required>
  <br><br>
  <input type="submit" value="Atualizar">
 </form>
<button class="btn btn-outline-light mt-2" onclick="abrirModal()">Abrir Formulário</button>
 <div class="modal-custom" id="modalNoticia">
  <div class="modal-content-custom">
    <button class="close-modal-btn" onclick="fecharModal()">&times;</button>

    <div class="form-container">
      <form class="form">
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
                <path d="M10 1C9.7 1 9.5 1.1 9.3 1.3L3.3 7.3C3.1 7.5 3 7.7 3 8V20C3 21.7 4.3 23 6 23H7C7.6 23 8 22.6 8 22C8 21.4 7.6 21 7 21H6C5.4 21 5 20.6 5 20V9H10C10.6 9 11 8.6 11 8V3H18C18.6 3 19 3.4 19 4V9C19 9.6 19.4 10 20 10C20.6 10 21 9.6 21 9V4C21 2.3 19.7 1 18 1H10ZM9 7H6.4L9 4.4V7Z"/>
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
</body>
</html>