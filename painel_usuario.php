<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/dist/css/bootstrap-grid.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Painel de Usuario</title>
</head>
<body>
    <?php include_once './header.php'?>
    <div class="container-fluid d-flex align-items-center" style="min-height: 100vh;">
        <div class="d-flex flex-column align-items-center" style="min-width: 220px;">
            <img src="img/usuarioTeste.png" alt="" style="border-radius: 50%; height: 200px; width: 190px;">
        </div>
        <section class="container my-5 ms-5">
            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <div class="card">
                        <h1>Teste</h1>
                        <h1>Testando</h1>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include_once './footer.php'?>
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
    .card{
        box-shadow: #FF084B;
        border-color: #FF084B;
        padding: 200px;
        width: 1000px;
        background-color: transparent;
    }
    .card h1{
        font-size: 30px;
        display: flex;
        flex-direction: row;
        color: #FF084B;
        justify-content: center;
    }
    </style>
</style>