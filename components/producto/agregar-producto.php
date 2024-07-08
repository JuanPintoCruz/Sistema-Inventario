<?php 
 include("../../BD/bd.php");
include("../../sesion.php");
?>
<?php 


$medida = "";
$moneda = "";
$estado = "";
// Verifica si se ha enviado el formulario por POST
if($_POST){
    $idnombre_categoria = isset($_POST["idnombre_categoria"]) ? $_POST["idnombre_categoria"] : "";
    $codigo_producto = isset($_POST["codigo_producto"]) ? $_POST["codigo_producto"] : "";
    $codigo_barra = isset($_POST["codigo_barra"]) ? $_POST["codigo_barra"] : "";
    $nombre_producto = isset($_POST["nombre_producto"]) ? $_POST["nombre_producto"] : "";
    $marca = isset($_POST["marca"]) ? $_POST["marca"] : "";
    $medida = isset($_POST["medida"]) ? $_POST["medida"] : "";
    $precio_compra = isset($_POST["precio_compra"]) ? $_POST["precio_compra"] : "";

    $precio_venta = isset($_POST["precio_venta"]) ? $_POST["precio_venta"] : "";
    $estado  = isset($_POST["estado"]) ? $_POST["estado"] : "";
    $moneda = isset($_POST["moneda"]) ? $_POST["moneda"] : "";
    $cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : "";

    // Recolecta los nombres de los archivos de las imágenes enviadas
    $foto_producto = isset($_FILES["foto_producto"]["name"]) ? $_FILES["foto_producto"]["name"] : "";

    // Prepara la consulta SQL para insertar los datos del empleado
    $sentencia = $conexion->prepare("INSERT INTO `tbl_productos` 
    (`codigo_producto`, `codigo_barra`, `nombre_producto`, `idnombre_categoria`, 
    `marca`, `medida`, `precio_compra`, `precio_venta`,
     `estado`, `moneda`, `cantidad`, `foto_producto`) 
    VALUES (:codigo_producto, :codigo_barra, :nombre_producto, :idnombre_categoria, :marca, :medida, :precio_compra, 
    :precio_venta, :estado, :moneda, :cantidad, :foto_producto)");
 
    // Asigna los valores a los parámetros de la consulta
    // Consulta de empresas
    $sentencia->bindParam(":codigo_producto", $codigo_producto);
    $sentencia->bindParam(":codigo_barra", $codigo_barra);
    $sentencia->bindParam(":nombre_producto", $nombre_producto);
    $sentencia->bindParam(":idnombre_categoria", $idnombre_categoria);
    $sentencia->bindParam(":marca", $marca);
    $sentencia->bindParam(":medida", $medida);
    $sentencia->bindParam(":precio_compra", $precio_compra);

    // Consulta de los clientes
    $sentencia->bindParam(":precio_venta", $precio_venta);
    $sentencia->bindParam(":estado", $estado );
    $sentencia->bindParam(":moneda", $moneda);
    $sentencia->bindParam(":cantidad", $cantidad);


    // Obtener la fecha actual para el nombre de archivo único
    $fecha_actual = new DateTime();
    $nombreArchivo_foto = ($foto_producto != '') ? $fecha_actual->getTimestamp() . "_" . $foto_producto : "";
    // Obtener la ubicación temporal del archivo cargado
    $tmp_foto = isset($_FILES["foto_producto"]["tmp_name"]) ? $_FILES["foto_producto"]["tmp_name"] : "";
    // Si se cargó una foto, mueve el archivo a la ubicación deseada
    if ($tmp_foto != '') {
         move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto);
    }
    // Asignar el nombre de archivo al parámetro de la consulta
    $sentencia->bindParam(":foto_producto", $nombreArchivo_foto);

    $sentencia->execute();
    $mensaje="Registro Agregado";
    header("Location: ../../views/productos.php?mensaje=".$mensaje);
    exit; 
}
// Selecciona la información de los puestos
$sentencia_categorias = $conexion->prepare("SELECT * FROM `tbl_categorias`");
$sentencia_categorias->execute();
$lista_tbl_categorias = $sentencia_categorias->fetchAll(PDO::FETCH_ASSOC);
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
                                <h1> Agregar Productos</h1>
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
                    <br> 
                        <!-- Primer row  -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="codigo_producto">Codigo de producto</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="codigo_producto" name="codigo_producto" placeholder="Ingrese el codigo">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="codigo_barra">Codigo de barra</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="codigo_barra" name="codigo_barra" placeholder="Ingrese el codigo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_producto">Nombre del producto</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="nombre_producto" name="nombre_producto" placeholder="Ingrese el producto">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="idnombre_categoria" class="form-label">Categoria</label>
                                <select class="form-control custom-select" name="idnombre_categoria" id="idnombre_categoria">
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
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
                                     id="marca" name="marca" placeholder="Ingresar la marca">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="medida">Medida </label>
                                    <select name="medida" class="form-control custom-select">
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
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="cantidad" name="cantidad" placeholder="Ingrese la cantidad">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precio_compra">Precio Compra</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control" 
                                    id="precio_compra" name="precio_compra" placeholder="Ingrese el precio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precio_venta">Precio Venta</label>
                                    <input  style="border:1.5px solid #48e" type="text" class="form-control"
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
                                        <option value="activo" <?php echo ($medida=="activo")?"selected":"";?> >Activo</option>
                                        <option value="Inactivo" <?php echo ($medida=="inactivo")?"selected":"";?> >Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="moneda">Moneda </label>
                                    <select name="estado" class="form-control custom-select">
                                        <option value="">Seleccionar Tipo </option>
                                        <option value="soles" <?php echo ($medida=="soles")?"selected":"";?> >Soles</option>
                                        <option value="dolares" <?php echo ($medida=="dolares")?"selected":"";?> >Dolares</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                        <label for="foto_producto">Foto (Opcional)</label>
                                        <input  style="border:1.5px solid #48e" 
                                        type="file" id="foto_producto" name="foto_producto"
                                        class="form-control-file">
                                </div>
                            </div>
                        </div>
                            <!-- Termina el tercero  -->
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