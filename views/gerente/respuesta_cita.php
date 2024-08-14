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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cita_id = $_POST['cita_id'];
    $accion = $_POST['accion'];

    // Establecer el nuevo estado según la acción
    if ($accion === 'confirmar') {
        $nuevo_estado = 'confirmada';
    } elseif ($accion === 'rechazar') {
        $nuevo_estado = 'rechazada';
    } else {
        die('Acción no válida');
    }

    // Actualizar el estado de la cita en la base de datos
    $query = "UPDATE citas SET estado = :estado WHERE id = :cita_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':estado', $nuevo_estado, PDO::PARAM_STR);
    $stmt->bindParam(':cita_id', $cita_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Cita actualizada correctamente.";
    } else {
        echo "Error al actualizar la cita.";
    }

    // Redirigir de vuelta a la página de visualización de citas
    header('Location: ver_citas.php');
    exit();
}
?>