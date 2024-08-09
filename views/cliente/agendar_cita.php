<?php
include_once '../../config/db.php';

// Iniciar la sesión y verificar el rol del usuario
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
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

    // Preparar la consulta SQL de inserción
    $sql = "INSERT INTO citas (usuario_id, autolavado_id, servicio_id, fecha, hora, nombre, apellido, placa, telefono, tipo_vehiculo, comentarios) 
            VALUES (:usuario_id, :autolavado_id, :servicio_id, :fecha, :hora, :nombre, :apellido, :placa, :telefono, :tipo_vehiculo, :comentarios)";
    
    $stmt = $conn->prepare($sql);

    // Vincular los valores a los parámetros
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':autolavado_id', $autolavado_id);
    $stmt->bindParam(':servicio_id', $servicio_id);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora', $hora);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':tipo_vehiculo', $tipo_vehiculo);
    $stmt->bindParam(':comentarios', $comentarios);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al usuario a una página de éxito o mostrar un mensaje de éxito
        echo "AGENDAMIENTO EXITOSO";
        exit();
    } else {
        // Manejar el error
        echo "Error al agendar la cita. Por favor, inténtalo de nuevo.";
    }
}
?>

