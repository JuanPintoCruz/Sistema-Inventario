<?php
// CONEXION
include("BD/bd.php");

// Banners
$sentencia = $conexion->prepare("SELECT * FROM tbl_banners LIMIT 1");
$sentencia->execute();
$lista_tbl_banners = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Banners2
$sentencia = $conexion->prepare("SELECT * FROM tbl_bannerdos LIMIT 1");
$sentencia->execute();
$lista_tbl_bannerdos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Banners3
$sentencia = $conexion->prepare("SELECT * FROM tbl_bannertres LIMIT 1");
$sentencia->execute();
$lista_tbl_bannertres = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
  <title>Las Computers</title>
  <!--icons-->
  <link rel="icon" type="image/x-icon" href="img/logo.png">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- versión de bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" 
  integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <!-- iconos  -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" 
  integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="index.css"> -->
</head>
<body>
  <!--Seccion de navegacion-->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:rgb(0,131,252)" >
    <div class="container">
      <a class="navbar-brand" href="#"><img src="img/logo.png" width="40" height="40" style="margin:8px;" alt="logo">Las Computers</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="nav navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#inicio" style="font-size:1.4rem;font-weight: bold; color:white">INICIO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#menu" style="font-size:1.4rem;font-weight: bold; color:white">Menu del dia</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#chefs" style="font-size:1.4rem;font-weight: bold; color:white">Chefs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#testimonios" style="font-size:1.4rem;font-weight: bold; color:white">Testimonio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contacto" style="font-size:1.4rem;font-weight: bold; color:white">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#horarios" style="font-size:1.4rem;font-weight: bold; color:white">Horarios</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<section class="cabeza" style="overflow: hidden;">
    <div>
        <div id="carouselExampleIndicators" class="carousel slide mb-5" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <?php if (!empty($lista_tbl_banners)) { ?>
                    <div class="carousel-item active">
                        <?php foreach($lista_tbl_banners as $banner) {  ?>
                          
                            <img class="d-block img-fluid" src="web/banners/img/<?php echo htmlspecialchars($banner['foto_portada1']); ?>"alt="primero" style="height: 80vh; width: 100%; object-fit: cover;">
                            <div class="banner-text" style="position:absolute; top:50%; left:50%; transform: translate(-50%, -50%); text-align:center; color:#fff;">
                                <h1 style="color:white;font-weight:bold;font-size:4rem;text-shadow: -1px -1px 0 black,  1px -1px 0 black,-1px 1px 0 black,1px 1px 0 black;">
                                    <?php echo htmlspecialchars($banner['titulo1']); ?>
                                </h1>
                                <p style="color:white;font-weight:bold;font-size:2.5rem;text-shadow: -1px -1px 0 black,  1px -1px 0 black,-1px 1px 0 black,1px 1px 0 black;">
                                    <?php echo htmlspecialchars($banner['descripcion1']); ?>
                                </p>
                                <a href="#" class="btn btn-primary">Ver Menu</a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                <?php if (!empty($lista_tbl_bannerdos)) { ?>
                    <div class="carousel-item">
                        <?php foreach($lista_tbl_bannerdos as $banner) {  ?>
                            <img class="d-block img-fluid" src="web/banners/img2/<?php echo htmlspecialchars($banner['foto_portada']); ?>" alt="segundo" style="height: 80vh; width: 100%; object-fit: cover;">
                            <div class="banner-text" style="position:absolute; top:50%; left:50%; transform: translate(-50%, -50%); text-align:center; color:#fff;">
                                <h1 style="color:white;font-weight:bold;font-size:4rem;text-shadow: -1px -1px 0 black,  1px -1px 0 black,-1px 1px 0 black,1px 1px 0 black;">
                                    <?php echo htmlspecialchars($banner['titulo']); ?>
                                </h1>
                                <p style="color:white;font-weight:bold;font-size:2.5rem;text-shadow: -1px -1px 0 black,  1px -1px 0 black,-1px 1px 0 black,1px 1px 0 black;">
                                    <?php echo htmlspecialchars($banner['descripcion']); ?>
                                </p>
                                <a href="#" class="btn btn-primary">Ver Menu</a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                <?php if (!empty($lista_tbl_bannertres)) { ?>
                    <div class="carousel-item">
                        <?php foreach($lista_tbl_bannertres as $banner) {  ?>
                          <img class="d-block img-fluid" src="web/banners/img3/<?php echo htmlspecialchars($banner['foto_portada']); ?>" alt="segundo" style="height: 80vh; width: 100%; object-fit: cover;">
                            <div class="banner-text" style="position:absolute; top:50%; left:50%; transform: translate(-50%, -50%); text-align:center; color:#fff;">
                                <h1 style="color:white;font-weight:bold;font-size:4rem;text-shadow: -1px -1px 0 black,  1px -1px 0 black,-1px 1px 0 black,1px 1px 0 black;">
                                    <?php echo htmlspecialchars($banner['titulo']); ?>
                                </h1>
                                <p style="color:white;font-weight:bold;font-size:2.5rem;text-shadow: -1px -1px 0 black,  1px -1px 0 black,-1px 1px 0 black,1px 1px 0 black;">
                                    <?php echo htmlspecialchars($banner['descripcion']); ?>
                                </p>
                                <a href="#" class="btn btn-primary">Ver Menu</a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>
</html>