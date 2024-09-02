<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="views/styles/Estilos3.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<style>
    * 
    {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }
    body
    {
        justify-content: center;
    }
    .wrapper
    {
        background: transparent;
        border: rgba(255, 255, 255, .2);
        backdrop-filter: blur(20px);
        box-shadow: 7px 13px 37px #000;
        border-radius: 20px;
        padding: 30px 40px;
        position: center;
        margin: 20px 20px 20px 20px
    }
    .wrapper h1
    {
        font-size: 36px;
        text-align: center;
    }
    .wrapper .input-box
    {
        position: relative;
        width: 100%;
        height: 50px;
        margin: 30px 0;
    }
    .wrapper .Recuerdame
    {
        display: flex;
        justify-content: space-between;
        font-size: 14.5px;
        margin: -15 0 15px;    
    }
    .logo
    {
        border-radius: 50%;
    }
    .carro
    {
        border-radius: 30px;
    }
    .que
    {
        color: #000;
    }
    p
    {
        font-size: 20px
    }
    .marcos
    {
        border: 2px solid black;
        text-align: center;
        border-radius: 20px;
        margin: 10px ;
        background-color: #ffffff;
    }
    .sesion
    {
        border: 2px solid white;
        text-align: center;
        border-radius: 20px;
        background-color: #98C8BC;
    }
    .ir
    {
        text-decoration:none;
        position: relative;
        bottom: 2px;
    }
    img {
        max-width: 100%;
        height: auto; /* Mantiene la proporción de la imagen */
    }
    .nav-item {
        display: flex; /* Convertimos el elemento en un contenedor flex */
        align-items: center; /* Alineamos los elementos verticalmente al centro */
    }
    .bx.bxs-car
    {
        /* Estilos adicionales para el icono si es necesario */
        margin: 8px; /* Añade un margen derecho al icono para separar del texto */
        font-size: 20px;
    }
    .bx.bxs-location-plus
    {
        margin: 8px; /* Añade un margen derecho al icono para separar del texto */
        font-size: 20px;
    }
    .bx.bx-search-alt
    {
        margin: 8px; /* Añade un margen derecho al icono para separar del texto */
        font-size: 20px;
    }
    .bx.bxs-user
    {
        margin: 8px; /* Añade un margen derecho al icono para separar del texto */
        font-size: 20px;
    }
    .nav-link {
        font-size: 16px; /* Ajusta según tus necesidades */
        padding: 10px 20px; /* Ajusta el relleno interno del enlace */
    }
    .sesion {
  /* ... otros estilos ... */
    display: inline-block; /* O flex, si quieres más control sobre el diseño */
    }
    @media (max-width: 768px) {
        /* Estilos para pantallas pequeñas */
        .nav-link {
            font-size: 14px;
            padding: 8px 16px;
        }
    }
    .nav-link {
        display: flex;
        align-items: center;
    }
    .nav-link {
        padding: 5px 10px; /* Ajusta los valores según tus necesidades */
    }
    .navbar-nav 
    {
    display: flex;
    justify-content: space-between;
    }

    .nav-item 
    {
        flex-shrink: 0;
    }
    /* Media query para pantallas pequeñas */
    @media (max-width: 20px) 
    {
        .nav-link {
            padding: 5px 8px;
        }
    }
    /* ... (tu código CSS existente) */
    .pie-pagina {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }

    footer img {
        max-width: 100%;
        height: auto;
    }

    @media (max-width: 768px) {
        footer img {
            width: 100px;
        }
    }
</style>
</head>

<body>
    <div class="contenedor-principal">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/logo.jpeg" alt="Logo" id="logo" class="logo">
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
                                <a class="nav-link active" aria-current="page" href="../app-autosplash/views/session/sesion.php">
                                <i class='bx bxs-car'></i>       
                                Agendar Citas
                                </a>
                            </li>
                        </div>
                        <div class="marcos">
                        <li class="nav-item">                        
                            <a class="nav-link " href="../app-autosplash/views/session/sesion.php" role="button" aria-expanded="false">
                            <i class='bx bxs-location-plus' ></i>    
                            Ubicaciones
                            </a>
                        </li>
                        </div>
                        <div class="marcos">
                        <li class="nav-item">                        
                            <a class="nav-link" href="../app-autosplash/views/session/sesion.php">
                            <i class='bx bx-search-alt'></i>    
                            Conócenos
                            </a>
                        </li>
                        </div>
                    </ul>
                    <ul class="navbar-nav mx-auto">
                        <div class="sesion">
                            <li class="nav-item">
                                <a class="nav-link" href="../app-autosplash/views/session/sesion.php">
                                    <i class='bx bxs-user'></i>
                                    Iniciar Sesión
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script><br><br>
        <center><div class="wrapper">
        <h1 class="que">¿Qué es este aplicativo?</h1>
        <p>Como equipo de desarrollo del SENA,hemos diseñado una aplicación móvil 
        que conecta a usuarios con servicios de lavado de automóviles cercanos. 
        Hemos creado una solución escalable y eficiente que permite a los usuarios
        encontrar y reservar lavados de manera rápida y sencilla, a la vez que ofrece a 
        los negocios una mayor visibilidad. A través de un proceso de desarrollo ágil, 
        hemos priorizado la experiencia del usuario y la integración de funcionalidades como geolocalización 
        y pagos en línea. Esta aplicación representa una solución innovadora para la industria del lavado de automóviles, 
        facilitando la interacción entre usuarios y negocios locales.</p>
        <br>
        <center><img src="../app-autosplash/img/Carro.jpg" height="400px" border-radius="20px" class="carro"></center>
        <br>
        </div></center>
        <br>
    </div>



    <!--ESTE ES EL PIE DE PAGINA DE PARA ARRIBA VA TODA INFORMACIÓN DE CUALQUIER TIPO EN LA PAGINA DE INICIO-->
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="BOX">
                <figure>
                    <a href="index.php">
                        <img src="../app-autosplash/img/logo.jpeg" alt="Logo AutoSplash" height="200px" c>
                    </a>
                </figure>
            </div>
            <div class="BOX">
                <h2>SOBRE NOSOTROS</h2>
                <p> </p> <br><br><br>
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