<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = htmlspecialchars(trim($_POST["nome"]));
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $mensagem = htmlspecialchars(trim($_POST["mensagem"]));

  $destino = "jair.ribeiro.souza@gmail.com";

  $assunto = "Mensagem de Contato do Site";
  $corpo = "Nome: $nome\n";
  $corpo .= "E-mail: $email\n";
  $corpo .= "Mensagem:\n$mensagem";

  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  if (mail($destino, $assunto, $corpo, $headers)) {
    echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href = 'contato.php';</script>";
  } else {
    echo "<script>alert('Erro ao enviar mensagem. Tente novamente.'); window.location.href = 'contato.php';</script>";
  }
} else {
  header("Location: contato.php");
  exit;
}
