<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adm";

try {
  $conexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Establecer el modo de error de PDO a excepción
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}
?>