<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {  
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

$query = $conn->query("SELECT id, nombre, direccion, telefono, horario, latitud, longitud FROM autolavados WHERE aprobado = 1");
$autolavados = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../styles/estilomapa.css">
    <style>
        #map { height: 500px; width: 50%; margin: 0 auto; }
    </style>
</head>
<body>

<!-- Navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="Mapa.php">
            <img src="../../img/logo.jpeg" alt="Logo" id="logo" class="logo">
            <div class="titulo">AUTO-SPLASH</div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="agendar_cita.php">Agendar Citas</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenedor principal -->
<div class="container mt-4">
    <center>
        <h1 class="display-4">Autolavados</h1>
        <p class="lead">En este espacio se ubicarán todos los puntos de Autolavados que estén vinculados a nosotros.</p>
    </center>

    <!-- Mapa Leaflet -->
    <div id="map"></div>
</div>

<!-- Footer -->
<footer class="pie-pagina mt-5">
    <div class="grupo-1">
        <div class="BOX">
            <figure>
                <a href="#">
                    <img src="../../img/logo.jpeg" alt="Logo AutoSplash">
                </a>
            </figure>
        </div>
        <div class="BOX">
            <h2>SOBRE NOSOTROS</h2>
            <p>TEXTO EJEMPLO</p>
        </div>
        <div class="BOX">
            <h2>Síguenos:</h2>
            <div class="red-social">
                <a href="#" class="instagram"><img src="../../img/instagram.jpg" height="50px" class="insta"></a>
                <a href="#" class="tik-tok"><img src="../../img/tiktok.png" height="50px" class="tito"></a>
                <a href="#" class="whatsapp"><img src="../../img/whatsapp.png" height="55px" class="wha"></a>
            </div>
        </div>
    </div>
    <div class="grupo-2">
        <small>&copy; 2024 <b>AutoSplash</b> - Todos los derechos reservados.</small>
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
        maxZoom: 18,
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
                           '<a href="agendar_cita.php?id=' + autolavado.id + '" class="btn btn-primary mt-2">Agendar Cita</a>');
        }
    });
</script>
</body>
</html>