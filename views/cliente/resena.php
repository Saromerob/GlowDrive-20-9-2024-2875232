<?php
include_once '../../config/db.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    die('No se ha iniciado sesión.');
}

$usuarioId = $_SESSION['id']; // Obtener el ID del usuario desde la sesión

$database = new Database();
$conn = $database->conectar();

// Obtener la última reserva activa del usuario (puedes ajustar esta consulta según sea necesario)
$query = "
    SELECT re.id AS reserva_id, re.autolavado_id, r.contenido
    FROM reservas AS re
    JOIN recibos AS r ON r.reserva_id = re.id
    WHERE re.usuario_id = :usuario_id
    ORDER BY re.fecha_creacion DESC
    LIMIT 1
";
$stmt = $conn->prepare($query);
$stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
$stmt->execute();
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    die('No se encontró una reserva para este usuario.');
}

// Obtener los valores necesarios
$autolavadoId = $reserva['autolavado_id'];
$contenidoRecibo = $reserva['contenido'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Recibo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../../img/fondo.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Asegura que el contenido crezca verticalmente */
            align-items: center;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.8); /* Fondo blanco con opacidad */
            border-radius: 10px;
            padding: 20px;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #004080; /* Borde azul marino */
            margin-top: 20px; /* Espacio arriba del contenedor */
            margin-bottom: 20px; /* Espacio abajo del contenedor */
        }
        
        h1 {
            color: #004080; /* Azul marino */
            text-align: center;
        }
        
        pre {
            background-color: #e6f0ff; /* Fondo azul claro */
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        
        button {
            background-color: #004080; /* Azul marino */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }
        
        button:hover {
            background-color: #003366; /* Azul marino oscuro */
        }
        
        form {
            margin-top: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #004080; /* Azul marino */
        }
        
        input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #004080; /* Borde azul marino */
            border-radius: 5px;
        }
        
        input[type="submit"] {
            background-color: #004080; /* Azul marino */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        input[type="submit"]:hover {
            background-color: #003366; /* Azul marino oscuro */
        }

        footer {
            background-color: #003366; /* Azul marino oscuro */
            color: #fff;
            padding: 40px 20px;
            text-align: center;
            font-family: 'Arial', sans-serif;
            width: 100%; /* Asegura que el footer ocupe todo el ancho */
            position: relative;
            bottom: 0;
            margin-top: auto; /* Empuja el footer hacia el fondo */
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Centra el contenido horizontalmente */
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-logo img {
            max-height: 60px; /* Tamaño reducido para las imágenes */
            width: auto;
            border-radius: 50%; /* Imágenes redondas */
        }

        .footer-about, .footer-social {
            flex: 1;
            margin: 20px;
        }

        .footer-about h2, .footer-social h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .footer-about p, .footer-social p {
            font-size: 16px;
            line-height: 1.6;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .social-icon img {
            height: 40px; /* Tamaño reducido para las imágenes sociales */
            width: 40px; /* Tamaño reducido para las imágenes sociales */
            border-radius: 50%; /* Imágenes redondas */
        }

        .footer-bottom {
            margin-top: 20px;
            border-top: 1px solid #002244; /* Color de la línea superior */
            padding-top: 10px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                align-items: center;
            }

            .footer-logo img, .social-icon img {
                max-height: 50px; /* Ajuste en el tamaño para pantallas pequeñas */
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var puntuacionInput = document.getElementById('puntuacion');
            puntuacionInput.setAttribute('min', '1');
            puntuacionInput.setAttribute('max', '10');
            puntuacionInput.setAttribute('step', '1');
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Recibo</h1>
        <pre><?php echo htmlspecialchars($contenidoRecibo); ?></pre>

        <!-- Botón de cerrar -->
        <button class="button" onclick="window.close();">Cerrar</button>
        
        <!-- Formulario para dejar reseña -->
        <form action="../../repository/reseñaCliente.php" method="POST">
            <input type="hidden" name="autolavado_id" value="<?php echo $autolavadoId; ?>">
            <input type="hidden" name="usuario_id" value="<?php echo $usuarioId; ?>">
            <input type="hidden" name="fecha_creacion" value="<?php echo date('Y-m-d'); ?>">
            
            <label for="puntuacion">Puntuación</label>
            <input type="number" id="puntuacion" name="puntuacion" placeholder="Puntuación" required>
            
            <label for="comentario">Comentarios</label>
            <textarea id="comentario" name="comentario" placeholder="Ingresa tus comentarios aquí"></textarea>
            
            <input type="submit" value="Dejar Reseña">
        </form>
    </div>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <a href="index.php">
                    <img src="../../img/logo.jpeg" alt="Logo AutoSplash">
                </a>
            </div>
            <div class="footer-about">
                <h2>Sobre Nosotros</h2>
                <p>GlowDrive es la aplicación líder en servicios de lavado de automóviles, conectando usuarios con los mejores lavados cercanos.</p>
            </div>
            <div class="footer-social">
                <h2>Síguenos:</h2>
                <div class="social-icons">
                    <a href="https://www.instagram.com" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048C3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7C.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297c.04.852.174 1.433.372 1.942c.205.526.478.972.923 1.417c.444.445.89.719 1.416.923c.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417c.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zM8 1.442h.718c2.136 0 2.389.007 3.232.046c.78.035 1.204.166 1.486.275c.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485c.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598c-.28.11-.704.24-1.485.276c-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598a2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485c-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486c.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276c.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92a.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217a4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334a2.667 2.667 0 0 1 0-5.334z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                            <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654l.666-2.433l-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931a6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646c-.182-.065-.315-.099-.445.099c-.133.197-.513.646-.627.775c-.114.133-.232.148-.43.05c-.197-.1-.836-.308-1.592-.985c-.59-.525-.985-1.175-1.103-1.372c-.114-.198-.011-.304.088-.403c.087-.088.197-.232.296-.346c.1-.114.133-.198.198-.33c.065-.134.034-.248-.015-.347c-.05-.099-.445-1.076-.612-1.47c-.16-.389-.323-.335-.445-.34c-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992c.47.205.84.326 1.129.418c.475.152.904.129 1.246.08c.38-.058 1.171-.48 1.338-.943c.164-.464.164-.862.114-.944c-.05-.084-.182-.133-.38-.232z"/>
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
