<?php 
include("../../BD/bd.php");
include("../../sesion.php");

// Manejar la solicitud GET para obtener los datos del colaborador
if(isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Consulta para obtener los datos del registro
    $sentencia = $conexion->prepare("SELECT * FROM tbl_proveedores WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el registro
    if($registro) {
        // Datos de la empresa
        $tipo = $registro["tipo"];
        $nombre_proveedor = $registro["nombre_proveedor"];
        $ruc_dni = $registro["ruc_dni"];
        $pais = $registro["pais"];
        $departamento = $registro["departamento"];
        $provincia = $registro["provincia"];
        $distrito = $registro["distrito"];
        $direccion = $registro["direccion"];
        $telefono = $registro["telefono"];
        $correo = $registro["correo"];
        $extras = $registro["extras"];
        $foto_proveedor = $registro["foto_proveedor"];
    }
}

// Consulta para obtener la lista de perfiles
$sentencia_tbl_proveedores = $conexion->prepare("SELECT * FROM tbl_proveedores");
$sentencia_tbl_proveedores->execute();
$lista_tbl_proveedores = $sentencia_tbl_proveedores->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario por POST
if($_POST){

        // Recolecta los datos del formulario
        $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";
        $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
        $nombre_proveedor = isset($_POST["nombre_proveedor"]) ? $_POST["nombre_proveedor"] : "";
        $ruc_dni = isset($_POST["ruc_dni"]) ? $_POST["ruc_dni"] : "";
        $pais = isset($_POST["pais"]) ? $_POST["pais"] : "";
        $departamento = isset($_POST["departamento"]) ? $_POST["departamento"] : "";
        $provincia = isset($_POST["provincia"]) ? $_POST["provincia"] : "";
        $distrito = isset($_POST["distrito"]) ? $_POST["distrito"] : "";
        $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
        $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
        $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
        $extras = isset($_POST["extras"]) ? $_POST["extras"] : "";

        // Prepara y ejecuta la consulta SQL para actualizar los datos del proveedor
        $sentencia = $conexion->prepare("UPDATE tbl_proveedores SET tipo=:tipo, nombre_proveedor=:nombre_proveedor,
            ruc_dni=:ruc_dni, pais=:pais, departamento=:departamento, provincia=:provincia, 
            distrito=:distrito, direccion=:direccion, telefono=:telefono, 
            correo=:correo, extras=:extras WHERE id=:id");

        // Asigna los valores a los parámetros de la consulta
        $sentencia->bindParam(":tipo", $tipo);
        $sentencia->bindParam(":nombre_proveedor", $nombre_proveedor);
        $sentencia->bindParam(":ruc_dni", $ruc_dni);
        $sentencia->bindParam(":pais", $pais);
        $sentencia->bindParam(":departamento", $departamento);
        $sentencia->bindParam(":provincia", $provincia);
        $sentencia->bindParam(":distrito", $distrito);
        $sentencia->bindParam(":direccion", $direccion);
        $sentencia->bindParam(":telefono", $telefono);
        $sentencia->bindParam(":correo", $correo);
        $sentencia->bindParam(":extras", $extras);
        $sentencia->bindParam(":id", $txtID);

        // Ejecutar la consulta de actualización
        $sentencia->execute();

        // Actualiza la foto de perfil si se proporciona una nueva
        if(isset($_FILES["foto_proveedor"]["name"]) && $_FILES["foto_proveedor"]["name"] != "") {
            $foto_proveedor = $_FILES["foto_proveedor"]["name"];
            $fecha_actual = new DateTime();
            $nombreArchivo_foto_perfil = $fecha_actual->getTimestamp() . "_" . $foto_proveedor;
            $tmp_foto = $_FILES["foto_proveedor"]["tmp_name"];
            move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto_perfil);

            // Borrar el archivo anterior si existe
            $sentencia = $conexion->prepare("SELECT foto_proveedor FROM tbl_proveedores WHERE id = :id");
            $sentencia->bindParam(":id", $txtID);
            $sentencia->execute();
            $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
            if(isset($registro_recuperado["foto_proveedor"]) && $registro_recuperado["foto_proveedor"] != "") {
                if(file_exists("./img/".$registro_recuperado["foto_proveedor"])){
                    unlink("./img/".$registro_recuperado["foto_proveedor"]);
                }
            }

            // Actualizar el registro con la nueva foto
            $sentencia = $conexion->prepare("UPDATE tbl_proveedores SET foto_proveedor=:foto_proveedor WHERE id=:id");
            $sentencia->bindParam(":foto_proveedor", $nombreArchivo_foto_perfil);
            $sentencia->bindParam(":id", $txtID);
            $sentencia->execute();
        }

                // Redirección con mensaje
            $mensaje = "Registro Editado";
            header("Location: ../../views/proveedor.php?mensaje=" . urlencode($mensaje));
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
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .form-control {
            border: 1.5px solid #48e;
            height: auto;
            font-size: 14px;
        }
        .custom-select-wrapper {
            position: relative;
        }
        .custom-select {
            width: 100%;
            appearance: none;
            padding-right: 2.5rem; /* space for the icon */
        }
        .custom-select-wrapper::after {
            content: "\f078"; /* Font Awesome unicode for down arrow */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            top: 50%;
            right: 1rem;
            pointer-events: none;
            transform: translateY(-50%);
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
                                <h1> Modificar Proveedor</h1>
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
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label for="txtID">ID</label>
                                    <input type="text" class="form-control" id="txtID" name="txtID" value="<?php echo $txtID; ?>" readonly>
                                </div> 
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                
                    <br> 
                    <!-- primer row -->
                    <div class="row">

                      <div class="col-md-2"> 
                            <div class="form-group">
                                <label for="tipo">Tipo </label>
                                <select name="tipo" class="form-control custom-select">
                                    <option value="">Seleccionar Tipo </option>
                                    <option value="servicio" <?php echo ($tipo=="servicio")?"selected":"";?> >SERVICIO</option>
                                    <option value="articulo" <?php echo ($tipo=="articulo")?"selected":"";?> >ARTICULO</option>
                                    <option value="insumos" <?php echo ($tipo=="insumos")?"selected":"";?> >INSUMOS</option>
                                </select>
                            </div>
                      </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                    <label for="nombre_proveedor">Nombre empresa o del proveedor</label>
                                    <input  type="text" class="form-control" id="nombre_proveedor" value="<?php echo $nombre_proveedor; ?>"
                                     name="nombre_proveedor" placeholder="Ingrese el nombre de la empresa o proveedor">
                            </div>
                      </div>

                      <div class="col-md-2">
                            <div class="form-group">
                                <label for="ruc_dni">RUC/DNI</label>
                                <input  type="text" class="form-control" id="ruc_dni" value="<?php echo $ruc_dni; ?>"
                                 name="ruc_dni" placeholder="Ingrese el dni">
                            </div>
                       </div>

                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input  type="text" class="form-control" id="direccion"  value="<?php echo $direccion; ?>"
                                    name="direccion" placeholder="Ingrese la dirección">
                                </div>
                        </div>
                    </div>
                    <!-- primer row -->
                    

                    <!-- segundo row -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pais">País</label>
                                <input  type="text" class="form-control" id="pais" value="<?php echo $pais; ?>"
                                name="pais" placeholder="Ingrese el País">
                            </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input  type="text" class="form-control" id="departamento" value="<?php echo $departamento; ?>"
                                name="departamento" placeholder="Ingrese el departamento">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <input  type="text" class="form-control" id="provincia" value="<?php echo $provincia; ?>"
                                 name="provincia" placeholder="Ingrese la provincia">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="distrito">Distrito</label>
                                <input  type="text" class="form-control" id="distrito" value="<?php echo $distrito; ?>"
                                name="distrito" placeholder="Ingrese el distrito">
                            </div>
                        </div>
                    </div>

                    <!-- segundo row -->

                    <!-- tercer row -->

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input  type="email" class="form-control" id="correo"  value="<?php echo $correo; ?>"
                                name="correo" placeholder="Ingrese el correo">
                            </div>     
                        </div>
                        <div class="col-md-2">
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input  type="text" class="form-control" id="telefono" value="<?php echo $telefono; ?>"
                                     name="telefono" placeholder="Ingrese cosas adicionales">
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="extras">Extras</label>
                                    <input  type="text" class="form-control" id="extras" value="<?php echo $extras; ?>"
                                     name="extras" placeholder="Ingrese cosas adicionales">
                                </div>
                        </div>

                    </div>
                    <br><br><br>
                    <!-- tercer row -->

                       
                        <div class="row">
                            <!-- Fourth Column -->
                            <div class="col-md-4">
                            </div>
                            <!-- Fifth Column -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="foto_proveedor">Foto (Opcional)</label>
                                    <input type="file" id="foto_proveedor" name="foto_proveedor" class="form-control-file">
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <!-- Eighth Column -->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                    <img src="<?php echo $url_base;?>assets/img/guardarycerrar/guardar2.png" alt=""> Guardar</button>
                                    <a href="../../views/proveedor.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
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