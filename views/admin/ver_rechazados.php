<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {  // Suponiendo que el rol 3 es el correcto
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

// Consulta para ver todas las solicitudes rechazadas
$query = "SELECT r.id AS request_id, u.id AS user_id, u.nombre, u.correo, r.requested_role_id, r.status 
          FROM role_requests r 
          JOIN usuarios u ON r.user_id = u.id 
          WHERE r.status = 'rechazado'";
$stmt = $conn->prepare($query);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Restablecer a pendiente
if (isset($_GET['restablecer'])) {
    $request_id = $_GET['restablecer'];
    try {
        $updateQuery = "UPDATE role_requests SET status = 'pendiente' WHERE id = :request_id";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
        if ($updateStmt->execute()) {
            // Redirigir a la misma página sin parámetros GET
            header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
            exit;
        } else {
            echo "Error al actualizar el estado.";
        }
    } catch (PDOException $e) {
        die("Error al actualizar el estado: " . $e->getMessage());
    }
}

// Eliminar solicitud
if (isset($_GET['borrar'])) {
    $request_id = $_GET['borrar'];
    try {
        $deleteQuery = "DELETE FROM role_requests WHERE id = :request_id";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
        if ($deleteStmt->execute()) {
            // Redirigir a la misma página sin parámetros GET
            header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
            exit;
        } else {
            echo "Error al eliminar la solicitud.";
        }
    } catch (PDOException $e) {
        die("Error al eliminar la solicitud: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Rechazadas</title>
</head>
<body>
    <h6>ESTÁS VIENDO TODAS LAS SOLICITUDES RECHAZADAS</h6>
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
            <td><?php echo htmlspecialchars($request['user_id']); ?></td>
            <td><?php echo htmlspecialchars($request['nombre']); ?></td>
            <td><?php echo htmlspecialchars($request['correo']); ?></td>
            <td><?php echo htmlspecialchars($request['requested_role_id']); ?></td>
            <td><?php echo htmlspecialchars($request['status']); ?></td>
            <td>
                <!-- Formulario para restablecer el estado -->
                <form action="" method="get" style="display:inline;">
                    <input type="hidden" name="restablecer" value="<?php echo htmlspecialchars($request['request_id']); ?>">
                    <button type="submit">Restablecer a Pendiente</button>
                </form>
                <!-- Formulario para eliminar la solicitud -->
                <form action="" method="get" style="display:inline;">
                    <input type="hidden" name="borrar" value="<?php echo htmlspecialchars($request['request_id']); ?>">
                    <button type="submit">Borrar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <form action="admin_panel.php" method="post" style="display:inline;">
        <button type="submit" name="volver">Volver</button>
    </form>
    <form action="paginaInicio.php" method="post" style="display:inline;">
        <button type="submit" name="volverinicio">Volver al inicio</button>
    </form>
</body>
</html>
