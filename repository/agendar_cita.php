<?php
include_once '../config/db.php';

// Iniciar la sesión y verificar el rol del usuario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('Location: ../../useCase/logOut.php');
    die();
}



// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Verificar si el ID del usuario enviado es igual al ID del usuario logueado
    if ($usuario_id != $_SESSION['id']) {
        $_SESSION['error'] = "No tiene permisos para realizar esta acción.";
        header("Location: ../views/cliente/form_agendar_cita.php");
        exit();
    }

    // Preparar la consulta SQL de inserción
    $sql = "INSERT INTO citas (usuario_id, autolavado_id, servicio_id, fecha, hora, nombre, apellido, placa, telefono, tipo_vehiculo, comentarios, estado) 
            VALUES (:usuario_id, :autolavado_id, :servicio_id, :fecha, :hora, :nombre, :apellido, :placa, :telefono, :tipo_vehiculo, :comentarios, 'pendiente')";
    
    $stmt = $conn->prepare($sql);

    // Vincular los valores a los parámetros
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':autolavado_id', $autolavado_id, PDO::PARAM_INT);
    $stmt->bindParam(':servicio_id', $servicio_id, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':placa', $placa, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_vehiculo', $tipo_vehiculo, PDO::PARAM_STR);
    $stmt->bindParam(':comentarios', $comentarios, PDO::PARAM_STR);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $_SESSION['success'] = "Cita Agendada";
        header("Location: ../views/cliente/form_agendar_cita.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al agendar la cita. Por favor, inténtalo de nuevo.";
        header("Location: ../views/cliente/form_agendar_cita.php");
        exit();
    }
}
?>