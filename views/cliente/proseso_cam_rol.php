<?php
/*
include_once '../../config/db.php';

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=localhost;dbname=autosplash;charset=utf8", "root", "");
    echo "Conexión exitosa.<br>";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Iniciar la sesión y verificar el rol del usuario
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

// Capturar los valores de user_id y requested_role_id desde POST
$userId = $_POST['user_id'] ?? null;
$requested_role_id = $_POST['requested_role_id'] ?? null;

// Verificar si los valores han sido proporcionados
if (is_null($userId) || is_null($requested_role_id)) {
    die("Error: Los datos del formulario son inválidos.<br>");
}

echo "User ID: $userId<br>";
echo "Requested Role ID: $requested_role_id<br>";

// Verificar si el user_id existe en la tabla usuarios
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
$stmt->execute([$userId]);

if ($stmt->rowCount() == 0) {
    die("Error: El ID de usuario no existe en la base de datos.<br>");
}

// Verificar si ya existe una solicitud pendiente
$stmt = $pdo->prepare("SELECT * FROM role_requests WHERE user_id = ? AND status = 'pendiente'");
$stmt->execute([$userId]);

if ($stmt->rowCount() > 0) {
    echo "Ya tienes una solicitud pendiente.<br>";
} else {
    // Insertar nueva solicitud en la tabla role_requests
    $stmt = $pdo->prepare("INSERT INTO role_requests (user_id, requested_role_id, status) VALUES (?, ?, 'pendiente')");
    if ($stmt->execute([$userId, $requested_role_id])) {
        echo 'Solicitud enviada con éxito.<br>';
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Error al enviar la solicitud: " . $errorInfo[2] . "<br>";
    }
}*/
?>