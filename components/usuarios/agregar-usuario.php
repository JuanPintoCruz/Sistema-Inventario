<?php 
include("../../BD/bd.php");
include("../../sesion.php");

// Verifica si se ha enviado el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta los datos del formulario
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    $foto_perfil_usuario = isset($_FILES["foto_perfil_usuario"]["name"]) ? $_FILES["foto_perfil_usuario"]["name"] : "";

    // Prepara la consulta SQL para insertar los datos del usuario
    $sentencia = $conexion->prepare("INSERT INTO `tbl_usuarios` 
    (`usuario`, `password`, `correo`, `foto_perfil_usuario`) 
    VALUES (:usuario, :password, :correo, :foto_perfil_usuario)");

    // Asigna los valores a los parámetros de la consulta
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);

    // Obtener la fecha actual para el nombre de archivo único
    $fecha_actual = new DateTime();
    $nombreArchivo_foto = ($foto_perfil_usuario != '') ? $fecha_actual->getTimestamp() . "_" . $foto_perfil_usuario : "";
    $tmp_foto = isset($_FILES["foto_perfil_usuario"]["tmp_name"]) ? $_FILES["foto_perfil_usuario"]["tmp_name"] : "";
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto);
    }
    $sentencia->bindParam(":foto_perfil_usuario", $nombreArchivo_foto);

    // Ejecutar la sentencia
    if ($sentencia->execute()) {
        header("Location: ../../views/usuario.php?mensaje=Registro Agregado");
        exit;
    }
}

// Selecciona la información de los usuarios
$sentencia_usuarios = $conexion->prepare("SELECT * FROM `tbl_usuarios`");
$sentencia_usuarios->execute();
$lista_tbl_usuarios = $sentencia_usuarios->fetchAll(PDO::FETCH_ASSOC);
?>

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
        .form-group input, .form-group select {
            height: auto;
            font-size: 14px;
            border: 1.5px solid #48e;
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
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title d-flex justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
                                <h1> Agregar Usuario</h1>
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
                            <div class="col-md-4"></div>
                            <!-- Second Column -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="usuario">Usuario:</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese usuario">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña">
                                </div>
                                <div class="form-group">
                                    <label for="correo">Correo:</label>
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo">
                                </div>
                            </div>
                            <!-- Third Column -->
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <!-- Fourth Column -->
                            <div class="col-md-4"></div>
                            <!-- Fifth Column -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="foto_perfil_usuario">Foto (Opcional)</label>
                                    <input type="file" id="foto_perfil_usuario" name="foto_perfil_usuario" class="form-control-file">
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <!-- Eighth Column -->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" value="enviar" name="" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                    <img src="<?php echo $url_base;?>assets/img/guardarycerrar/guardar2.png" alt=""> Guardar</button>
                                    <a href="../../views/usuario.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
                                    <img src="<?php echo $url_base;?>assets/img/guardarycerrar/cerrar2.png" alt=""> Cancelar</a>
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