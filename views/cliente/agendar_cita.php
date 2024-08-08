<?php
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

// Consultas para autolavados y servicios
$sql_autolavados = "SELECT id, nombre FROM autolavados";
$stmt_autolavados = $conn->query($sql_autolavados);

$sql_servicios = "SELECT id, nombre FROM servicios";
$stmt_servicios = $conn->query($sql_servicios);

// Consultar tipos de vehículos
$sql_tipo_vehiculo = "SELECT id, tipo FROM tipo_vehiculo";
$stmt_tipo_vehiculo = $conn->query($sql_tipo_vehiculo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CitasCliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/Estilos4.css">
    <style>
        /* Estilos Generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: url('../../img/fondo.jpg');
            font-family: 'calibri';
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        h1 {
            color: #fff;
        }
        .contenedor-principal {
            flex: 1;
        }
        .pie-pagina {
            margin-top: auto;
        }

        /* Navbar */
        .navbar {
            background-color: transparent;
            backdrop-filter: blur(10px);
            box-shadow: 5px 10px 12px #000;
        }

        .navbar .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar .navbar-brand img {
            height: 90px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .titulo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d1b2a;
            border: 2px solid white;
            border-radius: 20px;
            background-color: rgba(219, 219, 217);
            padding: 0 10px;
        }

        .navbar .nav-link {
            font-size: 1.1rem;
            color: #0d1b2a;
            font-weight: bold;
        }

        .navbar .nav-link:hover {
            color: gray;
        }

        /* Banner */
        .wrapper {
            width: 420px;
            background: transparent;
            border: rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 7px 13px 37px #000;
            border-radius: 20px;
            padding: 30px 40px;
            margin: auto;
            text-align: center;
            color: #fff;
        }

        .controls {
            border-radius: 20px;
            border: 2px solid #000;
            width: 100%;
            height: 50px;
            margin: 5px 0;
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 15px 0;
        }

        .input-box input,
        .input-box textarea {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border: 2px solid #000;
            border-radius: 20px;
            padding: 10px;
            color: #fff;
        }

        .input-box input::placeholder,
        .input-box textarea::placeholder {
            color: #000;
        }

        .btn {
            width: 100%;
            height: 45px;
            background: #99c9bd;
            border: none;
            border-radius: 40px;
            box-shadow: 7px 13px 37px #000;
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
            margin-top: 20px;
        }

        /* Footer */
        footer.pie-pagina {
            background-color: rgb(55, 84, 107);
            color: #fff;
            padding: 20px 0;
        }

        footer.pie-pagina .grupo-1 {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
        }

        footer.pie-pagina .grupo-1 .BOX {
            text-align: center;
        }

        footer.pie-pagina .grupo-1 .BOX h2 {
            margin-bottom: 15px;
        }

        footer.pie-pagina .red-social a {
            display: inline-block;
            width: 45px;
            height: 45px;
            line-height: 45px;
            margin: 5px;
            border-radius: 50%;
            background-color: black;
            color: #fff;
            text-align: center;
            transition: all 0.3s ease;
        }

        footer.pie-pagina .red-social a:hover {
            color: aqua;
        }

        footer.pie-pagina .grupo-2 {
            text-align: center;
            padding: 10px 0;
        }

        footer.pie-pagina .grupo-2 small {
            font-size: 15px;
        }
        .LogoRegistro{
            radius: 50px;
        }

        /* Responsividad */
        @media (max-width: 800px) {
            .pie-pagina .grupo-1 {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .navbar .nav-link {
                font-size: 0.9rem;
            }

            .navbar .navbar-brand .titulo {
                font-size: 1.2rem;
            }

            .wrapper {
                width: 90%;
            }
        }
        /* General */
body {
    margin: 0;
    padding: 0;
    background: url('../../img/fondo.jpg');
    font-family: 'calibri';
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Wrapper del formulario */
.wrapper {
    width: 420px;
    background: transparent;
    border: rgba(255, 255, 255, .2);
    backdrop-filter: blur(20px);
    box-shadow: 7px 13px 37px #000;
    border-radius: 20px;
    padding: 30px 40px;
    margin: auto;
    text-align: center;
    color: #fff;
}

/* Imagen dentro del formulario */
.wrapper img.LogoRegistro {
    height: 80px; /* Tamaño pequeño */
    width: 80px; /* Mantiene la forma circular */
    border-radius: 50%; /* Hace la imagen redonda */
    margin-bottom: 20px;
}

/* Imagen adicional debajo del formulario */
.extra-img {
    display: block;
    margin: 20px auto;
    height: 50px; /* Tamaño pequeño */
    width: 50px; /* Mantiene la forma circular */
    border-radius: 50%; /* Hace la imagen redonda */
    object-fit: cover; /* Asegura que la imagen se ajuste bien */
}

/* Ajustes responsivos */
@media (max-width: 800px) {
    .wrapper {
        width: 90%;
    }
}
h2{
    color: black;
}


    </style>
</head>
<body>
    <div class="contenedor-principal">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="agendar_cita.php">
                    <img src="../../img/logo.jpeg" alt="Logo" id="logo" class="logo">
                    <div class="titulo">AUTO-SPLASH</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                    <li class="nav-item conos">
                        <button type="button" class="btn btn-outline-light" onclick="window.location.href='Mapa.php';">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            </svg>
                            Mapa
                        </button>
                    </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <div>
                            <p class="ini">
                                <button type="button" class="btn btn-outline-light" onclick="window.location.href='paginaInicio.php';">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
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

        <div class="wrapper">
            <form action="enviar_cita.php" method="post">
                <img src="../../img/logo.jpeg" class="LogoRegistro" alt="Logo">
                <h1>INGRESE DATOS PARA RESERVACIÓN</h1>

                <!-- Campo oculto para ID del usuario -->
                <input type="hidden" name="usuario_id" value="<!-- ID del usuario actual -->">

                <!-- Selección de autolavado -->
                <label for="autolavado">Autolavado:</label>
                <select name="autolavado_id" class="controls" required>
                    <option value="">Seleccione un autolavado</option>
                    <?php
                    // Verifica si hay resultados
                    if ($stmt_autolavados->rowCount() > 0) {
                        // Muestra cada autolavado como una opción
                        while($row = $stmt_autolavados->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No hay autolavados disponibles</option>';
                    }
                    ?>
                </select>

                <!-- Selección de servicio -->
                <label for="servicio">Servicio:</label>
                <select name="servicio_id" class="controls" required>
                    <option value="">Seleccione un servicio</option>
                    <?php
                    // Verifica si hay resultados
                    if ($stmt_servicios->rowCount() > 0) {
                        // Muestra cada servicio como una opción
                        while($row = $stmt_servicios->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No hay servicios disponibles</option>';
                    }
                    ?>
                </select>

                <!-- Entrada de fecha y hora -->
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" class="input-box" required>
                <label for="hora">Hora:</label>
                <input type="time" name="hora" class="input-box" required>

                <!-- Datos personales -->
                <label for="nombre">Nombre:</label>
                <input class="controls" type="text" id="nombre" name="nombre" required autocomplete="off">
                <label for="apellido">Apellido:</label>
                <input class="controls" type="text" id="apellido" name="apellido" required autocomplete="off">
                <label for="placa">Placa:</label>
                <input class="controls" type="text" id="placa" name="placa" required autocomplete="off">
                <label for="telefono">Teléfono:</label>
                <input class="controls" type="number" id="telefono" name="telefono" required autocomplete="off">
                <label for="tipo_vehiculo">Tipo de vehículo:</label>
                <select name="tipo_vehiculo" class="controls" required>
                    <option value="">Seleccione un tipo de vehículo</option>
                    <?php
                    // Verifica si hay resultados
                    if ($stmt_tipo_vehiculo->rowCount() > 0) {
                        // Muestra cada tipo de vehículo como una opción
                        while($row = $stmt_tipo_vehiculo->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['tipo'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No hay tipos de vehículo disponibles</option>';
                    }
                    ?>
                </select>

                <!-- Comentarios -->
                <label for="comentarios">Comentarios:</label>
                <textarea name="comentarios" class="input-box" placeholder="Ingrese comentarios aquí (opcional)"></textarea>

                <!-- Botón de envío -->
                <button type="submit" class="btn">Enviar Cita</button>
            </form>
        </div>
    </div>

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
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-instagram icon-lg" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                    </a>
                    <a href="#" class="tik-tok">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-tiktok icon-lg" viewBox="0 0 16 16">
                        <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                        </svg>
                    </a>
                    <a href="#" class="whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                        </svg>

                    </a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            <small>&copy; 2024 <b>AutoSplash</b> - Todos Los Derechos Reservados.</small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
