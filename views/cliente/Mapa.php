<!DOCTYPE html>
<html>
<head>
		<title> Mapa Interactivo </title>
		<meta charset="UTF-8">
        <link rel="stylesheet" href="../styles/estilomapa.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <?php
        session_start();
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
            header('location: ../../useCase/logOut.php');
            die();
        }
        ?>
</head>
<body>



	<nav class="navbar navbar-expand-lg">
		<div class="container-fluid">
			<a class="navbar-brand" href="Mapa.php">
				<img src="../../img/logo.jpeg" alt="Logo" id="logo" class="logo">
				<div class="titulo">AUTO-SPLASH</div>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mx-auto">
				<div class="citas">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="agendar_cita.php">Agendar Citas</a>
					</li>
				</div>
				<div class="ubi">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="Mapa.php">Mapa</a>
					</li>
					</div>
				</div>
				</ul>
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<div class="sesion">
							<a class="nav-link" href="../../useCase/logOut.php"><p class="ini"> <img src="../../img/user.png" class="user1">Cerrar Sesión</p></a>
						</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<div class="contenedor-principal">
	<i> <P> <Font size="10"> <h1>Autolavados</h1> </Font>
			<body bgcolor="F4D6FF">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.9890235928137!2d-74.11339912415592!3d4.595988542554673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f992512b0e255%3A0x109a96acffbb61c!2sSENA%20-%20Centro%20de%20Materiales%20y%20ensayos!5e0!3m2!1ses-419!2sco!4v1714676527213!5m2!1ses-419!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<h1 class="info">
	En este espacio se ubicaran todos los puntos 
	de Autolavados que esten vinculados a nosotros
	por el momento ponemos el mapa dinamico de maps
</h1>


<footer class="pie-pagina">
	<div class="grupo-1"> 
		<div class="BOX">
			<FIGUre>
				<a href="#">
					<img src="../../img/logo.jpeg" alt="Logo AutoSplash" >
				</a>
			</FIGUre>
		</div>
		<div class="BOX">
			<h2>SOBRE NOSOTROS</h2>
			<p> TEXTO EJEMPLO</p>
			<p> </p>
		</div>
		<div class="BOX">
		<h2> Siguenos: </h2>
		<div class="red-social">
			<center>
			<a href="#" class="instagram">
				<img src="../../img/instagram.jpg" height="50px" class="insta">
			</a>
			<a href="#" class="tik-tok">
				<img src="../../img/tiktok.png" height="50px" class="tito">
			</a>
			<a href="#" class="whatsapp">
				<img src="../../img/whatsapp.png" height="55px" class="wha">
			</a>
		</center>
		</div>
	</div>
	<div class="grupo-2">
		<small>&copy; 2024<b>AutoSplash</b>-Todos Los Derechos Reservados.</small>

	</div>
</footer>




</body>
</html>
