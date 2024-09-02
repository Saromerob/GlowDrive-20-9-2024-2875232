<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include_once '../config/db.php';

session_start();
$correo = $_POST['correo'];



if (!empty($correo)) {
    $db = new Database();  // Crear instancia de la clase de conexión a la base de datos
    $conn = $db->conectar();

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
            $numeroRandom = random_int(1,1000);
            
            //Contraseña random
            $haseada = $nombreUsuario.$numeroRandom;
            $arreglo = "UPDATE usuarios SET contrasena = :contrasena WHERE correo = :correo";
            $statement = $conn->prepare($arreglo);
            $statement->bindValue(':contrasena', $haseada);
            $statement->bindValue(':correo', $correo);
            $statement->execute();

            // Correo ingresado
            
            $mail = new PHPMailer();

            try {
                $mail->SMTPDebug = 0;
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'santiagoromero2105@gmail.com';  // Coloca tu correo de Gmail colocar gmail de empresa
                $mail->Password   = 'ucmv vkop nodc aeak';        // Coloca tu contraseña de Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Destinatarios
                $mail->setFrom('santiagoromero2105@gmail.com', 'Soporte');
                $mail->addAddress($correo);  // Añade el correo del usuario
                
                // Contenido
                $mail->isHTML(false);
                $mail->Subject = 'Recuperación de contraseña';
                $mail->Body    = 'Hola ' . $nombreUsuario . ',  Tu nueva contraseña es: ' . $haseada . ' Por favor, cámbiala una vez inicies sesión.';
                //pendiente....
                //$mail->SMTPDebug = 4; // Puedes aumentar el nivel a 3 o 4 para más detalle.
                //pendiente....
                
                // Envio correo
                $mail->send();
                $_SESSION['success'] = "Se ha enviado un correo con la nueva contraseña.";
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error al enviar el correo: {$mail->ErrorInfo}";
            }

            //Redirige la pagina de recuperacion de contraseña
            header("Location: ../views/perfil/recuperarContra.php");
            exit();
            
        } else {
            $_SESSION['error_message'] = 'Correo incorrecto';
            header("Location: ../views/perfil/recuperarContra.php");
            exit();
        }
    }
}
?>