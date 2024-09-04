<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/Estilos3.css">

</head>
<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header('location: ../../useCase/logOut.php');
    die();
}
?>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="paginaInicio.php">
                <img src="../../img/logo.jpeg" alt="Logo" id="logo">
                <div class="titulo">GLOW-DRIVE</div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <div class="marcos">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin_panel.php">Ver
                                Solicitudes</a>
                        </li>
                    </div>
                    <div class="marcos">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="crearUsuario.php">Administrar
                                Usuarios</a>
                        </li>
                    </div>
                    <div class="marcos">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin_autolavados.php">Administrar
                                Autolavados</a>
                        </li>
                    </div>
                    <div class="marcos">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="public_map.php">Ver Autolavados
                                aprobados
                                en el mapa</a>
                        </li>
                    </div>
                    <div class="marcos">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="../perfil/cambiarcontraAdmin.php">Cambiar
                                Contraseña</a>
                        </li>
                    </div>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="navbar-brand ms-auto" href="../../index.php">
                        </a>
                        <div class="sesion">
                            <a class="nav-link" href="../../useCase/logOut.php">
                                <p class="ini"> <img src="../../img/user.png" class="user1">Cerrar Sesión</p>
                            </a>
                        </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>