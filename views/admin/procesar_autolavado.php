<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {  
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar(); // Asegúrate de tener tu conexión a la base de datos aquí

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $latitud = filter_var($_POST['latitud'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitud = filter_var($_POST['longitud'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $aprobado = isset($_POST['aprobado']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE autolavados SET latitud = :latitud, longitud = :longitud, aprobado = :aprobado WHERE id = :id");
    $stmt->execute(['latitud' => $latitud, 'longitud' => $longitud, 'aprobado' => $aprobado, 'id' => $id]);

    header("Location: admin_autolavados.php");
    exit();
}
?>
