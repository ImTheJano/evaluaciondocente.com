<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
require_once(BASE_PATH.'/php/conf/Autoload.php');
\conf\Autoload::load();
function alert($str,$class){
?>
	<div class="alert <?php echo $class?>"><center><?php echo $str?></center></div>
<?php }
$session=new \session\Session();
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
		<!-- Loader -->
		<link rel="stylesheet" href="css/loader/blocks.css">
	</head>
	<body id="page-top">
		<?php
		if($session::$mode!='usuario'){
			alert('No puedes administrar este sitio sin credenciales,<br> vuelve al inicio y logueate','alert-danger');
		?>
		<div class="row px-5">
			<div class="col-md-8 offset-md-2 px-5">
				<a href="/evaluaciondocente.com" class="btn btn-primary btn-block">Ir al inicio</a>
			</div>
		</div>
		<?php
		die();
		}
		?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="">
				<i class="fas fa-bars"></i>
			</button>
			<a class="navbar-brand" href="">Evaluación docente</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="">Ayuda</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="">Información</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container">
		</div>
		<div id="wrapper">
			<!-- sidebar -->
			<ul class="sidebar navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="" id="lnkAdmUsuario">
						<i class="fas fa-fw fa-user"></i>
						<span>Usuario</span>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-fw fa-folder"></i>
						<span>Administrar</span>
					</a>
					<div class="dropdown-menu" aria-labelledby="adminDropdown">
						<h6 class="dropdown-header">Tablas:</h6>
						<a class="dropdown-item" href="" id="lnkAdmProfesores">Profesores</a>
						<a class="dropdown-item" href="" id="lnkAdmPreguntas">Preguntas</a>
						<a class="dropdown-item" href="" id="lnkAdmAlumnos">Alumnos</a>
						<div class="dropdown-divider"></div>
						<h6 class="dropdown-header">Crear:</h6>
						<a class="dropdown-item" href="" id="lnkNuevoUsuario">Usuario</a>
						<a class="dropdown-item" href="" id="lnkNuevoProfesor">Profesor</a>
						<a class="dropdown-item" href="" id="lnkNuevoPregunta">Pregunta</a>
						<a class="dropdown-item" href="" id="lnkNuevoAlumno">Alumno</a>
						<a class="dropdown-item" href="" id="lnkNuevoGrupo">Grupo</a>
						<a class="dropdown-item" href="" id="lnkNuevoMateria">Materia</a>
					</div>
				</li>
				<li class="nav-item dropdown" href="" >
					<a class="nav-link dropdown-toggle" href="" id="chartsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-fw fa-chart-area"></i>
						<span>Graficas</span>
					</a>
					<div class="dropdown-menu" aria-labelledby="chartsDropdown">
						<h6 class="dropdown-header">Graficas:</h6>
						<a class="dropdown-item" href="" id="lnkGraficaGeneral">General</a>
						<a class="dropdown-item" href="" id="lnkGraficaSeccion">Seccion</a>
						<a class="dropdown-item" href="" id="lnkGraficaProfesor">Profesor</a>
					</div>
				</li>
				<li class="nav-item dropdown" href="" >
					<a class="nav-link dropdown-toggle" href="" id="tablesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-fw fa-table"></i>
						<span>Tablas</span>
					</a>
					<div class="dropdown-menu" aria-labelledby="tablesDropdown">
						<h6 class="dropdown-header">Tablas:</h6>
						<a class="dropdown-item" href="">General</a>
						<a class="dropdown-item" href="">Grupo</a>
						<a class="dropdown-item" href="">Profesor</a>
					</div>
				</li>
			</ul>
			<div id="content-wrapper">
				<div id="content" class="container"></div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="modalEvaluacion" tabindex="-1" role="dialog" aria-labelledby="modalEvaluacionTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalEvaluacionTitle"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="modalEvaluacionBody">
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

		<!-- Page level plugin JavaScript-->
		<script src="vendor/chart.js/Chart.min.js"></script>
		<script src="vendor/datatables/jquery.dataTables.js"></script>
		<script src="vendor/datatables/dataTables.bootstrap4.js"></script>

		<!-- Alertify -->
		<script src="js/alertify/alertify.min.js"></script>
		<script src="js/alerts.js"></script>

		<!-- Loader -->
		<script src="js/loader.js"></script>
		<!-- Mi script -->
		<script>
			$(document).ready(function(){
				loadPage($('#content'),'modules/infoUsuario',0);
				$('#lnkAdmUsuario').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/infoUsuario',500,'Cargando...');
				});
				$('#lnkAdmProfesores').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/adminProfesores',500,'Cargando...');
				});
				$('#lnkAdmAlumnos').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/adminAlumnos',500,'Cargando...');
				});
				$('#lnkAdmPreguntas').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/adminPreguntas',500,'Cargando...');
				});
				$('#lnkGraficaProfesor').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/graficasProfesor',500,'Cargando...');
				});
				$('#lnkNuevoAlumno').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/nuevoAlumno',500,'Cargando...');
				});
				$('#lnkNuevoGrupo').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/nuevoGrupo',500,'Cargando...');
				});
				$('#lnkNuevoUsuario').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/nuevoUsuario',500,'Cargando...');
				});
				$('#lnkNuevoPregunta').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/nuevaPregunta',500,'Cargando...');
				});
				$('#lnkGraficaSeccion').click(function(evt){
					evt.preventDefault();
					loadPage($('#content'),'modules/secciones',500,'Cargando...');
				});
			});
		</script>
	</body>

</html>
