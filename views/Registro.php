<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/Estilos.css">
</head>

<body>
    <section class="registro">
        <center><img src="../img/logo.jpeg" class="LogoRegistro"></center>
        <br>
        <h1>REGISTRO CLIENTES</h1><br>
        <form>
            Nombres: <input class="controls" type="text" name="nombres" pattern="[A-Za-z\s]+"
                placeholder="Ingrese nombres" required>
            Apellidos: <input class="controls" type="text" name="apellidos" pattern="[A-Za-z\s]+"
                placeholder="Ingrese Apellidos" required>
            Tipo de documento:
            <select class="controls" required>
                <option value=""></option>
                <option>Cédula de ciudadanía C.C</option>
                <option>Tarjeta de identidad T.I</option>
                <option>Cédula de Extranjería C.E</option>
                <option>Pasaporte P.S</option>
            </select>
            Número Documento: <input class="controls" type="text" name="numdoc" id="numdoc" pattern="[0-9]+"
                minlength="7" maxlength="18" placeholder="Número Documento" required>
            Teléfono: <input class="controls" type="text" name="Telefono" id="Telefono" pattern="[0-9]+" minlength="7"
                maxlength="10" placeholder="Ingrese Telefono" required>
            Correo: <input class="controls" type="email" name="Correo" id="Correo" placeholder="Ingrese Correo"
                required>
            Contraseña: <input class="controls" type="password" name="contraseña" id="contraseña" minlength="8"
                maxlength="15" placeholder="Ingrese Contraseña" required>
            Fecha nacimiento: <input class="controls" type="" name="fechaNacimiento" required>
            Dirección<input class="controls" type="text" minlength="5" placeholder="Dirección" required>
            <form>
                Localidad
                <select class="controls" required>
                    <option></option>
                    <option>Antonio Nariño</option>
                    <option>Barrios Unidos</option>
                    <option>Bosa</option>
                    <option>Chapinero</option>
                    <option>Engativá</option>
                    <option>Fontibón</option>
                    <option>Kennedy</option>
                    <option>La Candelaria</option>
                    <option>Puente Aranda</option>
                    <option>San Cristóbal</option>
                    <option>Santa Fe</option>
                    <option>Suba</option>
                    <option>Sumapaz</option>
                    <option>Teusaquillo</option>
                    <option>Tunjuelito</option>
                    <option>Usaquén</option>
                </select>
                <div class="register-link">
                    <input type="checkbox" class="aceptar" required>
                    <p>Estoy de acuerdo con los <a href="#">Términos y condiciones</a></p>
                    <input class="button" type="submit" name="registro" id="registro" value="Registrarse">
                    <p>Si ya tienes cuenta <a href="../index.php">Inicia Sesión</a></p>
                </div>
            </form>
    </section>
</body>

</html>