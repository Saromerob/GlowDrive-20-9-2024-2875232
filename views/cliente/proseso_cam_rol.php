<?php
// Incluir el archivo autoload de Composer

require_once '../../vendor/autoload.php';
include_once '../../config/db.php';

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=localhost;dbname=autosplash;charset=utf8", "root", "");
    echo "Conexión exitosa.";
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
    die("Error: Los datos del formulario son inválidos.");
}

// Verificar si el user_id existe en la tabla usuarios
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
$stmt->execute([$userId]);

if ($stmt->rowCount() == 0) {
    die("Error: El ID de usuario no existe en la base de datos.");
}

// Verificar si ya existe una solicitud pendiente
$stmt = $pdo->prepare("SELECT * FROM role_requests WHERE user_id = ? AND status = 'pendiente'");
$stmt->execute([$userId]);

if ($stmt->rowCount() > 0) {
    echo "Ya tienes una solicitud pendiente.";
} else {
    // Insertar nueva solicitud
    $stmt = $pdo->prepare("INSERT INTO role_requests (user_id, requested_role_id) VALUES (?, ?)");
    $stmt->execute([$userId, $requested_role_id]);

    
    
        // Destinatarios
        $mail->setFrom('michaelestivenrojastacuma@gmail.com', 'AutoSplash');
        $mail->addAddress('michaelestivenrojastacuma@gmail.com');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nueva solicitud de cambio de rol';
        $mail->Body    = 'El usuario con ID ' . htmlspecialchars($userId, ENT_QUOTES, 'UTF-8') . ' ha solicitado cambiar su rol.';

        // Enviar el correo
        $mail->send();
        echo 'Solicitud enviada con éxito.';
   
}
?>



