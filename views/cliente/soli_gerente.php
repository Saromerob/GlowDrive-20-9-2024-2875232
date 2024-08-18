<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('location: ../../useCase/logOut.php');
    die();
}

include_once '../../config/db.php';

$database = new Database();
$conn = $database->conectar();

// Consultar en la base de datos el ID del que está en sesión
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$userId = $result['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Solicitud de Cambio de Rol</title>
</head>
<body>
<form action="" method="POST">
    <p>Estás a punto de solicitar el cambio de rol a gerente. Confirma si deseas proceder.</p>
    Ingrese su correo electrónico: <input type="email" name="email" required><br>
    Nombres: <input type="text" name="nombres" required><br>
    Apellidos: <input type="text" name="apellidos" required><br>
    Dirección del autolavado: <input type="text" name="direccion" required><br>
    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
    <input type="hidden" name="requested_role_id" value="1">
    <button type="submit" name="confirm">Confirmar Solicitud</button>
</form>

<form action="paginaInicio.php" method="get">
    <button type="submit">Volver a la Página Principal</button>
</form>
</body>
</html>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    include_once '../../config/db.php';
    $database = new Database();
    $conn = $database->conectar();

    $userId = $_POST['user_id'];
    $requested_role_id = $_POST['requested_role_id'];

    // Verificar si ya existe una solicitud pendiente
    $stmt = $conn->prepare("SELECT * FROM role_requests WHERE user_id = ? AND status = 'pendiente'");
    $stmt->execute([$userId]);

    if ($stmt->rowCount() > 0) {
        echo "Ya tienes una solicitud pendiente.";
    } else {
        // Iniciar una transacción
        $conn->beginTransaction();
        try {
            // Insertar la nueva solicitud
            $stmt = $conn->prepare("INSERT INTO role_requests (user_id, requested_role_id, status) VALUES (?, ?, 'pendiente')");
            $stmt->execute([$userId, $requested_role_id]);

            // Configurar el correo usando la API de FormSubmit
            $form_action = "https://formsubmit.co/michaelestivenrojastacuma@gmail.com";
                $form_data = array(
                    "user_id" => "El usuario " . $userId . " ha solicitado el cambio de rol a gerente",
                    "email" => $_POST['email'], // Ingresar el correo electrónico proporcionado
                    "nombres" => $_POST['nombres'], // Ingresar los nombres proporcionados
                    "apellidos" => $_POST['apellidos'], // Ingresar los apellidos proporcionados
                    "direccion" => $_POST['direccion'], // Ingresar la dirección proporcionada
                    "_captcha" => "false"
                );
                

            // Crear un formulario HTML que se enviará automáticamente
            echo "<form id='autoSubmitForm' action='$form_action' method='POST'>";
            foreach ($form_data as $key => $value) {
                echo "<input type='hidden' name='$key' value='$value'>";
            }
            echo "</form>";

            echo "<script>document.getElementById('autoSubmitForm').submit();</script>";

            // Confirmar la transacción
            $conn->commit();
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
