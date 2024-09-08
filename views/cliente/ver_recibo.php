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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Recibo</title>
    <style>
        /* Estilo para el botón */
        .button {
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Recibo</h1>
    <pre><?php echo htmlspecialchars($recibo['contenido']); ?></pre>

    <!-- Botón de cerrar -->
    <button class="button" onclick="window.close();">Cerrar</button>
</body>
</html>
