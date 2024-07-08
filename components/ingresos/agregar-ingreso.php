<?php
include("../../BD/bd.php");
include("../../sesion.php");

$tipo_documento = "";
$id_proveedores = "";
// $id_producto = "";
$fecha = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_proveedores = $_POST["id_proveedores"];
    // $id_producto = $_POST["id_producto"];
    $tipo_documento = $_POST["tipo_documento"];
    $fecha = $_POST["fecha"];

    // Prepara la consulta SQL para insertar los datos 
    $sentencia = $conexion->prepare("INSERT INTO `tbl_ingresos` 
    (`id_proveedores`, `tipo_documento`, `fecha`) 
    VALUES (:id_proveedores, :tipo_documento, :fecha)");

    // Asigna los valores a los parámetros de la consulta
    $sentencia->bindParam(":id_proveedores", $id_proveedores);
    $sentencia->bindParam(":tipo_documento", $tipo_documento);
    $sentencia->bindParam(":fecha", $fecha);

    // Ejecuta la consulta
    if ($sentencia->execute()) {
        $mensaje = "Ingreso registrado correctamente.";
    } else {
        $mensaje = "Error al registrar el ingreso.";
    }

    // Redirige a la página de ingresos con un mensaje
    header("Location: ../../views/ingresos.php?mensaje=" . urlencode($mensaje));
    exit;
}

// Selecciona la información de los proveedores
$sentencia_tbl_proveedores = $conexion->prepare("SELECT * FROM `tbl_proveedores`");
$sentencia_tbl_proveedores->execute();
$lista_tbl_proveedores = $sentencia_tbl_proveedores->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
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
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title d-flex justify-content-center" style="color:#941111; text-align: center; font-size: 25px;">
                                <h1> Agregar Ingresos</h1>
                            </div>
                        </div>
                    </div>
                    <br> 
                </div>
            </div>

            <div class="content">
                <div class="container">
                    <form action="" method="post" enctype="multipart/form-data">
                      
            <!-- row --><div class="row">
                            <div class="col-md-4">
                                <label for="id_proveedores" class="form-label">Proveedores</label>
                                <select class="form-control custom-select" name="id_proveedores" id="id_proveedores">
                                    <option value="">Seleccionar Proveedor</option>
                                    <?php foreach ($lista_tbl_proveedores as $registro_proveedores): ?>
                                        <option value="<?php echo $registro_proveedores['id']; ?>">
                                            <?php echo $registro_proveedores['nombre_proveedor']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tipo_documento">Estado</label>
                                    <select name="tipo_documento" class="form-control custom-select">
                                        <option value="">Seleccionar Tipo</option>
                                        <option value="Factura" <?php echo ($tipo_documento == "Factura") ? "selected" : ""; ?>>Factura</option>
                                        <option value="Boleta" <?php echo ($tipo_documento == "Boleta") ? "selected" : ""; ?>>Boleta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nombre_producto">Nombre del producto</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="nombre_producto" name="nombre_producto" placeholder="Ingrese el producto">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nombre_producto">Nombre </label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="nombre_producto" name="nombre_producto" placeholder="Ingrese el producto">
                                </div>
                            </div>
                        </div> 
                        
                        <!-- row -->
                         <!-- <div class="row">
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_producto">Nombre del producto</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="nombre_producto" name="nombre_producto" placeholder="Ingrese el producto">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_producto">Nombre del producto</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="nombre_producto" name="nombre_producto" placeholder="Ingrese el producto">
                                </div>
                            </div>
                         </div> -->
                         <br> <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title d-flex justify-content-start"
                                   style="color:#941111; text-align: center; font-size: 25px;">
                                     <a  class="btn btn-danger" href="cre">Agregar Nuevo Producto </a>

                                    <!-- <input class="btn btn-danger" value="Agregar Nuevo producto +" style="color:white;">  -->
                                   <!-- <h1> Agregar Ingresos</h1> -->
                                </div>
                            </div>
                        </div>
 
                    <!-- Table -->

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
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio compra</th>
                                    <th scope="col">Precio Venta</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>ropa</td>
                                        <td>10</td>
                                        <td>20.00</td>
                                        <td>30</td>
                                        <td>Eliminar</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                            <br><br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                            <img src="<?php echo $url_base; ?>assets/img/guardarycerrar/guardar2.png" alt=""> Guardar
                                        </button>
                                        <a href="../../views/ingresos.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
                                            <img src="<?php echo $url_base; ?>assets/img/guardarycerrar/cerrar2.png" alt=""> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        
                    </form>
                </div>
            </div>
        </div>

        <?php include("../../modulos/footer.php") ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>