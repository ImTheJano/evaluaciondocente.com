<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
require_once(BASE_PATH.'/php/conf/Autoload.php');
\conf\Autoload::load();
$session=new \session\Session();
$session->sessionDestroy();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Inicio</title>
		<!-- Bootstrap core CSS-->
		<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom fonts for this template-->
		<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<!-- Page level plugin CSS-->
		<link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
		<!-- Custom styles for this template-->
		<link href="css/sb-admin.css" rel="stylesheet">
		<!-- Alertify-->
		<link href="css/alertify/alertify.min.css" rel="stylesheet">
	</head>
	<body id="page-top">
		<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
			<a class="navbar-brand" href="#">Evaluación docente</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="#">Ayuda</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Información</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="jumbotron">
			<h1 class="display-4">Bienvenido al sistema de evaluación docente</h1>
			<hr class="my-1">
			<p>Si tienes dudas de como usar el sistema por favor haz click aqui.</p>
			<a class="btn btn-primary btn-lg" href="#" role="button">Guia basica</a>
			<div class="row my-3">
				<div class="col-md-10 offset-md-1">
					<div class="row">
						<div class="col-md-4 my-3">
							<center>
								<div class="card" style="width: 20rem;">
									<img class="card-img-top" src="img/images/encuestado.jpg" alt="Card image cap" height="300rem">
									<div class="card-body">
										<h5 class="card-title">Alumnos</h5>
										<p class="card-text">Lorem ipsum dolor sit amet....</p>
										<a href="#" class="btn btn-primary" id="btn-entrar-alumno">Entrar</a>
									</div>
								</div>
							</center>
						</div>
						<div class="col-md-4 my-3">
							<center>
								<div class="card" style="width: 20rem;">
									<img class="card-img-top" src="img/images/profesor.jpg" alt="Card image cap" height="300rem">
									<div class="card-body">
										<h5 class="card-title">Profesores</h5>
										<p class="card-text">Lorem ipsum dolor sit amet....</p>
										<a href="#" class="btn btn-primary" id="btn-entrar-profesor">Entrar</a>
									</div>
								</div>
							</center>
						</div>
						<div class="col-md-4 my-3">
							<center>
								<div class="card" style="width: 20rem;">
									<img class="card-img-top" src="img/images/admin.jpg" alt="Card image cap" height="300rem">
									<div class="card-body">
										<h5 class="card-title">Administradores</h5>
										<p class="card-text">Lorem ipsum dolor sit amet....</p>
										<a href="#" class="btn btn-primary" id="btn-entrar-usuario">Entrar</a>
									</div>
								</div>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="modalInicio" tabindex="-1" role="dialog" aria-labelledby="modalInicioTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalInicioTitle"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="modalInicioBody">
					...
					</div>
				</div>
			</div>
		</div>
		<!-- Bootstrap core JavaScript-->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Core plugin JavaScript-->
		<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

		<!-- Custom scripts for all pages-->
		<script src="js/sb-admin.min.js"></script>

		<!-- Alertify -->
		<script src="js/alertify/alertify.min.js"></script>
		<script src="js/alerts.js"></script>
		<!-- Loader -->
		<script src="js/loader.js"></script>

		<!-- Mi script -->
		<script>
			$("#btn-entrar-alumno").click(function(evt){
				$("#modalInicio").modal("show");
				$("#modalInicioTitle").html("Entrar como alumno");
				loadPage($("#modalInicioBody"),"modules/alumnoLog",1000);
			});
			$("#btn-entrar-usuario").click(function(evt){
				$("#modalInicio").modal("show");
				$("#modalInicioTitle").html("Entrar como alumno");
				loadPage($("#modalInicioBody"),"modules/usuarioLog",1000);
			});
			$("#btn-entrar-profesor").click(function(evt){
				$("#modalInicio").modal("show");
				$("#modalInicioTitle").html("Entrar como alumno");
				loadPage($("#modalInicioBody"),"modules/profesorLog",1000);
			});
		</script>
	</body>

</html>
