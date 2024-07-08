<?php 
require("BD/bd.php");
// include("sesion.php");
session_start(); // Inicia la sesión antes de verificar si el usuario está autenticado

$url_base = "http://localhost/admin3/";

// Preguntar si el usuario no está autenticado
if(!isset($_SESSION["usuario"])){
    // Redirigir al usuario a la página de inicio de sesión
    header("Location:".$url_base."login.php");
    exit; // Asegúrate de salir del script después de redirigir al usuario
}

// Obtener el total usuarios
$total_usuarios_sentencia = $conexion->prepare("SELECT COUNT(*) as total FROM `tbl_usuarios`");
$total_usuarios_sentencia->execute();
$total_usuarios_result = $total_usuarios_sentencia->fetch(PDO::FETCH_ASSOC);
$total_usuarios = $total_usuarios_result['total'];

// Obtener el total de productos
$total_productos_sentencia = $conexion->prepare("SELECT COUNT(*) as total FROM `tbl_productos`");
$total_productos_sentencia->execute();
$total_productos_result = $total_productos_sentencia->fetch(PDO::FETCH_ASSOC);
$total_productos = $total_productos_result['total'];

// Obtener el total de clientes
$total_clientes_sentencia = $conexion->prepare("SELECT COUNT(*) as total FROM `tbl_clientes`");
$total_clientes_sentencia->execute();
$total_clientes_result = $total_clientes_sentencia->fetch(PDO::FETCH_ASSOC);
$total_clientes = $total_clientes_result['total'];

// Obtener el total de proveedores
$total_proveedores_sentencia = $conexion->prepare("SELECT COUNT(*) as total FROM `tbl_proveedores`");
$total_proveedores_sentencia->execute();
$total_proveedores_result = $total_proveedores_sentencia->fetch(PDO::FETCH_ASSOC);
$total_proveedores = $total_proveedores_result['total'];

// Obtener el total de proveedores
$total_categorias_sentencia = $conexion->prepare("SELECT COUNT(*) as total FROM `tbl_categorias`");
$total_categorias_sentencia->execute();
$total_categorias_result = $total_categorias_sentencia->fetch(PDO::FETCH_ASSOC);
$total_categorias = $total_categorias_result['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<?php 
  include("modulos/navbar.php")
 ?>
 <?php 
  include("modulos/aside.php")
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid"> 
          <br>
        <div class="bienvenido" style="border:1px solid #000;background-color:#0083FC;">
            <div class="row">
                <div class="col-9">
                    <div class="cuadro" > 
                        <h1 class="text-center" style="color:white;">System Administrador</h1>
                    </div>
                </div>
                <div class="col-3">
                    <div class="cuadro" style="color:white;"> <h2 class="text-center"> <?php echo $_SESSION["usuario"];?>
                    <img style="margin-left:30px;" src="<?php echo $url_base;?>assets/img/indexprincipal/principal.png" alt=""></h2> </div>
                </div>
            </div>
        </div>
        <br>
<!-- 1row -->
        <div class="row">
            <div class="col-12 text-center">
              <h1 style="font-weight:bold; color: purple; text-shadow: 0 0 5px white, 0 0 5px white, 0 0 5px white;">
                Bienvenidos al sistema  <?php echo $_SESSION["usuario"];?>
              </h1>
            </div>
        </div><!-- 1row -->
<!-- 2row -->
        <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="cuadro" style="border:1px solid #000;background-color:#0083FC;color:white;border-radius:10px; box-sizing: border-box;margin:10px;">
                        <br>
                        <h4 class="text-center">Usuarios</h4>
                        <h6 class="text-center"><span style="font-size:38px;"><?php echo $total_usuarios; ?></span> Usuarios <img style="margin-left:30px;" 
                        src="<?php echo $url_base;?>assets/img/indexprincipal/usuarios.png" alt=""></h6>
                    <div>
                    <div class="d-flex justify-content-center" style="background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 5px;">
                        <a href="<?php echo $url_base;?>views/usuario.php" style="color:black; display: inline-flex; align-items: center; text-decoration: none;">
                            <h6 style="margin: 0;">
                                Más Información<img style="margin-left:5px;" src="<?php echo $url_base;?>assets/img/indexprincipal/info.png" alt="">
                            </h6>
                        </a>
                    </div>
                    </div>
                </div>
                </div> 
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="cuadro" style="border:1px solid #000;background-color:#10D63C;color:white;border-radius:10px; box-sizing: border-box;margin:10px;">
                    <br>
                        <h4 class="text-center">Productos</h4>
                        <h6 class="text-center"><span style="font-size:38px;"><?php echo $total_productos; ?></span> Productos <img style="margin-left:30px;"
                        src="<?php echo $url_base;?>assets/img/indexprincipal/productos.png" alt=""></h6>
                        <div class="d-flex justify-content-center" style="background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 5px;">
                            <a href="<?php echo $url_base;?>views/productos.php" style="color:black; display: inline-flex; align-items: center; text-decoration: none;">
                                <h6 style="margin: 0;">
                                    Más Información<img style="margin-left:5px;" src="<?php echo $url_base;?>assets/img/indexprincipal/info.png" alt="">
                                </h6>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="cuadro" style="border:1px solid #000;background-color:#FB6613;color:white;border-radius:10px; box-sizing: border-box;margin:10px;">
                        <br>
                        <h4 class="text-center">Clientes</h4>
                        <h6 class="text-center"><span style="font-size:38px;"><?php echo $total_clientes; ?></span> Clientes <img style="margin-left:30px;" 
                        src="<?php echo $url_base;?>assets/img/indexprincipal/cliente.png" alt=""></h6>
                        <div class="d-flex justify-content-center" style="background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 5px;">
                            <a href="<?php echo $url_base;?>views/clientes.php" style="color:black; display: inline-flex; align-items: center; text-decoration: none;">
                                <h6 style="margin: 0;">
                                    Más Información<img style="margin-left:5px;" src="<?php echo $url_base;?>assets/img/indexprincipal/info.png" alt="">
                                </h6>
                            </a>
                        </div>
                    </div>
                </div>
            
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="cuadro" style="border:1px solid #000;background-color:#FF4949;color:white;border-radius:10px; box-sizing: border-box;margin:10px;">
                        <br>
                        <h4 class="text-center">Proveedores</h4>
                        <h6 class="text-center"><span style="font-size:38px;"><?php echo $total_proveedores; ?></span> Proveedores <img style="margin-left:30px;"
                        src="<?php echo $url_base;?>assets/img/indexprincipal/proveedores.png" alt=""></h6>
                        <div class="d-flex justify-content-center" style="background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 5px;">
                            <a href="<?php echo $url_base;?>views/proveedor.php" style="color:black; display: inline-flex; align-items: center; text-decoration: none;">
                                <h6 style="margin: 0;">
                                    Más Información<img style="margin-left:5px;" src="<?php echo $url_base;?>assets/img/indexprincipal/info.png" alt="">
                                </h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div> <!-- 2row -->


      <!-- 2row -->
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="cuadro" style="border:1px solid #000;background-color:#45F2FD;color:white;border-radius:10px; box-sizing: border-box;margin:10px;">
                        <br>
                        <h4 class="text-center">Categorias</h4>
                        <h6 class="text-center"><span style="font-size:38px;"><?php echo $total_categorias; ?></span> Categorias <img style="margin-left:30px;" 
                        src="<?php echo $url_base;?>assets/img/indexprincipal/usuarios.png" alt=""></h6>
                        <div class="d-flex justify-content-center" style="background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 5px;">
                            <a href="<?php echo $url_base;?>views/categorias.php" style="color:black; display: inline-flex; align-items: center; text-decoration: none;">
                            <h6 style="margin: 0;">
                                Más Información<img style="margin-left:5px;" src="<?php echo $url_base;?>assets/img/indexprincipal/info.png" alt="">
                            </h6>
                            </a>
                        </div>
                    </div>
                 </div>
                <div class="col-12 col-md-6 col-lg-3">
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                </div>
            </div> 

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
   <?php 
  include("modulos/footer.php")
  ?> 
  
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>