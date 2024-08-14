<?php
include_once '../../config/db.php';
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

$database = new Database();
$conn = $database->conectar();

//consultar en la base de datos el ID del que esta en SESION
$query = "SELECT id FROM usuarios WHERE nombre = '" . $_SESSION['nombre'] . "'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    foreach ($result as $row) {
        $userId = $row["id"];
    }
} else {
    // No se encontró ningún usuario con ese nombre de usuario
}
?>




<form method="POST" action="proseso_cam_rol.php">
    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
    <input type="hidden" name="requested_role_id" value="1"> <!-- Suponiendo que '2' es el ID del rol 'gerente' -->
    <button type="submit">Solicitar cambio a Gerente</button>
</form>
