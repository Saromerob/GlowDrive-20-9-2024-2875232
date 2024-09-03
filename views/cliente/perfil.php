<?php
include_once '../../config/db.php';
$database = new Database();
$conn = $database->conectar();
session_start();

// Verificar si el usuario ha iniciado sesión y si tiene el rol correcto
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    echo "<script>alert('No tienes permiso para acceder a esta página.'); window.location.href='../../useCase/logOut.php';</script>";
    exit;
}

// Consultar en la base de datos el ID del usuario que está en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->execute(['nombre' => $_SESSION['nombre']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $usuario_id = $result['id'];
} else {
    echo "<script>alert('Error: No se encontró ningún usuario con ese nombre de usuario.'); window.location.href='../../useCase/logOut.php';</script>";
    exit;
}

// Ejecutar la consulta SQL correctamente para obtener los datos del usuario
$sql = "SELECT nombre, correo, foto_perfil FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $usuario_id]);

// Verificar si la consulta devolvió un resultado
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "<script>alert('Error: No se encontró un usuario con ese ID.'); window.location.href='../../useCase/logOut.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../styles/modalperfil.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<center>

    <body>
        <div class="perfil-container">
            <h1>¡Hola, <?php echo htmlspecialchars($usuario['nombre']); ?>!</h1>
            <img src="../../img/<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de perfil"
                class="foto-perfil">
            <p>Email: <?php echo htmlspecialchars($usuario['correo']); ?></p>

            <button onclick="location.href='../perfil/cambiarcontraperfil.php'">Cambiar Contraseña</button>

            <button onclick="location.href='../../useCase/logOut.php'">Cerrar Sesión</button>
            <form action="subir_foto.php" method="post" enctype="multipart/form-data">
                <label for="foto">Subir nueva foto de perfil:</label>
                <input type="file" name="foto" id="foto" class="boton">
                <input type="submit" value="Subir Foto">
            </form>
        </div>

        <!-- Contenedor para notificaciones flotantes -->
        <div id="toast-container"></div>

        <script>
        function showToast(message, type) {
            var toast = document.createElement("div");
            toast.className = "toast " + type;
            toast.textContent = message;
            document.getElementById("toast-container").appendChild(toast);
            toast.style.visibility = 'visible';
            setTimeout(function() {
                toast.style.opacity = '0';
                setTimeout(function() {
                    toast.remove();
                }, 600); // Espera a que la transición termine antes de eliminar el elemento
            }, 2000); // Muestra el mensaje durante 2 segundos
        }

        // Muestra notificaciones con mensajes de la URL
        window.onload = function() {
            var params = new URLSearchParams(window.location.search);
            var status = params.get('status');
            var message = params.get('message');
            if (status && message) {
                showToast(decodeURIComponent(message), status);
            }
        }
        </script>
    </body>
</center>

</html>