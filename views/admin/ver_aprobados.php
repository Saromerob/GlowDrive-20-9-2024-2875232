<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {  // Suponiendo que el rol 3 es el correcto
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

// Consulta para ver todos los aprobados
$query = "SELECT r.id AS request_id, u.id AS user_id, u.nombre, u.correo, r.requested_role_id, r.status 
          FROM role_requests r 
          JOIN usuarios u ON r.user_id = u.id 
          WHERE r.status = 'aprobado'";
$stmt = $conn->prepare($query);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los aprobados</title>
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 8px 12px;
            margin: 2px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button.reject {
            background-color: #f44336;
        }

        button:hover {
            background-color: #45a049;
        }

        button.reject:hover {
            background-color: #d32f2f;
        }

        .footer-buttons {
            margin-top: 20px;
            text-align: center;
        }

        .footer-buttons form {
            display: inline-block;
            margin: 0 10px;
        }
    </style>
    <h6>ESTÁS VIENDO TODOS LOS APROBADOS</h6>
    <table border="1">
        <tr>
            <th>ID solicitud</th>
            <th>ID usuario</th>
            <th>Nombre usuario</th>
            <th>Email</th>
            <th>Rol solicitado</th>
            <th>Estado</th>
            <th>Editar</th>
        </tr>
        <?php foreach ($requests as $request): ?>
        <tr>
            <td><?php echo htmlspecialchars($request['request_id']); ?></td>
            <td><?php echo htmlspecialchars($request['user_id']); ?></td>
            <td><?php echo htmlspecialchars($request['nombre']); ?></td>
            <td><?php echo htmlspecialchars($request['correo']); ?></td>
            <td><?php echo htmlspecialchars($request['requested_role_id']); ?></td>
            <td><?php echo htmlspecialchars($request['status']); ?></td>
            <td>
                <form action="" method="get" style="display:inline;">
                    <input type="hidden" name="editar" value="<?php echo htmlspecialchars($request['user_id']); ?>">
                    <button type="submit">EDITAR</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php
    if (isset($_GET['editar'])) {
        $editar_id = $_GET['editar'];

        // Consulta para obtener los datos del usuario para editar
        $observar = "SELECT nombre, apellido, correo, role_id FROM usuarios WHERE id = :editar_id";
        $statement = $conn->prepare($observar);
        $statement->bindParam(':editar_id', $editar_id, PDO::PARAM_INT);
        $statement->execute();
        $usuarioData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($usuarioData) {
            $nombre = $usuarioData['nombre'];
            $apellido = $usuarioData['apellido'];
            $correo = $usuarioData['correo'];
            $rol = $usuarioData['role_id'];
            ?>
            <!-- Formulario para editar nombre, apellido, correo y rol -->
            <form method="post" action="">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($editar_id); ?>">
                NOMBRE: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br>
                APELLIDO: <input type="text" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>"><br>
                EMAIL: <input type="email" name="correo" value="<?php echo htmlspecialchars($correo); ?>"><br>
                ROL: <input type="number" name="rol" value="<?php echo htmlspecialchars($rol); ?>"><br>
                <input type="submit" name="actualizame" value="Actualizar Datos">
            </form>
            <?php
        } else {
            echo 'No se encontró el usuario.';
        }
    }

    // Actualización de los datos del usuario
    if (isset($_POST['actualizame'])) {
        $editar_id = $_POST['user_id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $rol = $_POST['rol'];

        try {
            $actualizar = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo = :correo, role_id = :role_id WHERE id = :id";
            $stmt = $conn->prepare($actualizar);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':role_id', $rol, PDO::PARAM_INT);
            $stmt->bindParam(':id', $editar_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Datos actualizados correctamente.";
                // Recargar la página para mostrar los datos actualizados
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "Error al actualizar los datos.";
            }
        } catch (PDOException $e) {
            die("Error en conexión a la base de datos: " . $e->getMessage());
        }
    }
    ?>
                <form action="admin_panel.php" method="post" style="display:inline;">
                    <button type="submit" name="volver">Volver</button>
                </form>
                <form action="paginaInicio.php" method="post" style="display:inline;">
                    <button type="submit" name="volverinicio">Volver al inicio</button>
                </form>

</body>
</html>
