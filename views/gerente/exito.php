<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <link rel="stylesheet" href="../../css/estilos.css"> <!-- Asegúrate de tener este archivo o incluir el CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3; /* Gris claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-message {
            color: #4682B4; /* Azul acero */
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-add-service {
            background-color: #4682B4; /* Fondo azul acero */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-add-service:hover {
            background-color: #4169E1; /* Azul real al pasar el cursor */
        }

        .btn-add-service svg {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-message">
            ¡Registro Exitoso!
        </div>
        <button class="btn-add-service" onclick="window.location.href='agg_servicios.php';">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 1a7 7 0 1 1 0 14A7 7 0 0 1 8 1zm0-1a8 8 0 1 0 0 16A8 8 0 0 0 8 0z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3H4a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Ahora agrega tu servicio para tus clientes
        </button>
    </div>
</body>
</html>
