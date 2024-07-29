<?php
include '../config/db.php';
session_start();
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

//Arma el texto de la consulta.
$consulta="SELECT*FROM usuarios where nombre='$usuario' and contrasena= '$contraseña'";
//Se ejecuta la consulta.
$resultado=mysqli_query($conn,$consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

$filas = mysqli_num_rows($resultado);

if($filas>0) {
    // Obtener los datos del usuario
    $userData = mysqli_fetch_assoc($resultado);
    // Guardar el rol en la sesión
    $_SESSION['role_id'] = $userData['role_id'];
    $_SESSION['nombre'] = $userData['nombre'];
    switch ($userData['role_id']) {
        case 1:
            header("Location: ../views/admin/pag_inicio.php");
            exit();
            break;
        case 2:
            header("Location: ../views/pag_inicio.php");
            break;
        default:
            $_SESSION['error_message'] = 'ERROR EN LA AUTENTICACION';
            header("Location: ../index.php");
            exit();
    }
}

mysqli_free_result($resultado);
mysqli_close($conn);
?>