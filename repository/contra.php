<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once '../config/db.php';
            //require 'vendor/autoload.php';
$db = new Database();//Llamada
$conn = $db->conectar();

session_start();
$correo = $_POST['correo'];

if ($conn) {
    //Arma el texto de la consulta.
    $consulta = "SELECT * FROM usuarios WHERE correo = :correo";
    //Manda la consulta a la base de datos y agrega los parametros (linea 15 y 16).
    $resultado = $conn->prepare($consulta);
    $resultado->bindValue(':correo', $correo);
    //Se ejecuta la consulta.
    $resultado->execute();
    //rowCount esta contando las filas.
    $filas = $resultado->rowCount();

    if($filas>0) {
        // Obtener los datos del usuario
        $userData = $resultado->fetch(PDO::FETCH_ASSOC);

        // Guardar el rol en la sesión
        $nombreUsuario = $userData['nombre'];
        $numeroRandom = random_int(1,200);
        
        //Contraseña random
        $haseada = $nombreUsuario.$numeroRandom;
        $arreglo = "UPDATE usuarios SET contrasena = :contrasena WHERE correo = :correo";
        $statement = $conn->prepare($arreglo);
        $statement->bindValue(':contrasena', $haseada);
        $statement->bindValue(':correo', $correo);
        $statement->execute();

        // Correo ingresado
        /*
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tu_correo@gmail.com';  // Coloca tu correo de Gmail
            $mail->Password   = 'tu_contraseña';        // Coloca tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Destinatarios
            $mail->setFrom('noreply@tu-dominio.com', 'Tu Nombre');
            $mail->addAddress($correo);  // Añade el correo del usuario

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = 'Hola ' . $nombreUsuario . ',<br><br>Tu nueva contraseña es: <strong>' . $haseada . '</strong><br>Por favor, cámbiala una vez inicies sesión.';

            $mail->send();
            $_SESSION['success'] = "Se ha enviado un correo con la nueva contraseña.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error al enviar el correo: {$mail->ErrorInfo}";
        }

        header("Location: ../views/perfil/recuperarContra.php");
        exit();*/
        
    } else {
        $_SESSION['error_message'] = 'Correo incorrecto';
        header("Location: ../views/perfil/recuperarContra.php");
        exit();
    }
}
?>