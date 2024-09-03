<?php
   session_start();//Para poder utilizar las variables de "$_SESSION" debo iniciar la sesion. "session_start();"
   require '../../config/db.php';
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
    <div class="wrapper">
        <form action="../../repository/contraseñacambiada.php" method="POST">
            <center><img src="../../img/logo.jpeg" class="LogoRegistro">
            </center>
            <h1>CAMBIAR CONTRASEÑA</h1>
            <div class="input-box">
                <input type="text" placeholder="Contraseña Nueva" name="contrasena" required>
                <i class='bx bxs-user'></i>
            </div>
            <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<h1 class="bad">' . $_SESSION['error_message'] . '</h1>';
                    unset($_SESSION['error_message']); 
                }
            ?>
            <button type="submit" class="btn">Cambiar Contraseña</button>
        </form>
    </div>
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="BOX">
                <figure>
                    <a href="paginaInicio.php">
                        <img src="../../img/logo.jpeg" alt="Logo AutoSplash" class="logo-pie" height="200px">
                    </a>
                </figure>
            </div>
            <div class="grupo-2">
                <small>&copy; 2024 <b>GlowDrive</b> - Todos Los Derechos Reservados.</small>
            </div>
    </footer>
</body>