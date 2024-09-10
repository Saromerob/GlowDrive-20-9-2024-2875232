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
body, html {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

.custom-navbar {
    background-color: rgba(0, 0, 0, 0.5); /* Fondo negro con opacidad del 50% */
    padding: 10px 20px;
}

.navbar-brand {
    display: flex;
    align-items: center;
}

.logo {
    width: 70px;
    height: 60px;
    border-radius: 50%;
}

.navbar-title {
    margin: 0 20px; 
    font-size: 1.5rem;
    color: #fff;
}

.navbar-toggler {
    border: none;
}

.navbar-collapse {
    display: flex;
    justify-content: center; /* Centra las opciones de navegación */
}

.navbar-nav {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 0;
    padding: 0;
}

.nav-item {
    margin: 0 20px; /* Espaciado uniforme entre los elementos de navegación */
}

.nav-link {
    color: #fff;
    font-size: 1rem;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    text-decoration: none; /* Evita el subrayado en los enlaces */
}

.nav-link i {
    margin-right: 5px;
}

.nav-link:hover {
    color: #ffcc00;
}

@media (max-width: 768px) {
    .navbar-title {
        font-size: 1.2rem;
    }

    .nav-link {
        font-size: 0.9rem;
        padding: 10px 0;
    }

    .navbar-collapse {
        display: block;
    }

    .navbar-nav {
        flex-direction: column; /* Ajusta la disposición para pantallas pequeñas */
        align-items: center; 
    }

    .nav-item {
        margin: 10px 0; /* Espaciado vertical entre los elementos de navegación */
    }
}



.app-description-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    background-color: rgba(249, 249, 249, 0.9); 
}

.content-wrapper {
    max-width: 800px;
    text-align: center;
    background: rgba(255, 255, 255, 0.9); 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.app-title {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
}

.app-description {
    font-size: 1.2rem;
    line-height: 1.6;
    color: #555;
    margin-bottom: 30px;
}

.image-wrapper {
    display: flex;
    justify-content: center;
}

.app-image {
    width: 100%;
    max-width: 600px;
    height: auto;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .app-title {
        font-size: 1.8rem;
    }

    .app-description {
        font-size: 1rem;
    }

    .content-wrapper {
        padding: 15px;
    }
}

    .footer {
    background-color: #003366; 
    color: #fff;
    padding: 40px 20px;
    text-align: center;
    font-family: 'Arial', sans-serif;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-logo img {
    max-height: 60px; /* Tamaño reducido para las imágenes */
    width: auto;
    border-radius: 50%; /* Imágenes redondas */
}

.footer-about {
    flex: 1;
    margin: 20px;
}

.footer-about h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.footer-about p {
    font-size: 16px;
    line-height: 1.6;
}

.footer-social {
    flex: 1;
    margin: 20px;
}

.footer-social h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.social-icon img {
    height: 40px; /* Tamaño reducido para las imágenes sociales */
    width: 40px; /* Tamaño reducido para las imágenes sociales */
    border-radius: 50%; /* Imágenes redondas */
}

.footer-bottom {
    margin-top: 20px;
    border-top: 1px solid #002244; /* Color de la línea superior */
    padding-top: 10px;
    font-size: 14px;
}

@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
    }

    .footer-logo, .footer-about, .footer-social {
        margin-bottom: 20px;
    }

    .footer-logo img, .social-icon img {
        max-height: 50px; /* Ajuste en el tamaño para pantallas pequeñas */
    }
}

</style>
</head>


<body>
    <div class="contenedor-principal">
        <nav class="navbar navbar-expand-lg custom-navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/logo.jpeg" alt="Logo" class="logo">
                    <span class="navbar-title">GLOW-DRIVE</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../app-autosplash/views/session/sesion.php">
                                <i class='bx bxs-car'></i> Agendar Citas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../app-autosplash/views/session/sesion.php">
                                <i class='bx bxs-location-plus'></i> Ubicaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../app-autosplash/views/session/sesion.php">
                                <i class='bx bxs-user'></i> Iniciar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script><br><br>
        <div class="app-description-container">
            <div class="content-wrapper">
                <h1 class="app-title">¿Qué es este aplicativo?</h1>
                <p class="app-description">
                    Como equipo de desarrollo del SENA, hemos diseñado una aplicación móvil
                    que conecta a usuarios con servicios de lavado de automóviles cercanos.
                    Hemos creado una solución escalable y eficiente que permite a los usuarios
                    encontrar y reservar lavados de manera rápida y sencilla, a la vez que ofrece a
                    los negocios una mayor visibilidad. A través de un proceso de desarrollo ágil,
                    hemos priorizado la experiencia del usuario y la integración de funcionalidades como
                    geolocalización y pagos en línea. Esta aplicación representa una solución innovadora para la
                    industria del lavado de automóviles, facilitando la interacción entre usuarios y negocios locales.
                </p>
                <div class="image-wrapper">
                    <img src="../app-autosplash/img/Carro.jpg" alt="Carro" class="app-image">
                </div>
            </div>
        </div>

        <br>
    </div>



    <!--ESTE ES EL PIE DE PAGINA DE PARA ARRIBA VA TODA INFORMACIÓN DE CUALQUIER TIPO EN LA PAGINA DE INICIO-->
    <footer class="footer">
    <div class="footer-container">
        <div class="footer-logo">
            <a href="index.php">
                <img src="../app-autosplash/img/logo.jpeg" alt="Logo AutoSplash">
            </a>
        </div>
        <div class="footer-about">
            <h2>Sobre Nosotros</h2>
            <p>GlowDrive es la aplicación líder en servicios de lavado de automóviles, conectando usuarios con los mejores lavados cercanos.</p>
        </div>
        <div class="footer-social">
            <h2>Síguenos:</h2>
            <div class="social-icons">
                <a href="https://www.instagram.com" class="social-icon">
                    <img src="img/instagram.jpg" alt="Instagram">
                </a>
                <a href="#" class="social-icon">
                    <img src="img/tiktok.png" alt="TikTok">
                </a>
                <a href="#" class="social-icon">
                    <img src="img/whatsapp.png" alt="WhatsApp">
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <small>&copy; 2024 <b>GlowDrive</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>

</body>

</html>