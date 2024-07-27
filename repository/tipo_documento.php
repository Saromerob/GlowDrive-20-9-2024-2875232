<?php 
include '../config/db.php';
session_start();

$consulta="SELECT*FROM tipo_documento"
$resultado=mysqli_query($conn,$consulta);
if (!$resultado) {
    die("Error en la consulta: ".mysqli_error($conn));
}

$tipe_document = array();
while ( $fila = mysqli_fetch_assoc($resultado)) {
    $tipe_document[] = $fila;
}

$_SESSION['tipo_documento'] = $tipe_document;
mysqli_close($conn)
?>