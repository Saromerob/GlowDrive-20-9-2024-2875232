<?php
include '../config/db.php';
session_start();
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
$_SESSION['usuario']=$usuario;//esto sirve para iniciar el usuario

if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$consulta="SELECT*FROM usuarios where nombre='$usuario' and contrasena= '$contraseña'";
$resultado=mysqli_query($conn,$consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

$filas = mysqli_num_rows($resultado);

if($filas>0) {
    header("location:../views/pag_inicio.php");//header lo que sirve es para saber como si fuera un ELSE.
    exit();
}else {
    $_SESSION['error_message'] = 'ERROR EN LA AUTENTICACION';
    header("Location: ../index.php");
    exit();
}

mysqli_free_result($resultado);
mysqli_close($conn);

?>