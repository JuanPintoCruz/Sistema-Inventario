<?php 
require("../../BD/bd.php");
include("../../sesion.php");
// Verificar si se ha enviado el ID a través de la URL
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Ejecutar consulta para obtener los datos del cliente basado en el ID
    try {
        $sentencia = $conexion->prepare("SELECT * FROM `tbl_perfil` WHERE id = :id");
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
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                      <br>
                        <div class="card" style="border-radius:30px;">
                            <div class="card-body" style="border:2px solid #48e;border-radius:30px;">
                                <div class="card-body text-center" >
                                    <img src="./img/<?php echo htmlspecialchars($registro["foto_perfil"]); ?>" width="180px" height="140px" /> 
                                    <h5>Detalles del Cliente</h5>
                                    <p><strong>Nombre de la Empresa:</strong> <?php echo htmlspecialchars($registro['nombre_empresa']); ?></p>
                                    <p><strong>RUC de la Empresa:</strong> <?php echo htmlspecialchars($registro['ruc_empresa']); ?></p>
                                    <p><strong>Dirección de la Empresa:</strong> <?php echo htmlspecialchars($registro['direccion_empresa']); ?></p>
                                    <p><strong>País de la Empresa:</strong> <?php echo htmlspecialchars($registro['pais_empresa']); ?></p>
                                    <p><strong>Departamento de la Empresa:</strong> <?php echo htmlspecialchars($registro['departamento_empresa']); ?></p>
                                    <p><strong>Provincia de la Empresa:</strong> <?php echo htmlspecialchars($registro['provincia_empresa']); ?></p>
                                    <p><strong>Distrito de la Empresa:</strong> <?php echo htmlspecialchars($registro['distrito_empresa']); ?></p>
                                    <p><strong>Nombres del Contacto:</strong> <?php echo htmlspecialchars($registro['nombres_contacto']); ?></p>
                                    <p><strong>Apellidos del Contacto:</strong> <?php echo htmlspecialchars($registro['apellidos_contacto']); ?></p>
                                    <p><strong>DNI del Contacto:</strong> <?php echo htmlspecialchars($registro['dni_contacto']); ?></p>
                                    <p><strong>Correo del Contacto:</strong> <?php echo htmlspecialchars($registro['correo_contacto']); ?></p>
                                    <p><strong>Teléfono del Contacto:</strong> <?php echo htmlspecialchars($registro['telefono_contacto']); ?></p>
                                    <br>
                                    <a href="../../views/clientes.php" class="btn btn-primary"><img class="img" style="margin:3px" src="<?php echo $url_base;?>assets/img/regresar2.png" width="30" height="30" alt="">Regresar</a>
                                </div>
                            </div>
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