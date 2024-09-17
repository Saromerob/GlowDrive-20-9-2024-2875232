<?php
include_once '../config/db.php';
$db = new Database(); // Llamada
$conn = $db->conectar();

session_start();
$correo = $_POST['correo']; // Cambiar 'usuario' por 'correo'
$contrasena = $_POST['contrasena'];
if ($conn) {
    // Arma el texto de la consulta.
    $consulta = "SELECT * FROM usuarios WHERE correo = :correo";
    // Manda la consulta a la base de datos y agrega los parámetros (línea 15 y 16).
    $resultado = $conn->prepare($consulta);
    $resultado->bindValue(':correo', $correo); // Cambiar 'usuario' por 'correo'
    
    // Se ejecuta la consulta.
    $resultado->execute();
    // rowCount está contando las filas.
    $filas = $resultado->rowCount();
    if ($filas > 0) {
        // Obtener los datos del usuario
        $userData = $resultado->fetch(PDO::FETCH_ASSOC);        
        if (password_verify($contrasena, $userData['contrasena'])) {
             // Guardar el rol en la sesión
            $_SESSION['id'] = $userData['id'];
            $_SESSION['role_id'] = $userData['role_id'];
            $_SESSION['nombre'] = $userData['nombre'];
            switch ($userData['role_id']) {
                case 1:
                    header("Location: ../views/gerente/paginaInicio.php");
                    exit();
                    break;
                case 2:
                    header("Location: ../views/cliente/paginaInicio.php");
                    break;
                case 3:
                    header("Location: ../views/admin/paginaInicio.php");
                    exit();
                    break;
                default:
                    $_SESSION['error_message'] = 'ERROR EN LA AUTENTICACIÓN';
                    header("Location: ../index.php");
                    exit();
            }
        } else {
            $_SESSION['error_message'] = 'Correo o contraseña incorrectos';
            header("Location: ../views/session/sesion.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Correo o contraseña incorrectos';
        header("Location: ../views/session/sesion.php");
        exit();
    }
}
?>