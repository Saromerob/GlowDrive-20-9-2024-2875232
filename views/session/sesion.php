sesión


sesión






<?php
   session_start();//Para poder utilizar las variables de "$_SESSION" debo iniciar la sesion. "session_start();"
   require '../../config/db.php';
   include '../../repository/localidad.php';
   include '../../repository/tipo_documento.php';
   //mysqli_close($conn);
   if (isset($_SESSION['nombre'])) {
    switch ($_SESSION['role_id']) {
        case 1:
            header("Location: ../gerente/paginaInicio.php");
            exit();
            break;
        case 2:
            header("Location: ../cliente/paginaInicio.php");
            break;
        case 3:
            header("Location: ../admin/paginaInicio.php");
            exit();
            break;
        default:
    }
   }


// Mostrar el mensaje de éxito
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success fade-out">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Borra el mensaje después de mostrarlo
}

// Mostrar el mensaje de error
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger fade-out">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // Borra el mensaje después de mostrarlo
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/estilosesion.css">
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
    <center>
        <div class="wrapper">
            <form action="../../repository/validar.php" method="POST">
                <div class="logo-container">
                    <img src="../../img/logo.jpeg" class="LogoRegistro" alt="Logo">
                </div>
                <h1>INICIO DE SESION</h1>
                <div class="input-box">
                    <input type="text" placeholder="Nombre de usuario" name="usuario" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Contraseña" name="contraseña" id="contrasena" required>
                    <img id="imagenOjo" src="../../img/ojito.png" height="20px" width="20px" 
                    style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%); cursor: pointer;"
                    onmousedown="mostrarContrasena()" 
                    onmouseup="ocultarContrasena()">
                    <script>
                        var contrasenaInput = document.getElementById("contrasena");
                        var imagenOjo = document.getElementById("imagenOjo");

                        function mostrarContrasena() {
                            contrasenaInput.type = "text";
                            imagenOjo.src = "../../img/ojito.png"; // Cambia la imagen al presionar
                        }

                        function ocultarContrasena() {
                            contrasenaInput.type = "password";
                            imagenOjo.src = "../../img/ojocerrado.png"; // Cambia la imagen al soltar
                        }
                    </script>
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
                    </label>
                    <a href="../perfil/recuperarContra.php" class="link">¿Olvide mi Contraseña?</a>
                </div>
                <button type="submit" class="btn">Ingresar</button>
                <div class="register-link">
                    <p>¿No tienes una cuenta? <a href="Registro.php">Registrate</a></p>
                </div>
            </form>
        </div>
    </center>

    <!--ESTE ES EL PIE DE PAGINA DE PARA ARRIBA VA TODA INFORMACIÓN DE CUALQUIER TIPO EN LA PAGINA DE INICIO-->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="../../img/logo.jpeg" alt="Logo AutoSplash">
            </div>
            <div class="footer-about">
                <h2>Sobre Nosotros</h2>
                <p>GlowDrive es la aplicación líder en servicios de lavado de automóviles, conectando usuarios con los
                    mejores lavados cercanos.</p>
            </div>
            <div class="footer-social">
                <h2>Síguenos:</h2>
                <div class="social-icons">
                    <a href="https://www.instagram.com" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-instagram" viewBox="0 0 16 16">
                            <path
                                d="M8 0C5.829 0 5.556.01 4.703.048C3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7C.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297c.04.852.174 1.433.372 1.942c.205.526.478.972.923 1.417c.444.445.89.719 1.416.923c.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417c.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zM8 1.442h.718c2.136 0 2.389.007 3.232.046c.78.035 1.204.166 1.486.275c.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485c.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598c-.28.11-.704.24-1.485.276c-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598a2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485c-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486c.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276c.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92a.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217a4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334a2.667 2.667 0 0 1 0-5.334z" />
                        </svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-tiktok" viewBox="0 0 16 16">
                            <path
                                d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
                        </svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path
                                d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654l.666-2.433l-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931a6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646c-.182-.065-.315-.099-.445.099c-.133.197-.513.646-.627.775c-.114.133-.232.148-.43.05c-.197-.1-.836-.308-1.592-.985c-.59-.525-.985-1.175-1.103-1.372c-.114-.198-.011-.304.088-.403c.087-.088.197-.232.296-.346c.1-.114.133-.198.198-.33c.065-.134.034-.248-.015-.347c-.05-.099-.445-1.076-.612-1.47c-.16-.389-.323-.335-.445-.34c-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992c.47.205.84.326 1.129.418c.475.152.904.129 1.246.08c.38-.058 1.171-.48 1.338-.943c.164-.464.164-.862.114-.944c-.05-.084-.182-.133-.38-.232z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <small>&copy; 2024 <b>GlowDrive</b> - Todos los Derechos Reservados.</small>
        </div>
    </footer>
</body>