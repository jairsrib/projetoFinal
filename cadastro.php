<?php
include_once './config/config.php';
include_once './classes/Usuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $usuario = new Usuario($db);
 $nome = $_POST['nome'];
 $sexo = $_POST['sexo'];
 $fone = $_POST['fone'];
 $email = $_POST['email'];
 $senha = $_POST['senha'];
 $usuario->criar($nome, $sexo, $fone, $email, $senha);
 header('Location: portal.php');
 exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="assets/form_cadastro.css">
 <meta charset="UTF-8">
 <title>Adicionar Usuário</title>
</head>
<body>
  
<div class="div-form">
<form class="form" method="POST">
    <p class="title">Cadastrar</p>
    <p class="message">Cadastre-se para divulgar suas notícias </p>
        <label>
            <input class="input" type="text" placeholder="" required="" name="nome">
            <span>Nome</span>
        </label>
            
    <label>
        <input class="input" type="email" placeholder="" required="" name="email">
        <span>Email</span>
    </label> 

    <label>
        <input class="input" type="number" placeholder="" required="" name="fone">
        <span>Telefone</span>
    </label>     

    <label>
        <input class="input" type="password" placeholder="" required="" name="senha">
        <span>Senha</span>
    </label>
    <label>
        <input class="input" type="password" placeholder="" required="">
        <span>Confirmar a senha</span>
    </label>

    <div class="radio-container">
  <div class="radio-wrapper">
    <label class="radio-button">
      <input id="option1" name="radio-group" type="radio" value="M">
      <span class="radio-checkmark"></span>
      <span class="radio-label">Masculino</span>
    </label>
  </div>

  <div class="radio-wrapper">
    <label class="radio-button">
      <input id="option2" name="radio-group" type="radio" value="F">
      <span class="radio-checkmark"></span>
      <span class="radio-label">Feminino</span>
    </label>
  </div>

  <div class="radio-wrapper">
    <label class="radio-button">
      <input id="option3" name="radio-group" type="radio" value="O">
      <span class="radio-checkmark"></span>
      <span class="radio-label">Outro</span>
    </label>
  </div>
</div>
    <button class="submit">Cadastrar</button>
    <p class="signin">Você já tem uma conta? <a href="login.php">Login</a> </p>
</form>
</div>
</select>
</body>
</html>
