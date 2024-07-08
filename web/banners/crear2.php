<?php 
 include("../../BD/bd.php");
include("../../sesion.php");
?>
<?php 
// Verifica si se ha enviado el formulario por POST
if($_POST){
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";

    // Recolecta los nombres de los archivos de las imágenes enviadas
    $foto_portada = isset($_FILES["foto_portada"]["name"]) ? $_FILES["foto_portada"]["name"] : "";

    // Prepara la consulta SQL para insertar los datos del empleado
    $sentencia = $conexion->prepare("INSERT INTO `tbl_bannerdos` 
    (`titulo`, `descripcion`, `foto_portada`) 
    VALUES (:titulo, :descripcion, :foto_portada)");

    // Asigna los valores a los parámetros de la consulta

    // Consulta de empresas
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);


    // Obtener la fecha actual para el nombre de archivo único
    $fecha_actual = new DateTime();
    $nombreArchivo_foto = ($foto_portada != '') ? $fecha_actual->getTimestamp() . "_" . $foto_portada : "";
    // Obtener la ubicación temporal del archivo cargado
    $tmp_foto = isset($_FILES["foto_portada"]["tmp_name"]) ? $_FILES["foto_portada"]["tmp_name"] : "";
    // Si se cargó una foto, mueve el archivo a la ubicación deseada
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./img2/" . $nombreArchivo_foto);
    }
    // Asignar el nombre de archivo al parámetro de la consulta
    $sentencia->bindParam(":foto_portada", $nombreArchivo_foto);
    $sentencia->execute();
    $mensaje="Registro Agregado";
    header("Location: banner2.php?mensaje=".$mensaje);
    exit; 
}
// Selecciona la información de los puestos
$sentencia_bannerdos = $conexion->prepare("SELECT * FROM `tbl_bannerdos`");
$sentencia_bannerdos->execute();
$lista_tbl_bannerdos = $sentencia_bannerdos->fetchAll(PDO::FETCH_ASSOC);
?>

<?php 
if(isset($_GET['mensaje'])){?>
<script>
  Swal.fire({icon:"success",title:"<?php echo $_GET['mensaje']; ?>"});
</script>

<?php } ?>

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
    /* Estilos personalizados */
    .input-group select.form-control {
      width: 60px; /* Ancho deseado para el select */
    }
    /* Media query para ajustar la disposición de los elementos en pantallas pequeñas */
    @media (max-width: 767px) {
      .content-header .container .row {
        flex-direction: column;
        align-items: center;
      }
      .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      table {
        width: 100%; /* Ajusta el ancho de la tabla al 100% */
        border-collapse: collapse; /* Fusiona los bordes de las celdas */
      }
      th, td {
        padding: 8px; /* Añade espaciado interno a las celdas */
        border: 1px solid #ddd; /* Añade bordes a las celdas */
        display: block; /* Hace que las celdas se muestren en bloques */
        width: 100%; /* Ocupa el ancho completo de su contenedor */
        text-align: left; /* Alinea el texto a la izquierda */
      }
      th {
        background-color: rgb(0, 59, 103); /* Color de fondo para las celdas de encabezado */
        color: white; /* Color de texto para las celdas de encabezado */
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php 
require("../../modulos/navbar.php");
require("../../modulos/aside.php");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <div class="content-header">
                <div class="container">
                    <br> <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title d-flex justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
                                <h1>Agregar el  Banner 2 </h1>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container -->
            </div>
            <!-- /.content-header -->  
  <!-- Main content -->
  <br><br> <br> 
  <div class="content">
    <div class="container">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="titulo">Titulo:</label>
              <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingrese el primer titulo">
            </div>
            <div class="form-group">
              <label for="descripcion">Descripcion:</label>
              <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la primera descripcion">
            </div>
            <div class="form-group">
              <label for="foto_portada">Foto  de Portada 2:</label>
              <input type="file" id="foto_portada" name="foto_portada" class="form-control-file">
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

<?php include("../../modulos/footer.php"); ?> 

<script>
function borrar(id){
  Swal.fire({
    title: "¿Desea Borrar el registro?",
    showCancelButton: true,
    confirmButtonText: "Si Borrar"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location="clientes.php?txtID="+id;
    }
  });
}
</script>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>
















