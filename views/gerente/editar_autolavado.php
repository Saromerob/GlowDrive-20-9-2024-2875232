<?php
include_once '../../config/db.php';
session_start();

$status_msg = '';
$status_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $autolavado_id = $_POST['autolavado_id'];
    $nombre = $_POST['nombre'];
    $horario = $_POST['horario'];

    // Manejar la foto
    if (!empty($_FILES['foto']['name'])) {
        $upload_dir = 'uploads/';
        
        // Verificar si la carpeta 'uploads/' existe
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Crear la carpeta con permisos adecuados
        }
        
        $foto = $upload_dir . basename($_FILES['foto']['name']);
        
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $foto)) {
            $status_msg = "Foto subida correctamente.";
            $status_type = "success";
        } else {
            $status_msg = "Error al subir la foto.";
            $status_type = "error";
            $foto = null; // Si no se pudo subir la foto, no intentamos guardar la ruta
        }
    } else {
        $foto = null; // Si no se sube una nueva foto, el valor será null
    }

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->conectar();

    // Actualizar los datos del autolavado
    $sql = "UPDATE autolavados SET nombre = :nombre, horario = :horario" 
            . ($foto ? ", foto = :foto" : "") // Solo actualizar la foto si existe
            . " WHERE id = :autolavado_id";
    
    $stmt = $conn->prepare($sql);

    // Preparar los parámetros para la ejecución
    $params = [
        'nombre' => $nombre,
        'horario' => $horario,
        'autolavado_id' => $autolavado_id
    ];

    if ($foto) {
        $params['foto'] = $foto;
    }

    // Ejecutar la consulta
    if ($stmt->execute($params)) {
        $status_msg = "Autolavado actualizado correctamente.";
        $status_type = "success";
    } else {
        $status_msg = "Error al actualizar el autolavado.";
        $status_type = "error";
    }

    // Guardar los mensajes de estado en la sesión
    $_SESSION['status_msg'] = $status_msg;
    $_SESSION['status_type'] = $status_type;
    
    // Redirigir para evitar reenvío del formulario en caso de actualización
    header("Location: perfil_autol.php");
    exit();
}
?>





