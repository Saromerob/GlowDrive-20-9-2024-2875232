<?php
include_once '../config/db.php';

session_start();
$db = new Database();  // Crear instancia de la clase de conexión a la base de datos
$conn = $db->conectar();

if (!isset($_SESSION['id'])) {
    die('Error: Usuario no autenticado. No se encontró ID de usuario en la sesión.');
}


if(!isset($_POST['contrasena'])) {
    $_SESSION['error_message'] = 'No puedo colocar una contraseña vacia';
    header("Location: ../views/cliente/paginaInicio.php");
    exit();
}

$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] :'';
$contrasena = isset($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_BCRYPT) :'';

if (isset($_SESSION['nombre'])) {
    if ($contrasena && $usuario_id) {
        $sql = "UPDATE usuarios SET contrasena = :contrasena WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':contrasena', $contrasena);
        $stmt->bindValue(':id', $usuario_id);
        switch ($_SESSION['role_id']) {
            case 1:
                if ($stmt->execute()) {
                    $_SESSION['success'] = 'Contraseña Cambiada Exitosamente';
                    header("Location: ../views/gerente/paginaInicio.php");
                } else {
                    $_SESSION['error_message'] = 'No se pudo cambiar la contraseña';
                    header("Location: ../views/gerente/paginaInicio.php");
                }
                exit();
            case 2:
                if ($stmt->execute()) {
                    $_SESSION['success'] = 'Contraseña Cambiada Exitosamente';
                    header("Location: ../views/cliente/paginaInicio.php");
                } else {
                    $_SESSION['error_message'] = 'No se pudo cambiar la contraseña';
                    header("Location: ../views/cliente/paginaInicio.php");
                }
                exit();
            case 3:
                if ($stmt->execute()) {
                    $_SESSION['success'] = 'Contraseña Cambiada Exitosamente';
                    header("Location: ../views/admin/paginaInicio.php");
                } else {
                    $_SESSION['error_message'] = 'No se pudo cambiar la contraseña';
                    header("Location: ../views/admin/paginaInicio.php");
                }
                exit();
            default:
                $_SESSION['error_message'] = 'Rol no válido';
                header("Location: ../views/session/sesion.php");
                exit();
        }
    }
}
?>