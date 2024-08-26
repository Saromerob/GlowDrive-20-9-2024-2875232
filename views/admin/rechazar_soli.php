<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    $stmt = $conn->prepare("UPDATE role_requests SET status = 'rechazado' WHERE id = ?");
    $stmt->execute([$request_id]);

    // Redirigir de nuevo al panel de administración
    header('location: admin_panel.php');
}
?>
