<?php
include_once '../../config/db.php';
session_start();

// Asegurarse de que el usuario es gerente o dueño
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) { 
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Consultar en la base de datos el ID del usuario que está en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->execute(['nombre' => $_SESSION['nombre']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    $userId = $result[0]['id'];
} else {
    // No se encontró ningún usuario con ese nombre de usuario
    echo "No se encontró el usuario.";
    exit();
}

// Obtener el ID del gerente desde la sesión
$gerente_id = $_SESSION['id'];

// Obtener los datos del autolavado asociado al gerente
$sql_autolavado = "SELECT * FROM autolavados WHERE dueno_id = :dueno_id";
$stmt_autolavado = $conn->prepare($sql_autolavado);
$stmt_autolavado->execute(['dueno_id' => $gerente_id]);
$autolavado = $stmt_autolavado->fetch(PDO::FETCH_ASSOC);

if ($autolavado) {
    echo "<center><img src='" . htmlspecialchars($autolavado['foto']) . "' alt='Foto del autolavado' style='
    width: 100px; 
    height: 100px; 
    object-fit: cover; 
    border-radius: 50%; 
    border: 2px solid #00796b; 
    display: block; 
    margin-bottom: 20px;
'><br><br></center>";
echo "Nombre del autolavado: <h1>" . htmlspecialchars($autolavado['nombre']) . "</h1><br>";
    echo "Horarios: " . htmlspecialchars($autolavado['horario']) . "<br>";


    // Obtener todos los servicios asociados a este autolavado
    $autolavado_id = $autolavado['id'];
    $sql_servicios = "SELECT * FROM servicios WHERE autolavado_id = :autolavado_id";
    $stmt_servicios = $conn->prepare($sql_servicios);
    $stmt_servicios->execute(['autolavado_id' => $autolavado_id]);
    $servicios = $stmt_servicios->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar servicios
    if ($servicios) {
        echo "<h3>Servicios del Autolavado:</h3>";
        foreach ($servicios as $servicio) {
            echo "Nombre del servicio: " . htmlspecialchars($servicio['nombre']) . "<br>";
            echo "Descripción: " . htmlspecialchars($servicio['descripcion']) . "<br>";
            echo "Precio: " . htmlspecialchars($servicio['precio']) . "<br><br>";
        }
    } else {
        echo "No hay servicios registrados para este autolavado.";
    }
} else {
    echo "No se encontró información del autolavado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autolavado y Servicios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa; /* Fondo color océano claro */
            color: #004d40; /* Texto color verde océano oscuro */
            margin: 0;
            padding: 20px;
        }

        h3 {
            color: #006064; /* Color de los títulos */
            text-align: center;
        }

        form {
            background-color: #ffffff; /* Fondo de los formularios */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
            margin-bottom: 30px;
        }

        label {
            color: #00796b; /* Color de las etiquetas */
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="file"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #b2ebf2;
            border-radius: 5px;
            background-color: #f0f4c3; /* Fondo de los campos de entrada */
            color: #004d40;
            font-size: 16px;
        }

        textarea {
            height: 100px;
        }

        button {
            background-color: #00796b; /* Botón color océano */
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #004d40; /* Cambiar a tono más oscuro en hover */
        }

        p {
            color: #004d40;
            font-style: italic;
        }

        .form-container {
            max-width: 600px; /* Ancho máximo para que se vea ordenado */
            margin: 0 auto;
        }
        .foto {
    color: #00796b; /* Color del texto del label */
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
    width: 100px; /* Tamaño ancho de la imagen */
    height: 100px; /* Tamaño alto de la imagen */
    object-fit: cover; /* Mantiene la proporción de la imagen */
    border-radius: 50%; /* Hace que la imagen sea redonda */
    border: 2px solid #00796b; /* Opcional: Borde alrededor de la imagen */
    display: block;
    margin-bottom: 20px;
}

input[type="file"] {
    display: block;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #e0f7fa; /* Fondo azul claro */
    border: 2px dashed #b2ebf2; /* Borde punteado */
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s ease;
}

input[type="file"]:hover {
    background-color: #b2ebf2; /* Fondo ligeramente más oscuro al hacer hover */
    border-color: #004d40; /* Cambio de color del borde */
}
.foto {
            color: #00796b; /* Color del texto del label */
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        input[type="file"] {
            display: block;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #e0f7fa; /* Fondo azul claro */
            border: 2px dashed #b2ebf2; /* Borde punteado */
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="file"]:hover {
            background-color: #b2ebf2; /* Fondo ligeramente más oscuro al hacer hover */
            border-color: #004d40; /* Cambio de color del borde */
        }

        /* Estilos específicos para la imagen de vista previa */
        .foto-preview {
            width: 100px; /* Tamaño ancho de la imagen */
            height: 100px; /* Tamaño alto de la imagen */
            object-fit: cover; /* Mantiene la proporción de la imagen */
            border-radius: 50%; /* Hace que la imagen sea redonda */
            border: 2px solid #00796b; /* Opcional: Borde alrededor de la imagen */
            display: block;
            margin-bottom: 20px; /* Espacio debajo de la imagen */
        }
        /* Estilos para las notificaciones */
        .notification {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            color: #fff;
            text-align: center;
        }

        .notification.success {
            background-color: #4caf50; /* Verde para éxito */
        }

        .notification.error {
            background-color: #f44336; /* Rojo para error */
        }

    </style>
</head>
<body>
    <h3>Editar Autolavado:</h3>
    <form action="editar_autolavado.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="autolavado_id" value="<?php echo htmlspecialchars($autolavado['id']); ?>">
        
        <label for="nombre">Nombre del autolavado:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($autolavado['nombre']); ?>" required>
        
        <label for="horario">Horarios:</label>
        <input type="text" id="horario" name="horario" value="<?php echo htmlspecialchars($autolavado['horario']); ?>" required>
        
        <label for="servicios">Servicios:</label>
        <p>EN LA PARTE DE ABAJO PODRÁ VER SUS SERVICIOS IMPLEMENTADOS Y PODRÁ EDITARLOS SEGÚN SU NECESIDAD</p>
    
        <input type="file" id="foto" name="foto">
        <div class="foto-preview-container">
            <?php if (!empty($autolavado['foto'])): ?>
                <img src="<?php echo htmlspecialchars($autolavado['foto']); ?>" alt="Foto del autolavado" class="foto-preview">
            <?php endif; ?>
        </div>
        
        <button type="submit">Guardar Cambios</button>
    </form>

    <h3>Editar Servicios:</h3>
    <?php if (!empty($servicios)): ?>
        <?php foreach ($servicios as $servicio): ?>
            <form action="editar_servicios.php" method="POST">
                <input type="hidden" name="servicio_id" value="<?php echo htmlspecialchars($servicio['id']); ?>">
                
                <label for="servicio_nombre_<?php echo htmlspecialchars($servicio['id']); ?>">Nombre del servicio:</label>
                <input type="text" id="servicio_nombre_<?php echo htmlspecialchars($servicio['id']); ?>" name="nombre" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" required>
                
                <label for="descripcion_<?php echo htmlspecialchars($servicio['id']); ?>">Descripción:</label>
                <textarea id="descripcion_<?php echo htmlspecialchars($servicio['id']); ?>" name="descripcion" required><?php echo htmlspecialchars($servicio['descripcion']); ?></textarea>
                
                <label for="precio_<?php echo htmlspecialchars($servicio['id']); ?>">Precio:</label>
                <input type="number" id="precio_<?php echo htmlspecialchars($servicio['id']); ?>" step="0.01" name="precio" value="<?php echo htmlspecialchars($servicio['precio']); ?>" required>
                
                <button type="submit">Guardar Cambios</button>
            </form>
            <br> <!-- Separador entre formularios de servicios -->
        <?php endforeach; ?>
    <?php endif; ?>
    <script>
        // Función para mostrar el mensaje de estado
        function showStatusMessage(message, type) {
            var messageDiv = document.getElementById('status-message');
            messageDiv.textContent = message;
            messageDiv.className = 'notification ' + type;
            messageDiv.style.display = 'block';
        }

        // Obtener los parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const statusMsg = urlParams.get('status_msg');
        const statusType = urlParams.get('status_type');

        // Mostrar el mensaje si existe
        if (statusMsg && statusType) {
            showStatusMessage(statusMsg, statusType);
        }
    </script>
</body>
</html>
