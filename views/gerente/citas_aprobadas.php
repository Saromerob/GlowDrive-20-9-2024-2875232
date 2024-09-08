<?php
include_once '../../config/db.php';
session_start();

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) { 
    header('Location: ../../useCase/logOut.php');
    exit();
}

$database = new Database();
$conn = $database->conectar();

// Consultar el ID del usuario (dueño) que está en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    die('No se encontró el usuario con ese nombre.');
}

$userId = $result['id'];

// Consultar el autolavado asociado al usuario logueado
$query = "SELECT id FROM autolavados WHERE dueno_id = :dueno_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':dueno_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$autolavado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$autolavado) {
    die('No se encontró un autolavado asociado a este usuario.');
}

$autolavadoId = $autolavado['id'];

// Obtener todas las citas pendientes del autolavado gestionado por el dueño logueado
$query = "SELECT 
            citas.id, 
            usuarios.nombre AS nombre_cliente, 
            usuarios.apellido AS apellido_cliente,
            citas.fecha, 
            citas.hora, 
            citas.estado
        FROM 
            citas
        JOIN 
            usuarios ON citas.usuario_id = usuarios.id
        WHERE 
            citas.estado = 'aceptada' 
            AND citas.autolavado_id = :autolavado_id";

$stmt = $conn->prepare($query);
$stmt->bindParam(':autolavado_id', $autolavadoId, PDO::PARAM_INT);
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$citas) {
    echo "No hay citas pendientes.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Pendientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      function actualizarEstado(citaId, nuevoEstado) {
    $.post("actualizar_terminado.php", { cita_id: citaId, estado: nuevoEstado }, function(response) {
        if (response.success) {
            alert("Recibo generado correctamente.");
            window.location.href = "ver_recibo.php?reserva_id=" + response.reserva_id; // Redirigir a la página del recibo
        } else {
            alert("Hubo un problema al generar el recibo: " + response.message);
        }
    }, "json");
}
    </script>
</head>
<body>
    <div class="container">
        <h1>Citas Aprobadas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citas as $cita): ?>
                <tr id="cita-<?php echo htmlspecialchars($cita['id']); ?>">
                <td><?php echo htmlspecialchars($cita['nombre_cliente']) . " " . htmlspecialchars($cita['apellido_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                    <td><?php echo htmlspecialchars($cita['estado']); ?></td>
                    <td>
                        <button class="btn btn-success" onclick="actualizarEstado(<?php echo $cita['id']; ?>, 'terminado')">Terminado</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

