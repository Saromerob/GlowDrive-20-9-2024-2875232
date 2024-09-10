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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Gerente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/Estilos7.css">
</head>

<body>
    <div class="contenedor-principal">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="registro_autolavado.php">
                    <img src="../../img/logo.jpeg" alt="Logo" id="logo" class="logo">
                    <div class="titulo">AUTO-SPLASH</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item conos">

                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <div>
                                <p class="ini">
                                    <button type="button" class="btn btn-outline-light"
                                        onclick="window.location.href='paginaInicio.php';">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
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
                </div>
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
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Términos y Condiciones - GLOWDRIVER</title>
            <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f0f8ff;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 80%;
                margin: 20px auto;
                padding: 20px;
                background-color: white;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .logo {
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }

            .logo img {
                max-width: 200px;
            }

            .terminos-condiciones h2 {
                color: #0077b6;
                /* Azul océano */
                text-align: center;
                font-size: 28px;
            }

            .terminos-condiciones p {
                font-size: 16px;
                line-height: 1.6;
                color: #333;
            }

            .terminos-condiciones h3 {
                color: #023e8a;
                margin-top: 20px;
            }

            .terminos-condiciones ul {
                margin-left: 20px;
                color: #333;
            }

            .terminos-condiciones ul li {
                margin-bottom: 10px;
            }

            /* Botones y estilo de los enlaces */
            .terminos-condiciones a {
                color: #0077b6;
                text-decoration: none;
            }

            .terminos-condiciones a:hover {
                text-decoration: underline;
            }
            </style>
        </head>

        <body>
            <div class="container">
                <!-- Logo de GLOWDRIVER -->
                <div class="logo">
                    <img src="../../img/logo.jpeg" alt="Logo de GLOWDRIVER">
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
        </body>

        </html>

        <?php
} else { // Permitir el registro del autolavado
?>
        <div class="wrapper">
            <form action="registrar_autolavado.php" method="POST">
                <img src="../../img/logo.jpeg" class="LogoRegistro" alt="Logo">
                <h1>INGRESE DATOS PARA REGISTRO</h1>

                <!-- Campo oculto para ID del usuario -->
                <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario_id); ?>">

                <!-- Nombre -->
                <label for="nombre">Nombre Autolavado:</label>
                <input name="nombre" id="nombre" class="controls" placeholder="Ingrese nombre" required>

                <!-- Dirección -->
                <label for="direccion">Dirección:</label>
                <input name="direccion" id="direccion" class="controls" placeholder="Ingrese Dirección" required>

                <!-- Número Teléfono -->
                <label for="telefono">Número de Teléfono:</label>
                <input name="telefono" id="telefono" class="controls" placeholder="Número de Teléfono" required>

                <!-- Horarios -->
                <label for="horario">Horarios:</label>
                <input name="horario" class="controls" placeholder="Horarios" required>

                <!-- Datos personales -->
                <label for="descripcion">Descripción</label>
                <textarea class="controls" id="descripcion" name="descripcion" required
                    placeholder="Descripción del Autolavado"></textarea>

                <label for="dueño">Dueño:</label>
                <input class="controls" type="text" id="dueño_id" name="dueño_id" required placeholder="Nombre Dueño">

                <label for="placa">Localidad:</label>
                <select class="controls" id="localidad_id" name="localidad_id" required>
                    <option value="">Seleccione localidad</option>
                    <!-- Opciones de localidad deberían ser añadidas aquí dinámicamente -->
                </select>

                <!-- Botón de envío -->
                <button type="submit" class="btn">Registrar</button>
            </form>
        </div>
        <?php
}
?>

        <br>
        <!-- Footer -->
        <footer class="pie-pagina">
            <div class="grupo-1">
                <div class="BOX">
                    <div class="contenedor-principal">
                        <!-- ... contenido del formulario ... -->
                        <img src="../../img/logo.jpeg" class="extra-img" alt="Imagen Redonda Pequeña">
                    </div>
                </div>
                <div class="BOX">
                    <h2>SOBRE NOSOTROS</h2>
                    <p>TEXTO EJEMPLO</p>
                </div>
                <div class="BOX">
                    <h2>Síguenos:</h2>
                    <div class="red-social">
                        <a href="https://www.instagram.com" class="instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                class="bi bi-instagram icon-lg" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.297-.048c.852-.04 1.433-.174 1.942-.372a3.868 3.868 0 0 0 1.416-.923 3.885 3.885 0 0 0 .923-1.417c.198-.509.333-1.09.372-1.942.039-.853.048-1.125.048-3.297s-.01-2.444-.048-3.297c-.04-.852-.174-1.433-.372-1.942a3.878 3.878 0 0 0-.923-1.416 3.893 3.893 0 0 0-1.417-.923c-.509-.198-1.09-.333-1.942-.372C10.444.01 10.172 0 8 0zm0 1.459c2.139 0 2.396.007 3.24.046.782.036 1.207.166 1.49.276.375.146.641.322.922.602.28.28.456.546.601.921.11.284.24.709.276 1.49.04.845.047 1.102.047 3.24 0 2.139-.006 2.396-.046 3.24-.036.782-.166 1.207-.276 1.49a2.454 2.454 0 0 1-.602.922c-.28.28-.546.455-.921.601-.284.11-.709.24-1.49.276-.845.039-1.102.047-3.24.047-2.139 0-2.396-.007-3.24-.046-.782-.036-1.207-.166-1.49-.276a2.49 2.49 0 0 1-.922-.602 2.492 2.492 0 0 1-.601-.921c-.11-.284-.24-.709-.276-1.49-.04-.845-.047-1.102-.047-3.24 0-2.139.007-2.396.046-3.24.036-.782.166-1.207.276-1.49a2.467 2.467 0 0 1 .602-.922 2.481 2.481 0 0 1 .921-.601c.284-.11.709-.24 1.49-.276.845-.039 1.102-.047 3.24-.047zM8 3.889a4.111 4.111 0 1 0 0 8.223 4.111 4.111 0 0 0 0-8.223zm0 6.759A2.648 2.648 0 1 1 8 4.35a2.648 2.648 0 0 1 0 5.297zm5.271-6.896a.959.959 0 1 0-1.918 0 .959.959 0 0 0 1.918 0z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="grupo-2">
                <small>Auto-Splash</small>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz4fnFO9gybBogGzOgQpeKnFQz7F2F6z9EiF19jqF5wrFvqN9Twv2ImFga" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-ST98ZRN3nmkCkzGp1OUtkP/Mo1E2/pxI1FVy31ySwm9GAK/TkvcP+nQEOE9sF0jw" crossorigin="anonymous">
        </script>
</body>

</html>