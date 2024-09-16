<?php
include_once '../../config/db.php';
session_start();

// Verificar que el usuario es gerente o dueño
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Consultar el ID del usuario en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->execute(['nombre' => $_SESSION['nombre']]);
$userId = $stmt->fetchColumn();

if (!$userId) {
    echo "No se encontró el usuario.";
    exit();
}

// Consultar el autolavado asociado al usuario
$sql_autolavado = "SELECT * FROM autolavados WHERE dueno_id = :dueno_id";
$stmt_autolavado = $conn->prepare($sql_autolavado);
$stmt_autolavado->execute(['dueno_id' => $userId]);
$autolavado = $stmt_autolavado->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autolavado y Servicios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/perfil_auto.css">
</head>
<body>
    <div class="container">
        <?php if ($autolavado): ?>
            <!-- Mostrar información del autolavado -->
            <center>
                <img src="<?php echo htmlspecialchars($autolavado['foto']); ?>" alt="Foto del autolavado" style="
                    width: 100px; 
                    height: 100px; 
                    object-fit: cover; 
                    border-radius: 50%; 
                    border: 2px solid #00796b; 
                    display: block; 
                    margin-bottom: 20px;">
                <br><br>
                <h1><?php echo htmlspecialchars($autolavado['nombre']); ?></h1>
                <p>Horarios: <?php echo htmlspecialchars($autolavado['horario']); ?></p>
            </center>

            <!-- Mostrar servicios del autolavado -->
            <?php
            $autolavado_id = $autolavado['id'];
            $sql_servicios = "SELECT * FROM servicios WHERE autolavado_id = :autolavado_id";
            $stmt_servicios = $conn->prepare($sql_servicios);
            $stmt_servicios->execute(['autolavado_id' => $autolavado_id]);
            $servicios = $stmt_servicios->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php if ($servicios): ?>
                <h3>Servicios del Autolavado:</h3>
                <?php foreach ($servicios as $servicio): ?>
                    <div>
                        <p><strong>Nombre del servicio:</strong> <?php echo htmlspecialchars($servicio['nombre']); ?></p>
                        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($servicio['descripcion']); ?></p>
                        <p><strong>Precio:</strong> <?php echo htmlspecialchars($servicio['precio']); ?></p>
                    </div>
                    <br>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay servicios registrados para este autolavado.</p>
            <?php endif; ?>

            <!-- Formulario para editar el autolavado -->
            <h3>Editar Autolavado:</h3>
            <form action="editar_autolavado.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="autolavado_id" value="<?php echo htmlspecialchars($autolavado['id']); ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del autolavado:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($autolavado['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="horario" class="form-label">Horarios:</label>
                    <input type="text" id="horario" name="horario" class="form-control" value="<?php echo htmlspecialchars($autolavado['horario']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto:</label>
                    <input type="file" id="foto" name="foto" class="form-control">
                    <?php if (!empty($autolavado['foto'])): ?>
                        <img src="<?php echo htmlspecialchars($autolavado['foto']); ?>" alt="Foto del autolavado" class="foto-preview" style="width: 100px; height: 100px; object-fit: cover;">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>

            <!-- Formulario para editar los servicios -->
            <h3>Editar Servicios:</h3>
            <?php if (!empty($servicios)): ?>
                <?php foreach ($servicios as $servicio): ?>
                    <form action="editar_servicios.php" method="POST" class="mb-4">
                        <input type="hidden" name="servicio_id" value="<?php echo htmlspecialchars($servicio['id']); ?>">

                        <div class="mb-3">
                            <label for="servicio_nombre_<?php echo htmlspecialchars($servicio['id']); ?>" class="form-label">Nombre del servicio:</label>
                            <input type="text" id="servicio_nombre_<?php echo htmlspecialchars($servicio['id']); ?>" name="nombre" class="form-control" value="<?php echo htmlspecialchars($servicio['nombre']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_<?php echo htmlspecialchars($servicio['id']); ?>" class="form-label">Descripción:</label>
                            <textarea id="descripcion_<?php echo htmlspecialchars($servicio['id']); ?>" name="descripcion" class="form-control" required><?php echo htmlspecialchars($servicio['descripcion']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="precio_<?php echo htmlspecialchars($servicio['id']); ?>" class="form-label">Precio:</label>
                            <input type="number" id="precio_<?php echo htmlspecialchars($servicio['id']); ?>" name="precio" class="form-control" step="0.01" value="<?php echo htmlspecialchars($servicio['precio']); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php else: ?>
            <!-- Mostrar mensaje si no hay autolavado asociado -->
            <div class="alert alert-warning">
                <h4 class="alert-heading">¡Atención!</h4>
                <p>No se encontró información del autolavado asociado a este usuario. Para poder realizar cambios, debe registrar un autolavado.</p>
                <p>Por favor, <a href="registro_autolavado.php" class="btn btn-primary">registre su autolavado aquí</a>.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
