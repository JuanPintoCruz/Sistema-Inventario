<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- <link rel="icon" type="image/x-icon" href="img/logo.png"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
</body>
</html>
<?php

session_start(); // Inicia la sesión antes de verificar si el usuario está autenticado

$url_base = "http://localhost/admin3/";

// Preguntar si el usuario no está autenticado
if(!isset($_SESSION["usuario"])){
    // Redirigir al usuario a la página de inicio de sesión
    header("Location:".$url_base."login.php");
    exit; // Asegúrate de salir del script después de redirigir al usuario
}

?>