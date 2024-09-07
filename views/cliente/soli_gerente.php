<?php
include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}
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
    <style>
        /* Ajustes generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../../img/Carro.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .contenedor-principal {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 1rem;
            color: #fff;
        }

        .navbar .titulo {
            font-size: 24px;
            color: #fff;
            font-weight: bold;
        }

        .navbar .nav-link {
            color: #fff;
            margin-left: 1rem;
            transition: color 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: #ffce00;
        }

        /* Sección del banner */
        .banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            margin-bottom: 2rem;
        }

        .banner .text-content {
            max-width: 50%;
        }

        .banner h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .banner p {
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .banner-img img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
        }

        /* Formulario centrado y redondeado */
        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 2rem auto;
        }

        form h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        form input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        form button {
            padding: 0.7rem 1.5rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #218838;
        }

        /* Footer */
        .pie-pagina {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 1rem;
            color: white;
        }

        .pie-pagina .logo-pie {
            width: 50px;
        }

        .pie-pagina h2 {
            color: #ffce00;
        }

        .pie-pagina .red-social a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="contenedor-principal">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.jpeg" alt="Logo" id="logo" class="logo">
                    <div class="titulo">AUTO-SPLASH</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="agendar_cita.php">Agendar Citas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="Mapa.php">Mapa</a>
                        </li>
                        <li class="nav-item">
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

        <!-- Sección del banner -->
        <section class="banner container">
            <div class="text-content">
                <h1>¿Qué es este aplicativo?</h1>
                <p>
                    Como equipo de desarrollo del SENA, hemos diseñado una aplicación móvil que conecta a usuarios con servicios de lavado de automóviles cercanos. 
                    Hemos creado una solución escalable y eficiente que permite a los usuarios encontrar y reservar lavados de manera rápida y sencilla, 
                    a la vez que ofrece a los negocios una mayor visibilidad.
                </p>
            </div>
            <div class="banner-img">
                <img src="../../img/Carro.jpg" alt="Imagen de Carro">
            </div>
        </section>

        <!-- Formulario de solicitud -->
        <form action="" method="POST">
            <h1>Estás a punto de solicitar el cambio de rol a gerente. Confirma si deseas proceder.</h1>

            <label for="email">Ingrese su correo electrónico:</label>
            <input type="email" name="email" required>

            <label for="nombres">Nombres:</label>
            <input type="text" name="nombres" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" required>

            <label for="direccion">Dirección del autolavado:</label>
            <input type="text" name="direccion" required>

            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            <input type="hidden" name="requested_role_id" value="1">
            <button type="submit" name="confirm">Confirmar Solicitud</button>
        </form>

        <!-- Botón de volver -->
        <form action="paginaInicio.php" method="get">
            <button type="submit">Volver a la Página Principal</button>
        </form>

        <!-- Footer -->
        <footer class="pie-pagina">
            <div class="grupo-1">
                <figure>
                    <a href="#">
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
                            <img src="https://example.com/instagram.svg" alt="Instagram">
                        </a>
                        <a href="https://twitter.com" class="twitter">
                            <img src="https://example.com/twitter.svg" alt="Twitter">
                        </a>
                        <a href="https://facebook.com" class="facebook">
                            <img src="https://example.com/facebook.svg" alt="Facebook">
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
