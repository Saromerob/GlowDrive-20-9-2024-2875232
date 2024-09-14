<?php /*
include_once '../../config/db.php';// Incluye el archivo de conexión
//require_once 'conexionPDOresumida.php'; 
?>
<?php 
session_start();
if (!isset($_SESSION['role_id']))
	{
		header('location: ../../../app-autosplash/index.php');
		die(); exit();
	}
else
	{
		if($_SESSION['role_id'] !=1)
			{
				header('location: ../../../app-autosplash/index.php');
				die(); exit();
			}
	}
?>
<html>

<head></head>

<body style="background-color:#328DC9;">
    <div align="center">
        <?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->conectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];
	//$fotosesion = $_SESSION['foto'];//echo $fotosesion;
echo "<font face= impact size= 6> Bienvenid@ <br>Administrador  <br>".$usuario."</font><br>";
?>
    </div>
    <table border="6" align="center">
        <tr>
            <td>
                <div align="center">
                    <form method="POST" action="#">
                        IDROL <input type="number" name="idrol" required="" placeholder="Ingrese Rol" min="1"
                            max="4"><br>
                        NOMBRE <input type="text" name="usuario" required="" placeholder="Ingrese Nombre"
                            pattern="[a-z]{4,8}"><br>
                        APELLIDO <input type="text" name="apellido" required="" placeholder="Ingrese Apellido"
                            pattern="[a-z]{4,8}"><br>
                        NUMERO DOCUMENTO<input type="number" name="numeroDoc" required=""
                            placeholder="Ingrese numero de documento"><br>
                        TIPO DOCUMENTO <input type="number" name="documento" required=""
                            placeholder="Ingrese tipo de documento"><br>
                        TELEFONO <input type="number" name="telefono" required="" placeholder="Ingrese Telefono"><br>
                        EMAIL <input type="email" name="email" required="" placeholder="Ingrese Email"><br>
                        CLAVE <input type="password" name="clave" required="" placeholder="Ingrese Contraseña"><br>
                        LOCALIDAD <input type="number" name="localidad" required="" placeholder="Ingrese localidad"><br>
                        FECHANACIMIENTO <input type="date" name="nacimiento" required=""
                            placeholder="Ingrese fecha de nacimiento"><br>
                        ENVIAR <input type="submit" name="insertar" value="Insertar Datos">
                    </form>
                </div>
                <?php
if (isset($_POST['insertar'])) 
	{
    $idrol 		= $_POST['idrol'];
    $usuario 	= $_POST['usuario'];
    $apellido 	= $_POST['apellido'];
    $numDoc 	= $_POST['numeroDoc'];
    $TipDoc 	= $_POST['documento'];
    $telefono 	= $_POST['telefono'];
    $email 		= $_POST['email'];
    $clave 		= $_POST['clave'];
	$localidad 		= $_POST['localidad'];
    $fechNacimiento = $_POST['nacimiento'];

    try 
    	{
//include_once '../../config/db.php';// Incluye el archivo de conexión
        $db = new Database(); // Crea una instancia de la clase Database
        $conexion = $db->conectar(); // Establece la conexión a la base de datos
        // Preparar la consulta SQL para la inserción de datos
		
       // $query = "INSERT INTO  usuarios (nombre, apellido, num_documento, tipo_documento_id, telefono, correo, contrasena, fecha_nacimiento, role_id) VALUES ('$usuario', '$apellido', '$numDoc', '$TipDoc', '$telefono', '$email', '$clave', '$fechNacimiento', '$idrol')";
		$query = "INSERT INTO usuarios (nombre, apellido, num_documento, tipo_documento_id, telefono, correo, contrasena, fecha_nacimiento, localidad_id, role_id) VALUES (:usuario, :apellido, :numeroDoc, :documento, :telefono,:email, :clave, :nacimiento, :localidad, :idrol)";
		$stmt = $conexion->prepare($query);// Preparar la sentencia, Las sentencias preparadas son una técnica utilizada para ejecutar consultas SQL de manera segura y eficiente en bd.
       //bindParam Vincula un parámetro al nombre de variable especificado 
        // Bind de los parámetros, $stmt:variable que hace referencia a una sentencia preparada.
		//la función bindParam para vincular un parámetro llamado :usuario a una variable $usuario.
        $stmt->bindParam(':usuario', $usuario);//->bindParam(':usuario', $usuario): Esta parte de la línea de código enlaza un valor a un parámetro en la sentencia preparada.
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':numeroDoc', $numDoc);
        $stmt->bindParam(':documento', $TipDoc);
        $stmt->bindParam(':clave', $clave);//:usuario es un marcador de posición en la sentencia preparada. Los marcadores de posición son indicadores que se utilizan en la sentencia SQL en lugar de valores concretos para evitar la inyección de SQL y permitir la reutilización de la sentencia con diferentes valores.
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':idrol', $idrol);//$idrol es una variable que contiene el valor que deseas asignar al marcador :idrol. El valor de $idrol se utilizará en lugar del marcador :idrol cuando se ejecute la sentencia preparada.
        $stmt->bindParam(':email', $email);
		$stmt->bindParam(':localidad', $localidad);
        $stmt->bindParam(':nacimiento', $fechNacimiento);
        // Ejecutar la sentencia
        $stmt->execute();
        if ($stmt)
			{// Comprobar si se insertó correctamente
				
	        if ($stmt->rowCount() > 0) 
		        {	echo "Registro insertado exitosamente.";//header("location: administrador.php");
				 	echo "<script> window.open('pag_inicio.php')  </script> ";
		        } 
		      else 
		        {   echo "No se pudo insertar el registro.";
		        }
			}
	    } 
	    catch (PDOException $e) 
	    {   die("Error en la inserción: " . $e->getMessage());
	    }			
	}
	unset($_POST['insertar']);
		?>
            </td>
    </table>
    <?php
try {
    $db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->conectar(); // Obtiene la conexión PDO
    $observar = "SELECT * FROM usuarios";
    $statement = $conexion->query($observar);
    if ($statement) {// Verifica si la consulta se ejecutó correctamente
        echo '<table border="3" align="center">
            <tr>	
                <th>ID</th>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>NUMERO DE DOCUMENTO</th>
                <th>TIPO DE DOCUMENTO</th>
                <th>TELEFONO</th>
                <th>EMAIL</th>
                <th>CONTRASEÑA</th>
                <th>FECHA DE NACIMIENTO</th>
                <th>LOCALIDAD</th>
                <th>ROL</th>
                <th>EDITAR</th>
                <th>BORRAR</th>
            </tr>';

        while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $filas['id'];
            $usuario = $filas['nombre'];
            $lastname = $filas['apellido'];
            $ndoc = $filas['num_documento'];
            $tdoc = $filas['tipo_documento_id'];
            $celular = $filas['telefono'];
            $password = $filas['contrasena'];
            $email = $filas['correo'];
            $iderol = $filas['role_id'];
            $local = $filas['localidad_id'];
            $fnacimiento = $filas['fecha_nacimiento'];
            //$fotografia = $filas['foto'];

            echo '<tr align="center">
                    <td>' . $id . '</td>
                    <td>' . $usuario . '</td>
                    <td>' . $lastname . '</td>
                    <td>' . $ndoc . '</td>
                    <td>' . $tdoc . '</td>
                    <td>' . $celular . '</td>
                    <td>' . $email . '</td>
                    <td>' . $password . '</td>
                    <td>' . $fnacimiento . '</td>
                    <td>' . $local . '</td>
                    <td>' . $iderol . '</td>
                    <td><a href="pag_inicio.php?editar=' . $id . '">Editar</a></td>
										<td><button style="background-color: orange"><a href="pag_inicio.php? borrar='. $id . '">Borrar</a></button></td>

                </tr>';
        }
        echo '</table>';
    } 
    else 
    {   echo 'Error en la consulta.';
    }
} 
catch (PDOException $e) 
	{   die("Error en conexión a la base de datos: " . $e->getMessage());
	}
?>

    <?php
if(isset($_GET['editar']))
	{
	try 
		{
		$editar_id = $_GET['editar'];
	    $db = new Database(); // Crea una instancia de la clase Database
	    $conexion = $db->conectar(); // Obtiene la conexión PDO
	    $observar = "SELECT * FROM usuarios WHERE id = '$editar_id'";
	    $statement = $conexion->query($observar);
	    if ($statement)// Verifica si la consulta se ejecutó correctamente
		    {
	        while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) 
		        {
        			$id         =$filas['id'];
					$usuario    =$filas['nombre'];
					$apellidoo    =$filas['apellido'];
					$docnum    =$filas['num_documento'];
					$doctip    =$filas['tipo_documento_id'];
					$telf    =$filas['telefono'];
					$correo      =$filas['correo'];
					$contrasena   =$filas['contrasena'];
					$nacimfech      =$filas['fecha_nacimiento'];
					$local      =$filas['localidad_id'];
					$idrole      =$filas['role_id'];
					
					
		        }
	        echo '</table>';
			} 
		else 
			{ echo 'Error en la consulta.';
			} 
		} 
	catch (PDOException $e) 
		{  die("Error en conexión a la base de datos: " . $e->getMessage());
		}
?>
    <table border="6" align="center">
        <tr>
            <td>
                <div align="center">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        NOMBRE <input type="text" name="usuario" value="<?php echo $usuario  ?>"> <br>
                        APELLIDO <input type="text" name="apellido" value="<?php echo $apellidoo  ?>"> <br>
                        NUMERO DOCUMENTO <input type="number" name="numdocumento" value="<?php echo $docnum  ?>"> <br>
                        TIPO DE DOCUMENTO <input type="number" name="tipdocument" value="<?php echo $doctip  ?>"> <br>
                        TELEFONO <input type="number" name="celular" value="<?php echo $usuario  ?>"> <br>
                        EMAIL <input type="email" name="correo" value="<?php echo $correo    ?>"><br>
                        CLAVE <input type="password" name="clave" value="<?php echo $contrasena ?>"><br>
                        FECHA NACIMIENTO <input type="date" name="fechnacimiento"
                            value="<?php echo $nacimfech    ?>"><br>
                        LOCALIDAD <input type="number" name="localidad" value="<?php echo $local    ?>"><br>
                        ROL <input type="number" name="rol" value="<?php echo $idrole    ?>"><br>

                        <input type="submit" name="actualizame" value="Actualizar Datos" style="cursor: pointer;"><br>
                    </form>
                </div>

    </table>
    <?php
unset($_POST['editar']);//no es necesario usar unset($_POST['editar']); Los datos POST se enviarán solo cuando el formulario se envía, por lo que no necesitas eliminarlos manualmente.
  }
?>
    <?php
if(isset($_POST['actualizame']))
	{
	$actualizausuario		= $_POST['usuario'];
	$actualizaapellido 		= $_POST['apellido'];
	$actualizandocumento 	= $_POST['numdocumento'];
	$actualizatdocumento 	= $_POST['tipdocument'];
	$actualizacelular 		= $_POST['celular'];
	$actualizaemail   		= $_POST['correo'];
	$actualizaclave   		= $_POST['clave'];
	$actualizafnacimiento 	= $_POST['fechnacimiento'];
	$actualizalocalidad 	= $_POST['localidad'];
	$actualizaidrol   		= $_POST['rol'];
	
	

	$ruta = "imagenes/".basename($_FILES['imagenasubir']['name']);
		if (move_uploaded_file($_FILES['imagenasubir']['tmp_name'],$ruta)) 
			{
			echo "<div align='center'><font face='impact' size='3'><b> 
			El archivo ".basename($_FILES['imagenasubir']['name'])." ha sido subido satisfactoriamente</b></font></div>";
			}
		else
			{	echo "el archivo de imagen no se cambio";
			} // esta funcion esta en discusion para ser aprobada o no
	try {
	    $db = new Database(); // Crea una instancia de la clase Database
	    $conexion = $db->conectar(); // Obtiene la conexión PDO
	    $observar = "UPDATE usuarios SET nombre = '$actualizausuario', apellido = '$actualizaapellido', num_documento = '$actualizandocumento', tipo_documento_id = '$actualizatdocumento', telefono = '$actualizacelular', correo = '$actualizaemail', contrasena = ('$actualizaclave'), fecha_nacimiento = '$actualizafnacimiento', localidad_id = '$actualizalocalidad', role_id = '$actualizaidrol'  WHERE id = '$editar_id'";

	    $ejecutar = $conexion->query($observar);// Verifica si la consulta se ejecutó correctamente
		    if ($ejecutar)
				{	//header("Location: administrador.php");
					echo "<script>window.open('pag_inicio.php')</script> ";
				}
			else
				{	echo "<script>alert ('no se pudo EDITAR')</script> ";
				}
		} 
	catch (PDOException $e) 
		{
		    die("Error en conexión a la base de datos: " . $e->getMessage());
		}
	}			
?>
    <?php
if(isset($_GET['borrar']))
	{
	try 
		{
		$borrar_id = $_GET['borrar'];
	    $db = new Database(); // Crea una instancia de la clase Database
	    $conexion = $db->conectar(); // Obtiene la conexión PDO
	    $borrar = "DELETE FROM usuarios WHERE id = '$borrar_id'";
	    $ejecutar = $conexion->query($borrar);

	    // Verifica si la consulta se ejecutó correctamente
		    if ($ejecutar) 
			    {//header("Location: administrador.php");
					echo "<script>window.open('pag_inicio.php')</script> ";
				}
			else
				{	echo "<script>alert ('no se logro eliminar')</script> ";
				}
		} 
	catch (PDOException $e) 
		{   die("Error en conexión a la base de datos: " . $e->getMessage());
		}
	}
	unset($_POST['borrar']);
?>
    <div align="center">
        <form action="../../../app-autosplash/index.php" method="POST">
            <button style="background: red; height:40px; width: 150px" name="cerrar_sesion">
                Cerrar Sesion
            </button>
            <!-- 
		<input type="submit" name="cerrar_sesion" value="Cerrar Sesion"> -->
        </form>
    </div>
</body>

</html>*/
?>



<?php
// codigo de arriba es el original el cualcontiene todo los comentarios para entender la funcionabilidad.
//codigo limpio sin comentarios y estilos, en cuanto a la funcionabilidad, ya esta correcto todo para el usuo.

include_once '../../config/db.php';
session_start();

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header('location: ../../useCase/logOut.php');
    die();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administrador</title>
    <link rel="stylesheet" href="../styles/estiloAdmin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
    background-image: url('../../img/fondo.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
}

.custom-navbar {
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(80px);
    box-shadow: 0px 1px 2px black;
    height: 90px;
    padding: 10px 20px;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
}

.navbar-brand {
    display: flex;
    align-items: center;
}

.logo {
    width: 70px;
    height: 60px;
    border-radius: 50%;
    border: 3px solid #18282e;
}

.navbar-title {
    border: 4px solid #18282e;
    font-weight: bold;
    background-color: #f2f0d9;
    border-radius: 25px;
    margin: 0 20px;
    font-size: 1rem;
    color: #18282e;
    padding: 5px 10px;
}

/* Botón de Cerrar Sesión */
.logout-button {
    background-color: #18282e;
    color: #f2f0d9;
    font-size: 1rem;
    padding: 10px 20px;
    border-radius: 20px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.logout-button:hover {
    background-color: rgba(10, 73, 125, 0.8);
    color: #fff;
}

.user-icon {
    width: 25px;
    height: 25px;
    margin-right: 10px;
}







.footer {
    background-color: #003366 !important; 
    color: #fff;
    padding: 40px 20px;
    text-align: center;
    font-family: 'Arial', sans-serif;
}


.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-logo img {
    width: 110px;
    height: 110px; 
    width: auto;
    border-radius: 50%; /* Imágenes redondas */
    border: 4px solid  #9faba7; 
}

.footer-about {
    flex: 1;
    margin: 20px;
}

.footer-about h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.footer-about p {
    font-size: 16px;
    line-height: 1.6;
}

.footer-social {
    flex: 1;
    margin: 20px;
}

.footer-social h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.social-icons {
    color: #f2f0d9;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.social-icon img {
    color: #f2f0d9;
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
    }

    .footer-logo, .footer-about, .footer-social {
        margin-bottom: 20px;
    }

    .footer-logo img, .social-icon img {
        max-height: 90px; /* Ajuste en el tamaño para pantallas pequeñas */
    }
}

    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid">
        <!-- Logo y Título -->
        <a class="navbar-brand" href="paginaInicio.php">
            <img src="../../img/logo.jpeg" alt="Logo" class="logo">
            <span class="navbar-title">GLOW-DRIVE</span>
        </a>

        <!-- Contenido del menú -->
            <ul class="navbar-nav ms-auto">
                <!-- Botón Cerrar sesión a la derecha -->
                <li class="nav-item">
                    <a class="btn logout-button" href="paginaInicio.php">
                        <img src="../../img/user.png" class="user-icon"> colver
                    </a>
                </li>
            </ul>
    </div>
</nav>



    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="welcome">
            <?php
            $db = new Database();
            $conexion = $db->conectar();
            $usuario = $_SESSION['nombre'];
            echo "Bienvenid@ Administrador <br>" . $usuario;
            ?>
        </div>
        
        <div class="form-container">
            <!-- Formulario de búsqueda -->
            <form method="POST" action="#">
                <label for="buscarCorreo">Buscar por correo electrónico:</label>
                <input type="email" name="buscarCorreo" placeholder="Ingrese el correo">
                <input type="submit" name="buscar" value="Buscar">
            </form>
        </div>

        <?php
        // Consulta para mostrar usuarios
        $query = "SELECT * FROM usuarios";
        if (isset($_POST['buscar'])) {
            $correoBusqueda = $_POST['buscarCorreo'];
            $query .= " WHERE correo = :correo";
        }

        try {
            $statement = $conexion->prepare($query);
            if (isset($_POST['buscar'])) {
                $statement->bindParam(':correo', $correoBusqueda);
            }
            $statement->execute();
        } catch (PDOException $e) {
            die("Error en conexión a la base de datos: " . $e->getMessage());
        }

        if ($statement->rowCount() > 0) {
            echo '<table>
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>NUMERO DE DOCUMENTO</th>
                        <th>TIPO DE DOCUMENTO</th>
                        <th>TELEFONO</th>
                        <th>EMAIL</th>
                        <th>ROL</th>
                        <th>EDITAR</th>
                        <th>BORRAR</th>
                    </tr>';

            while ($fila = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                        <td>' . $fila['id'] . '</td>
                        <td>' . $fila['nombre'] . '</td>
                        <td>' . $fila['apellido'] . '</td>
                        <td>' . $fila['num_documento'] . '</td>
                        <td>' . $fila['tipo_documento_id'] . '</td>
                        <td>' . $fila['telefono'] . '</td>
                        <td>' . $fila['correo'] . '</td>
                        <td>' . $fila['role_id'] . '</td>
                        <td><a class="btn" href="crearUsuario.php?editar=' . $fila['id'] . '">Editar</a></td>
                        <td><a class="btn" href="crearUsuario.php?borrar=' . $fila['id'] . '">Borrar</a></td>
                    </tr>';
            }
            echo '</table>';
        } else {
            echo 'No se encontraron resultados.';
        }

        // Formulario de inserción
        ?>
        <div class="form-container">
            <form method="POST" action="#">
                <center><img src="../../img/logo.jpeg" class="LogoRegistro"></center><br>
                IDROL <br><input type="number" name="idrol" required placeholder="Ingrese Rol" min="1" max="4"><br>
                NOMBRE <br><input type="text" name="usuario" required placeholder="Ingrese Nombre" pattern="[a-zA-Z]{4,8}"><br>
                APELLIDO <br><input type="text" name="apellido" required placeholder="Ingrese Apellido" pattern="[a-zA-Z]{4,8}"><br>
                NUMERO DOCUMENTO <input type="number" name="numeroDoc" required placeholder="Ingrese numero de documento"><br>
                TIPO DOCUMENTO <input type="number" name="documento" required placeholder="Ingrese tipo de documento"><br>
                TELEFONO <input type="number" name="telefono" required placeholder="Ingrese Telefono"><br>
                EMAIL<br><input type="email" name="email" required placeholder="Ingrese Email"><br>
                CLAVE <br><input type="password" name="clave" required placeholder="Ingrese Contraseña"><br>
                LOCALIDAD <input type="number" name="localidad" required placeholder="Ingrese localidad"><br>
                FECHA NACIMIENTO <input type="date" name="nacimiento" required><br>
                <br><input type="submit" name="insertar" value="Insertar Datos">
            </form>
        </div>

        <?php
        // Inserción de datos
        if (isset($_POST['insertar'])) {
            $query = "INSERT INTO usuarios (nombre, apellido, num_documento, tipo_documento_id, telefono, correo, contrasena, fecha_nacimiento, localidad_id, role_id) 
                      VALUES (:usuario, :apellido, :numeroDoc, :documento, :telefono, :email, :clave, :nacimiento, :localidad, :idrol)";
            try {
                $stmt = $conexion->prepare($query);
                $stmt->execute([
                    ':usuario' => $_POST['usuario'],
                    ':apellido' => $_POST['apellido'],
                    ':numeroDoc' => $_POST['numeroDoc'],
                    ':documento' => $_POST['documento'],
                    ':telefono' => $_POST['telefono'],
                    ':email' => $_POST['email'],
                    ':clave' => password_hash($_POST['clave'], PASSWORD_BCRYPT),
                    ':nacimiento' => $_POST['nacimiento'],
                    ':localidad' => $_POST['localidad'],
                    ':idrol' => $_POST['idrol']
                ]);

                echo "Registro insertado exitosamente.";
            } catch (PDOException $e) {
                die("Error en la inserción: " . $e->getMessage());
            }
        }

        // Edición de usuarios
        if (isset($_GET['editar'])) {
            $editar_id = $_GET['editar'];
            $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $editar_id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <table border="1" align="center" style="border-collapse: collapse; width: 60%; background-color: #f0f8ff;">
    <tr>
        <H1>EDITAR</H1>
        <td style="padding: 20px; background-color: #18282e; border: 1px solid #7f8c8d;">
            <form method="POST" action="#">
                <label style="color: #f2f0d9; font-weight: bold;">NOMBRE</label>
                <input type="text" name="usuario" value="<?php echo $usuario['nombre']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">APELLIDO</label>
                <input type="text" name="apellido" value="<?php echo $usuario['apellido']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">NUMERO DOCUMENTO</label>
                <input type="number" name="numdocumento" value="<?php echo $usuario['num_documento']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">TIPO DE DOCUMENTO</label>
                <input type="number" name="tipdocument" value="<?php echo $usuario['tipo_documento_id']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">TELEFONO</label>
                <input type="number" name="celular" value="<?php echo $usuario['telefono']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">EMAIL</label>
                <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">CLAVE</label>
                <input type="password" name="clave" value="<?php echo $usuario['contrasena']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">FECHA NACIMIENTO</label>
                <input type="date" name="fechnacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">LOCALIDAD</label>
                <input type="number" name="localidad" value="<?php echo $usuario['localidad_id']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <label style="color: #f2f0d9; font-weight: bold;">ROL</label>
                <input type="number" name="rol" value="<?php echo $usuario['role_id']; ?>" style="margin-bottom: 10px; width: 100%;"><br>

                <input type="submit" name="actualizame" value="Actualizar Datos" style="background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            </form>
        </td>
    </tr>
</table>

            <?php
        }

        // Actualización de datos
        if (isset($_POST['actualizame'])) {
            $query = "UPDATE usuarios SET nombre = :usuario, apellido = :apellido, num_documento = :numdocumento, tipo_documento_id = :tipdocumento, telefono = :telefono, correo = :correo, contrasena = :clave, fecha_nacimiento = :fechnacimiento, localidad_id = :localidad, role_id = :rol WHERE id = :id";
            try {
                $stmt = $conexion->prepare($query);
                $stmt->execute([
                    ':usuario' => $_POST['usuario'],
                    ':apellido' => $_POST['apellido'],
                    ':numdocumento' => $_POST['numdocumento'],
                    ':tipdocumento' => $_POST['tipdocument'],
                    ':telefono' => $_POST['celular'],
                    ':correo' => $_POST['correo'],
                    ':clave' => password_hash($_POST['clave'], PASSWORD_BCRYPT),
                    ':fechnacimiento' => $_POST['fechnacimiento'],
                    ':localidad' => $_POST['localidad'],
                    ':rol' => $_POST['rol'],
                    ':id' => $_GET['editar']
                ]);

                echo '<p style="color: green; font-weight: bold; background: white; text-align: center;">Datos actualizados exitosamente.</p>';

            } catch (PDOException $e) {
                die("Error en la actualización: " . $e->getMessage());
            }
        }

        // Eliminación de usuarios
        if (isset($_GET['borrar'])) {
            $borrar_id = $_GET['borrar'];
            $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $borrar_id]);
            echo "Registro borrado correctamente.";
        }
        ?>
    </div>
    <!--ESTE ES EL PIE DE PAGINA DE PARA ARRIBA VA TODA INFORMACIÓN DE CUALQUIER TIPO EN LA PAGINA DE INICIO-->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-logo">
            <img src="../../img/logo.jpeg" alt="Logo AutoSplash">
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