<?php 
include("../../BD/bd.php");
include("../../sesion.php");

// Manejar la solicitud GET para obtener los datos del colaborador
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Consulta para obtener los datos del registro
    $sentencia = $conexion->prepare("SELECT * FROM tbl_sucursales WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el registro
    if ($registro) {
        // Datos de la empresa
        $nombre = $registro["nombre"];
        $direccion = $registro["direccion"];
        $ruc = $registro["ruc"];
        $pais = $registro["pais"];
        $departamento = $registro["departamento"];
        $provincia = $registro["provincia"];
        $distrito = $registro["distrito"];

        // Datos del cliente
        $telefono = $registro["telefono"];
        $correo = $registro["correo"];
        $responsable = $registro["responsable"];
        $nombre_web = $registro["nombre_web"];
        $foto_empresa = $registro["foto_empresa"];
    }
}

// Consulta para obtener la lista de perfiles
$sentencia_tbl_sucursales = $conexion->prepare("SELECT * FROM tbl_sucursales");
$sentencia_tbl_sucursales->execute();
$lista_tbl_sucursales = $sentencia_tbl_sucursales->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario por POST
if ($_POST) {
    // Recolecta los datos del formulario
    // Datos de la empresa 
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
    $ruc = isset($_POST["ruc"]) ? $_POST["ruc"] : "";
    $pais = isset($_POST["pais"]) ? $_POST["pais"] : "";
    $departamento = isset($_POST["departamento"]) ? $_POST["departamento"] : "";
    $provincia = isset($_POST["provincia"]) ? $_POST["provincia"] : "";
    $distrito = isset($_POST["distrito"]) ? $_POST["distrito"] : "";

    // Datos del cliente
    $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    $responsable = isset($_POST["responsable"]) ? $_POST["responsable"] : "";
    $nombre_web = isset($_POST["nombre_web"]) ? $_POST["nombre_web"] : "";

    // Prepara y ejecuta la consulta SQL para actualizar los datos del perfil
    $sentencia = $conexion->prepare("UPDATE tbl_sucursales SET nombre=:nombre, direccion=:direccion,
     ruc=:ruc, pais=:pais, departamento=:departamento,
      provincia=:provincia, distrito=:distrito, telefono=:telefono,
       correo=:correo, responsable=:responsable, nombre_web=:nombre_web WHERE id=:id");

    // Asigna los valores a los parámetros de la consulta
    // Datos de la empresa
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":direccion", $direccion);
    $sentencia->bindParam(":ruc", $ruc);
    $sentencia->bindParam(":pais", $pais);
    $sentencia->bindParam(":departamento", $departamento);
    $sentencia->bindParam(":provincia", $provincia);
    $sentencia->bindParam(":distrito", $distrito);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":responsable", $responsable);
    $sentencia->bindParam(":nombre_web", $nombre_web);
    $sentencia->bindParam(":id", $txtID);

    // Ejecutar la consulta de actualización
    $sentencia->execute();

    // Actualiza la foto de perfil si se proporciona una nueva
    if (isset($_FILES["foto_empresa"]["name"]) && $_FILES["foto_empresa"]["name"] != "") {
        $foto_empresa = $_FILES["foto_empresa"]["name"];
        $fecha_actual = new DateTime();
        $nombreArchivo_foto_perfil = $fecha_actual->getTimestamp() . "_" . $foto_empresa;
        $tmp_foto = $_FILES["foto_empresa"]["tmp_name"];
        move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto_empresa);

        // Borrar el archivo anterior si existe
        $sentencia = $conexion->prepare("SELECT foto_empresa FROM tbl_sucursales WHERE id = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registro_recuperado["foto_empresa"]) && $registro_recuperado["foto_empresa"] != "") {
            if (file_exists("./img/" . $registro_recuperado["foto_empresa"])) {
                unlink("./img/" . $registro_recuperado["foto_empresa"]);
            }
        }

        // Actualizar el registro con la nueva foto
        $sentencia = $conexion->prepare("UPDATE tbl_sucursales SET foto_empresa=:foto_empresa WHERE id=:id");
        $sentencia->bindParam(":foto_empresa", $nombreArchivo_foto_empresa);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    // Redirección con mensaje
    $mensaje = "Registro Editado";
    header("Location: ../../views/sucursal.php?mensaje=" . urlencode($mensaje));
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
                                    <input type="text" class="form-control" id="txtID"
                                     name="txtID" value="<?php echo $txtID; ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                                          <!-- Primer row -->
                    <div class="row">
                            <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text"  value="<?php echo $nombre; ?>"
                                    class="form-control" id="nombre" name="nombre"
                                     placeholder="Ingrese el nombre ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion">Direccion</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text" value="<?php echo $direccion; ?>"
                                     class="form-control" id="direccion" name="direccion"
                                      placeholder="Ingrese la direccion">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ruc">Ruc</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text" value="<?php echo $ruc; ?>"
                                     class="form-control" id="ruc" name="ruc"
                                      placeholder="Ingrese el Ruc">
                                </div>
                            </div>
                    </div>
                    <!-- Primer row -->
                    
                     <!-- Segundo row -->
                     <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pais">País</label>
                                    <input  style="border:1.5px solid #48e"
                                     type="text" value="<?php echo $pais; ?>"
                                     class="form-control" id="pais" name="pais"
                                      placeholder="Ingrese el País">
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <input  style="border:1.5px solid #48e"
                                     type="text" value="<?php echo $departamento; ?>"
                                     class="form-control" id="departamento" name="departamento"
                                      placeholder="Ingrese el número del departamento">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="provincia">Provincia</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text"  value="<?php echo $provincia; ?>"
                                    class="form-control" id="provincia" name="provincia"
                                     placeholder="Ingrese la provincia">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="distrito">Distrito</label>
                                    <input  style="border:1.5px solid #48e"
                                     type="text" value="<?php echo $distrito; ?>"
                                     class="form-control" id="distrito" name="distrito" 
                                     placeholder="Ingrese del distrito">
                                </div>
                            </div>
                    </div>
                    <!-- Segundo row -->
                    <!-- <h5 class="sub_title" style="color:red;">Datos del Cliente:</h5>  <br> -->

                    <!--Tercero row -->
                    <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text" value="<?php echo $telefono; ?>" 
                                    class="form-control" id="telefono" name="telefono" 
                                    placeholder="Ingrese el telefono">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="correo">Correo:</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text" value="<?php echo $correo; ?>" 
                                    class="form-control" id="correo" name="correo" 
                                    placeholder="Ingrese el correo">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="responsable">Responsable</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text" value="<?php echo $responsable; ?>" 
                                    class="form-control" id="responsable" name="responsable"
                                     placeholder="Ingrese al Responsable">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nombre_web">Web</label>
                                    <input  style="border:1.5px solid #48e" 
                                    type="text" value="<?php echo $nombre_web; ?>" 
                                    class="form-control" id="nombre_web" name="nombre_web"
                                     placeholder="Ingrese la web">
                                </div>

                            </div>
                    </div>
                    <!-- Tercero row -->
                        <br> <br>                    
                        <div class="row">
                            <!-- Fourth Column -->
                            <div class="col-md-4">
                            </div>
                            <!-- Fifth Column -->
                            <div class="col-md-4">

                                <div class="form-group">
                                    <img id="previewImage" width="100" src="<?php echo $foto_empresa; ?>"
                                     class="img-fluid rounded" alt=" imagen">
                                    <input type="file" class="form-control-file" name="foto_empresa" 
                                    id="foto_empresa" aria-describedby="helpId" placeholder="Foto" />
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                        <img src="<?php echo $url_base; ?>assets/img/guardarycerrar/guardar2.png" alt="">Modificar
                                    </button>
                                    <a href="../../views/sucursal.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
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