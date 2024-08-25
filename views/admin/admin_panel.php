<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {  // Suponiendo que el rol 3 es el correcto
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

// Consulta para ver todos los pendientes incluyendo user_id
$query = "SELECT r.id AS request_id, u.id AS user_id, u.nombre, u.correo, r.requested_role_id, r.status 
          FROM role_requests r 
          JOIN usuarios u ON r.user_id = u.id 
          WHERE r.status = 'pendiente'";
$stmt = $conn->prepare($query);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Pendientes</title>
</head>
<body>
    <h6>ESTÁS VIENDO TODAS LAS SOLICITUDES PENDIENTES</h6>
    <table border="1">
        <tr>
            <th>ID solicitud</th>
            <th>ID usuario</th>
            <th>Nombre usuario</th>
            <th>Email</th>
            <th>Rol solicitado</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($requests as $request): ?>
        <tr>
            <td><?php echo htmlspecialchars($request['request_id']); ?></td>
            <td><?php echo htmlspecialchars($request['user_id']); ?></td> <!-- Mostrar el user_id -->
            <td><?php echo htmlspecialchars($request['nombre']); ?></td>
            <td><?php echo htmlspecialchars($request['correo']); ?></td>
            <td><?php echo htmlspecialchars($request['requested_role_id']); ?></td>
            <td><?php echo htmlspecialchars($request['status']); ?></td>
            <td>
                <!-- Aquí puedes agregar botones para aprobar o rechazar la solicitud -->
                <form action="aprobacion_soli.php" method="post" style="display:inline;">
                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                    <button type="submit" name="approve">Aprobar</button>
                </form>
                <form action="rechazar_soli.php" method="post" style="display:inline;">
                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                    <button type="submit" name="reject">Rechazar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <form action="ver_aprobados.php" method="post" style="display:inline;">
    <button type="submit" name="reject">Ver Aprobados</button>
    </form>
    <form action="ver_rechazados.php" method="post" style="display:inline;">
    <button type="submit" name="reject">Ver rechazados</button>
    </form>
    <form action="paginaInicio.php" method="post" style="display:inline;">
        <button type="submit" name="volverinicio">Volver al inicio</button>
    </form>
</body>
</html>
