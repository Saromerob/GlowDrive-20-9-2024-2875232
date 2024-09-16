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
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../styles/Estilos1.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <form action="../../repository/contraseñacambiada.php" method="POST">
            <center><img src="../../img/logo.jpeg" class="LogoRegistro" alt="Logo" style="width: 150px; border-radius: 50%;"></center>
            <h1>CAMBIAR CONTRASEÑA</h1>
            <div class="input-box">
                <input type="password" placeholder="Contraseña Nueva" name="contrasena" required>
                <i class='bx bxs-lock'></i>
            </div>
            <?php if (isset($_SESSION['error_message'])): ?>
                <p class="bad" style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            <button type="submit" class="btn">Cambiar Contraseña</button>
            <button type="button" class="btn-outline-light" onclick="window.location.href='../cliente/paginaInicio.php';">
                Volver
            </button>
        </form>
    </div>
    <footer>
        <div>&copy; 2024 <b>GlowDrive</b> - Todos Los Derechos Reservados.</div>
    </footer>
</body>

</html>
