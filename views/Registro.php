<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="styles/Estilos.css">
</head>

<body>
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
                <option value="1">Cedula de Ciudadanía C.C</option>
                <option value="2">Cedula de Extranjería C.E</option>
                <option value="3">Pasaporte </option>
                <option value="4">NIT</option>
                <option value="5">Tarjeta de Identidad</option>
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
                <option value="1">Usaquén</option>
                <option value="2">Chapinero</option>
                <option value="3">Santa Fe</option>
                <option value="4">San Cristóbal</option>
                <option value="5">Usme</option>
                <option value="6">Tunjuelito</option>
                <option value="7">Bosa</option>
                <option value="8">Kennedy</option>
                <option value="9">Fontibón</option>
                <option value="10">Engativá</option>
                <option value="11">Suba</option>
                <option value="12">Barrios Unidos</option>
                <option value="13">Teusaquillo</option>
                <option value="14">Los Mártires</option>
                <option value="15">Antonio Nariño</option>
                <option value="16">Puente Aranda</option>
                <option value="17">La Candelaria</option>
                <option value="18">Rafael Uribe Uribe</option>
                <option value="19">Ciudad Bolívar</option>
                <option value="20">Sumapaz</option>
            </select><br><br>
            <input class="controls" type="checkbox" required>Estoy de acuerdo con los <a href="#"> Términos y
                condiciones</a>
            <input class="button" type="submit" name="registro" id="registro" value="Registrarse">
            <p>Si ya tienes cuenta <a href="../index.php">Inicia Sesion</a></p>
        </form><br>
    </section>
</body>

</html>