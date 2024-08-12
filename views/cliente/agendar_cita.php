<?php
include_once '../../config/db.php';
include_once 'form_agendar_cita.php';

// Iniciar la sesión y verificar el rol del usuario

// Verificar si la sesión ya está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ahora puedes acceder a las variables de sesión
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Continuar con el resto de tu código...



// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Obtener el ID del usuario logueado
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $loggedUserId = $result['id'];
} else {
    // No se encontró ningún usuario con ese nombre de usuario
    header('Location: ../../useCase/logOut.php');
    exit();
}

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
    

    // Verificar si el ID del usuario enviado es igual al ID del usuario logueado
    if ($usuario_id != $loggedUserId) {
        echo "No tiene permisos para realizar esta acción.";
        exit();
    }

    // Preparar la consulta SQL de inserción
    $sql = "INSERT INTO citas (usuario_id, autolavado_id, servicio_id, fecha, hora, nombre, apellido, placa, telefono, tipo_vehiculo, comentarios) 
            VALUES (:usuario_id, :autolavado_id, :servicio_id, :fecha, :hora, :nombre, :apellido, :placa, :telefono, :tipo_vehiculo, :comentarios)";
    
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
        // Redirigir al usuario a una página de éxito o mostrar un mensaje de éxito
        echo "AGENDAMIENTO EXITOSO";
        exit();
    } else {
        // Manejar el error
        echo "Error al agendar la cita. Por favor, inténtalo de nuevo.";
    }
}
?>
