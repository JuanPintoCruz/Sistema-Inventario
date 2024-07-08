<?php 
 include("../../BD/bd.php");
include("../../sesion.php");
?>

<?php 

// Verifica si se ha enviado el formulario por POST
// if($_SERVER["REQUEST_METHOD"] == "POST"){
if($_POST){
    //Variable  //Verifica el valor del parametro //Si está presente, se asigna el valor del parámetro; de lo contrario, se asigna una cadena vacía
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

    // Recolecta los nombres de los archivos de las imágenes enviadas
    $foto_empresa = isset($_FILES["foto_empresa"]["name"]) ? $_FILES["foto_empresa"]["name"] : "";


    // Prepara la consulta SQL para insertar los datos del empleado
    $sentencia = $conexion->prepare("INSERT INTO `tbl_sucursales` 
    (`nombre`, `direccion`, `ruc`, `pais`, 
    `departamento`, `provincia`, `distrito`, `telefono`,
     `correo`, `responsable`, `nombre_web`, `foto_empresa`) 
    VALUES (:nombre, :direccion, :ruc, :pais, :departamento, :provincia, :distrito, 
    :telefono, :correo, :responsable, :nombre_web, :foto_empresa)");

    // Asigna los valores a los parámetros de la consulta

    // Consulta de empresas
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":direccion", $direccion);
    $sentencia->bindParam(":ruc", $ruc);
    $sentencia->bindParam(":pais", $pais);
    $sentencia->bindParam(":departamento", $departamento);
    $sentencia->bindParam(":provincia", $provincia);
    $sentencia->bindParam(":distrito", $distrito);

    // Consulta de los clientes
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":responsable", $responsable);
    $sentencia->bindParam(":nombre_web", $nombre_web);

    // Obtener la fecha actual para el nombre de archivo único
    $fecha_actual = new DateTime();
    $nombreArchivo_foto = ($foto_empresa != '') ? $fecha_actual->getTimestamp() . "_" . $foto_empresa : "";
    // Obtener la ubicación temporal del archivo cargado
    $tmp_foto = isset($_FILES["foto_empresa"]["tmp_name"]) ? $_FILES["foto_empresa"]["tmp_name"] : "";
    // Si se cargó una foto, mueve el archivo a la ubicación deseada
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto);
    }
    // Asignar el nombre de archivo al parámetro de la consulta
    $sentencia->bindParam(":foto_empresa", $nombreArchivo_foto);
    $sentencia->execute();
    $mensaje="Registro Agregado";
    header("Location: ../../views/sucursal.php?mensaje=".$mensaje);
    exit; 
}
// Selecciona la información de los puestos
$sentencia_sucursales = $conexion->prepare("SELECT * FROM `tbl_sucursales`");
$sentencia_sucursales->execute();
$lista_tbl_sucursales = $sentencia_sucursales->fetchAll(PDO::FETCH_ASSOC);
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
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title d-flex justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
                                <h1> Agregar Sucursales</h1>
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
                    <div class="col-md-4">
                            
                    </div>
                    <!-- <h5 class="sub_title" style="color:red;">Datos de la empresa:</h5>  <br> -->
                     <!-- Primer row -->
                    <div class="row">
                            <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" id="nombre" name="nombre"
                                     placeholder="Ingrese el nombre ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion">Direccion</label>
                                    <input  style="border:1.5px solid #48e" type="text"
                                     class="form-control" id="direccion" name="direccion"
                                      placeholder="Ingrese la direccion">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ruc">Ruc</label>
                                    <input  style="border:1.5px solid #48e" type="text"
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
                                    <input  style="border:1.5px solid #48e" type="text"
                                     class="form-control" id="pais" name="pais"
                                      placeholder="Ingrese el País">
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <input  style="border:1.5px solid #48e" type="text"
                                     class="form-control" id="departamento" name="departamento"
                                      placeholder="Ingrese el número del departamento">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="provincia">Provincia</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" id="provincia" name="provincia"
                                     placeholder="Ingrese la provincia">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="distrito">Distrito</label>
                                    <input  style="border:1.5px solid #48e" type="text"
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
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" id="telefono" name="telefono" 
                                    placeholder="Ingrese el telefono">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="correo">Correo:</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" id="correo" name="correo" 
                                    placeholder="Ingrese el correo">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="responsable">Responsable</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" id="responsable" name="responsable"
                                     placeholder="Ingrese al Responsable">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nombre_web">Web</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
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
                                    <label for="foto_empresa">Foto (Opcional)</label>
                                    <input  style="border:1.5px solid #48e" type="file" id="foto_empresa" name="foto_empresa" class="form-control-file">
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <!-- Eighth Column -->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;"><img src="<?php echo $url_base;?>assets/img/guardarycerrar/guardar2.png" alt=""> Guardar</button>
                                    <a href="../../views/sucursal.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;"><img src="<?php echo $url_base;?>assets/img/guardarycerrar/cerrar2.png" alt=""> Cancelar</a>
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