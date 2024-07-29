<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //todos estos datos se estan enviando a la base de datos.
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
    $num_documento = isset($_POST['num_documento']) ? $_POST['num_documento'] : '';
    $tipo_documento_id = isset($_POST['tipo_documento_id']) ? $_POST['tipo_documento_id'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
    $localidad_id = isset($_POST['localidad_id']) ? $_POST['localidad_id'] : '';
    //Rol quemado: Explicito en una variable creada por uno mismo
    $id_rol = 2;
    $status = true;

    // Verificar si todos los campos requeridos tienen valores
    if ($nombre && $apellido && $num_documento && $tipo_documento_id && $telefono && $correo && $contrasena && $fecha_nacimiento && $localidad_id) {
        //  insertar los datos
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, contrasena, telefono, num_documento, tipo_documento_id, localidad_id, fecha_nacimiento, role_id, estado)
                VALUES ('$nombre', '$apellido', '$correo', '$contrasena', '$telefono', '$num_documento', '$tipo_documento_id', '$localidad_id', '$fecha_nacimiento','$id_rol', '$status')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            header("location:../index.php");
            $_SESSION['success'] = 'Usuario Registrado Exitosamente';
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    } else {
        echo "Error: Todos los campos son requeridos.";
        exit();
    }

    
    $conn->close();
} else {
    echo "Error: No se recibieron datos.";
}
?>