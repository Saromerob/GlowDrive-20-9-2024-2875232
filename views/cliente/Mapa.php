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
	<center>
		<i> <P> <Font size="10"> <h1>Autolavados</h1> </Font>
		<body bgcolor="F4D6FF">
			<h1>Autolavado Dacar's</h1>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9459.180121425268!2d-74.12985637784054!3d4.576897484993817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f98cd4271de4f%3A0xb851b08f62587206!2sAutolavado%20Dacar&#39;s!5e0!3m2!1ses-419!2sco!4v1723236096105!5m2!1ses-419!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><br>
			<h1>Moto lavado y Auto lavado Agua Car</h1>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9459.18516375047!2d-74.12243075148108!3d4.576515941230433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f98e781923d61%3A0x257a165c8a818641!2sMoto%20lavado%20y%20Auto%20lavado%20Agua%20Car!5e0!3m2!1ses-419!2sco!4v1723236534231!5m2!1ses-419!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><br>
			<h1>Auto Lavado Carwasn</h1>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9459.259751372729!2d-74.13083035574209!3d4.570868316673751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9f33623e7eff%3A0xee2c681d23f857ff!2sAuto%20Lavado%20Carwasn!5e0!3m2!1ses-419!2sco!4v1723236571849!5m2!1ses-419!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><br>
	</center>
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
