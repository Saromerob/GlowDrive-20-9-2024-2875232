<?php
// Conexión a la base de datos usando PDO
require 'db_connection.php';

$user_id = $_POST['user_id'];
$requested_role_id = $_POST['requested_role_id'];

// Verificar si ya existe una solicitud pendiente
$stmt = $pdo->prepare("SELECT * FROM role_requests WHERE user_id = ? AND status = 'pendiente'");
$stmt->execute([$user_id]);

if ($stmt->rowCount() > 0) {
    echo "Ya tienes una solicitud pendiente.";
} else {
    // Insertar nueva solicitud
    $stmt = $pdo->prepare("INSERT INTO role_requests (user_id, requested_role_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $requested_role_id]);

    // Notificar al superadmin por correo electrónico
    $superadmin_email = 'superadmin@tuempresa.com'; // Correo del superadmin
    $subject = "Nueva solicitud de cambio de rol";
    $message = "El usuario con ID $user_id ha solicitado cambiar su rol en el sistema. Por favor, revisa la solicitud en el panel de administración.";
    $headers = "From: noreply@tuempresa.com"; // Opcional: Configurar un remitente

    if (mail($superadmin_email, $subject, $message, $headers)) {
        echo "Correo enviado con éxito.";
    } else {
        echo "Error al enviar el correo.";
    }

    echo "Solicitud enviada con éxito.";
}
?>
