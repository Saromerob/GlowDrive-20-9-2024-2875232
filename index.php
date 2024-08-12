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
                <a class="navbar-brand" href="../app-autosplash/index.php">
                    <img src="../app-autosplash/img/logo.jpeg" alt="Logo" id="logo" class="logo">
                    <div class="titulo">AUTO-SPLASH</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                    <div class="citas">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../app-autosplash/views/cliente/agendar_cita.php">Agendar Citas</a>
                        </li>
                    </div>
                    <div class="ubi">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../app-autosplash/views/cliente/Mapa.php">Mapa</a>
                        </li>
                        </div>
                        <div class="conocenos">
                        <li class="nav-item">
                            <a class="nav-link" href="../app-autosplash/views/Nosotros.php">Conócenos</a>
                        </li>
                    </div>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="navbar-brand ms-auto" href="Login.html">
                            </a>
                            <div class="sesion">
                                <a class="nav-link" href="../app-autosplash/views/session/sesion.php"><p class="ini"><img src="Img/user.png" class="user1">Iniciar Sesión</p></a>
                            </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <br><br>
    <div class="wrapper">
        <div class="banner-info">
        <h1 class="info">¿Que es este aplicativo?</h1>
        <h4>
            <p class="info">Como equipo de desarrollo del SENA, hemos diseñado una aplicación móvil 
                que conecta a usuarios con servicios de lavado de automóviles cercanos. 
                Hemos creado una solución escalable y eficiente que permite a los usuarios 
                encontrar y reservar lavados de manera rápida y sencilla, a la vez que ofrece 
                a los negocios una mayor visibilidad. A través de un proceso de desarrollo ágil, 
                hemos priorizado la experiencia del usuario y la integración de funcionalidades 
                como geolocalización y pagos en línea. Esta aplicación representa una solución 
                innovadora para la industria del lavado de automóviles, facilitando la interacción 
                entre usuarios y negocios locales.
            </p>
        </h4>
        <img src="../app-autosplash/img/Carro.jpg" alt="Imagen Autosplash" class="Carro">
    </div>
</div>

</h1>
</div>
<br><br>



    <!--ESTE ES EL PIE DE PAGINA DE PARA ARRIBA VA TODA INFORMACIÓN DE CUALQUIER TIPO EN LA PAGINA DE INICIO-->
    <footer class="pie-pagina">
        <div class="grupo-1"> 
            <div class="BOX">
                <figure>
                    <a href="../app-autosplash/index.php">
                        <img src="../app-autosplash/img/logo.jpeg" alt="Logo AutoSplash" class="logo">
                    </a>
                </figure>
            </div>
            <div class="BOX">
                <h2 ><a href="../app-autosplash/views/Nosotros.php" class="nosotros">SOBRE NOSOTROS</a></h2>
                <p> TEXTO EJEMPLO</p>
                <p> </p>
            </div>
            <div class="BOX">
            <h2> Siguenos: </h2>
            <div class="red-social">
                <center>
                <a href="www.instagram.com" class="instagram">
                    <img src="Img/instagram.jpg" height="50px" class="insta">
                </a>
                <a href="#" class="tik-tok">
                    <img src="Img/tiktok.png" height="50px" class="tito">
                </a>
                <a href="#" class="whatsapp">
                    <img src="Img/whatsapp.png" height="55px" class="wha">
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