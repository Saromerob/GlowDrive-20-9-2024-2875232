<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si tiene el rol correcto
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    echo "<script>alert('No tienes permiso para acceder a esta página.'); window.location.href='../../useCase/logOut.php';</script>";
    exit;
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

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
    <link rel="stylesheet" href="styles.css">
<style>           
 body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa; /* Fondo azul claro */
            margin: 0;
            padding: 0;
        }

        .perfil-container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; /* Fondo blanco para el contenedor */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .foto-perfil {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        h1 {
            color: #0277bd; /* Azul océano */
        }

        button {
            background-color: #0288d1; /* Azul más oscuro para los botones */
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #01579b; /* Azul aún más oscuro al pasar el ratón */
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #0277bd;
        }

        input[type="file"] {
            display: block;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #0288d1;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #01579b;
        }

        /* Estilo para las notificaciones flotantes */
        #toast-container {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 300px;
            z-index: 1000;
        }

        .toast {
            visibility: hidden;
            min-width: 100%;
            margin: 5px 0;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            font-size: 16px;
            white-space: nowrap;
            padding: 10px;
            box-sizing: border-box;
            transition: opacity 0.6s, visibility 0.6s;
        }

        .toast.success {
            background-color: #4CAF50; /* Verde */
        }

        .toast.error {
            background-color: #f44336; /* Rojo */
        }
        .boton {
    background-color: #0288d1;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    margin: 10px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .perfil-container {
                width: 95%;
                padding: 10px;
            }

            .foto-perfil {
                width: 120px;
                height: 120px;
            }

            button {
                font-size: 14px;
                padding: 8px 16px;
                margin: 5px;
            }

            input[type="submit"] {
                font-size: 14px;
                padding: 8px;
            }

            .toast {
                font-size: 14px;
                padding: 8px;
                min-width: 80%;
            }
        }
</style>
</head>
<center><body>
<div class="perfil-container">
        <h1>¡Hola, <?php echo htmlspecialchars($usuario['nombre']); ?>!</h1>
        <img src="../../img/<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de perfil" class="foto-perfil">
        <p>Email: <?php echo htmlspecialchars($usuario['correo']); ?></p>
        <button onclick="location.href='../perfil/recuperarContra.php'">Cambiar Contraseña</button>
        <button onclick="location.href='ajustes.php'">Ajustes</button>
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
</body></center>
</html>



