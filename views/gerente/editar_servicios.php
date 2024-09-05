<?php
include_once '../../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servicio_id = $_POST['servicio_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->conectar();

    // Actualizar los datos del servicio
    $sql = "UPDATE servicios SET nombre = :nombre, descripcion = :descripcion, precio = :precio WHERE id = :servicio_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio' => $precio,
        'servicio_id' => $servicio_id
    ]);

    echo "Servicio actualizado correctamente.";
}
$_SESSION['status_msg'] = $status_msg;
    $_SESSION['status_type'] = $status_type;
    
    // Redirigir para evitar reenvío del formulario en caso de actualización
    header("Location: perfil_autol.php");
    exit();
?>
