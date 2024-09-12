<?php
include_once '../../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservaId = $_POST['reserva_id'];
    $nombreUsuario = $_POST['nombre_usuario'];
    $apellidoUsuario = $_POST['apellido_usuario'];

    $database = new Database();
    $conn = $database->conectar();

    // Verificar si ya existe un recibo para esta reserva
    $queryCheck = "SELECT COUNT(*) as total FROM recibos WHERE reserva_id = :reserva_id";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bindParam(':reserva_id', $reservaId, PDO::PARAM_INT);
    $stmtCheck->execute();
    $resultado = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultado['total'] > 0) {
        // Si ya existe un recibo, no permitas enviar otro
        echo "Ya se ha enviado un recibo para esta reserva.";
    } else {
        // Obtener los datos de la reserva, cita asociada y detalles del servicio
        $query = "SELECT reservas.*, usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario, 
                        autolavados.nombre AS nombre_autolavado, citas.fecha AS cita_fecha, citas.hora AS cita_hora,
                        servicios.nombre AS nombre_servicio, servicios.descripcion AS descripcion_servicio, servicios.precio AS precio_servicio
                    FROM reservas 
                    JOIN usuarios ON reservas.usuario_id = usuarios.id
                    JOIN autolavados ON reservas.autolavado_id = autolavados.id
                    JOIN citas ON reservas.usuario_id = citas.usuario_id AND reservas.fecha = citas.fecha
                    JOIN servicios ON citas.servicio_id = servicios.id
                    WHERE reservas.id = :reserva_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':reserva_id', $reservaId, PDO::PARAM_INT);
        $stmt->execute();
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reserva) {
            die('No se encontró la reserva.');
        }

        // Crear el contenido del recibo
        $reciboContenido = "
            Recibo de Reserva\n
            Cliente: {$reserva['nombre_usuario']} {$reserva['apellido_usuario']}\n
            Autolavado: {$reserva['nombre_autolavado']}\n
            Fecha de la cita: {$reserva['cita_fecha']} {$reserva['cita_hora']}\n
            Servicio: {$reserva['nombre_servicio']}\n
            Descripción: {$reserva['descripcion_servicio']}\n
            Precio: {$reserva['precio_servicio']}\n
            Placa del vehículo: {$reserva['placa']}\n
            Estado: {$reserva['estado']}\n
        ";

        // Definir el nombre del archivo para el recibo
        $reciboNombre = "Recibo_Reserva_" . $reservaId . ".txt";

        // Insertar el recibo en la base de datos
        $queryInsert = "INSERT INTO recibos (reserva_id, usuario_id, nombre_archivo, contenido)
                        VALUES (:reserva_id, :usuario_id, :nombre_archivo, :contenido)";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->bindParam(':reserva_id', $reservaId, PDO::PARAM_INT);
        $stmtInsert->bindParam(':usuario_id', $reserva['usuario_id'], PDO::PARAM_INT);
        $stmtInsert->bindParam(':nombre_archivo', $reciboNombre, PDO::PARAM_STR);
        $stmtInsert->bindParam(':contenido', $reciboContenido, PDO::PARAM_STR);
        $stmtInsert->execute();

        echo "Recibo enviado y guardado en la base de datos.";
    }
}
?>


