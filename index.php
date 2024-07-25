<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="views/styles/Estilos1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <form action="usecase/validar.php" method="POST">
            <center><img src="img/logo.jpeg" class="LogoRegistro">
            </center>
            <h1>INICIO DE SESION</h1>
            <div class="input-box">
                <input type="text" placeholder="Nombre de usuario" name="usuario" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Contraseña" name="contraseña" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="Recuerdame">
                <label>
                    <input type="checkbox">Recuerdame la clave
                </label><br><br>
                <a href="" class="link">¿Olvide mi Contraseña?</a>
            </div>
            <button type="submit" class="btn">Ingresar</button>
            <div class="register-link">
                <p>¿No tienes una cuenta? <a href="views/Registro.php">Registrate</a></p>
            </div>
        </form>
    </div>
</body>
</html>