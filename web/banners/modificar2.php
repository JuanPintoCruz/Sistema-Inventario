<?php 
include("../../BD/bd.php");
include("../../sesion.php");

// Manejar la solicitud GET para obtener los datos del colaborador
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Consulta para obtener los datos del registro
    $sentencia = $conexion->prepare("SELECT * FROM tbl_bannerdos WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el registro
    if ($registro) {
        $titulo = $registro["titulo"];
        $descripcion = $registro["descripcion"];
        $foto_portada = $registro["foto_portada"];
    }
}

// Consulta para obtener la lista de perfiles
$sentencia_tbl_bannerdos = $conexion->prepare("SELECT * FROM tbl_bannerdos");
$sentencia_tbl_bannerdos->execute();
$lista_tbl_bannerdos = $sentencia_tbl_bannerdos->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario por POST
if ($_POST) {
    // Recolecta los datos del formulario
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";

    // Prepara y ejecuta la consulta SQL para actualizar los datos del perfil
    $sentencia = $conexion->prepare("UPDATE tbl_bannerdos SET titulo=:titulo, descripcion=:descripcion
     WHERE id=:id");

    // Asigna los valores a los parámetros de la consulta
    // Datos de la empresa
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":id", $txtID);

    // Ejecutar la consulta de actualización
    $sentencia->execute();

    // Actualiza la foto de perfil si se proporciona una nueva
    if (isset($_FILES["foto_portada"]["name"]) && $_FILES["foto_portada"]["name"] != "") {
        $foto_portada = $_FILES["foto_portada"]["name"];
        $fecha_actual = new DateTime();
        $nombreArchivo_foto_portada = $fecha_actual->getTimestamp() . "_" . $foto_portada;
        $tmp_foto = $_FILES["foto_portada"]["tmp_name"];
        move_uploaded_file($tmp_foto, "./img2/" . $nombreArchivo_foto_portada);

        // Borrar el archivo anterior si existe
        $sentencia = $conexion->prepare("SELECT foto_portada FROM tbl_bannerdos WHERE id = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registro_recuperado["foto_portada"]) && $registro_recuperado["foto_portada"] != "") {
            if (file_exists("./img2/" . $registro_recuperado["foto_portada"])) {
                unlink("./img2/" . $registro_recuperado["foto_portada"]);
            }
        }

        // Actualizar el registro con la nueva foto
        $sentencia = $conexion->prepare("UPDATE tbl_bannerdos SET foto_portada=:foto_portada WHERE id=:id");
        $sentencia->bindParam(":foto_portada", $nombreArchivo_foto_portada);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    // Redirección con mensaje
    $mensaje = "Registro Editado";
    header("Location: banner2.php?mensaje=" . urlencode($mensaje));
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
                    <br> <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title d-flex justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
                                <h1> Modificar Banner2</h1>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container -->
            </div>
            <!-- /.content-header -->
            <!-- Content Body --> <br>
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
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="titulo">Titulo:</label>
                                    <input type="text" class="form-control" id="titulo" 
                                    value="<?php echo $titulo ?>"
                                    name="titulo" placeholder="Ingrese el primer titulo">
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripcion:</label>
                                    <input type="text" class="form-control" id="descripcion"
                                    value="<?php echo $descripcion ?>"
                                    name="descripcion" placeholder="Ingrese la primera descripcion">
                                </div>

                               <div class="form-group">
                                    <img2 id="previewImage" width="100" src="<?php echo $foto_portada; ?>" class="img2-fluid rounded" alt="Vista previa de la imagen">
                                    <input type="file" class="form-control" name="foto_portada" id="foto_portada" aria-describedby="helpId" placeholder="Foto" />
                                </div>
                        </div>
                        <div class="col-md-4"></div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                <button type="submit" value="enviar" name="" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                    <img src="<?php echo $url_base;?>assets/img/guardarycerrar/guardar2.png" alt=""> Guardar
                                </button>
                                <a href="banner2.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
                                    <img src="<?php echo $url_base;?>assets/img/guardarycerrar/cerrar2.png" alt=""> Cancelar
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
