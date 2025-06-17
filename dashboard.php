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
            <section>
    <div class="container">
        <div class="carousel">
            <input type="radio" name="slides" checked="checked" id="slide-1">
            <input type="radio" name="slides" id="slide-2">
            <input type="radio" name="slides" id="slide-3">
            <input type="radio" name="slides" id="slide-4">
            <input type="radio" name="slides" id="slide-5">
            <input type="radio" name="slides" id="slide-6">
            <ul class="carousel__slides">
                <li class="carousel__slide">
                    <figure>
                        <div>
                            <img src="img/SobreE-Sports.png" alt="">
                        </div>
                        <figcaption>
                            <span class="credit">Sobre E-Sports</span>
                        </figcaption>
                    </figure>
                </li>
                <li class="carousel__slide">
                    <figure>
                        <div>
                            <img src="img/profissionalismo.png" alt="">
                        </div>
                        <figcaption>
                            <span class="credit">Profissionalismo</span>                            
                        </figcaption>
                    </figure>
                </li>
                <li class="carousel__slide">
                    <figure>
                        <div>
                            <img src="img/olimpiadas.png" alt="">
                        </div>
                        <figcaption>
                            
                            <span class="credit">Olimpiadas</span>                            
                        </figcaption>
                    </figure>
                </li>
                <li class="carousel__slide">
                    <figure>
                        <div>
                            <img src="img/lucrativo.png" alt="">
                        </div>
                        <figcaption>
                            
                            <span class="credit">Lucrativo</span>                            
                        </figcaption>
                    </figure>
                </li>
                <li class="carousel__slide">
                    <figure>
                        <div>
                            <img src="img/competitivo.png" alt="">
                        </div>
                        <figcaption>
                            
                            <span class="credit">Competitivo</span>                            
                        </figcaption>
                    </figure>
                </li>
            </ul>    
            <ul class="carousel__thumbnails">
                <li>
                    <label for="slide-1"><img src="img/SobreE-Sports.png" alt=""></label>
                </li>
                <li>
                    <label for="slide-2"><img src="img/profissionalismo.png" alt=""></label>
                </li>
                <li>
                    <label for="slide-3"><img src="img/olimpiadas.png" alt=""></label>
                </li>
                <li>
                    <label for="slide-4"><img src="img/lucrativo.png" alt=""></label>
                </li>
                <li>
                    <label for="slide-5"><img src="img/competitivo.png" alt=""></label>
                </li>
            </ul>
        </div>
    </div>
</section>
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




section {
    padding: 50px 0;
}

.container {
    max-width: 1044px;
    margin: 0 auto;
    padding: 0 20px;
}

.carousel {
    position: relative;
    width: 100%;
    max-width: 600px;
    margin: 0 auto 22px auto;
}

.carousel input[type="radio"] {
    display: none;
}

.carousel__slides {
    display: flex;
    width: 500%;
    transition: margin-left 0.5s ease;
    margin-left: 0;
    padding: 0;
    list-style: none;
    overflow: hidden;
    border-radius: 10px;
    background: #171717;
}

.carousel__slide {
    width: 100%;
    flex: 0 0 100%;
    box-sizing: border-box;
    color: #fff;
    text-align: center;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.carousel__slide figure {
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.carousel__slide img {
    width: 100%;
    max-width: 450px;
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
    margin: 0 auto;
}

.carousel__slide figcaption {
    margin-top: 15px;
    font-size: 1em;
    color: #fff;
}

.carousel__slide .credit {
    color: #aaa;
    font-size: 0.9em;
}

.carousel__thumbnails {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
    list-style: none;
    padding: 0;
}

.carousel__thumbnails li {
    border-radius: 5px;
    overflow: hidden;
    border: 2px solid transparent;
    transition: border 0.3s;
}

.carousel__thumbnails img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 5px;
    transition: box-shadow 0.3s;
}

.carousel input#slide-1:checked ~ .carousel__slides {
    margin-left: 0%;
}
.carousel input#slide-2:checked ~ .carousel__slides {
    margin-left: -100%;
}
.carousel input#slide-3:checked ~ .carousel__slides {
    margin-left: -200%;
}
.carousel input#slide-4:checked ~ .carousel__slides {
    margin-left: -300%;
}
.carousel input#slide-5:checked ~ .carousel__slides {
    margin-left: -400%;
}

.carousel input#slide-1:checked ~ .carousel__thumbnails li:nth-child(1),
.carousel input#slide-2:checked ~ .carousel__thumbnails li:nth-child(2),
.carousel input#slide-3:checked ~ .carousel__thumbnails li:nth-child(3),
.carousel input#slide-4:checked ~ .carousel__thumbnails li:nth-child(4),
.carousel input#slide-5:checked ~ .carousel__thumbnails li:nth-child(5) {
    border: 2px solid #FF084B;
}

@media (max-width: 700px) {
    .carousel {
        max-width: 100%;
    }
    .carousel__slide img {
        max-width: 100%;
        height: 180px;
    }
    .carousel__thumbnails img {
        width: 50px;
        height: 35px;
    }
}

</style>