<?php
// Conexión a la base de datos usando PDO
require 'db_connection.php';

// Obtener solicitudes pendientes
$stmt = $pdo->query("
    SELECT rr.id, u.name AS user_name, r.role_name AS requested_role, rr.request_date 
    FROM role_requests rr 
    JOIN users u ON rr.user_id = u.id 
    JOIN roles r ON rr.requested_role_id = r.id 
    WHERE rr.status = 'pendiente'
");
$requests = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Cambio de Rol</title>
</head>
<body>
    <h1>Solicitudes Pendientes</h1>
    <?php foreach ($requests as $request): ?>
        <div>
            <p>Usuario: <?php echo $request['user_name']; ?></p>
            <p>Rol solicitado: <?php echo $request['requested_role']; ?></p>
            <p>Fecha de solicitud: <?php echo $request['request_date']; ?></p>
            <form method="POST" action="approve_request.php">
                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                <button type="submit" name="action" value="approve">Aprobar</button>
                <button type="submit" name="action" value="reject">Rechazar</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
