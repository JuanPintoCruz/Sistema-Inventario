
<?php 
session_start();

if(isset($_POST["usuario"]) && isset($_POST["password"])) {
    include("BD/bd.php");
    
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    
    $sentencia = $conexion->prepare("SELECT *, count(*) as n_usuario 
    FROM tbl_usuarios WHERE usuario = :usuario AND password = :password");
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->execute();
    
    $lista_tbl_usuarios = $sentencia->fetch(PDO::FETCH_ASSOC);
    
    $n_usuario = $lista_tbl_usuarios["n_usuario"];

    if($n_usuario == 1){
       $_SESSION["usuario"] = $lista_tbl_usuarios["usuario"];
       $_SESSION["logueado"] = true;
       header("Location:index.php");
       exit;
    } else {
        echo "Usuario o contraseña incorrecta";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Login Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<body>
<div class="container">
    <br> <br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card" style="border:4px solid #48e;border-radius:30px;">
            <br>
            <h1 class="text-center"  style="color:#48e;font-weight:bold;font-size:30px;">Inicio de Sesión</h1>
                <div class="card-body">
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="usuario" class="form-label"><img src="assets/img/login/usuario.png"  width="40" height="40"alt=""> <strong>Usuario:</srtong></label>
                            <br>
                            <input class="form-control" type="text" name="usuario" id="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><img src="assets/img/login/password.png"   width="40" height="40"alt=""><strong>Contraseña:</strong></label>
                            <br>
                            <input class="form-control" type="password" name="password" id="password" required>
                        </div>
                        <br>
                        <div class="text-center">
                            <button  class="btn btn-primary" type="submit" >Iniciar Sesion</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="card-footer text-muted text-center">© 2024 Company Name</div> -->
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>