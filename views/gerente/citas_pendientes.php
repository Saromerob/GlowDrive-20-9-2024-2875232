<?php
include_once '../../config/db.php';
session_start();

// Asegurarse de que el usuario es gerente o dueño
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) { 
    header('Location: ../../useCase/logOut.php');
    exit();
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->conectar();

// Obtener todas las citas pendientes del autolavado gestionado por el gerente/dueño logueado
$query = "SELECT c.id, c.fecha, c.hora, u.nombre, c.estado 
          FROM citas c 
          JOIN usuarios u ON c.usuario_id = u.id 
          WHERE c.autolavado_id = :autolavado_id AND c.estado = 'pendiente'";
          
$stmt = $conn->prepare($query);
$stmt->bindParam(':autolavado_id', $_SESSION['autolavado_id'], PDO::PARAM_INT);
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/Estilos3.css">
</head>

<body>
    <h2>Citas Pendientes</h2>
    <table>
        <tr>
            <th>Nombre del Cliente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($citas as $cita): ?>
        <tr>
            <td><?php echo htmlspecialchars($cita['nombre']); ?></td>
            <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
            <td><?php echo htmlspecialchars($cita['hora']); ?></td>
            <td>
                <form action="actualizar_cita.php" method="POST">
                    <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                    <button type="submit" name="accion" value="confirmar">Confirmar</button>
                    <button type="submit" name="accion" value="rechazar">Rechazar</button>
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
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <!-- Footer 
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="BOX">
                <div class="contenedor-principal">
                    ... contenido del formulario ... 
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
    -->
</body>