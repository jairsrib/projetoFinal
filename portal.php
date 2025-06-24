<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';
require_once './header.php';
if (!isset($_SESSION['usuario_id'])) {
 exit();
}
$usuario = new Usuario($db);
if (isset($_GET['deletar'])) {
 $id = $_GET['deletar'];

 $usuario->deletar($id);
 exit();
}
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
$dados = $usuario->ler();
function saudacao() {
 $hora = date('H');
 if ($hora >= 6 && $hora < 12) {
  return "Bom dia";
 } elseif ($hora >= 12 && $hora < 18) {
  return "Boa tarde";
 } else {
  return "Boa noite";
 }
}
?>

<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "projeto_final");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta
$sql = "SELECT * FROM noticias";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
 <meta charset="UTF-8">
 <title>Portal</title>
</head>
<body>
    <div class="container">
    <a href="nova_noticia.php">no va noticia</a>

     <?php while ($row = $result->fetch_assoc()) { ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
            <h2><?php echo $row['titulo']; ?></h2>
            <p><?php echo $row['texto']; ?></p>
            <p><strong>Data:</strong> <?php echo $row['data']; ?></p>
            <img src="<?php echo $row['imagem']; ?>" alt="Imagem da notícia" style="max-width: 400px;">
        </div>
    <?php } ?>
 <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
 <a href="cadastro.php">Adicionar Usuário</a>
 <a href="logout.php">Logout</a>
 <a href="dashboard.php">Dashboard</a>
<br>
 <table border="1">
  <tr>
   <th>ID</th>
   <th>Nome</th>
   <th>Sexo</th>
   <th>Fone</th>
   <th>Email</th>
   <th>Ações</th>
  </tr>
  <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
   <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['nome']; ?></td>

    <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' :
'Feminino'; ?></td>
    <td><?php echo $row['fone']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td>
     <a href="editar.php?id=<?php echo $row['id'];
?>">Editar</a>
     <a href="deletar.php?id=<?php echo $row['id'];
?>">Deletar</a>
    </td>
   </tr>
  <?php endwhile; ?>
 </table>
    </div>
</body>
</html>

<style>
  
body {
  position: absolute;
  background-image: radial-gradient(
    circle at 50% 50%,
    #171717,
    #0000 2px,
    hsl(0 0 4%) 2px
  );
  background-size: 8px 8px;
  width: 100%;
  height: 100%;
}

@keyframes thingy {
  0% {
    filter: var(--f) hue-rotate(0deg);
  }
  to {
    filter: var(--f) hue-rotate(1turn);
  }
}

body::before {
  content: "";
  position: absolute;
  inset: -8em;
  z-index: -1;
  --f: blur(7em) brightness(5);
  --c: #09f;
  animation:
    blobs-1e28bd3d 150s linear infinite,
    thingy 5s linear infinite;
  background-color: #000;
  background-image: radial-gradient(
      ellipse 66px 50px at 50% 50%,
      #0f0 0%,
      transparent 100%
    ),
    radial-gradient(ellipse 77px 60px at 50% 50%, #0f0 0%, transparent 100%),
    radial-gradient(ellipse 78px 100px at 50% 50%, #0f0 0%, transparent 100%),
    radial-gradient(ellipse 73px 96px at 50% 50%, #0f0 0%, transparent 100%),
    radial-gradient(ellipse 76px 77px at 50% 50%, #0f0 0%, transparent 100%),
    radial-gradient(ellipse 66px 51px at 50% 50%, #0f0 0%, transparent 100%),
    radial-gradient(ellipse 90px 57px at 50% 50%, #0f0 0%, transparent 100%),
    radial-gradient(ellipse 89px 93px at 50% 50%, #0f0 0%, transparent 100%);
  background-size:
    726px 576px,
    1242px 454px,
    876px 1160px,
    691px 873px,
    914px 550px,
    1159px 340px,
    1017px 831px,
    313px 977px;
}

@keyframes blobs-1e28bd3d {
  0% {
    background-position:
      271px 478px,
      62px 291px,
      67px 861px,
      553px 413px,
      36px 392px,
      1077px 226px,
      400px 799px,
      7px 264px;
  }

  to {
    background-position:
      -14975px -2978px,
      31112px 11187px,
      -20081px 8981px,
      11609px -3952px,
      -12760px 12492px,
      -9354px 2946px,
      9553px 21574px,
      946px 9057px;
  }
}

</style>