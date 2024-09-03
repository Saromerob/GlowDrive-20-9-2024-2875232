<?php
include_once '../config/db.php';
$db = new Database();//Llamada
$conn = $db->conectar();

session_start();
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

if ($conn) {
    //Arma el texto de la consulta.
    $consulta = "SELECT * FROM usuarios WHERE nombre = :usuario AND contrasena = :contrasena";
    //Manda la consulta a la base de datos y agrega los parametros (linea 15 y 16).
    $resultado = $conn->prepare($consulta);
    $resultado->bindValue(':usuario', $usuario);
    $resultado->bindValue(':contrasena', $contraseña);
    //Se ejecuta la consulta.
    $resultado->execute();
    //rowCount esta contando las filas.
    $filas = $resultado->rowCount();

    if($filas>0) {
        // Obtener los datos del usuario
        $userData = $resultado->fetch(PDO::FETCH_ASSOC);
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
                $_SESSION['error_message'] = 'ERROR EN LA AUTENTICACION';
                header("Location: ../index.php");
                exit();
        }
    } else {$_SESSION['id'] = $userData['id'];
        $_SESSION['error_message'] = 'Usuario o contraseña incorrectos';
        header("Location: ../views/session/sesion.php");
        exit();
    }
}
?>