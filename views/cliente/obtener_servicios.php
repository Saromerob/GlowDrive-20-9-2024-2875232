
<?php /*
include_once '../../config/db.php';

// Iniciar la sesión y verificar el rol del usuario
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

if (isset($_POST['autolavado_id'])) {
    $autolavado_id = $_POST['autolavado_id'];

    // Consulta para obtener los servicios y sus precios
    $stmt = $conn->prepare('SELECT id, nombre, precio FROM servicios WHERE autolavado_id = ?');
    $stmt->execute([$autolavado_id]);

    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($servicios); // Retorna los servicios y precios en formato JSON
}*/





















include_once '../../config/db.php';

// Iniciar la sesión y verificar el rol del usuario
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

if (isset($_POST['autolavado_id'])) {
    $autolavado_id = $_POST['autolavado_id'];

    // Consulta para obtener los servicios y sus precios
    $stmt = $conn->prepare('SELECT id, nombre, precio FROM servicios WHERE autolavado_id = ?');
    $stmt->execute([$autolavado_id]);

    $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($servicios); // Retorna los servicios y precios en formato JSON
}





?>

