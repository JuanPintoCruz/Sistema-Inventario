<?php 
 include("../BD/bd.php");
include("../sesion.php");
?>

<?php 


// Verifica si se ha enviado el formulario por POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Recolecta los datos del formulario
    // Datos de la empresa 
    $nombre_empresa = isset($_POST["nombre_empresa"]) ? $_POST["nombre_empresa"] : "";
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $ruc_dni = isset($_POST["ruc_dni"]) ? $_POST["ruc_dni"] : "";
    $pais = isset($_POST["pais"]) ? $_POST["pais"] : "";
    $departamento = isset($_POST["departamento"]) ? $_POST["departamento"] : "";
    $provincia = isset($_POST["provincia"]) ? $_POST["provincia"] : "";
    $distrito = isset($_POST["distrito"]) ? $_POST["distrito"] : "";


// Datos del cliente
    $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
    $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    $extras = isset($_POST["extras"]) ? $_POST["extras"] : "";


    // Recolecta los nombres de los archivos de las imágenes enviadas
    $foto_proveedor = isset($_FILES["foto_proveedor"]["name"]) ? $_FILES["foto_proveedor"]["name"] : "";


    // Prepara la consulta SQL para insertar los datos del empleado
    $sentencia = $conexion->prepare("INSERT INTO `tbl_proveedores` 
    (`nombre_empresa`, `nombre`, `ruc_dni`, `pais`, 
    `departamento`, `provincia`, `distrito`, `direccion`,
     `telefono`, `correo`, `extras`, `foto_proveedor`) 
    VALUES (:nombre_empresa, :nombre, :ruc_dni, :pais, :departamento, :provincia, :distrito, 
    :direccion, :telefono, :correo, :extras, :foto_proveedor)");

    // Asigna los valores a los parámetros de la consulta

    // Consulta de empresas
    $sentencia->bindParam(":nombre_empresa", $nombre_empresa);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":ruc_dni", $ruc_dni);
    $sentencia->bindParam(":pais", $pais);
    $sentencia->bindParam(":departamento", $departamento);
    $sentencia->bindParam(":provincia", $provincia);
    $sentencia->bindParam(":distrito", $distrito);

    // Consulta de los clientes
    $sentencia->bindParam(":direccion", $direccion);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":extras", $extras);
    $sentencia->bindParam(":telefono_contacto", $telefono_contacto);

    // Obtener la fecha actual para el nombre de archivo único
    $fecha_actual = new DateTime();
    $nombreArchivo_foto = ($foto_proveedor != '') ? $fecha_actual->getTimestamp() . "_" . $foto_proveedor : "";
    // Obtener la ubicación temporal del archivo cargado
    $tmp_foto = isset($_FILES["foto_proveedor"]["tmp_name"]) ? $_FILES["foto_proveedor"]["tmp_name"] : "";
    // Si se cargó una foto, mueve el archivo a la ubicación deseada
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./img/" . $nombreArchivo_foto);
    }
    // Asignar el nombre de archivo al parámetro de la consulta
    $sentencia->bindParam(":foto_proveedor", $nombreArchivo_foto);

    try {
        $sentencia->execute();
        echo "<script>alert('Cliente  agregado correctamente.');</script>";
        echo "<script>window.location.href='../clientes.php';</script>";
    } catch (PDOException $e) {
        echo "Error al crear el colaborador: " . $e->getMessage();
    }
}

// Selecciona la información de los puestos
$sentencia_tbl_proveedores = $conexion->prepare("SELECT * FROM `tbl_proveedores`");
$sentencia_tbl_proveedores->execute();
$lista_tbl_proveedores = $sentencia_tbl_proveedores->fetchAll(PDO::FETCH_ASSOC);
?>