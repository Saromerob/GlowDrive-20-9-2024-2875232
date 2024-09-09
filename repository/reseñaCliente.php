<?php

include_once '../config/db.php';
include_once '../views/cliente/reseña.php';
// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();
// Iniciar la sesión y verificar el rol del usuario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario.
    //intval() me ayuda a convertir el valor que llega en texto a un valor entero.
    $usuario_id = intval($_SESSION['id']);
    $puntuacion = $_POST['puntuacion'];
    $fecha_creacion = $_POST['fecha_creacion'];
    $comentarios = $_POST['comentario'];
    
    // Preparar la consulta SQL de inserción
    $sql = "INSERT INTO reseñas (usuario_id, puntuacion, fecha_creacion, comentario) 
            VALUES (:usuario_id, :puntuacion, :fecha_creacion, :comentario)";
    
    $stmt = $conn->prepare($sql);

    // Vincular los valores a los parámetros
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_creacion', $fecha_creacion, PDO::PARAM_INT);
    $stmt->bindParam(':comentario', $comentarios, PDO::PARAM_STR);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: ../views/cliente/resena.php");
        echo "RESEÑA COMPLETA";
        exit();
    } else {
        echo "Error al ingresar reseña, intentalo nuevamente.";
    }
}
?>