<?php 
include("../../BD/bd.php");
include("../../sesion.php");

// Manejar la solicitud GET para obtener los datos del colaborador
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Consulta para obtener los datos del registro
    $sentencia = $conexion->prepare("SELECT * FROM tbl_categorias WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el registro
    if ($registro) {
        // Datos de la empresa
        $nombre_categoria = $registro["nombre_categoria"];
        $descripcion = $registro["descripcion"];
        $tipo_estado = $registro["tipo_estado"];
    }
}

// Consulta para obtener la lista de perfiles
$sentencia_tbl_categorias = $conexion->prepare("SELECT * FROM tbl_categorias");
$sentencia_tbl_categorias->execute();
$lista_tbl_categorias = $sentencia_tbl_categorias->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario por POST
if ($_POST) {
    // Recolecta los datos del formulario
    // Datos de la empresa 
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";
    $nombre_categoria = isset($_POST["nombre_categoria"]) ? $_POST["nombre_categoria"] : "";
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
    $tipo_estado = isset($_POST["tipo_estado"]) ? $_POST["tipo_estado"] : "";

    // Prepara y ejecuta la consulta SQL para actualizar los datos del perfil
    $sentencia = $conexion->prepare("UPDATE tbl_categorias 
    SET nombre_categoria=:nombre_categoria, descripcion=:descripcion, 
    tipo_estado=:tipo_estado WHERE id=:id");

    // Asigna los valores a los parámetros de la consulta
    // Datos de la empresa
    $sentencia->bindParam(":nombre_categoria", $nombre_categoria);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":tipo_estado", $tipo_estado);
    $sentencia->bindParam(":id", $txtID);

    // Ejecutar la consulta de actualización
    $sentencia->execute();

    // Redirección con mensaje
    $mensaje = "Registro Editado";
    header("Location: ../../views/categorias.php?mensaje=" . urlencode($mensaje));
    exit;
}
?>

<?php 
if (isset($_GET['mensaje'])) { ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "success",
            title: "<?php echo $_GET['mensaje']; ?>"
        });
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
        .form-group input,
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
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title d-flex justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
                                <h1> Modificar Categorias</h1>
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
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txtID">ID</label>
                                    <input type="text" class="form-control" id="txtID" name="txtID" value="<?php echo $txtID; ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-4">
                                
                            </div>
                            <!-- Second Column -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_categoria">Nombre</label>
                                    <input type="text" class="form-control" value="<?php echo $nombre_categoria; ?>"
                                     id="nombre_categoria" name="nombre_categoria" placeholder="Ingrese el nombre_categoria">
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripcion</label>
                                    <input type="text" class="form-control" value="<?php echo $descripcion; ?>"
                                     id="descripcion" name="descripcion" 
                                     placeholder="Ingrese la descripcion">
                                </div>
                                <div class="form-group">
                                <label for="tipo_estado">Estado </label>
                                    <select name="tipo_estado" class="form-control custom-select">
                                        <option value="">Seleccionar Tipo </option>
                                        <option value="activo" <?php echo ($tipo_estado=="activo")?"selected":"";?> >Activo</option>
                                        <option value="inactivo" <?php echo ($tipo_estado=="inactivo")?"selected":"";?> >Inactivo</option>
                                    </select>
                                    <!-- <label for="tipo_estado">Estado</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="tipo_estado" name="tipo_estado" placeholder="Ingrese el nombre_categoria"> -->
                                </div>
                            </div>
                            <div class="col-md-4">    

                            </div>


                         </div>
                            <!-- Third Column -->
                            
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                        <img src="<?php echo $url_base; ?>assets/img/guardarycerrar/guardar2.png" alt="">Modificar
                                    </button>
                                    <a href="../../views/categorias.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
                                        <img src="<?php echo $url_base; ?>assets/img/guardarycerrar/cerrar2.png" alt="">Cancelar
                                    </a>
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