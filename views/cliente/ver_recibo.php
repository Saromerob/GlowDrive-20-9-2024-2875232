<?php
include_once '../../config/db.php';
session_start();

if (!isset($_GET['id'])) {
    die('No se especificó el ID del recibo.');
}

$reciboId = $_GET['id'];

$database = new Database();
$conn = $database->conectar();

// Obtener los datos del recibo
$query = "SELECT contenido FROM recibos WHERE id = :recibo_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':recibo_id', $reciboId, PDO::PARAM_INT);
$stmt->execute();
$recibo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recibo) {
    die('No se encontró el recibo.');
}


if (!isset($_GET['id'])) {
    die('No se especificó el ID de la reserva.');
}

$reservaId = $_GET['id'];

$database = new Database();
$conn = $database->conectar();

// Obtener los datos de la reserva
$query = "SELECT autolavado_id FROM reservas WHERE id = :reserva_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':reserva_id', $reservaId, PDO::PARAM_INT);
$stmt->execute();
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    die('No se encontró la reserva.');
}

// Si la reserva existe, puedes acceder al autolavado_id de la siguiente manera
$autolavadoId = $reserva['autolavado_id'];

echo "El ID del autolavado es: " . $autolavadoId;


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Recibo</title>
    <link rel="stylesheet" href="../../views/styles/Estilos13.css">
</head>
<body>
    <div class="container">
        <h1>Recibo</h1>
        <pre><?php echo htmlspecialchars($recibo['contenido']); ?></pre>

        <!-- Botón de cerrar -->
        <button class="button" onclick="window.close();">Cerrar</button>
    <li class="nav-item">
        <div>
            <button type="button" class="btn" style="background-color: orange; border-color: #007bff; color: white;" onclick="window.location.href='resena.php';">
                Reseñar
            </button>
        </div>
    </li>
</ul>
    </div>
</body>
</html>

