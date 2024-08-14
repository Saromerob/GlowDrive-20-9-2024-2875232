<?php 
include_once '../../config/db.php';

//verificar si la sesion esta activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ahora puedes acceder a las variables de la sesion
(!isset($-SESSION['role_id']) || $_SESSION['role_id'] !=2) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

//conetar a la base de datos
$database = new Database();
$conn = $database->conectar();

?>