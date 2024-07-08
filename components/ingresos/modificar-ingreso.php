<?php 
include("../../BD/bd.php");
include("../../sesion.php");

// Manejar la solicitud GET para obtener los datos del colaborador
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Consulta para obtener los datos del registro
    $sentencia = $conexion->prepare("SELECT * FROM tbl_clientes WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el registro
    if ($registro) {
        // Datos de la empresa
        $nombre_empresa = $registro["nombre_empresa"];
        $ruc_empresa = $registro["ruc_empresa"];
        $direccion_empresa = $registro["direccion_empresa"];
        $pais_empresa = $registro["pais_empresa"];
        $departamento_empresa = $registro["departamento_empresa"];
        $provincia_empresa = $registro["provincia_empresa"];
        $distrito_empresa = $registro["distrito_empresa"];

        // Datos del cliente
        $nombres_contacto = $registro["nombres_contacto"];
        $apellidos_contacto = $registro["apellidos_contacto"];
        $dni_contacto = $registro["dni_contacto"];
        $correo_contacto = $registro["correo_contacto"];
        $foto_perfil = $registro["foto_perfil"];
        $telefono_contacto = $registro["telefono_contacto"];
    }
}

// Consulta para obtener la lista de perfiles
$sentencia_tbl_clientes = $conexion->prepare("SELECT * FROM tbl_clientes");
$sentencia_tbl_clientes->execute();
$lista_tbl_clientes = $sentencia_tbl_clientes->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario por POST
if ($_POST) {
    // Recolecta los datos del formulario
    // Datos de la empresa 
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";
    $nombre_empresa = isset($_POST["nombre_empresa"]) ? $_POST["nombre_empresa"] : "";
    $ruc_empresa = isset($_POST["ruc_empresa"]) ? $_POST["ruc_empresa"] : "";
    $direccion_empresa = isset($_POST["direccion_empresa"]) ? $_POST["direccion_empresa"] : "";
    $pais_empresa = isset($_POST["pais_empresa"]) ? $_POST["pais_empresa"] : "";
    $departamento_empresa = isset($_POST["departamento_empresa"]) ? $_POST["departamento_empresa"] : "";
    $provincia_empresa = isset($_POST["provincia_empresa"]) ? $_POST["provincia_empresa"] : "";
    $distrito_empresa = isset($_POST["distrito_empresa"]) ? $_POST["distrito_empresa"] : "";

    // Datos del cliente
    $nombres_contacto = isset($_POST["nombres_contacto"]) ? $_POST["nombres_contacto"] : "";
    $apellidos_contacto = isset($_POST["apellidos_contacto"]) ? $_POST["apellidos_contacto"] : "";
    $dni_contacto = isset($_POST["dni_contacto"]) ? $_POST["dni_contacto"] : "";
    $correo_contacto = isset($_POST["correo_contacto"]) ? $_POST["correo_contacto"] : "";
    $telefono_contacto = isset($_POST["telefono_contacto"]) ? $_POST["telefono_contacto"] : "";

    // Prepara y ejecuta la consulta SQL para actualizar los datos del perfil
    $sentencia = $conexion->prepare("UPDATE tbl_clientes SET nombre_empresa=:nombre_empresa, ruc_empresa=:ruc_empresa,
     direccion_empresa=:direccion_empresa, pais_empresa=:pais_empresa, departamento_empresa=:departamento_empresa,
      provincia_empresa=:provincia_empresa, distrito_empresa=:distrito_empresa, nombres_contacto=:nombres_contacto,
       apellidos_contacto=:apellidos_contacto, dni_contacto=:dni_contacto, correo_contacto=:correo_contacto,
        telefono_contacto=:telefono_contacto WHERE id=:id");

    // Asigna los valores a los parámetros de la consulta
    // Datos de la empresa
    $sentencia->bindParam(":nombre_empresa", $nombre_empresa);
    $sentencia->bindParam(":ruc_empresa", $ruc_empresa);
    $sentencia->bindParam(":direccion_empresa", $direccion_empresa);
    $sentencia->bindParam(":pais_empresa", $pais_empresa);
    $sentencia->bindParam(":departamento_empresa", $departamento_empresa);
    $sentencia->bindParam(":provincia_empresa", $provincia_empresa);
    $sentencia->bindParam(":distrito_empresa", $distrito_empresa);
    // Datos del cliente
    $sentencia->bindParam(":nombres_contacto", $nombres_contacto);
    $sentencia->bindParam(":apellidos_contacto", $apellidos_contacto);
    $sentencia->bindParam(":dni_contacto", $dni_contacto);
    $sentencia->bindParam(":correo_contacto", $correo_contacto);
    $sentencia->bindParam(":telefono_contacto", $telefono_contacto);
    $sentencia->bindParam(":id", $txtID);

    // Ejecutar la consulta de actualización
    $sentencia->execute();

    // Actualiza la foto de perfil si se proporciona una nueva
    if (isset($_FILES["foto_perfil"]["name"]) && $_FILES["foto_perfil"]["name"] != "") {
        $foto_perfil = $_FILES["foto_perfil"]["name"];
        $fecha_actual = new DateTime();
        $nombreArchivo_foto_perfil = $fecha_actual->getTimestamp() . "_" . $foto_perfil;
        $tmp_foto = $_FILES["foto_perfil"]["tmp_name"];
        move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto_perfil);

        // Borrar el archivo anterior si existe
        $sentencia = $conexion->prepare("SELECT foto_perfil FROM tbl_clientes WHERE id = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registro_recuperado["foto_perfil"]) && $registro_recuperado["foto_perfil"] != "") {
            if (file_exists("./img/" . $registro_recuperado["foto_perfil"])) {
                unlink("./img/" . $registro_recuperado["foto_perfil"]);
            }
        }

        // Actualizar el registro con la nueva foto
        $sentencia = $conexion->prepare("UPDATE tbl_clientes SET foto_perfil=:foto_perfil WHERE id=:id");
        $sentencia->bindParam(":foto_perfil", $nombreArchivo_foto_perfil);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    // Redirección con mensaje
    $mensaje = "Registro Editado";
    header("Location: ../../views/clientes.php?mensaje=" . urlencode($mensaje));
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
                                <h1> Modificar Cliente</h1>
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
                     <!-- Primer row -->
                     <div class="row">
                            <div class="col-md-5">
                                 <div class="form-group">
                                    <label for="nombre_empresa">Nombre de la Empresa</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="nombre_empresa" value="<?php echo $nombre_empresa; ?>"
                                    name="nombre_empresa" placeholder="Ingrese el nombre de la empresa">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ruc_empresa">Numero de Ruc</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="ruc_empresa" value="<?php echo $ruc_empresa; ?>"
                                    name="ruc_empresa" placeholder="Ingrese el número RUC">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion_empresa">Dirección</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="direccion_empresa"  value="<?php echo $direccion_empresa; ?>"
                                    name="direccion_empresa" placeholder="Ingrese la dirección">
                                </div>
                            </div>
                    </div>
                    <!-- Primer row -->
                    
                     <!-- Segundo row -->
                     <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pais_empresa">País</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="pais_empresa" value="<?php echo $pais_empresa; ?>" 
                                    name="pais_empresa" placeholder="Ingrese el País">
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form-group">
                                    <label for="departamento_empresa">Departamento</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="departamento_empresa"  value="<?php echo $departamento_empresa; ?>"
                                    name="departamento_empresa" placeholder="Ingrese el número del departamento">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="provincia_empresa">Provincia</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="provincia_empresa" value="<?php echo $provincia_empresa; ?>" 
                                    name="provincia_empresa" placeholder="Ingrese la provincia">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="distrito_empresa">Distrito</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="distrito_empresa"  value="<?php echo $distrito_empresa; ?>"
                                    name="distrito_empresa" placeholder="Ingrese del distrito">
                                </div>
                            </div>
                    </div>
                    <!-- Segundo row -->
                    <!-- <h5 class="sub_title" style="color:red;">Datos del Cliente:</h5>  <br> -->

                    <!--Tercero row -->
                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombres_contacto">Nombre</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="nombres_contacto"  value="<?php echo $nombres_contacto; ?>"
                                    name="nombres_contacto" placeholder="Ingrese el nombre">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apellidos_contacto">Apellidos</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="apellidos_contacto"  value="<?php echo $apellidos_contacto; ?>"
                                    name="apellidos_contacto" placeholder="Ingrese los apellidos">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dni_contacto">DNI</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="dni_contacto"  value="<?php echo $dni_contacto; ?>"
                                    name="dni_contacto" placeholder="Ingrese el dni">
                                </div>
                            </div>
                    </div>
                    <!-- Tercero row -->
                    <!--Cuarto row -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="correo_contacto">Correo</label>
                                    <input  style="border:1.5px solid #48e" type="email" class="form-control" 
                                    id="correo_contacto" value="<?php echo $correo_contacto; ?>"
                                    name="correo_contacto" placeholder="Ingrese el correo">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="telefono_contacto">Teléfono</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="telefono_contacto"  value="<?php echo $telefono_contacto; ?>" 
                                    name="telefono_contacto" placeholder="Ingrese el teléfono">
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                    </div>
                    <!-- Cuarto  row -->

                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img id="previewImage" width="100" src="<?php echo $foto_perfil; ?>" class="img-fluid rounded" alt="Vista previa de la imagen">
                                    <input type="file" class="form-control" name="foto_perfil" id="foto_perfil" aria-describedby="helpId" placeholder="Foto" />
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                        <img src="<?php echo $url_base; ?>assets/img/guardarycerrar/guardar2.png" alt="">Modificar
                                    </button>
                                    <a href="../../views/clientes.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
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