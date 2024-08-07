<?php
include '../../config/db.php';  // Incluye el archivo de conexión PDO

// Crear una instancia de la clase Database
$db = new Database();
$conn = $db->conectar(); // Obtener la conexión PDO

// Obtén los datos del formulario
$usuario_id = $_POST['usuario_id'];
$autolavado_id = $_POST['autolavado_id'];
$servicio_id = $_POST['servicio_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$placa = $_POST['placa'];
$telefono = $_POST['telefono'];
$tipo_vehiculo = $_POST['tipo_vehiculo'];
$comentarios = $_POST['comentarios'];

// Prepara la sentencia SQL para prevenir inyección SQL
$sql = "INSERT INTO citas (usuario_id, autolavado_id, servicio_id, fecha, hora, nombre, apellido, placa, telefono, tipo_vehiculo, comentarios) VALUES (:usuario_id, :autolavado_id, :servicio_id, :fecha, :hora, :nombre, :apellido, :placa, :telefono, :tipo_vehiculo, :comentarios)";
$stmt = $conn->prepare($sql);

// Vincula los parámetros
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->bindParam(':autolavado_id', $autolavado_id, PDO::PARAM_INT);
$stmt->bindParam(':servicio_id', $servicio_id, PDO::PARAM_INT);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':hora', $hora);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':apellido', $apellido);
$stmt->bindParam(':placa', $placa);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':tipo_vehiculo', $tipo_vehiculo, PDO::PARAM_INT);
$stmt->bindParam(':comentarios', $comentarios);

// Ejecuta la sentencia
if ($stmt->execute()) {
    echo "Cita enviada exitosamente";
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}

// Cierra la conexión
$conn = null;
?>
