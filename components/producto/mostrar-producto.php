<?php 
 include("../../BD/bd.php");
include("../../sesion.php");
?>

<?php

// Verificar si se ha enviado el ID a través de la URL
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    try {
        // Prepara la consulta SQL para seleccionar los datos del producto con su categoría asociada
        $sentencia = $conexion->prepare("SELECT 
            p.*, 
            c.nombre_categoria 
            FROM tbl_productos p
            LEFT JOIN tbl_categorias c
             ON p.idnombre_categoria = c.id
            WHERE p.id = :id");

        // Vincula el parámetro :id con el valor recibido desde $_GET
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Si no se encuentra ningún registro con el ID proporcionado, mostrar un mensaje
        if (!$registro) {
            echo "No se encontró ningún registro con ese ID.";
            exit;
        }
    } catch (PDOException $e) {
        // Captura cualquier error de PDO y muestra un mensaje
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        exit;
    }
} else {
    // Si no se proporciona ningún ID a través de la URL, mostrar un mensaje
    echo "No se ha proporcionado ningún ID.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php require("../../modulos/navbar.php") ?>
        <?php require("../../modulos/aside.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container ">

            <br><br><br>
                <div class="card mx-auto" style="border:2px solid #19AB53;border-radius:30px; max-width: 900px; padding: 20px;">
                    <!--1row-->     
                    <div class="row justify-content-center my-3">
                        <div class="col-md-10 text-center">
                        <img src="./img/<?php echo htmlspecialchars($registro["foto_producto"]); ?>" width="180px" height="140px" class="rounded-circle" /> 
                        </div>
                    </div>
                        <div class="text-center">
                                <h4 class="text-center" style="color:red;">
                                     Detalles del Producto 
                                </h4>
                        </div>
                    <!--2row-->     
                    <div class="row my-2">
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Codigo Producto</strong>
                            <br>
                            <?php echo htmlspecialchars($registro['codigo_producto']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Codigo barra</strong><br>
                            <?php echo htmlspecialchars($registro['codigo_barra']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p  class="text-center"> <strong style="color:#0047FC;">Nombre del Producto</strong>
                            <br>
                            <?php echo htmlspecialchars($registro['nombre_producto']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Categoria:</strong><br>
                            <?php echo htmlspecialchars($registro['nombre_categoria']); ?></p>
                        </div>
                    </div>
                    <!--3row-->     
                    <div class="row my-2">
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Marca:</strong><br>
                            <?php echo htmlspecialchars($registro['marca']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Medida:</strong><br>
                            <?php echo htmlspecialchars($registro['medida']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Precio Compra</strong><br>
                            <?php echo htmlspecialchars($registro['precio_compra']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Precio Venta</strong><br>
                            <?php echo htmlspecialchars($registro['precio_venta']); ?></p>
                        </div>
                    </div>
                    <!--4row-->     
                    <div class="row my-2">
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Cantidad:</strong><br>
                            <?php echo htmlspecialchars($registro['cantidad']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Estado:</strong><br>
                            <?php echo htmlspecialchars($registro['estado']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Moneda:</strong><br>
                            <?php echo htmlspecialchars($registro['moneda']); ?></p>
                        </div>
                    </div>
                    <!--5row-->     
                    <!--6row-->     
                    <div class="row my-2">
                        <div class="col-md-12 text-center">
                            <a href="../../views/productos.php" class="btn btn-primary">
                                <img class="img" style="margin:3px" src="<?php echo $url_base;?>assets/img/regresar2.png" width="30" height="30" alt="Regresar"> Regresar
                            </a>
                        </div>
                    </div>
                </div>  

            </div>          
        </div>
        <!-- /.content-wrapper -->

        <?php include("../../modulos/footer.php") ?>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>