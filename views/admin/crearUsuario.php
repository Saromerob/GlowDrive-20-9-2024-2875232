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

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('location: ../../useCase/logOut.php');
    die();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administrador</title>
    <style>
    body {
        background-color: #1a1a2e;
        color: #eaeaea;
        font-family: Arial, sans-serif;
    }

    .container {
        text-align: center;
        padding: 50px;
    }

    .welcome {
        font-size: 2.5em;
        margin-bottom: 30px;
    }

    .form-container {
        background-color: #162447;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        margin-bottom: 50px;
        display: inline-block;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container input[type="email"],
    .form-container input[type="password"],
    .form-container input[type="date"] {
        width: 80%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container input[type="submit"] {
        background-color: #1f4068;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
    }

    .form-container input[type="submit"]:hover {
        background-color: #1b1b2f;
    }

    table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
        margin-bottom: 50px;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #0f3460;
    }

    td {
        background-color: #162447;
    }

    .btn {
        background-color: #1f4068;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #1b1b2f;
    }

    .logout-btn {
        background-color: #e94560;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
    }

    .logout-btn:hover {
        background-color: #b0003a;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="welcome">
            <?php
        $db = new Database();
        $conexion = $db->conectar();
        $usuario = $_SESSION['nombre'];
        echo "Bienvenid@ <br>Administrador <br>" . $usuario;
        ?>
        </div>
        <div class="form-container">
            <form method="POST" action="#">
                IDROL <input type="number" name="idrol" required placeholder="Ingrese Rol" min="1" max="4"><br>
                NOMBRE <input type="text" name="usuario" required placeholder="Ingrese Nombre" pattern="[a-z]{4,8}"><br>
                APELLIDO <input type="text" name="apellido" required placeholder="Ingrese Apellido"
                    pattern="[a-z]{4,8}"><br>
                NUMERO DOCUMENTO <input type="number" name="numeroDoc" required
                    placeholder="Ingrese numero de documento"><br>
                TIPO DOCUMENTO <input type="number" name="documento" required
                    placeholder="Ingrese tipo de documento"><br>
                TELEFONO <input type="number" name="telefono" required placeholder="Ingrese Telefono"><br>
                EMAIL<br> <input type="email" name="email" required placeholder="Ingrese Email"><br>
                CLAVE <input type="password" name="clave" required placeholder="Ingrese Contraseña"><br>
                LOCALIDAD <input type="number" name="localidad" required placeholder="Ingrese localidad"><br>
                FECHA NACIMIENTO <input type="date" name="nacimiento" required
                    placeholder="Ingrese fecha de nacimiento"><br>
                <input type="submit" name="insertar" value="Insertar Datos">
            </form>
        </div>
        <?php
    if (isset($_POST['insertar'])) {
        $idrol = $_POST['idrol'];
        $usuario = $_POST['usuario'];
        $apellido = $_POST['apellido'];
        $numDoc = $_POST['numeroDoc'];
        $TipDoc = $_POST['documento'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $clave = $_POST['clave'];
        $localidad = $_POST['localidad'];
        $fechNacimiento = $_POST['nacimiento'];

        try {
            $db = new Database();
            $conexion = $db->conectar();
            $query = "INSERT INTO usuarios (nombre, apellido, num_documento, tipo_documento_id, telefono, correo, contrasena, fecha_nacimiento, localidad_id, role_id) VALUES (:usuario, :apellido, :numeroDoc, :documento, :telefono, :email, :clave, :nacimiento, :localidad, :idrol)";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':numeroDoc', $numDoc);
            $stmt->bindParam(':documento', $TipDoc);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':localidad', $localidad);
            $stmt->bindParam(':nacimiento', $fechNacimiento);
            $stmt->bindParam(':idrol', $idrol);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Registro insertado exitosamente.";
                echo "<script> window.open('crearUsuario.php') </script>";
            } else {
                echo "No se pudo insertar el registro.";
            }
        } catch (PDOException $e) {
            die("Error en la inserción: " . $e->getMessage());
        }

        unset($_POST['insertar']);
    }
    ?>
        <?php
    try {
        $db = new Database();
        $conexion = $db->conectar();
        $observar = "SELECT * FROM usuarios";
        $statement = $conexion->query($observar);

        if ($statement) {
            echo '<table>
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

                echo '<tr>
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
                        <td><a class="btn" href="crearUsuario.php?editar=' . $id . '">Editar</a></td>
                        <td><button class="btn"><a href="crearUsuario.php?borrar=' . $id . '">Borrar</a></button></td>
                    </tr>';
            }
            echo '</table>';
        } else {
            echo 'Error en la consulta.';
        }
    } catch (PDOException $e) {
        die("Error en conexión a la base de datos: " . $e->getMessage());
    }
    ?>
        <?php
    if (isset($_GET['editar'])) {
        try {
            $editar_id = $_GET['editar'];
            $db = new Database();
            $conexion = $db->conectar();
            $observar = "SELECT * FROM usuarios WHERE id = '$editar_id'";
            $statement = $conexion->query($observar);

            if ($statement) {
                while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $id = $filas['id'];
                    $usuario = $filas['nombre'];
                    $apellidoo = $filas['apellido'];
                    $docnum = $filas['num_documento'];
                    $doctip = $filas['tipo_documento_id'];
                    $telf = $filas['telefono'];
                    $correo = $filas['correo'];
                    $contrasena = $filas['contrasena'];
                    $nacimfech = $filas['fecha_nacimiento'];
                    $local = $filas['localidad_id'];
                    $idrole = $filas['role_id'];
                }
            } else {
                echo 'Error en la consulta.';
            }
        } catch (PDOException $e) {
            die("Error en conexión a la base de datos: " . $e->getMessage());
        }
        ?>
        <table border="6" align="center">
            <tr>
                <td>
                    <div align="center">
                        <form method="POST" action="#" enctype="multipart/form-data">
                            NOMBRE <input type="text" name="usuario" value="<?php echo $usuario ?>"><br>
                            APELLIDO <input type="text" name="apellido" value="<?php echo $apellidoo ?>"><br>
                            NUMERO DOCUMENTO <input type="number" name="numdocumento" value="<?php echo $docnum ?>"><br>
                            TIPO DE DOCUMENTO <input type="number" name="tipdocument" value="<?php echo $doctip ?>"><br>
                            TELEFONO <input type="number" name="celular" value="<?php echo $telf ?>"><br>
                            EMAIL <input type="email" name="correo" value="<?php echo $correo ?>"><br>
                            CLAVE <input type="password" name="clave" value="<?php echo $contrasena ?>"><br>
                            FECHA NACIMIENTO <input type="date" name="fechnacimiento"
                                value="<?php echo $nacimfech ?>"><br>
                            LOCALIDAD <input type="number" name="localidad" value="<?php echo $local ?>"><br>
                            ROL <input type="number" name="rol" value="<?php echo $idrole ?>"><br>
                            <input type="submit" name="actualizame" value="Actualizar Datos"
                                style="cursor: pointer;"><br>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <?php
        unset($_POST['editar']);
    }
    ?>
        <?php
    if (isset($_POST['actualizame'])) {
        $actualizausuario = $_POST['usuario'];
        $actualizaapellido = $_POST['apellido'];
        $actualizandocumento = $_POST['numdocumento'];
        $actualizatdocumento = $_POST['tipdocument'];
        $actualizacelular = $_POST['celular'];
        $actualizaemail = $_POST['correo'];
        $actualizaclave = $_POST['clave'];
        $actualizafnacimiento = $_POST['fechnacimiento'];
        $actualizalocalidad = $_POST['localidad'];
        $actualizaidrol = $_POST['rol'];

        try {
            $db = new Database();
            $conexion = $db->conectar();
            $observar = "UPDATE usuarios SET nombre = '$actualizausuario', apellido = '$actualizaapellido', num_documento = '$actualizandocumento', tipo_documento_id = '$actualizatdocumento', telefono = '$actualizacelular', correo = '$actualizaemail', contrasena = ('$actualizaclave'), fecha_nacimiento = '$actualizafnacimiento', localidad_id = '$actualizalocalidad', role_id = '$actualizaidrol' WHERE id = '$editar_id'";
            $ejecutar = $conexion->query($observar);

            if ($ejecutar) {
                echo "<script>window.open('crearUsuario.php')</script> ";
            } else {
                echo "<script>alert ('no se pudo EDITAR')</script> ";
            }
        } catch (PDOException $e) {
            die("Error en conexión a la base de datos: " . $e->getMessage());
        }
    }
    ?>
        <?php
    if (isset($_GET['borrar'])) {
        try {
            $borrar_id = $_GET['borrar'];
            $db = new Database();
            $conexion = $db->conectar();
            $borrar = "DELETE FROM usuarios WHERE id = '$borrar_id'";
            $ejecutar = $conexion->query($borrar);

            if ($ejecutar) {
                echo "<script>window.open('crearUsuario.php')</script> ";
            } else {
                echo "<script>alert ('no se logro eliminar')</script> ";
            }
        } catch (PDOException $e) {
            die("Error en conexión a la base de datos: " . $e->getMessage());
        }
        unset($_POST['borrar']);
    }
    ?>
        <div align="center">
            <form action="../../useCase/logOut.php" method="POST">
                <button class="logout-btn" name="cerrar_sesion">Cerrar Sesión</button>
            </form>
        </div>
        <div align="center">
            <form action="paginaInicio.php" method="POST">
                <button class="logout-btn" name="cerrar_sesion">Volver al inicio</button>
            </form>
        </div>
    </div>
</body>

</html>