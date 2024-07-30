<?php

$db = new Database();//Llamada
$conn = $db->conectar();
if ($conn) {
    // Define una consulta SQL para seleccionar todas las columnas de la tabla 'localidades'.
    $consulta="SELECT * FROM localidades";

    // Ejecuta la consulta en la base de datos y almacena el resultado en la variable $resultado.
    $resultado = $conn->query($consulta);

    // Verifica si la consulta se ejecutó correctamente.
    // Si hubo un error, termina la ejecución del script y muestra el mensaje de error.
    if (!$resultado) {
        die("Error en la consulta: " . $conn->errorInfo()[2]);
    }
    // Array:Es un listado de cosas.
    // Inicializa un array para almacenar los resultados.
    $localidades = array();

    // Recorre el resultado y almacena cada fila en el array.
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $localidades[] = $fila;
    }

    // Guarda el array de resultados en una variable de sesión.
    $_SESSION['localidades'] = $localidades;
}
?>