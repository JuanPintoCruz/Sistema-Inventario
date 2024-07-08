<?php 
 include("../../BD/bd.php");
include("../../sesion.php");
?>
<?php 

$tipo_estado = "";

if($_POST){

    $nombre_categoria = isset($_POST["nombre_categoria"]) ? $_POST["nombre_categoria"] : "";
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
    $tipo_estado = isset($_POST["tipo_estado"]) ? $_POST["tipo_estado"] : "";

    // Prepara la consulta SQL para insertar los datos del empleado
    $sentencia = $conexion->prepare("INSERT INTO `tbl_categorias` 
    (`nombre_categoria`, `descripcion`, `tipo_estado`) 
    VALUES (:nombre_categoria, :descripcion, :tipo_estado)");

    // Asigna los valores a los parámetros de la consulta

    // Consulta de empresas
    $sentencia->bindParam(":nombre_categoria", $nombre_categoria);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":tipo_estado", $tipo_estado);



    $sentencia->execute();
    $mensaje="Registro Agregado";
    header("Location: ../../views/categorias.php?mensaje=".$mensaje);
    exit; 
}
// Selecciona la información de los puestos
$sentencia_categorias = $conexion->prepare("SELECT * FROM `tbl_categorias`");
$sentencia_categorias->execute();
$lista_tbl_categorias = $sentencia_categorias->fetchAll(PDO::FETCH_ASSOC);
?>

<?php 
if(isset($_GET['mensaje'])){?>
<script>
  Swal.fire({icon:"success",title:"<?php echo $_GET['mensaje']; ?>"});
</script>

<?php } ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .form-group input  style="border:1.5px solid #48e",
        .form-group select {
            height: auto;
            font-size: 14px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php require("../../modulos/navbar.php") ?>
        <?php require("../../modulos/aside.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <br><br><br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title d-flex justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
                                <h1> Agregar Categorias</h1>
                            </div>
                        </div>
                    </div>
                    <br> 
                </div><!-- /.container -->
            </div>
            <!-- /.content-header -->

            <!-- Content Body -->
            <div class="content">
                <div class="container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-4">
                            </div>
                            <!-- Second Column -->
                            <div class="col-md-4">
                            <div class="form-group">
                                    <label for="nombre_categoria">Nombre </label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" id="nombre_categoria" name="nombre_categoria" 
                                    placeholder="Ingrese el nombre del producto">
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripcion</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" id="descripcion" name="descripcion" 
                                    placeholder="Ingrese la descripcion o ubicacion">
                                </div>

                                <div class="form-group">
                                <label for="tipo_estado">Estado </label>
                                    <select name="tipo_estado" class="form-control custom-select">
                                        <option value="">Seleccionar Tipo </option>
                                        <option value="activo" <?php echo ($tipo_estado=="activo")?"selected":"";?> >Activo</option>
                                        <option value="inactivo" <?php echo ($tipo_estado=="inactivo")?"selected":"";?> >Inactivo</option>

                                    </select>
                                </div>

                            </div>
                            <!-- Third Column -->
                            <div class="col-md-4">
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <!-- Eighth Column -->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;"><img src="<?php echo $url_base;?>assets/img/guardarycerrar/guardar2.png" alt=""> Guardar</button>
                                    <a href="../../views/categorias.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;"><img src="<?php echo $url_base;?>assets/img/guardarycerrar/cerrar2.png" alt=""> Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include("../../modulos/footer.php") ?>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>