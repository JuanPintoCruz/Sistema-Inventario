<?php 
 include("../../BD/bd.php");
include("../../sesion.php");
?>

<?php 


// Verifica si se ha enviado el formulario por POST
// if($_SERVER["REQUEST_METHOD"] == "POST"){
if($_POST){
    // Recolecta los datos del formulario
    // Datos de la empresa 
//ESTA ES LA VARIABLE//  $nombre_empresa
//ISSET // Es una función en PHP que verifica si una variable está definida y no es null.
//$_POST["nombre_empresa"]: Si la expresión isset($_POST["nombre_empresa"]) es verdadera (es decir, si el parámetro nombre_empresa está presente),
// entonces $_POST["nombre_empresa"] se asigna a la variable $nombre_empresa.
//: Este es el dos puntos, que separa las dos opciones en el operador ternario.
// isset($_POST["nombre_empresa"]) verifica si nombre_empresa ha sido enviada en el formulario y contiene algún valor.
//? Este es el signo de interrogación, que marca el comienzo del operador 
// "" (Cadena Vacía):Si isset($_POST["nombre_empresa"]) es falso (es decir, nombre_empresa no está 
// presente en los datos enviados por el formulario), se asigna una cadena vacía a $nombre_empresa.
// La superglobal $_POST contiene datos enviados mediante el método POST desde un formulario HTML.
// isset($_POST["nombre_empresa"]) verifica si el parámetro "nombre_empresa" está presente en los datos POST recibidos.
// Si está presente, se asigna su valor a la variable $nombre_empresa; de lo contrario, se asigna una cadena vacía.

    //Variable  //Verifica el valor del parametro //Si está presente, se asigna el valor del parámetro; de lo contrario, se asigna una cadena vacía
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

    // Recolecta los nombres de los archivos de las imágenes enviadas
    $foto_perfil = isset($_FILES["foto_perfil"]["name"]) ? $_FILES["foto_perfil"]["name"] : "";


    // Prepara la consulta SQL para insertar los datos del empleado
    $sentencia = $conexion->prepare("INSERT INTO `tbl_clientes` 
    (`nombre_empresa`, `ruc_empresa`, `direccion_empresa`, `pais_empresa`, 
    `departamento_empresa`, `provincia_empresa`, `distrito_empresa`, `nombres_contacto`,
     `apellidos_contacto`, `dni_contacto`, `correo_contacto`, `foto_perfil`, `telefono_contacto`) 
    VALUES (:nombre_empresa, :ruc_empresa, :direccion_empresa, :pais_empresa, :departamento_empresa, :provincia_empresa, :distrito_empresa, 
    :nombres_contacto, :apellidos_contacto, :dni_contacto, :correo_contacto, :foto_perfil, :telefono_contacto)");

    // Asigna los valores a los parámetros de la consulta

    // Consulta de empresas
    $sentencia->bindParam(":nombre_empresa", $nombre_empresa);
    $sentencia->bindParam(":ruc_empresa", $ruc_empresa);
    $sentencia->bindParam(":direccion_empresa", $direccion_empresa);
    $sentencia->bindParam(":pais_empresa", $pais_empresa);
    $sentencia->bindParam(":departamento_empresa", $departamento_empresa);
    $sentencia->bindParam(":provincia_empresa", $provincia_empresa);
    $sentencia->bindParam(":distrito_empresa", $distrito_empresa);

    // Consulta de los clientes
    $sentencia->bindParam(":nombres_contacto", $nombres_contacto);
    $sentencia->bindParam(":apellidos_contacto", $apellidos_contacto);
    $sentencia->bindParam(":dni_contacto", $dni_contacto);
    $sentencia->bindParam(":correo_contacto", $correo_contacto);
    $sentencia->bindParam(":telefono_contacto", $telefono_contacto);

    // Obtener la fecha actual para el nombre de archivo único
    $fecha_actual = new DateTime();
    $nombreArchivo_foto = ($foto_perfil != '') ? $fecha_actual->getTimestamp() . "_" . $foto_perfil : "";
    // Obtener la ubicación temporal del archivo cargado
    $tmp_foto = isset($_FILES["foto_perfil"]["tmp_name"]) ? $_FILES["foto_perfil"]["tmp_name"] : "";
    // Si se cargó una foto, mueve el archivo a la ubicación deseada
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto);
    }
    // Asignar el nombre de archivo al parámetro de la consulta
    $sentencia->bindParam(":foto_perfil", $nombreArchivo_foto);
    $sentencia->execute();
    $mensaje="Registro Agregado";
    header("Location: ../../views/clientes.php?mensaje=".$mensaje);
    exit; 
}
// Selecciona la información de los puestos
$sentencia_clientes = $conexion->prepare("SELECT * FROM `tbl_clientes`");
$sentencia_clientes->execute();
$lista_tbl_clientes = $sentencia_clientes->fetchAll(PDO::FETCH_ASSOC);
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
                                <h1> Agregar Cliente</h1>
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
                            <div class="col-md-5">
                                 <div class="form-group">
                                    <label for="nombre_empresa">Nombre de la Empresa</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Ingrese el nombre de la empresa">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ruc_empresa">Numero de Ruc</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="ruc_empresa" name="ruc_empresa" placeholder="Ingrese el número RUC">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion_empresa">Dirección</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="direccion_empresa" name="direccion_empresa" placeholder="Ingrese la dirección">
                                </div>
                            </div>
                    </div>
                    <!-- Primer row -->
                    
                     <!-- Segundo row -->
                     <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pais_empresa">País</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="pais_empresa" name="pais_empresa" placeholder="Ingrese el País">
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form-group">
                                    <label for="departamento_empresa">Departamento</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="departamento_empresa" name="departamento_empresa" placeholder="Ingrese el número del departamento">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="provincia_empresa">Provincia</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="provincia_empresa" name="provincia_empresa" placeholder="Ingrese la provincia">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="distrito_empresa">Distrito</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="distrito_empresa" name="distrito_empresa" placeholder="Ingrese del distrito">
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
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="nombres_contacto" name="nombres_contacto" placeholder="Ingrese el nombre">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apellidos_contacto">Apellidos</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="apellidos_contacto" name="apellidos_contacto" placeholder="Ingrese los apellidos">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dni_contacto">DNI</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="dni_contacto" name="dni_contacto" placeholder="Ingrese el dni">
                                </div>
                            </div>
                    </div>
                    <!-- Tercero row -->
                    <!--Cuarto row -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="correo_contacto">Correo</label>
                                    <input  style="border:1.5px solid #48e" type="email" class="form-control" id="correo_contacto" name="correo_contacto" placeholder="Ingrese el correo">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="telefono_contacto">Teléfono</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" placeholder="Ingrese el teléfono">
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                    </div>
                    <!-- Cuarto  row -->
                        <br> <br>                    
                        <div class="row">
                            <!-- Fourth Column -->
                            <div class="col-md-4">
                                <!-- <div class="form-group">
                                    <label for="fecha_nacimiento">Cumpleaños</label>
                                    <input  style="border:1.5px solid #48e" type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                                </div> -->
                            </div>
                            <!-- Fifth Column -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="foto_perfil">Foto (Opcional)</label>
                                    <input  style="border:1.5px solid #48e" type="file" id="foto_perfil" name="foto_perfil" class="form-control-file">
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <!-- Eighth Column -->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;"><img src="<?php echo $url_base;?>assets/img/guardarycerrar/guardar2.png" alt=""> Guardar</button>
                                    <a href="../../views/clientes.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;"><img src="<?php echo $url_base;?>assets/img/guardarycerrar/cerrar2.png" alt=""> Cancelar</a>
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