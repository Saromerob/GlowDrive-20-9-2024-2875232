<?php
include_once '../../config/db.php'; // Incluye la configuración y clase de la base de datos

session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

try {
    // Crear una instancia de la base de datos
    $database = new Database();
    $conn = $database->conectar();

    // Validar datos del formulario
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING); // Cambiar a STRING para evitar problemas con formatos de número
    $horario = filter_var($_POST['horario'], FILTER_SANITIZE_STRING);
    $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING);
    $dueno_id = filter_var($_POST['usuario_id'], FILTER_SANITIZE_NUMBER_INT);
    $localidad_id = filter_var($_POST['localidad_id'], FILTER_SANITIZE_NUMBER_INT);

    // Preparar la consulta de inserción
    $sql = 'INSERT INTO autolavados (nombre, direccion, telefono, horario, descripcion, dueno_id, localidad_id, fecha_creacion, fecha_actualizacion)
            VALUES (:nombre, :direccion, :telefono, :horario, :descripcion, :dueno_id, :localidad_id, NOW(), NOW())';

    $stmt = $conn->prepare($sql);

    // Bind de los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':horario', $horario);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':dueno_id', $dueno_id);
    $stmt->bindParam(':localidad_id', $localidad_id);

    // Ejecutar la consulta
    $stmt->execute();

    // Redirigir a la página de éxito
    header('Location: exito.php');
    exit;
} catch (PDOException $e) {
    // Manejo de errores
    error_log('Error: ' . $e->getMessage()); // Registra el error en el archivo de log
    echo 'Error al insertar datos en la base de datos. Por favor, intenta nuevamente más tarde.';
}
?>
