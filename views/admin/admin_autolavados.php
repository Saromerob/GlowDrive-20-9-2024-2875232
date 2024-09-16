<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {  
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

$query = $conn->query("SELECT id, nombre, direccion, localidad_id, latitud, longitud, aprobado FROM autolavados");
$autolavados = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Autolavados</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <link rel="stylesheet" href="../styles/adminatuolavados.css"/>
    <style>
        #map { height: 500px; width: 50%; }
        table { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Administrar Autolavados</h1>
    <div id="map" align="center"></div><br><br>
    <div class="form-dk">
        <form id="updateForm" method="POST" action="procesar_autolavado.php">
            <input type="hidden" name="id" id="autolavadoId">
            <p>Nombre: <input type="text" name="nombre" id="nombre" readonly></p><br>
            <!-- Estos campos han sido eliminados del formulario -->
            <!-- <p>Dirección: <input type="text" name="direccion" id="direccion"></p><br>
            <p>Localidad: <input type="text" name="localidad" id="localidad"></p><br> -->
            <label>Latitud: <input type="text" name="latitud" id="latitud"></label><br><br>
            <label>Longitud: <input type="text" name="longitud" id="longitud"></label><br><br>
            <label>Aprobar: <input type="checkbox" name="aprobado" id="aprobado"></label><br>
            <br> <input type="submit" name="guardar" value="Guardar">
        </form>
    </div>

    <?php
    try {
        $db = new Database();
        $conexion = $db->conectar();
        $observar = "SELECT * FROM autolavados";
        $statement = $conexion->query($observar);

        if ($statement) {
            echo '<table border="2" style="width:100%; border-collapse: collapse; text-align:center; font-family:Arial, sans-serif; color:#18282e; background-color:#f2f0d9;">
                <tr style="background-color:#6c8487; color:white;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">NOMBRE</th>
                    <th style="padding:10px;">DIRECCION</th>
                    <th style="padding:10px;">TELEFONO</th>
                    <th style="padding:10px;">HORARIOS</th>
                    <th style="padding:10px;">DESCRIPCION</th>
                    <th style="padding:10px;">DUEÑO ID</th>
                    <th style="padding:10px;">LOCALIDAD</th>
                    <th style="padding:10px;">LONGITUD</th>
                    <th style="padding:10px;">LATITUD</th>
                    <th style="padding:10px;">APROBADO</th>
                    <th style="padding:10px;">EDITAR</th>
                </tr>';

            while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
                $id = $filas['id'];
                $nautolavado = $filas['nombre'];
                $direccion = $filas['direccion'];
                $celular = $filas['telefono'];
                $horario = $filas['horario'];
                $descripcion = $filas['descripcion'];
                $dueno_id = $filas['dueno_id'];
                $local = $filas['localidad_id'];
                $lat = $filas['latitud'];
                $lng = $filas['longitud'];
                $aprobado = $filas['aprobado'];

                echo '<tr style="background-color:#9faba7; color:#18282e;">
                    <td style="padding:10px;">' . $id . '</td>
                    <td style="padding:10px;">' . $nautolavado . '</td>
                    <td style="padding:10px;">' . $direccion . '</td>
                    <td style="padding:10px;">' . $celular . '</td>
                    <td style="padding:10px;">' . $horario . '</td>
                    <td style="padding:10px;">' . $descripcion . '</td>
                    <td style="padding:10px;">' . $dueno_id . '</td>
                    <td style="padding:10px;">' . $local . '</td>
                    <td style="padding:10px;">' . $lat . '</td>
                    <td style="padding:10px;">' . $lng . '</td>
                    <td style="padding:10px;">' . $aprobado . '</td>
                    <td style="padding:10px;">
                        <button onclick="editarAutolavado(' . htmlspecialchars(json_encode($filas)) . ')" style="padding:5px 10px; background-color:#18282e; color:white; border:none; border-radius:5px;">Editar</button>
                    </td>
                </tr>';
            }
            echo '</table>';
        } else {
            echo 'Error en la consulta.';
        }
    } catch (PDOException $e) {
        die("Error en conexión a la base de datos: " . $e->getMessage());
    }
    ?>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([4.60971, -74.08175], 6); // Coordenadas centradas en Bogotá

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        var autolavados = <?php echo json_encode($autolavados); ?>;
        autolavados.forEach(function(autolavado) {
            // Solo añadir al mapa los autolavados aprobados
            if (autolavado.aprobado == 1 && autolavado.latitud && autolavado.longitud) {
                var marker = L.marker([autolavado.latitud, autolavado.longitud]).addTo(map)
                    .bindPopup(autolavado.nombre + '<br>' + autolavado.direccion)
                    .on('click', function() {
                        document.getElementById('autolavadoId').value = autolavado.id;
                        document.getElementById('latitud').value = autolavado.latitud;
                        document.getElementById('longitud').value = autolavado.longitud;
                        document.getElementById('aprobado').checked = autolavado.aprobado == 1;
                        document.getElementById('nombre').value = autolavado.nombre; // Se ha cambiado textContent por value
                        // Dirección y localidad no se deben modificar, así que no se actualizan
                    });
            }
        });

        map.on('click', function(e) {
            document.getElementById('latitud').value = e.latlng.lat;
            document.getElementById('longitud').value = e.latlng.lng;
        });

        function editarAutolavado(autolavado) {
            document.getElementById('autolavadoId').value = autolavado.id;
            document.getElementById('nombre').value = autolavado.nombre; // Se ha cambiado textContent por value
            document.getElementById('latitud').value = autolavado.latitud;
            document.getElementById('longitud').value = autolavado.longitud;
            document.getElementById('aprobado').checked = autolavado.aprobado == 1;
        }
    </script>
    <form action="paginaInicio.php" method="post" style="display:inline;">
        <br>  <button type="submit" name="volverinicio">Volver</button>
    </form>
</body>
</html>
