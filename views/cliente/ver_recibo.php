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
    <style>
        body {
            background-image: url('../../img/fondo.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }




        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
            box-sizing: border-box;
        }

        pre {
            background-color: #eee;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            white-space: pre-wrap; /* Mantener el formato del contenido */
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recibo</h1>
        <pre><?php echo htmlspecialchars($recibo['contenido']); ?></pre>

        <!-- Botón de cerrar -->
        <button class="button" onclick="window.close();">Cerrar</button>
        <ul class="navbar-nav ms-auto">
        <li class="nav-item">
    <div>
        <button type="button" class="btn" style="background-color: orange; border: none; color: white; border-radius: 15px; padding: 10px 20px; cursor: pointer;" onclick="window.location.href='resena.php';">
            Reseñar
        </button>
    </div>
</li>
</ul>
    </div>
</body>
</html>

