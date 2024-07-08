
<?php 
require("../../BD/bd.php");
include("../../sesion.php");
// Verificar si se ha enviado el ID a través de la URL
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Ejecutar consulta para obtener los datos del cliente basado en el ID
    try {
        $sentencia = $conexion->prepare("SELECT * FROM `tbl_sucursales` WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        if (!$registro) {
            echo "No se encontró ningún registro con ese ID.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        exit;
    }
} else {
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
            <div class="container">
                  <br><br><br>
                <div class="card mx-auto" style="border:2px solid #19AB53;border-radius:30px; max-width: 900px; padding: 20px;">
                    <!--1row-->     
                    <div class="row justify-content-center my-3">
                        <div class="col-md-10 text-center">
                            <img src="./img/<?php echo htmlspecialchars($registro["foto_empresa"]); ?>"
                             width="180px" height="140px" class="rounded-circle" alt="Foto de perfil" />
                        </div>
                    </div>
                    <!--2row-->     
                    <div class="row my-2">
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Nombre :</strong><br>
                            <?php echo htmlspecialchars($registro['nombre']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Direccion:</strong><br>
                            <?php echo htmlspecialchars($registro['direccion']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">ruc:</strong><br>
                            <?php echo htmlspecialchars($registro['ruc']); ?></p>
                        </div>
                    </div>
                    <!--3row-->     
                    <div class="row my-2">
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">País </strong><br>
                            <?php echo htmlspecialchars($registro['pais']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Departamento </strong><br>
                            <?php echo htmlspecialchars($registro['departamento']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Provincia </strong><br>
                            <?php echo htmlspecialchars($registro['provincia']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-center"><strong style="color:#0047FC;">Distrito</strong><br>
                            <?php echo htmlspecialchars($registro['distrito']); ?></p>
                        </div>
                    </div>
                    <!--4row-->     
                    <div class="row my-2">
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Telefono:</strong><br>
                            <?php echo htmlspecialchars($registro['telefono']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Correo:</strong><br>
                            <?php echo htmlspecialchars($registro['correo']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center"><strong style="color:#0047FC;">Responsable:</strong><br>
                            <?php echo htmlspecialchars($registro['responsable']); ?></p>
                        </div>
                    </div>
                    <!--5row-->     
                    <div class="row my-2">
                        <div class="col-md-12 text-center">
                            <p><strong style="color:#0047FC;">Web:</strong><br>
                            <?php echo htmlspecialchars($registro['nombre_web']); ?></p>
                        </div>
                    </div>
                    <!--6row-->     
                    <div class="row my-2">
                        <div class="col-md-12 text-center">
                            <a href="../../views/sucursal.php" class="btn btn-primary">
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
