<?php 
include("../../BD/bd.php");
include("../../sesion.php");

// Manejar la solicitud GET para obtener los datos del colaborador
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Consulta para obtener los datos del registro
    $sentencia = $conexion->prepare("SELECT * FROM tbl_productos WHERE id=:id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el registro
    if ($registro) {
        // Datos de la empresa
        $codigo_producto = $registro["codigo_producto"];
        $codigo_barra = $registro["codigo_barra"];
        $nombre_producto = $registro["nombre_producto"];
        $idnombre_categoria = $registro["idnombre_categoria"];
        $marca = $registro["marca"];
        $medida = $registro["medida"];
        $precio_compra = $registro["precio_compra"];

        // Datos del cliente
        $precio_venta = $registro["precio_venta"];
        $estado = $registro["estado"];
        $moneda = $registro["moneda"];
        $cantidad = $registro["cantidad"];
        $foto_producto = $registro["foto_producto"];
    }
}

// Consulta para obtener la lista de perfiles
$sentencia_tbl_productos = $conexion->prepare("SELECT * FROM tbl_productos");
$sentencia_tbl_productos->execute();
$lista_tbl_productos = $sentencia_tbl_productos->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario por POST
if ($_POST) {
    // Recolecta los datos del formulario
    // Datos de la empresa 
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";
    $codigo_producto = isset($_POST["codigo_producto"]) ? $_POST["codigo_producto"] : "";
    $codigo_barra = isset($_POST["codigo_barra"]) ? $_POST["codigo_barra"] : "";
    $nombre_producto = isset($_POST["nombre_producto"]) ? $_POST["nombre_producto"] : "";
    $idnombre_categoria = isset($_POST["idnombre_categoria"]) ? $_POST["idnombre_categoria"] : "";
    $marca = isset($_POST["marca"]) ? $_POST["marca"] : "";
    $medida = isset($_POST["medida"]) ? $_POST["medida"] : "";
    $precio_compra = isset($_POST["precio_compra"]) ? $_POST["precio_compra"] : "";
    // Datos del cliente
    $precio_venta = isset($_POST["precio_venta"]) ? $_POST["precio_venta"] : "";
    $estado = isset($_POST["estado"]) ? $_POST["estado"] : "";
    $estado = isset($_POST["cantidad"]) ? $_POST["cantidad"] : "";
    $moneda = isset($_POST["moneda"]) ? $_POST["moneda"] : "";

    // Prepara y ejecuta la consulta SQL para actualizar los datos del perfil
    // Aquí falta quitar la coma después de `foto_producto`
    $sentencia = $conexion->prepare("UPDATE tbl_productos 
    SET codigo_producto=:codigo_producto, codigo_barra=:codigo_barra, 
    nombre_producto=:nombre_producto, idnombre_categoria=:idnombre_categoria, marca=:marca, medida=:medida,
     precio_compra=:precio_compra, precio_venta=:precio_venta, estado=:estado, moneda=:moneda, cantidad=:cantidad,
     foto_producto=:foto_producto
      WHERE id=:id");

    // Asigna los valores a los parámetros de la consulta
    // Datos de la empresa
    $sentencia->bindParam(":codigo_producto", $codigo_producto);
    $sentencia->bindParam(":codigo_barra", $codigo_barra);
    $sentencia->bindParam(":nombre_producto", $nombre_producto);
    $sentencia->bindParam(":idnombre_categoria", $idnombre_categoria);
    $sentencia->bindParam(":marca", $marca);
    $sentencia->bindParam(":medida", $medida);
    $sentencia->bindParam(":precio_compra", $precio_compra);
    // Datos del cliente
    $sentencia->bindParam(":precio_venta", $precio_venta);
    $sentencia->bindParam(":estado", $estado);
    $sentencia->bindParam(":cantidad", $cantidad);
    $sentencia->bindParam(":moneda", $moneda);
    $sentencia->bindParam(":foto_producto", $foto_producto);
    $sentencia->bindParam(":id", $txtID);

    $sentencia->execute();

    // Actualiza la foto de perfil si se proporciona una nueva
    if (isset($_FILES["foto_producto"]["name"]) && $_FILES["foto_producto"]["name"] != "") {
        $foto_producto = $_FILES["foto_producto"]["name"];
        $fecha_actual = new DateTime();
        $nombreArchivo_foto_perfil = $fecha_actual->getTimestamp() . "_" . $foto_producto;
        $tmp_foto = $_FILES["foto_producto"]["tmp_name"];
        move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto_perfil);

        // Borrar el archivo anterior si existe
        $sentencia = $conexion->prepare("SELECT foto_producto FROM tbl_productos WHERE id = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registro_recuperado["foto_producto"]) && $registro_recuperado["foto_producto"] != "") {
            if (file_exists("./img/" . $registro_recuperado["foto_producto"])) {
                unlink("./img/" . $registro_recuperado["foto_producto"]);
            }
        }

        // Actualizar el registro con la nueva foto
        $sentencia = $conexion->prepare("UPDATE tbl_productos SET foto_producto=:foto_producto WHERE id=:id");
        $sentencia->bindParam(":foto_producto", $nombreArchivo_foto_perfil);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    // Redirección con mensaje
    $mensaje = "Registro Editado";
    header("Location: ../../views/productos.php?mensaje=" . urlencode($mensaje));
    exit;
}


// Selecciona la información de los puestos
$sentencia_categorias = $conexion->prepare("SELECT * FROM `tbl_categorias`");
$sentencia_categorias->execute();
$lista_tbl_categorias = $sentencia_categorias->fetchAll(PDO::FETCH_ASSOC);
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
                                <h1> Modificar Producto</h1>
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
                                    <input type="text" class="form-control" id="txtID" name="txtID" value="<?php echo $txtID; ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-4"></div>
                        </div>


                        <!-- Primer row  -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="codigo_producto">Codigo de producto</label>
                                    <input  style="border:1.5px solid #48e" type="text"
                                    class="form-control"  value="<?php echo $codigo_producto; ?>" 
                                    id="codigo_producto" name="codigo_producto" placeholder="Ingrese el codigo">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="codigo_barra">Codigo de barra</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" value="<?php echo $codigo_barra; ?>"
                                    id="codigo_barra" name="codigo_barra" placeholder="Ingrese el codigo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_producto">Nombre del producto</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" value="<?php echo $nombre_producto; ?>" 
                                     id="nombre_producto" name="nombre_producto" placeholder="Ingrese el producto">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="idnombre_categoria" class="form-label">Categoria</label>
                                <select class="form-control custom-select" name="idnombre_categoria"
                                 id="idnombre_categoria">
                                    <?php foreach($lista_tbl_categorias as $registro_categorias): ?>
                                        <option value="<?php echo $registro_categorias['id']; ?>">
                                        <?php echo $registro_categorias['nombre_categoria']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Termina el primero  -->
                        <br> 
                        <!-- Segunda row  -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control"value="<?php echo $marca;?>"
                                     id="marca" name="marca" placeholder="Ingresar la marca">
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="medida">Medida </label>
                                    <select name="medida" class="form-control custom-select" >
                                        <option value="">Seleccionar Tipo </option>
                                        <option value="kilo" <?php echo ($medida=="kilo")?"selected":"";?> >Kilo</option>
                                        <option value="kilogramo" <?php echo ($medida=="kilogramo")?"selected":"";?> >Kilograma</option>
                                        <option value="gramo" <?php echo ($medida=="gramo")?"selected":"";?> >Gramo</option>
                                        <option value="unidad" <?php echo ($medida=="unidad")?"selected":"";?> >Unidad</option>
                                        <option value="lata" <?php echo ($medida=="lata")?"selected":"";?> >Lata</option>
                                        <option value="litro" <?php echo ($medida=="litro")?"selected":"";?> >Litro</option>
                                        <option value="saco" <?php echo ($medida=="saco")?"selected":"";?> >Saco</option>
                                        <option value="tarjeta" <?php echo ($medida=="tarjeta")?"selected":"";?> >Tarjeta</option>
                                        <option value="caja" <?php echo ($medida=="caja")?"selected":"";?> >Caja</option>
                                        <option value="sobre" <?php echo ($medida=="sobre")?"selected":"";?> >Sobre</option>
                                        <option value="galon" <?php echo ($medida=="galon")?"selected":"";?> >Galon</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input  style="border:1.5px solid #48e" type="text"
                                     class="form-control" value="<?php echo $cantidad;?>" 
                                    id="cantidad" name="cantidad" placeholder="Ingrese la cantidad">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precio_compra">Precio Compra</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" value="<?php echo $precio_compra;?>" 
                                    id="precio_compra" name="precio_compra" placeholder="Ingrese el precio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precio_venta">Precio Venta</label>
                                    <input  style="border:1.5px solid #48e" type="text" 
                                    class="form-control" value="<?php echo $precio_venta;?>" 
                                     id="precio_venta" name="precio_venta" placeholder="Ingrese el precio">
                                </div>
                            </div>
                        </div>
                            <!-- Termina el segundo  -->
                        <br> 
                     <!-- Tercer row  -->
                        <div class="row">
                            
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estado">Estado </label>
                                <select name="estado" class="form-control custom-select">
                                    <option value="">Seleccionar Tipo </option>
                                    <option value="activo" <?php echo ($estado=="activo") ? "selected" : ""; ?> >Activo</option>
                                    <option value="inactivo" <?php echo ($estado=="inactivo") ? "selected" : ""; ?> >Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="moneda">Moneda </label>
                                <select name="moneda" class="form-control custom-select">
                                    <option value="">Seleccionar Tipo </option>
                                    <option value="soles" <?php echo ($moneda=="soles") ? "selected" : ""; ?> >Soles</option>
                                    <option value="dolares" <?php echo ($moneda=="dolares") ? "selected" : ""; ?> >Dolares</option>
                                </select>
                            </div>
                        </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                        <label for="foto_producto">Foto (Opcional)</label>
                                        <img id="previewImage" width="100" src="<?php echo $foto_producto; ?>" 
                                        class="img-fluid rounded" alt="imagen">
                                        <input  style="border:1.5px solid #48e" 
                                        type="file" id="foto_producto" name="foto_producto"
                                        class="form-control-file">
                                </div>
                            </div>
                        </div>
                            <!-- Termina el tercero  -->


                        <br><br><br>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="margin:10px;background-color: #48e;">
                                        <img src="<?php echo $url_base; ?>assets/img/guardarycerrar/guardar2.png" alt="">Modificar
                                    </button>
                                    <a href="../../views/productos.php" class="btn btn-secondary" style="margin: 10px; background-color: #48e;">
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