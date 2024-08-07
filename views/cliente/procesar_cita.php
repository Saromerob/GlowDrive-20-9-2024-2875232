<?php
include '../../config/db.php'; // Incluye el archivo de conexión a la base de datos

// Obtén los datos del formulario
$usuario_id = $_POST['usuario_id'];
$autolavado_id = $_POST['autolavado_id'];
$servicio_id = $_POST['servicio_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$comentarios = $_POST['comentarios'];

// Prepara la sentencia SQL para prevenir inyección SQL
$stmt = $conn->prepare("INSERT INTO citas (usuario_id, autolavado_id, servicio_id, fecha, hora, comentarios) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiisss", $usuario_id, $autolavado_id, $servicio_id, $fecha, $hora, $comentarios);

// Ejecuta la sentencia
if ($stmt->execute()) {
    echo "Cita enviada exitosamente";
} else {
    echo "Error: " . $stmt->error;
}

// Cierra la sentencia y la conexión
$stmt->close();
$conn->close();
?>