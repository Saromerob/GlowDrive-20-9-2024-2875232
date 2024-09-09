<?php
include_once '../../config/db.php';
session_start();

// Asegurarse de que el usuario es gerente o dueño
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) { 
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Conectar a la base de datos
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
            citas.estado = 'pendiente' 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/citaspendientes.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Citas Pendientes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
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
                    <td><?php echo htmlspecialchars($cita['id']); ?></td>
                    <td><?php echo htmlspecialchars($cita['nombre_cliente']) . " " . htmlspecialchars($cita['apellido_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                    <td><?php echo htmlspecialchars($cita['estado']); ?></td>
                    <td>
                        <button class="btn btn-success" onclick="actualizarEstado(<?php echo $cita['id']; ?>, 'aceptar')">Aceptar</button>
                        <button class="btn btn-danger" onclick="actualizarEstado(<?php echo $cita['id']; ?>, 'rechazar')">Rechazar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
    

    <script>
        function actualizarEstado(citaId, accion) {
            $.ajax({
                url: 'actualizar_estado.php',
                type: 'POST',
                data: {
                    cita_id: citaId,
                    accion: accion
                },
                success: function(response) {
                    // Eliminar la fila de la tabla si la actualización fue exitosa
                    $('#cita-' + citaId).remove();
                },
                error: function(xhr, status, error) {
                    alert('Error al actualizar el estado de la cita.');
                }
            });
        }
    </script>
    <form action="citas_aprobadas.php" method="post">
            <button type="submit">Ver Aprobados</button>
        </form>
</body>
</html>
