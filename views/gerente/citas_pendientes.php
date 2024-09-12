<?php
include_once '../../config/db.php';
session_start();

// Verificar si el usuario es gerente o dueño
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Obtener el ID del usuario en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    die('No se encontró el usuario con ese nombre.');
}

$userId = $result['id'];

// Obtener el autolavado asociado al usuario logueado
$query = "SELECT id FROM autolavados WHERE dueno_id = :dueno_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':dueno_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$autolavado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$autolavado) {
    die('No se encontró un autolavado asociado a este usuario.');
}

$autolavadoId = $autolavado['id'];

// Obtener todas las citas pendientes del autolavado
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/citaspendientes.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body {
    background-color: #f5f5f5;
    color: #333;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: blue;
}

.table {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-collapse: separate;
    width: 100%;
    margin-top: 20px;
}

.table thead th {
    background-color: #444;
    color: white;
    text-align: center;
    padding: 15px;
}

.table tbody td {
    text-align: center;
    padding: 15px;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #ddd;
}

.btn {
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Responsividad */
@media (max-width: 768px) {
    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table tbody td {
        display: block;
        text-align: center;
        position: relative;
    }

    .table tbody td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
        text-align: center;
        background-color: #eee;
    }

    .btn {
        width: 100%;
        margin: 10px 0;
    }
}

    </style>
</head>
<center><body>
    <div class="container">
        <h1>Citas Pendientes</h1>
        <table class="table table-striped table-hover">
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
        <form action="citas_aprobadas.php" method="post">
            <button type="submit" class="btn btn-primary mt-3">Ver Aprobados</button>
        </form>
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
                    $('#cita-' + citaId).remove();
                },
                error: function() {
                    alert('Error al actualizar el estado de la cita.');
                }
            });
        }
    </script>
</body></center>
</html>
