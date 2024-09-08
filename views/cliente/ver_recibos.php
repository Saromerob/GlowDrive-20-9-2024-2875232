<?php
session_start();
include_once '../../config/db.php';

// Verificar si el usuario tiene el rol correcto
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) { 
    header('Location: ../../useCase/logOut.php');
    exit();
}

$database = new Database();
$conn = $database->conectar();

// Consultar el ID del usuario (dueño) que está en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    die('No se encontró el usuario con ese nombre.');
}

$userId = $result['id'];

// Obtener los recibos del usuario
$query = "SELECT * FROM recibos WHERE usuario_id = :usuario_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':usuario_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$recibos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Recibos</title>
</head>
<body>
    <h1>Recibos de Usuario</h1>

    <?php if (empty($recibos)): ?>
        <p>No se encontraron recibos.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($recibos as $recibo): ?>
                <li>
                    <a href="ver_recibo.php?id=<?php echo htmlspecialchars($recibo['id']); ?>" target="_blank">
                        <?php echo htmlspecialchars($recibo['nombre_archivo']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
