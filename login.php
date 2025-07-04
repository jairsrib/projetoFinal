<?php
session_start();
include_once "./config/config.php";
include_once "./classes/Usuario.php";
include_once "./config/theme_config.php";
$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    if ($dados_usuario = $usuario->login($email, $senha)) {
      $_SESSION['usuario_id'] = $dados_usuario['id'];
      $_SESSION['usuario_tipo'] = $dados_usuario['tipo'];
       header('Location: index.php'); // Redireciona para o dashboard
      exit();
    } else {
      $mensagem_erro = 'Credenciais inválidas!';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br" <?php echo getThemeDataAttribute(); ?>>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/theme.css">
  <link rel="stylesheet" href="assets/tela_login.css">
</head>

<body>
  <div class="container">
    <div class="box">
      <h1 class="login">Login</h1>
      <form class="form" method="POST">
        <p id="heading">Login</p>
        <div class="field">
          <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"></path>
          </svg>
          <input autocomplete="off" placeholder="Email" class="input-field" type="email" name="email" required>
        </div>
        <div class="field">
          <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
          </svg>
          <input placeholder="Password" class="input-field" type="password" name="senha" required>
        </div>
        <div class="btn">
          <button class="button1" name="login" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
          <button class="button2" type="button" onclick="window.location.href='cadastro.php'">Cadastrar</button>
        </div>
        <button class="button3" type="button" name="esqueceu_senha" onclick="document.getElementById('modalEsqueci').style.display='block'">Esqueceu a Senha</button>
      </form>
      <div class="mensagem">
        <?php if (isset($mensagem_erro)) echo '<p>' .
          $mensagem_erro . '</p>'; ?>
      </div>
    </div>
  </div>

  <div id="modalEsqueci" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:var(--overlay-bg);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:var(--bg-card);padding:2rem;border-radius:12px;max-width:400px;margin:10vh auto;position:relative;color:var(--text-primary);">
      <button onclick="document.getElementById('modalEsqueci').style.display='none'" style="position:absolute;top:10px;right:15px;background:none;border:none;font-size:1.5rem;color:var(--text-primary);">&times;</button>
      <h2 style="color:var(--text-accent);">Recuperar Senha</h2>
      <form method="post" action="esqueceu_senha.php">
        <label for="email_rec" style="color:var(--text-primary);">Digite seu e-mail cadastrado:</label>
        <input type="email" name="email_rec" id="email_rec" class="input-field" required style="width:100%;margin:1rem 0;">
        <button type="submit" class="button1" style="width:100%;">Recuperar Senha</button>
      </form>
    </div>
  </div>
  
  <script src="assets/js/theme.js"></script>
</body>

</html>