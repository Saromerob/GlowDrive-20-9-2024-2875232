<?php

session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {  
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

$query = $conn->query("SELECT nombre, direccion, latitud, longitud FROM autolavados WHERE aprobado = 1 ");
$autolavados = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Auolavados</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 500px; width: 50%; }
        body{
            color: #000000;
            background: url('../../img/fondo.jpg');
            background-size: cover;
            font-family: 'calibri';
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            align-items: center;
        }
        h1{
            text-align: center;
        }
        button{
            background-color: #1f4068;
            color: white;
        }
    </style>
</head>
<body>
    <h1>AUTOLAVADOS DISPONIBLES</h1>
    <div id="map"  align="center"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([4.60971, -74.08175], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        var autolavados = <?php echo json_encode($autolavados); ?>;
        autolavados.forEach(function(autolavado) {
            if (autolavado.latitud && autolavado.longitud) {
                L.marker([autolavado.latitud, autolavado.longitud]).addTo(map)
                    .bindPopup(autolavado.nombre + '<br>' + autolavado.direccion);
            }
        });
    </script>
    <form action="paginaInicio.php" method="post" style="display:inline;">
                    <button type="submit" name="volverinicio">Volver al inicio</button>
                </form>
</body>
</html>