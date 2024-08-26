<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

// Consultar en la base de datos el ID del usuario en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$userId = $result['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Solicitud de Cambio de Rol</title>
    <link rel="stylesheet" href="../styles/Estilos9.css">
</head>
<body>
    <div class="contenedor-principal">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.jpeg" alt="Logo" id="logo" class="logo">
                    <div class="titulo">AUTO-SPLASH</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item citas">
                            <a class="nav-link active" aria-current="page" href="agendar_cita.php">Agendar Citas</a>
                        </li>
                        <li class="nav-item ubi">
                            <a class="nav-link active" aria-current="page" href="Mapa.php">Mapa</a>
                        </li>
                        <li class="nav-item ubi">
                            <a class="nav-link active" aria-current="page" href="soli_gerente.php">Solicitar rol "Gerente"</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../useCase/logOut.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="banner container">
            <div class="text-content">
                <h1 class="Que">¿Qué es este aplicativo?</h1>
                <p class="info">
                    Como equipo de desarrollo del SENA, hemos diseñado una aplicación móvil 
                    que conecta a usuarios con servicios de lavado de automóviles cercanos. 
                    Hemos creado una solución escalable y eficiente que permite a los usuarios 
                    encontrar y reservar lavados de manera rápida y sencilla, a la vez que ofrece 
                    a los negocios una mayor visibilidad.
                </p>
            </div>
            <div class="banner-img">
                <img src="../../img/Carro.jpg" class="carro" alt="Imagen de Carro">
            </div>
        </section>

        <center>
            <form action="" method="POST">
                <h1>Estás a punto de solicitar el cambio de rol a gerente. Confirma si deseas proceder.</h1>
                <label for="email">Ingrese su correo electrónico:</label> 
                <input type="email" name="email" required><br>
                
                <label for="nombres">Nombres:</label> 
                <input type="text" name="nombres" required><br>
                
                <label for="apellidos">Apellidos:</label> 
                <input type="text" name="apellidos" required><br>
                
                <label for="direccion">Dirección del autolavado:</label> 
                <input type="text" name="direccion" required><br>
                
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <input type="hidden" name="requested_role_id" value="1">
                <button type="submit" name="confirm">Confirmar Solicitud</button>
            </form>

            <form action="paginaInicio.php" method="get">
                <button type="submit">Volver a la Página Principal</button>
            </form>
        </center>

        <footer class="pie-pagina">
            <div class="grupo-1">
                <figure>
                    <a href="paginaInicio.php">
                        <img src="../../img/logo.jpeg" alt="Logo AutoSplash" class="logo-pie">
                    </a>
                </figure>
                <div class="BOX">
                    <h2>SOBRE NOSOTROS</h2>
                </div>
                <div class="BOX">
                    <h2>Síguenos:</h2>
                    <div class="red-social">
                        <a href="https://www.instagram.com" class="instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-instagram icon-lg" viewBox="0 0 16 16">
                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.218 4.109 4.109 0 0 0 0-8.218zm0 1.658a2.45 2.45 0 1 1 0 4.902 2.45 2.45 0 0 1 0-4.902z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com" class="twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-twitter icon-lg" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.676 6.676 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.574 6.574 0 0 1-2.087.797 3.286 3.286 0 0 0-5.594 2.994A9.325 9.325 0 0 1 1.114 2.1 3.283 3.283 0 0 0 2.13 6.148a3.323 3.323 0 0 1-1.487-.41v.042a3.288 3.288 0 0 0 2.637 3.218 3.203 3.203 0 0 1-.864.114c-.21 0-.416-.02-.616-.058a3.283 3.283 0 0 0 3.066 2.279 6.588 6.588 0 0 1-4.862 1.367 9.286 9.286 0 0 0 5.034 1.475"/>
                            </svg>
                        </a>
                        <a href="https://facebook.com" class="facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-facebook icon-lg" viewBox="0 0 16 16">
                                <path d="M8 1C4.318 1 1 4.318 1 8s3.318 7 7 7 7-3.318 7-7-3.318-7-7-7zM8 0c4.418 0 8 3.582 8 8s-3.582 8-8 8-8-3.582-8-8 3.582-8 8-8zm.4 8H6.839v4.889H5.34V8H4V6.866h1.34V5.94c0-1.092.547-2.15 2.117-2.15h1.504v1.317H8.6c-.312 0-.403.15-.403.385v1.376h1.552L9.62 8H8.4z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="grupo-2">
                <small>&copy; 2023 <b>AutoSplash</b> - Todos los Derechos Reservados.</small>
            </div>
        </footer>
    </div>
</body>
</html>

