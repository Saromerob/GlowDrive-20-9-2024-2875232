<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$db = new Database();
$conn = $db->conectar();

if ($conn) {
    $consulta = "SELECT * FROM tipo_documento";
    $resultado = $conn->query($consulta);
    if (!$resultado) {
        $_SESSION['error_message'] = 'Error al cargar tipos de documento.';
        return;
    }

    $typeDocument = array();
    while ( $fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $typeDocument[] = $fila;
    }

    $_SESSION['tipo_documento'] = $typeDocument;
}
?>