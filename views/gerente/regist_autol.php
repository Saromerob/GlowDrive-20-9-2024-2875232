<?php
include_once '../../config/db.php'; // Incluye la configuración y clase de la base de datos

session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Conexión a la base de datos
try {
    // Crear una instancia de la base de datos
    $database = new Database();
    $conn = $database->conectar();

    // Preparar la consulta de inserción
    $sql = 'INSERT INTO autolavados (nombre, direccion, telefono, horario, descripcion, dueno_id, localidad_id, fecha_creacion, fecha_actualizacion)
            VALUES (:nombre, :direccion, :telefono, :horario, :descripcion, :dueno_id, :localidad_id, NOW(), NOW())';

    $stmt = $conn->prepare($sql);

    // Bind de los parámetros
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':direccion', $_POST['direccion']);
    $stmt->bindParam(':telefono', $_POST['telefono']);
    $stmt->bindParam(':horario', $_POST['horario']);
    $stmt->bindParam(':descripcion', $_POST['descripcion']);
    $stmt->bindParam(':dueno_id', $_POST['usuario_id']);
    $stmt->bindParam(':localidad_id', $_POST['localidad_id']);

    // Ejecutar la consulta
    $stmt->execute();

    // Redirigir a una página de éxito
    header('Location: exito.php');
    exit;
} catch (PDOException $e) {
    // Manejo de errores
    error_log('Error: ' . $e->getMessage()); // Registra el error en el archivo de log
    echo 'Error al insertar datos en la base de datos. Por favor, intenta nuevamente más tarde.';
}
