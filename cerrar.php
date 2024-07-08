<?php 
session_start();
session_destroy();

echo "Se destruyo la session del usuario";
header("location:login.php");
?>