<?php
include_once '../config/db.php';
$db = new Database(); // Llamada
$conn = $db->conectar();

session_start();
$correo = $_POST['correo']; 
$contraseña = $_POST['contraseña'];

if ($conn) {
    // Arma el texto de la consulta para obtener la contraseña hasheada y otros datos del usuario.
    $consulta = "SELECT * FROM usuarios WHERE correo = :correo";
    
    // Manda la consulta a la base de datos y agrega el parámetro del correo.
    $resultado = $conn->prepare($consulta);
    $resultado->bindValue(':correo', $correo); 
    
    // Se ejecuta la consulta.
    $resultado->execute();
    
    // Verificar si existe el usuario con ese correo.
    if ($resultado->rowCount() > 0) {
        // Obtener los datos del usuario
        $userData = $resultado->fetch(PDO::FETCH_ASSOC);
        
        // Verificar la contraseña usando password_verify
        if (password_verify($contraseña, $userData['contrasena'])) {
            // Contraseña correcta, continuar con la autenticación
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
            // La contraseña es incorrecta
            $_SESSION['error_message'] = 'Correo o contraseña incorrectos';
            header("Location: ../views/session/sesion.php");
            exit();
        }
    } else {
        // El correo no existe
        $_SESSION['error_message'] = 'Correo o contraseña incorrectos';
        header("Location: ../views/session/sesion.php");
        exit();
    }
}
?>
