<?php
include_once '../../config/db.php';
session_start();

// Asegurarse de que el usuario es gerente o dueño
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $citaId = $_POST['cita_id'];
    $accion = $_POST['accion'];
    
    // Determinar el nuevo estado basado en la acción
    $nuevoEstado = $accion === 'aceptar' ? 'aceptada' : 'rechazada';

    // Actualizar el estado de la cita en la base de datos
    $stmt = $conn->prepare("UPDATE citas SET estado = :nuevoEstado, fecha_actualizacion = NOW() WHERE id = :citaId");
    $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_STR);
    $stmt->bindParam(':citaId', $citaId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirigir de nuevo a la página del gerente
    header('Location: citas_pendientes.php');
    exit();
}
?>
