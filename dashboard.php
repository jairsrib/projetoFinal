<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/dist/css/bootstrap-grid.css">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <?php
        require_once './header.php';
        ?>
    </header>
    <div class="container-fluid">
        <div class="row">
            <img class="banner" src="./img/banner.png" alt="" width="100%" height="400px">
        </div>
        </div>
    <div class="container-fluid">
        <div class="titulo-home">
        <h1>Ultimas Noticias</h1>
        </div>
        <div class="row-3">
        <div class="col-12">
            <img src="./img/SobreE-Sports.png" alt="" width="450px" height="450px">
        </div>
        <div class="col-12">
            <img src="./img/profissionalismo.png" alt="" width="450px" height="450px">
        </div>
        </div>
    </div>
<footer>
    <?php 
    require_once './footer.php';
    ?>
</footer>
</body>
</html>

<style>
body {
  width: 100%;
  height: 100%;

  background: #171717;
  --gap: 5em;
  --line: 1px;
  --color: rgba(255, 255, 255, 0.2);

  background-image: linear-gradient(
      -90deg,
      transparent calc(var(--gap) - var(--line)),
      var(--color) calc(var(--gap) - var(--line) + 1px),
      var(--color) var(--gap)
    ),
    linear-gradient(
      0deg,
      transparent calc(var(--gap) - var(--line)),
      var(--color) calc(var(--gap) - var(--line) + 1px),
      var(--color) var(--gap)
    );
  background-size: var(--gap) var(--gap);
}
.banner:hover{
    transform: scale(1.00);
    border: 1px solid black;
    border-radius: 20px;
}
.titulo-home{
    color: #FF084B;
    font-family: DM Sans, sans-serif;
    font-size: 2em;
    display: flex;
    justify-content: center;
}
</style>