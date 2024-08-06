<?php
   session_start();//Para poder utilizar las variables de "$_SESSION" debo iniciar la sesion. "session_start();"
   require '../../config/db.php';
   include '../../repository/localidad.php';
   include '../../repository/tipo_documento.php';
   //mysqli_close($conn);
   if (isset($_SESSION['nombre'])) {
    switch ($_SESSION['role_id']) {
        case 1:
            header("Location: ../admin/paginaInicio.php");
            exit();
            break;
        case 2:
            header("Location: ../cliente/paginaInicio.php");
            break;  
        default:
    }
   }
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
    <div>
        <p id="successMessage" style="color: black;"></p>
        <!-- Todo: HACER modal para mostrar el mensaje del registro exitoso. tener en cuenta que el modal debe ir arriba del php en donde se esta trayendo la $_SESSION
        toca que tener tambien muy en cuenta que la etiqueta que se vya a mostrar en este caso ' id="successMessage" ' porque es el que esta trayendo el mensaje desde
        el script de PHP -->
    </div>
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
        <form action="../../repository/validar.php" method="POST">
            <center><img src="../../img/logo.jpeg" class="LogoRegistro">
            </center>
            <h1>INICIO DE SESION</h1>
            <div class="input-box">
                <input type="text" placeholder="Nombre de usuario" name="usuario" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Contraseña" name="contraseña" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<h1 class="bad">' . $_SESSION['error_message'] . '</h1>';
                    unset($_SESSION['error_message']); 
                }
            ?>
            <div class="Recuerdame">
                <label>
                    <input type="checkbox">Recuerdame la clave
                </label><br><br>
                <a href="" class="link">¿Olvide mi Contraseña?</a>
            </div>
            <button type="submit" class="btn">Ingresar</button>
            <div class="register-link">
                <p>¿No tienes una cuenta? <a href="Registro.php">Registrate</a></p>
            </div>
        </form>
    </div>
</body>