<?php
include_once '../../config/db.php';
session_start();

// Verificar si se ha enviado el ID de la cita y el nuevo estado
if (isset($_POST['cita_id']) && isset($_POST['estado'])) {
    $citaId = $_POST['cita_id'];
    $nuevoEstado = $_POST['estado'];

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->conectar();

    // Obtener los datos de la cita específica
    $query = "SELECT * FROM citas WHERE id = :cita_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cita_id', $citaId, PDO::PARAM_INT);
    $stmt->execute();
    $cita = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cita) {
        // Cambiar el estado de la cita a "terminado"
        $updateQuery = "UPDATE citas SET estado = :estado WHERE id = :cita_id";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bindParam(':estado', $nuevoEstado, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':cita_id', $citaId, PDO::PARAM_INT);
        $stmtUpdate->execute();

        // Insertar los datos en la tabla reservas
        $insertQuery = "INSERT INTO reservas (usuario_id, autolavado_id, fecha, tipo_vehiculo_id, placa, estado) 
                        VALUES (:usuario_id, :autolavado_id, :fecha, :tipo_vehiculo_id, :placa, 'completada')";
        
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->bindParam(':usuario_id', $cita['usuario_id'], PDO::PARAM_INT);
        $stmtInsert->bindParam(':autolavado_id', $cita['autolavado_id'], PDO::PARAM_INT);
        $stmtInsert->bindParam(':fecha', $cita['fecha'], PDO::PARAM_STR);
        $stmtInsert->bindParam(':tipo_vehiculo_id', $cita['tipo_vehiculo'], PDO::PARAM_INT);
        $stmtInsert->bindParam(':placa', $cita['placa'], PDO::PARAM_STR);
        $stmtInsert->execute();

        // Obtener el ID de la reserva recién insertada
        $reservaId = $conn->lastInsertId();

        if ($stmtInsert) {
            echo json_encode(['success' => true, 'reserva_id' => $reservaId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al insertar la reserva.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Cita no encontrada.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
}
?>

