<?php
include_once '../../config/db.php';
session_start();

if (!isset($_GET['reserva_id'])) {
    die('Reserva no especificada.');
}

$reservaId = $_GET['reserva_id'];

$database = new Database();
$conn = $database->conectar();

// Obtener los datos de la reserva, cita asociada y detalles del servicio
$query = "SELECT reservas.*, usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario, 
                 autolavados.nombre AS nombre_autolavado, citas.fecha AS cita_fecha, citas.hora AS cita_hora,
                 servicios.nombre AS nombre_servicio, servicios.descripcion AS descripcion_servicio, servicios.precio AS precio_servicio
          FROM reservas 
          JOIN usuarios ON reservas.usuario_id = usuarios.id
          JOIN autolavados ON reservas.autolavado_id = autolavados.id
          JOIN citas ON reservas.usuario_id = citas.usuario_id AND reservas.fecha = citas.fecha
          JOIN servicios ON citas.servicio_id = servicios.id
          WHERE reservas.id = :reserva_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':reserva_id', $reservaId, PDO::PARAM_INT);
$stmt->execute();
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    die('No se encontró la reserva.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Reserva</title>
</head>
<body>
    <h1>Recibo de Reserva</h1>
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($reserva['nombre_usuario']) . " " . htmlspecialchars($reserva['apellido_usuario']); ?></p>
    <p><strong>Autolavado:</strong> <?php echo htmlspecialchars($reserva['nombre_autolavado']); ?></p>
    <p><strong>Fecha de la cita:</strong> <?php echo htmlspecialchars($reserva['cita_fecha']) . " " . htmlspecialchars($reserva['cita_hora']); ?></p>
    <p><strong>Placa del vehículo:</strong> <?php echo htmlspecialchars($reserva['placa']); ?></p>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($reserva['estado']); ?></p>
    <h2>Detalles del Servicio</h2>
    <p><strong>Servicio:</strong> <?php echo htmlspecialchars($reserva['nombre_servicio']); ?></p>
    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($reserva['descripcion_servicio']); ?></p>
    <p><strong>Precio:</strong> <?php echo htmlspecialchars($reserva['precio_servicio']); ?></p>

    <form action="enviar_recibo.php" method="POST">
        <input type="hidden" name="reserva_id" value="<?php echo $reserva['id']; ?>">
        <input type="hidden" name="nombre_usuario" value="<?php echo htmlspecialchars($reserva['nombre_usuario']); ?>">
        <input type="hidden" name="apellido_usuario" value="<?php echo htmlspecialchars($reserva['apellido_usuario']); ?>">
        <button type="submit">Enviar recibo</button>
    </form>
</body>
</html>

