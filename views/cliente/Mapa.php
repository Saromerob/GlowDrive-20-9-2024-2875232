<?php
include_once '../../config/db.php';

session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {  
    header('location: ../../useCase/logOut.php');
    die();
}

// Conexión a la base de datos
$database = new Database();
$conn = $database->conectar();

// Consulta para obtener autolavados aprobados
$query = $conn->query("SELECT id, nombre, direccion, telefono, horario, latitud, longitud FROM autolavados WHERE aprobado = 1");
$autolavados = $query->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener reseñas
$sql = "
SELECT 
    r.id AS reseña_id,
    u.nombre AS usuario_nombre,
    r.puntuacion,
    r.comentario,
    r.fecha_creacion,
    a.nombre AS autolavado_nombre
FROM 
    reseñas r
JOIN 
    usuarios u ON r.usuario_id = u.id
JOIN 
    autolavados a ON r.autolavado_id = a.id
ORDER BY 
    r.fecha_creacion DESC
";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
$stmt->execute();
$reseñas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Autolavados</title>
    <!-- Incluye Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Incluye Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/estilomapas.css">
    <link rel="stylesheet" href="../styles/mapa2.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="Mapa.php">
                <img src="../../img/logo.jpeg" alt="Logo" class="logo">
                <span class="navbar-title">GLOW-DRIVE</span>
            </a>

            <!-- Botón de menú desplegable para dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del menú -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-light"
                            onclick="window.location.href='paginaInicio.php';">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                <path fill-rule="evenodd"
                                    d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                            </svg>
                            Volver
                        </button>
                    </li>
                    <!-- Otros elementos de navegación aquí -->
                </ul>
            </div>
        </div>
    </nav>


    <!-- Contenedor principal -->
    <div class="container mt-4">
        <center>
            <h1 class="display-4">Autolavados</h1>
            <p class="lead">En este espacio se ubicarán todos los puntos de Autolavados que estén vinculados a nosotros.
            </p>
        </center>

        <!-- Mapa Leaflet -->
        <div id="map"></div>
    </div>
    <div class="reviews-section">
        <h2>Reseñas de Clientes</h2>
        <?php if (count($reseñas) > 0): ?>
        <?php foreach ($reseñas as $reseña): ?>
        <div class="review">
            <h3>Autolavado: <?php echo htmlspecialchars($reseña['autolavado_nombre']); ?></h3>
            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($reseña['usuario_nombre']); ?></p>
            <p><strong>Puntuación:</strong> <?php echo htmlspecialchars($reseña['puntuacion']); ?>/10</p>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($reseña['fecha_creacion']); ?></p>
            <p><strong>Comentario:</strong> <?php echo htmlspecialchars($reseña['comentario']); ?></p>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No hay reseñas disponibles.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <!-- Logo -->
            <div class="footer-logo">
                <img src="../../img/logo.jpeg" alt="Logo AutoSplash" class="logo-pie">
            </div>

            <!-- Sobre Nosotros -->
            <div class="footer-about">
                <h2>Sobre Nosotros</h2>
                <p>GlowDrive es la aplicación líder en servicios de lavado de automóviles, conectando usuarios con los
                    mejores lavados cercanos.</p>
            </div>

            <!-- Redes Sociales -->
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
            <p>&copy; 2024 GlowDrive. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts de JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    // Inicializa el mapa
    var map = L.map('map').setView([4.60971, -74.08175], 13); // Coordenadas centradas en Bogotá, Colombia

    // Añade el mapa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 30,
    }).addTo(map);

    // Datos de autolavados generados desde PHP
    var autolavados = <?php echo json_encode($autolavados); ?>;

    // Añade marcadores al mapa con los datos de los autolavados
    autolavados.forEach(function(autolavado) {
        if (autolavado.latitud && autolavado.longitud) {
            var marker = L.marker([autolavado.latitud, autolavado.longitud]).addTo(map)
                .bindPopup('<b>' + autolavado.nombre + '</b><br>' +
                    autolavado.direccion + '<br>' +
                    'Horario: ' + autolavado.horario + '<br>' +
                    '<a href="form_agendar_cita.php?id=' + autolavado.id +
                    '" class="btn btn-primary mt-2">Agendar Cita</a>');
        }
    });
    </script>
</body>

</html>