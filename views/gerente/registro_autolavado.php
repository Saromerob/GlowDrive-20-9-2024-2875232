<?php 

include_once '../../config/db.php';

// Iniciar la sesión y verificar el rol del usuario
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('location: ../../useCase/logOut.php');
    die();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Consultar en la base de datos el ID del usuario que está en SESIÓN
$query = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $_SESSION['nombre'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $userId = $result["id"];
    $_SESSION['id'] = $userId; // Asignar el ID del usuario a la sesión
} else {
    // No se encontró ningún usuario con ese nombre
    // Aquí podrías redirigir a una página de error o mostrar un mensaje
    die("Error: Usuario no encontrado.");
}
?>
<?php
// Consulta para obtener las localidades
$sql = 'SELECT id, nombre FROM localidades';
$stmt = $conn->query($sql);

// Obtener los resultados en un array asociativo
$localidades = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Gerente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/regist_autola.css">
    <link rel="stylesheet" href="../styles/terminos.css">
    <style>
      
        .mensaje-exito {
            color: green;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }
        .mensaje-error {
            color: red;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }
        .boton-agregar-servicios {
            background-color: #ff69b4; /* Color rosa */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            width: 50%;
            margin: 0 auto;
        }
        .boton-agregar-servicios:hover {
            background-color: #ff1493; /* Un tono más oscuro de rosa */
        }
    </style>
</head>

<body>
    <div class="contenedor-principal">
        <nav class="navbar navbar-expand-lg custom-navbar">
            <div class="container-fluid">
                <!-- Logo y Título -->
                <a class="navbar-brand" href="registro_autolavado.php">
                    <img src="../../img/logo.jpeg" alt="Logo" class="logot">
                    <span class="navbar-title">GLOW-DRIVE</span>
                </a>
            </div>
        </nav>
        <br>

        <?php 
$dueno_id = $_SESSION['id']; // ID del usuario logueado
$query = "SELECT * FROM autolavados WHERE dueno_id = :dueno_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':dueno_id', $dueno_id, PDO::PARAM_INT);
$stmt->execute();
$autolavado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($autolavado) {
    // El usuario ya tiene un autolavado registrado
    echo "<h1>Ya tienes un autolavado registrado.</h1>";
    ?>

        <body>
            <div class="container">
                <center>
                    <h1>Ya tienes un autolavado registrado.</h1>
                </center>
                <!-- Logo de GLOWDRIVER -->
                <div class="logo">
                    <img src="../../img/logo.jpeg" alt="Logo de GLOWDRIVER" class="logor">
                </div>

                <!-- Términos y condiciones -->
                <div class="terminos-condiciones">
                    <h2>Términos y Condiciones para Gerentes Aceptados en GLOWDRIVER</h2>
                    <p><strong>Última actualización:</strong> [Fecha]</p>

                    <h3>1. Aceptación del rol</h3>
                    <p>
                        Al ser aceptado como gerente en GLOWDRIVER, el usuario adquiere el rol de administrador del
                        autolavado registrado bajo su dirección. Esto implica la gestión directa de las citas, los
                        servicios ofrecidos y la relación con los clientes dentro de la plataforma.
                    </p>

                    <h3>2. Uso de la plataforma</h3>
                    <p>
                        El gerente es responsable de utilizar la plataforma GLOWDRIVER de manera correcta y de acuerdo
                        con las políticas establecidas. Esto incluye mantener actualizada la información del autolavado,
                        gestionar de manera eficiente las citas y garantizar un servicio adecuado a los clientes.
                    </p>

                    <h3>3. Responsabilidades y obligaciones</h3>
                    <ul>
                        <li><strong>Gestión de citas:</strong> El gerente tiene la obligación de aceptar o rechazar las
                            citas programadas de manera oportuna.</li>
                        <li><strong>Transparencia:</strong> Los datos de contacto y la dirección del autolavado deben
                            ser correctos y estar actualizados.</li>
                        <li><strong>Calidad del servicio:</strong> El gerente debe garantizar que los servicios
                            ofrecidos a través de GLOWDRIVER se realicen con el nivel de calidad descrito en la
                            plataforma.</li>
                    </ul>

                    <h3>4. Privacidad y protección de datos</h3>
                    <p>
                        El gerente debe tratar con confidencialidad toda la información relacionada con los clientes de
                        su autolavado. GLOWDRIVER implementa medidas de seguridad para proteger los datos, pero el
                        gerente también tiene la responsabilidad de no divulgar esta información a terceros no
                        autorizados.
                    </p>

                    <h3>5. Modificaciones en los términos</h3>
                    <p>
                        GLOWDRIVER se reserva el derecho de actualizar estos términos para reflejar cambios en la
                        operación de la plataforma o en las regulaciones aplicables. El gerente será notificado de
                        cualquier cambio importante y deberá aceptar las nuevas condiciones para seguir utilizando el
                        sistema.
                    </p>

                    <h3>6. Revocación del rol</h3>
                    <p>
                        GLOWDRIVER puede revocar el rol de gerente si se detectan infracciones a estos términos,
                        incumplimientos graves de las responsabilidades o mal uso de la plataforma.
                    </p>

                    <h3>7. Resolución de disputas</h3>
                    <p>
                        Cualquier disputa relacionada con el rol de gerente deberá ser notificada a GLOWDRIVER para su
                        revisión. La plataforma se reserva el derecho de mediar y tomar decisiones para resolver el
                        conflicto.
                    </p>

                    <h3>8. Política de notificaciones</h3>
                    <p>
                        El gerente recibirá notificaciones de citas nuevas y respuestas de clientes a través de la
                        plataforma. Es responsabilidad del gerente atender estas notificaciones y tomar las acciones
                        necesarias.
                    </p>
                </div>
            </div>
            <center>
            <?php if (isset($mensajeExito)): ?>
        <div class="mensaje-exito">
            <p><?php echo $mensajeExito; ?></p>
            <a href="agrega_servicios.php">
                <button class="boton-agregar-servicios">Ahora agrega servicios para tus clientes</button>
            </a>
        </div>
    <?php elseif (isset($mensajeError)): ?>
        <div class="mensaje-error">
            <p><?php echo $mensajeError; ?></p>
        </div>
    <?php endif; ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <div>
                            <p class="ini">
                                <button type="button" class="btn btn-outline-light btn-custom"
                                    onclick="window.location.href='paginaInicio.php';">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                        <path fill-rule="evenodd"
                                            d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                    </svg>
                                    Volver
                                </button>
                            </p>
                        </div>
                    </li>
                </ul>
            </center>
        </body>

</html>

<?php
} else { // Permitir el registro del autolavado
?>
<div class="wrapper">
    <form action="regist_autol.php" method="POST">
        <img src="../../img/logo.jpeg" class="LogoRegistro" alt="Logo">
        <h1>INGRESE DATOS PARA REGISTRO</h1>

        <!-- Campo oculto para ID del usuario -->
        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($userId); ?>">

        <!-- Nombre -->
        <label for="nombre">Nombre Autolavado:</label>
        <input name="nombre" id="nombre" class="controls" placeholder="Ingrese nombre" required autocomplete="off">

        <!-- Dirección -->
        <label for="direccion">Dirección:</label>
        <input name="direccion" id="direccion" class="controls" placeholder="Ingrese Dirección" required autocomplete="off">

        <!-- Número Teléfono -->
        <label for="telefono">Número de Teléfono:</label>
        <input name="telefono" type="number" id="telefono" class="controls" placeholder="Número de Teléfono" required autocomplete="off">

        <!-- Horarios -->
        <label for="horario">Horarios:</label>
        <input name="horario" class="controls" placeholder="Horarios: Ejemplo de 12am-11pm" required autocomplete="off">

        <!-- Descripción -->
        <label for="descripcion">Descripción</label>
        <textarea class="controls" id="descripcion" name="descripcion" required
            placeholder="Descripción del Autolavado" autocomplete="off"></textarea>

        <!-- Localidad -->
        <label for="localidad_id">Localidad:</label>
        <select class="controls" id="localidad_id" name="localidad_id" required>
            <option value="">Seleccione localidad</option>
            <?php foreach ($localidades as $localidad): ?>
            <option value="<?php echo htmlspecialchars($localidad['id']); ?>">
                <?php echo htmlspecialchars($localidad['nombre']); ?>
            </option>
            <?php endforeach; ?>
        </select>

        <br>
        <!-- Botón de envío -->
        <br><button type="submit" class="btn">Registrar</button>
    </form>
</div>


<?php
}
?>

<br>
<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-logo">
            <img src="../../img/logo.jpeg" alt="Logo AutoSplash">
        </div>
        <div class="footer-about">
            <h2>Sobre Nosotros</h2>
            <p>GlowDrive es la aplicación líder en servicios de lavado de automóviles, conectando usuarios con
                los mejores lavados cercanos.</p>
        </div>
        <div class="footer-social">
            <h2>Síguenos:</h2>
            <div class="social-icons">
                <a href="https://www.instagram.com" class="social-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-instagram" viewBox="0 0 16 16">
                        <path
                            d="M8 0C5.829 0 5.556.01 4.703.048C3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7C.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297c.04.852.174 1.433.372 1.942c.205.526.478.972.923 1.417c.444.445.89.719 1.416.923c.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417c.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zM8 1.442h.718c2.136 0 2.389.007 3.232.046c.78.035 1.204.166 1.486.275c.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485c.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598c-.28.11-.704.24-1.485.276c-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598a2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485c-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486c.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276c.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92a.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217a4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334a2.667 2.667 0 0 1 0-5.334z" />
                    </svg>
                </a>
                <a href="#" class="social-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-tiktok" viewBox="0 0 16 16">
                        <path
                            d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
                    </svg>
                </a>
                <a href="#" class="social-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path
                            d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654l.666-2.433l-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931a6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646c-.182-.065-.315-.099-.445.099c-.133.197-.513.646-.627.775c-.114.133-.232.148-.43.05c-.197-.1-.836-.308-1.592-.985c-.59-.525-.985-1.175-1.103-1.372c-.114-.198-.011-.304.088-.403c.087-.088.197-.232.296-.346c.1-.114.133-.198.198-.33c.065-.134.034-.248-.015-.347c-.05-.099-.445-1.076-.612-1.47c-.16-.389-.323-.335-.445-.34c-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992c.47.205.84.326 1.129.418c.475.152.904.129 1.246.08c.38-.058 1.171-.48 1.338-.943c.164-.464.164-.862.114-.944c-.05-.084-.182-.133-.38-.232z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <small>&copy; 2024 <b>GlowDrive</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>
</body>

</html>