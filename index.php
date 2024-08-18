<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="views/styles/Estilos3.css">

</head>

<body>
    <div class="contenedor-principal">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/logo.jpeg" alt="Logo" id="logo">
                    <div class="titulo">AUTO-SPLASH</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <div class="marcos">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="views/session/sesion.php">Agendar
                                    Citas</a>
                            </li>
                        </div>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="sesion.php" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Ubicaciones
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Calle 13 #45-65</a></li>
                                <li><a class="dropdown-item" href="#">Av Boyacá- Calle 44B Sur</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="views/Nosotros.php">Conócenos</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="navbar-brand ms-auto" href="../index.php">
                            </a>
                            <div class="sesion">
                                <a class="nav-link" href="views/session/sesion.php">
                                    <p class="ini"> <img src="img/user.png" class="user1">Iniciar Sesión</p>
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
    </div>



    <!--ESTE ES EL PIE DE PAGINA DE PARA ARRIBA VA TODA INFORMACIÓN DE CUALQUIER TIPO EN LA PAGINA DE INICIO-->
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="BOX">
                <FIGUre>
                    <a href="index.php">
                        <img src="../app-autosplash/img/logo.jpeg" alt="Logo AutoSplash" height="200px">
                    </a>
                </FIGUre>
            </div>
            <div class="BOX">
                <h2>SOBRE NOSOTROS</h2>
                <p> TEXTO EJEMPLO</p>
                <p> </p>
            </div>
            <div class="BOX">
                <h2> Siguenos: </h2>
                <div class="red-social">
                    <center>
                        <a href="www.instagram.com" class="instagram">
                            <img src="img/instagram.jpg" height="50px" class="insta">
                        </a>
                        <a href="#" class="tik-tok">
                            <img src="img/tiktok.png" height="50px" class="tito">
                        </a>
                        <a href="#" class="whatsapp">
                            <img src="img/whatsapp.png" height="55px" class="wha">
                        </a>
                    </center>
                </div>
            </div>
            <div class="grupo-2">
                <small>&copy; 2024<b>AutoSplash</b>-Todos Los Derechos Reservados.</small>

            </div>
    </footer>
</body>

</html>