<?php
include_once '../../config/db.php';
session_start();

// Verificar si el usuario tiene el rol adecuado
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Consultar en la base de datos el ID del usuario que está en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $userId = $result["id"];
} else {
    die('No se encontró el usuario con ese nombre.');
}

// Obtener las últimas 3 citas del usuario logueado
$query = "
    SELECT c.id, a.nombre AS autolavado, c.fecha, c.hora, c.estado 
    FROM citas c 
    JOIN autolavados a ON c.autolavado_id = a.id 
    WHERE c.usuario_id = :userId
    ORDER BY c.fecha DESC, c.hora DESC
    LIMIT 3
";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar si la última cita ha sido aceptada
$ultimaCitaAceptada = false;
if (!empty($citas) && $citas[0]['estado'] === 'aceptada') {
    $ultimaCitaAceptada = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/Estilos3.css">
    <script>
        // Mostrar una alerta si la última cita fue aceptada
        window.onload = function() {
            <?php if ($ultimaCitaAceptada): ?>
                alert('¡Tu última cita ha sido aceptada!');
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <div class="container">
        <h1>Mis Citas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Autolavado</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($citas)): ?>
                    <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cita['id']); ?></td>
                        <td><?php echo htmlspecialchars($cita['autolavado']); ?></td>
                        <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                        <td><?php echo htmlspecialchars($cita['estado']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No tienes citas programadas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
