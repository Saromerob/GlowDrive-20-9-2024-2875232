<?php
   session_start();//Para poder utilizar las variables de "$_SESSION" debo iniciar la sesion. "session_start();"
   require '../../config/db.php';
   include '../../repository/localidad.php';
   include '../../repository/tipo_documento.php';
   //mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/Estilos1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    //include_once 'conexionPDO.php';
    if(isset($_POST['cerrar_sesion']))
        {
            include_once 'useCase/logOut.php';
            /*session_unset();
            session_destroy();*/
            /*header("Location: ../index.php");*/ // Redirige al usuario a la página de inicio de sesión
        }
        if (isset($_SESSION['success'])) {
            echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("successMessage").innerText = "' . $_SESSION['success'] . '";
                        $("#successModal").modal("show");
                    });
                </script>';
            unset($_SESSION['success']); 
        }
    ?>
    <div class="wrapper">
        <form action="../../repository/contra.php" method="POST">
            <center><img src="../../img/logo.jpeg" class="LogoRegistro">
            </center>
            <h1>RECUPERAR CONTRASEÑA</h1>
            <div class="input-box">
                <input type="text" placeholder="Email" name="correo" required>
                <i class='bx bxs-user'></i>
            </div>
            <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<h1 class="bad">' . $_SESSION['error_message'] . '</h1>';
                    unset($_SESSION['error_message']); 
                }
            ?>
            <button type="submit" class="btn">Enviar Contraseña</button>
            <div class="register-link">
                <p>¿Ya tienes una cuenta? <a href="../session/sesion.php">Inicia Sesion</a></p>
            </div>
        </form>
    </div>
</body>