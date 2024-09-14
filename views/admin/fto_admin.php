<?php
include_once '../../config/db.php';
$database = new Database();
$conn = $database->conectar();

session_start();

// Verificar si el usuario ha iniciado sesión y si tiene el rol correcto
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header('location: ../../useCase/logOut.php');
    die();
}





// Consultar en la base de datos el ID del usuario que está en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->execute(['nombre' => $_SESSION['nombre']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    foreach ($result as $row) {
        $usuario_id = $row["id"];
    }
} else {
    header('Location: perfil.php?status=error&message=No se encontró ningún usuario con ese nombre de usuario.');
    exit;
}

// Verificar si se subió un archivo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $foto = $_FILES['foto'];

    // Validar la imagen y su tamaño
    if ($foto['size'] > 0 && $foto['size'] < 5000000) {  // Tamaño menor de 5MB
        $file_info = getimagesize($foto['tmp_name']);
        if ($file_info !== false) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($file_info['mime'], $allowed_types)) {
                $extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
                $nuevo_nombre = uniqid() . '.' . $extension;

                // Mover el archivo subido al directorio deseado
                $ruta_destino = '../../img/' . $nuevo_nombre;
                if (move_uploaded_file($foto['tmp_name'], $ruta_destino)) {
                    // Actualizar la base de datos con la nueva foto de perfil
                    $sql = "UPDATE usuarios SET foto_perfil = :foto_perfil WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['foto_perfil' => $nuevo_nombre, 'id' => $usuario_id]);
                    header('Location: perfil.php?status=success&message=Foto de perfil actualizada correctamente.');
                } else {
                    header('Location: perfil.php?status=error&message=Error al mover el archivo.');
                }
            } else {
                header('Location: perfil.php?status=error&message=Tipo de archivo no permitido.');
            }
        } else {
            header('Location: perfil.php?status=error&message=El archivo no es una imagen válida.');
        }
    } else {
        header('Location: perfil.php?status=error&message=El archivo es demasiado grande o no se subió correctamente.');
    }
} else {
    header('Location: perfil.php?status=error&message=No se ha subido ningún archivo.');
}
?>