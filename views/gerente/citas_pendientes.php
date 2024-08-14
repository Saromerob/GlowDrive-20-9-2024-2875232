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

// Obtener todas las citas pendientes del autolavado gestionado por el gerente/dueño logueado
$query = "SELECT c.id, c.fecha, c.hora, u.nombre, c.estado 
          FROM citas c 
          JOIN usuarios u ON c.usuario_id = u.id 
          WHERE c.autolavado_id = :autolavado_id AND c.estado = 'pendiente'";
          
$stmt = $conn->prepare($query);
$stmt->bindParam(':autolavado_id', $_SESSION['autolavado_id'], PDO::PARAM_INT);
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Citas Pendientes</h2>
<table>
    <tr>
        <th>Nombre del Cliente</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Acción</th>
    </tr>
    <?php foreach ($citas as $cita): ?>
    <tr>
        <td><?php echo htmlspecialchars($cita['nombre']); ?></td>
        <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
        <td><?php echo htmlspecialchars($cita['hora']); ?></td>
        <td>
            <form action="actualizar_cita.php" method="POST">
                <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                <button type="submit" name="accion" value="confirmar">Confirmar</button>
                <button type="submit" name="accion" value="rechazar">Rechazar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>