<?php 
require("../BD/bd.php");
include("../sesion.php");

// Definir $nombre_proveedores basado en el parámetro GET si está presente
$nombre_proveedores = isset($_GET['nombre_proveedores']) ? $_GET['nombre_proveedores'] : '';

// Ejecutar consulta
if ($nombre_proveedores) {
  $sentencia = $conexion->prepare("SELECT * FROM `tbl_proveedores` 
  WHERE nombre_proveedores LIKE :nombre_proveedores");
  $nombre_proveedores = "%" . $nombre_proveedores . "%";
  $sentencia->bindParam(':nombre_proveedores', $nombre_proveedores);
} else {
  $sentencia = $conexion->prepare("SELECT * FROM `tbl_proveedores`");
}
// esto arreglar en el otro $sentencia->execute();
// $lista_tbl_productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// seleccionar informacion
$sentencia = $conexion->prepare("SELECT *,
-- Subconsulta para obtener el nombre del puesto del empleado
(
    -- Inicia la subconsulta
    SELECT nombre_proveedor
    FROM tbl_proveedores 
    -- Selecciona el nombre del puesto 
    -- donde el id del puesto en tbl_puestos coincida con el idpuesto en tbl_empleados
    WHERE tbl_proveedores.id = tbl_ingresos.id_proveedores 
    -- Limita la subconsulta a un único resultado
    LIMIT 1
) as proveedor

 FROM `tbl_ingresos`");

$sentencia->execute();
$lista_tbl_ingresos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// eliminar datos
if(isset($_GET['txtID'])) {
  $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : '';

  $sentencia = $conexion->prepare("DELETE FROM tbl_ingresos WHERE id = :id");
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();
  $mensaje="Registro eliminado";
  header("Location: ingresos.php?mensaje=".$mensaje);
  exit; 
}
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
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
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
  require("../modulos/navbar.php")
 ?>
 <?php 
  require("../modulos/aside.php")
 ?>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 d-flex align-items-center mb-3">
              <form action=".php" method="GET" class="form-inline w-100">
                <label for="" class="mr-2 font-weight-bold">Producto:</label>
                <div class="input-group flex-grow-1">
                  <input type="text" id="" name="" class="form-control"
                   placeholder="Buscar por producto" aria-label="Nombre" aria-describedby="basic-addon1">
                  <div class="input-group-append" >
                      <button class="btn btn-primary" type="submit"
                       style="border-radius: 0px 10px 10px 0px;">
                        <img src="<?php echo $url_base;?>assets/img/cliente/buscar-cliente.png" alt="buscar" style="width: 16px; height: 16px;"> Buscar
                      </button> 
                    <a href=".php" class="btn btn-danger" style="margin-left:10px;border-radius: 10px;">Dejar de Buscar</a>
                  </div>
                </div>
              </form>
          </div>
          <div class="col-md-4 text-start">
              <a href="../components/ingresos/agregar-ingreso.php" class="btn btn-success mb-3" type="button" style="border-radius: 10px;">
                <img src="<?php echo $url_base;?>assets/img/cliente/agregar-cliente.png" alt="agregar" style="width: 18px; height: 18px;"> Agregar Nuevo
              </a>
          </div>
        </div>
      </div>
  </div>
  <!-- /.content-header -->
  <!-- Table -->
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <div class="title d-flex-justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
            Información de los Ingresos
          </div>
          <br>
          <table class="table">
            <thead  style="color:white;background-color:rgb(0,59,103)">
              <tr>
                <th scope="col">Número</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Producto</th>
                <th scope="col">Documento</th>
                <th scope="col">Total Compra</th>
                <th scope="col">Fecha</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($lista_tbl_ingresos as $registro){?>
              <tr>
                <td><?php echo $registro['id'];?></td>
                <td> <?php echo $registro['proveedor'];?></td>
                <td>Ropa</td>
                <td><?php echo $registro['tipo_documento'];?></td>
                 <td>100.00</td>
                 <td><?php echo $registro['fecha'];?></td>
                <td>
                <a name="" id="" class="btn btn-info" href="../components/ingresos/mostrar-ingreso.php?txtID=<?php echo $registro['id']; ?>"role="button">P</a>
                <a name="" id="" class="btn btn-info" href="../components/ingresos/modificar-ingreso.php?txtID=<?php echo $registro['id']; ?>"role="button">M</a>
                <a name="" id="" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);"role="button">E</a>
                </td> <!-- No hay datos disponibles en la tabla para estas columnas -->
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
include("../modulos/footer.php")
?> 
</div>

<script>
 function borrar(id){
  Swal.fire({
  title: "¿Desea Borrar el registro?",
  showCancelButton: true,
  confirmButtonText: "Si Borrar"
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location="ingresos.php?txtID="+id;
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
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>