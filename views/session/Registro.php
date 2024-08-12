<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="../styles/Estilos.css">
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
        <center><a href="../../index.php"><img src="../../img/logo.jpeg" class="LogoRegistro"></a></center> <br>
        <h2>REGISTRO DE CLIENTES</h2>
        <form action="../../repository/registro_usuario.php" method="post">
            Nombres: <input class="controls" type="text" name="nombres" pattern="[A-Za-z\s]+"
                placeholder="Ingrese nombres" required>
            Apellidos: <input class="controls" type="text" name="apellidos" pattern="[A-Za-z\s]+"
                placeholder="Ingrese Apellidos" required>
            <label for="tipo_documento_id">Tipo de Documento:</label>
            <select class="controls" name="tipo_documento_id" id="tipo_documento_id" required><br><br>
                <?php foreach ($typeDocuments as $typeDocument): ?>
                <option value="<?php echo $typeDocument['id']; ?>"><?php echo $typeDocument['tipo']; ?></option>
                <?php endforeach; ?>
            </select><br>
            Número Documento: <input class="controls" type="text" name="numdoc" id="numdoc" pattern="[0-9]+"
                minlength="7" maxlength="18" placeholder="Número Documento" required>
            Teléfono: <input class="controls" type="text" name="Telefono" id="Telefono" pattern="[0-9]+" minlength="7"
                maxlength="10" placeholder="Ingrese Telefono" required>
            Correo: <input class="controls" type="email" name="Correo" id="Correo" placeholder="Ingrese Correo"
                required>
            Contraseña: <input class="controls" type="password" name="contraseña" id="contraseña" minlength="8"
                maxlength="15" placeholder="Ingrese Contraseña" required>
            Fecha nacimiento: <input class="controls" type="date" name="fechaNacimiento" required>
            <label for="localidad_id">Localidad:</label>
            <select class="controls" name="localidad_id" id="localidad_id">
                <?php foreach ($localidades as $localidad): ?>
                <option value="<?php echo $localidad['id']; ?>"><?php echo $localidad['nombre']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <div class="Recuerdame">
                <label>
                    <input type="checkbox">Estoy de acuerdo con los términos y condiciones
                </label><br><br>
            </div>
            <input class="button" type="submit" name="registro" id="registro" value="Registrarse">
            <p>Si ya tienes cuenta <a href="sesion.php">Inicia Sesion</a></p>
        </form><br>
    </section>

    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="BOX">
                <figure>
                    <a href="#">
                        <img src="../../img/logo.jpeg" alt="Logo AutoSplash">
                    </a>
                </figure>
            </div>
            <div class="BOX">
                <h2><a href="Nosotros.html"><a href="../../views/Nosotros.php" class="nosotros">SOBRE
                            NOSOTROS</a></h2>
                <div class="grupo-2">
                    <small>&copy; 2024<b>AutoSplash<br>-Todos Los Derechos Reservados.</small>

                </div>
            </div>

    </footer>
</body>

</html>