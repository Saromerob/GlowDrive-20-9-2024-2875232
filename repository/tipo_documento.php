<?php
//include_once '../config/db.php';
$db = new Database();//Llamada
$conn = $db->conectar();

if ($conn) {
    $consulta = "SELECT * FROM tipo_documento";
    $resultado = $conn->query($consulta);
    if (!$resultado) {
        die("Error en la consulta: ".$conn->errorInfo()[2]);
    }

    $typeDocument = array();
    while ( $fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $typeDocument[] = $fila;
    }

    $_SESSION['tipo_documento'] = $typeDocument;
}
?>