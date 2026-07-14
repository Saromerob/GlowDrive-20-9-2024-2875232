<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db = new Database();
$conn = $db->conectar();
if ($conn) {
    $consulta="SELECT * FROM localidades";
    $resultado = $conn->query($consulta);

    if (!$resultado) {
        $_SESSION['error_message'] = 'Error al cargar localidades.';
        return;
    }

    $localidades = array();
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $localidades[] = $fila;
    }

    $_SESSION['localidades'] = $localidades;
}
?>