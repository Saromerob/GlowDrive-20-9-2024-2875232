<?php
include '../config/db.php';
session_start();

// Define una consulta SQL para seleccionar todas las columnas de la tabla 'localidades'.
$consulta="SELECT * FROM localidades";

// Ejecuta la consulta en la base de datos y almacena el resultado en la variable $resultado.
$resultado=mysqli_query($conn,$consulta);

// Verifica si la consulta se ejecutó correctamente.
// Si hubo un error, termina la ejecución del script y muestra el mensaje de error.
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}
// Array:Es un listado de cosas.
// Inicializa un array para almacenar los resultados.
$localidades = array();

// Recorre el resultado y almacena cada fila en el array.
while ($fila = mysqli_fetch_assoc($resultado)) {
    $localidades[] = $fila;
}

// Guarda el array de resultados en una variable de sesión.
$_SESSION['localidades'] = $localidades;

// Cierra la conexión a la base de datos.
mysqli_close($conn);
?>