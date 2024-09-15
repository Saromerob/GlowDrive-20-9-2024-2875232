<?php
// Verifica la ruta y el archivo db.php
include_once '../config/db.php'; 

// Verifica si la clase Database está definida
if (!class_exists('Database')) {
    die('La clase Database no está definida.');
}

session_start();

// Verificar si el formulario fue enviado correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $usuarioId = $_POST['usuario_id'];
    $autolavadoId = $_POST['autolavado_id'];
    $puntuacion = $_POST['puntuacion'];
    $comentario = $_POST['comentario'];
    $fechaCreacion = $_POST['fecha_creacion'];
    
    // Validar que los campos necesarios no estén vacíos
    if (empty($usuarioId) || empty($autolavadoId) || empty($puntuacion)) {
        die('Faltan datos obligatorios para la reseña.');
    }

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->conectar();
    
    // Insertar la reseña en la base de datos
    $query = "
        INSERT INTO reseñas (usuario_id, autolavado_id, puntuacion, comentario, fecha_creacion, fecha_actualizacion) 
        VALUES (:usuario_id, :autolavado_id, :puntuacion, :comentario, :fecha_creacion, NOW())
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
    $stmt->bindParam(':autolavado_id', $autolavadoId, PDO::PARAM_INT);
    $stmt->bindParam(':puntuacion', $puntuacion, PDO::PARAM_INT);
    $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
    $stmt->bindParam(':fecha_creacion', $fechaCreacion, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Reseña insertada correctamente.";
        header('Location: ../views/cliente/resena.php');
        exit();
        // Puedes redirigir a una página de confirmación o mostrar un mensaje.
    } else {
        $_SESSION['error'] = "Hubo un error al insertar la reseña.";
        header('Location: ../views/cliente/resena.php');
        exit();
    }
} else {
    die('Método de solicitud no válido.');
}
?>