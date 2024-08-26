<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {  
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

// Consulta para obtener todas las solicitudes pendientes
$query = "SELECT r.id AS request_id, u.id AS user_id, u.nombre, u.correo, r.requested_role_id, r.status 
          FROM role_requests r 
          JOIN usuarios u ON r.user_id = u.id 
          WHERE r.status = 'pendiente'";
$stmt = $conn->prepare($query);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Pendientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 8px 12px;
            margin: 2px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button.reject {
            background-color: #f44336;
        }

        button:hover {
            background-color: #45a049;
        }

        button.reject:hover {
            background-color: #d32f2f;
        }

        .footer-buttons {
            margin-top: 20px;
            text-align: center;
        }

        .footer-buttons form {
            display: inline-block;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <h1>Solicitudes Pendientes</h1>
    <table>
        <tr>
            <th>ID Solicitud</th>
            <th>ID Usuario</th>
            <th>Nombre Usuario</th>
            <th>Email</th>
            <th>Rol Solicitado</th>
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
            <td class="actions">
                <form action="aprobacion_soli.php" method="post">
                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                    <button type="submit" name="approve">Aprobar</button>
                </form>
                <form action="rechazar_soli.php" method="post">
                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                    <button type="submit" name="reject" class="reject">Rechazar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="footer-buttons">
        <form action="ver_aprobados.php" method="post">
            <button type="submit">Ver Aprobados</button>
        </form>
        <form action="ver_rechazados.php" method="post">
            <button type="submit" class="reject">Ver Rechazados</button>
        </form>
        <form action="paginaInicio.php" method="post">
            <button type="submit">Volver al Inicio</button>
        </form>
    </div>
</body>
</html>

