<?php 
include '../config/db.php';
session_start();

$consulta="SELECT * FROM tipo_documento";
$resultado=mysqli_query($conn,$consulta);
if (!$resultado) {
    die("Error en la consulta: ".mysqli_error($conn));
}

$typeDocument = array();
while ( $fila = mysqli_fetch_assoc($resultado)) {
    $typeDocument[] = $fila;
}

$_SESSION['tipo_documento'] = $typeDocument;
mysqli_close($conn)
?>