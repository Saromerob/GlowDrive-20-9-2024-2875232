<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="styles/Estilos.css">
</head>

<body>
    <?php
        session_start();

        // Verifica si la variable de sesión 'localidades' está definida
        if (isset($_SESSION['localidades']) || isset($_SESSION['tipo_documento'])) {
            $localidades = $_SESSION['localidades'];
            $typeDocuments = $_SESSION['tipo_documento'];
        } else {
            $localidades = array();
            $typeDocuments = array();
        }
    ?>
    <section class="registro">
        <center><img src="../img/logo.jpeg" class="LogoRegistro"></center> <br>
        <h2>REGISTRO DE USUARIOS</h2>
        <form action="../repository/registro_usuario.php" method="post">
            <label for="nombre">Nombre:</label>
            <input class="controls" type="text" id="nombre" name="nombre" required><br><br>
            <label for="apellido">Apellido:</label>
            <input class="controls" type="text" id="apellido" name="apellido" required><br><br>
            <label for="tipo_documento_id">Tipo de Documento:</label>
            <select class="controls" name="tipo_documento_id" id="tipo_documento_id" required><br><br>
                <?php foreach ($typeDocuments as $typeDocument): ?>
                <option value="<?php echo $typeDocument['id']; ?>"><?php echo $typeDocument['tipo']; ?></option>
                <?php endforeach; ?>
            </select><br>
            </select>
            <label for="num_documento"><br>Numero de Documento:</label>
            <input class="controls" type="text" id="num_documento" name="num_documento" required><br><br>
            <label for="telefono">Telefono:</label>
            <input class="controls" type="text" id="telefono" name="telefono" required><br><br>
            <label for="correo">Correo:</label>
            <input class="controls" type="email" id="correo" name="correo" required><br><br>
            <label for="contrasena">Contraseña:</label>
            <input class="controls" type="password" id="contrasena" name="contrasena" required><br><br>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input class="controls" type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>
            <label for="localidad_id">Localidad:</label>
            <select class="controls" name="localidad_id" id="localidad_id">
                <?php foreach ($localidades as $localidad): ?>
                <option value="<?php echo $localidad['id']; ?>"><?php echo $localidad['nombre']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <input class="controls" type="checkbox" required>Estoy de acuerdo con los <a href="#"> Términos y
                condiciones</a>
            <input class="button" type="submit" name="registro" id="registro" value="Registrarse">
            <p>Si ya tienes cuenta <a href="../index.php">Inicia Sesion</a></p>
        </form><br>
    </section>
</body>

</html>