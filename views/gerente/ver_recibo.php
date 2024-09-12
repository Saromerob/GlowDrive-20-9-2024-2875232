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
    <style>
        body, html {
    background-image: url('../../img/fondo.jpg');
    background-repeat: no-repeat;
    background-size: cover; /* Ajusta la imagen al tamaño de la ventana */
    background-position: center; /* Centra la imagen de fondo */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}


        .contenedor-recibo {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        p strong {
            color: #555;
        }

        h2 {
            color: #ffb24d;
            text-align: center;
            margin-top: 30px;
            font-size: 22px;
        }

        .boton-enviar {
            background-color: #007bff; /* Azul */
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .boton-enviar:hover {
            background-color: #28a745; /* Verde al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="contenedor-recibo">
        <h1>Recibo de Reserva</h1>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($reserva['nombre_usuario']) . " " . htmlspecialchars($reserva['apellido_usuario']); ?></p>
        <p><strong>Autolavado:</strong> <?php echo htmlspecialchars($reserva['nombre_autolavado']); ?></p>
        <p><strong>Fecha de la cita:</strong> <?php echo htmlspecialchars($reserva['cita_fecha']) . " " . htmlspecialchars($reserva['cita_hora']); ?></p>
        <p><strong>Placa del vehículo:</strong> <?php echo htmlspecialchars($reserva['placa']); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($reserva['estado']); ?></p>

        <h2>Detalles del Servicio</h2>
        <p><strong>Servicio:</strong> <?php echo htmlspecialchars($reserva['nombre_servicio']); ?></p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($reserva['descripcion_servicio']); ?></p>
        <p><strong>Precio:</strong> <?php echo htmlspecialchars($reserva['precio_servicio']." pesos"); ?></p>

        <form action="enviar_recibo.php" method="POST">
            <input type="hidden" name="reserva_id" value="<?php echo $reserva['id']; ?>">
            <input type="hidden" name="nombre_usuario" value="<?php echo htmlspecialchars($reserva['nombre_usuario']); ?>">
            <input type="hidden" name="apellido_usuario" value="<?php echo htmlspecialchars($reserva['apellido_usuario']); ?>">
            <button type="submit" class="boton-enviar">Enviar recibo</button>
        </form>
    </div>
</body>
</html>


