<?php
require 'db_connection.php';

$request_id = $_POST['request_id'];
$action = $_POST['action'];

if ($action === 'approve') {
    // Obtener el user_id y el requested_role_id de la solicitud
    $stmt = $pdo->prepare("SELECT user_id, requested_role_id FROM role_requests WHERE id = ?");
    $stmt->execute([$request_id]);
    $request = $stmt->fetch();

    // Actualizar el rol del usuario
    $stmt = $pdo->prepare("UPDATE users SET role_id = ? WHERE id = ?");
    $stmt->execute([$request['requested_role_id'], $request['user_id']]);

    // Marcar la solicitud como aprobada
    $stmt = $pdo->prepare("UPDATE role_requests SET status = 'aprobado' WHERE id = ?");
    $stmt->execute([$request_id]);

    echo "Solicitud aprobada y rol actualizado.";
} else {
    // Marcar la solicitud como rechazada
    $stmt = $pdo->prepare("UPDATE role_requests SET status = 'rechazado' WHERE id = ?");
    $stmt->execute([$request_id]);

    echo "Solicitud rechazada.";
}
?>
