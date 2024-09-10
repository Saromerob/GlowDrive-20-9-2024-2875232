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
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <div>
                        <p class="ini"><br>
                            <button type="button" class="btn btn-outline-light"
                                onclick="window.location.href='../cliente/paginaInicio.php';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                    <path fill-rule="evenodd"
                                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                </svg>
                                Volver
                            </button>
                        </p>
                    </div>
                </li>
            </ul>
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