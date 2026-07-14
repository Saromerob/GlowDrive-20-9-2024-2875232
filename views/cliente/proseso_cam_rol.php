<?php
session_start();

include_once '../../config/db.php';

try {
    $database = new Database();
    $pdo = $database->conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error de conexión a la base de datos.';
    header('Location: soli_gerente.php');
    exit();
}

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

$userId = $_POST['user_id'] ?? null;
$requested_role_id = $_POST['requested_role_id'] ?? null;

if (is_null($userId) || is_null($requested_role_id)) {
    $_SESSION['error'] = 'Los datos del formulario son inválidos.';
    header('Location: soli_gerente.php');
    exit();
}

$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
$stmt->execute([$userId]);

if ($stmt->rowCount() == 0) {
    $_SESSION['error'] = 'El ID de usuario no existe en la base de datos.';
    header('Location: soli_gerente.php');
    exit();
}

$stmt = $pdo->prepare("SELECT id FROM role_requests WHERE user_id = ? AND status = 'pendiente'");
$stmt->execute([$userId]);

if ($stmt->rowCount() > 0) {
    $_SESSION['pendiente'] = "Ya tienes una solicitud pendiente.";
    header('Location: soli_gerente.php');
    exit();
} else {
    $stmt = $pdo->prepare("INSERT INTO role_requests (user_id, requested_role_id, status) VALUES (?, ?, 'pendiente')");
    if ($stmt->execute([$userId, $requested_role_id])) {
        $_SESSION['success'] = 'Solicitud enviada con éxito.';
        header('Location: soli_gerente.php');
    } else {
        $_SESSION['error'] = 'Error al enviar la solicitud.';
        header('Location: soli_gerente.php');
    }
    exit();
}
?>