<?php
include_once '../../config/db.php';

session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

$database = new Database();
$conn = $database->conectar();

if (isset($_POST['autolavado_id'])) {
    $autolavado_id = $_POST['autolavado_id'];

    $stmt = $conn->prepare('SELECT id, nombre, precio FROM servicios WHERE autolavado_id = ?');
    $stmt->execute([$autolavado_id]);

    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($servicios);
}
?>
