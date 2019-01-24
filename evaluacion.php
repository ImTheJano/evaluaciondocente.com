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
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
		<?php
		if($session::$usuario->encuestado->status=='R'){
			alert('Ya hemos recibido tu respuesta, gracias por participar','alert-success');
			die();
		}
		if($session::$status){
			if($session::$mode!='encuestado'){
				alert('No puedes resolver esta encuesta','alert-danger');
				die();
			}
		}else{
			alert('No puedes resolver esta encuesta','alert-danger');
			die();
		}
		?>
		<div class="container">
			<div class="row my-2">
				<div class="col-md-3">
					<div class="card" style="width: 18rem;">
						<div class="card-body">
							<h5 class="card-title">Matricula: <?php echo $session::$usuario->encuestado->matricula?></h5>
							<h6 class="card-subtitle mb-2 text-muted">Grupo: <?php echo $session::$usuario->grupo?></h6>
							<p class="card-text text-secondary text-muted" id='tagStatus'>Encuesta pendiente</p>
						</div>
					</div>
				</div>
				<div class="col-md-9 px-5">
					<p class="lead">
						En los siguientes reactivos marca un valor del 1 al 5 para cada uno de tus profesores, siendo 1 la calificación que menos acuerda con el enunciado y 5 la que mas acuerda.
					</p>
					<p class="lead">
						Al terminar un reactivo pulsa el boton siguiente para continuar con el siguiente.
					</p>
				</div>
			</div>
			<div class="container">
				<center>
					<div id="reactivo"></div>
				</center>
			</div>
			<!-- Pagination -->
			<div id="pagination">
				<div class="d-flex center justify-content-center my-2">
					<span class="btn btn-primary mx-2" id="btnSiguiente">Anterior</span>
					<span class="btn btn-primary mx-2" id="btnAnterior">Siguiente</span>
				</div>
				<div class="d-flex center justify-content-center ">
					<span class="btn btn-primary" id="btnEnviar">Enviar</span>
				</div>
				<nav aria-label="..." class="table-responsive">
					<ul class="pagination" id="evaluacionPagination">
						<li class="page-item">
							<a class="page-link" href="#" tabindex="-1" id="btnPrevious">Anterior</a>
						</li>
						<!-- pages -->
						<li class="page-item" id="liNext">
							<a class="page-link" href="#" id="btnNext">Siguiente</a>
						</li>
					</ul>
				</nav>
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

		<!-- Alertify -->
		<script src="js/alertify/alertify.min.js"></script>
		<script src="js/alerts.js"></script>

		<!-- Loader -->
		<script src="js/loader.js"></script>
		<!-- Mi script -->
		<script>
			window.onbeforeunload = function(event) {
				event.returnValue = "Write something clever here..";
			};
			var grupo="<?php echo $session::$usuario->grupo?>";
			var profesores=new Array;
			var respuestas=new Array;
			var nReactivos=0;
			$(document).ready(function(){
				var req1={'function':'get','qry':'SELECT * FROM pregunta'};
				var req2={'function':'get','qry':'SELECT * FROM grupoProfesorMateria,profesor WHERE grupoProfesorMateria.claveProf=profesor.claveProf and grupoProfesorMateria.idG="'+grupo+'"'};
				var request=[req1,req2];
				$.post(
					'php/request/Request.php',
					{
						'_data':JSON.stringify({
							'function':'multi',
							'request':request
						})
					},
					function(respuesta,status){
						data=JSON.parse(respuesta);
						nReactivos=data[0]['count'];
						nProfesores=data[1]['count']
						reactivos=data[0]['obj'];
						profesores=data[1]['obj'];
						$.each(reactivos,function(i,reactivo){
							respuestas[reactivo['numP']]=new Array;
							$.each(profesores,function(j,profesor){
								respuestas[reactivo['numP']][j]=0;
							});
						});
						for(i=0;i<nReactivos;i++){
							pag=$('<li>',{
								'class':'page-item hiddable',
								'id':'btnPag-'+i,
								'onClick':'setCurrentPageReactivo('+(1+i)+')'
							}).append($('<a>',{'class':'page-link','id':'a-'+i,'html':1+i,'href':'#'}));
							$('#liNext').before(pag);
						}
						showPageReactivos();
						$('#btnEnviar').click(function(){
							enviar=true;
							$.each(reactivos,function(i,reactivo){
								$.each(profesores,function(j,profesor){
									if(respuestas[reactivo['numP']][j]==0){
										alertify.error('<span class="text-white">Falta por contestar reactivo '+(i+1)+'</span>');
										enviar=false;
										return false;
									}
								});
								if(!enviar)return false;
							});
							if(enviar){
								loadSpinnerGrow($('#reactivo'),'Enviando respuesta...');
								setTimeout(function(){enviarRespuestas();},1000);
								function enviarRespuestas(){
									$.post(
										'php/request/SendEncuesta.php',
										{
											'_data':JSON.stringify({
												'profesores':profesores,
												'respuestas':respuestas
											})
										},
										function(respuesta2,status2){
											data2=JSON.parse(respuesta2);
											if(data2['status']){
												loadPage($('#reactivo'),'modules/reporteConclucion',3000,'Concluyendo');
												$('#pagination').html('<a href="/evaluaciondocente.com" class="btn btn-link">Volver al inicio</a>');
												$.post(
													'php/request/Request.php',
													{
														'_data':JSON.stringify({
															'function':'set',
															'st':'UPDATE encuestado SET status="R" WHERE matricula = "<?php echo $session::$usuario->encuestado->matricula?>"'
														})
													},
													function(respuesta3,status3){
														data3=JSON.parse(respuesta3);
														if(data3['status']){
															$('#tagStatus').html('Encuesta concluida')
														}
													}
												);
											}else{
											}
										}
									);
								}
							}
						});
					}
				);
			});
			var currentReactivo=1;
			// Pagination
			setCurrentPageReactivo(1);
			var maxPageReactivosShowed=10;
			function ocultarPageReactivos(){
				$('.hiddable').attr('hidden','true').removeClass('active');
				$('#btnPag-'+0).removeAttr('hidden');
				$('#btnPag-'+(nReactivos-1)).removeAttr('hidden');
			}
			function showPageReactivos(){
				if(currentReactivo<maxPageReactivosShowed){
					ocultarPageReactivos();
					for(i=0;i<maxPageReactivosShowed;i++){
						$('#btnPag-'+i).removeAttr('hidden');
						if(i+1==currentReactivo)$('#btnPag-'+i).addClass('active');
					}
				}
				if((currentReactivo>=maxPageReactivosShowed)&&currentReactivo<=(nReactivos-maxPageReactivosShowed)){
					ocultarPageReactivos();
					for(i=(currentReactivo-(maxPageReactivosShowed/2));i<currentReactivo+(maxPageReactivosShowed/2);i++){
						$('#btnPag-'+i).removeAttr('hidden');
						if(i+1==currentReactivo)$('#btnPag-'+i).addClass('active');
					}
				}
				if(currentReactivo>(nReactivos-maxPageReactivosShowed)){
					ocultarPageReactivos();
					for(i=(nReactivos-maxPageReactivosShowed);i<nReactivos;i++){
						$('#btnPag-'+i).removeAttr('hidden');
						if(i+1==currentReactivo)$('#btnPag-'+i).addClass('active');
					}
				}
			}
			function setCurrentPageReactivo(cp){
				loadPage($('#reactivo'),'modules/reactivo?reactivo='+cp);
				currentReactivo=cp;
				showPageReactivos();
			}
			$('#btnPrevious').click(function(evt){
				evt.preventDefault();
				if(currentReactivo>1)setCurrentPageReactivo(currentReactivo-1);
			});
			$('#btnNext').click(function(evt){
				evt.preventDefault();
				if(currentReactivo<nReactivos)setCurrentPageReactivo(currentReactivo+1);
			});
			$('#btnSiguiente').click(function(evt){
				evt.preventDefault();
				if(currentReactivo>1)setCurrentPageReactivo(currentReactivo-1);
			});
			$('#btnAnterior').click(function(evt){
				evt.preventDefault();
				if(currentReactivo<nReactivos)setCurrentPageReactivo(currentReactivo+1);
			});
			evaluacionAleatoria=function(){
				var req1={'function':'get','qry':'SELECT * FROM pregunta'};
				var req2={'function':'get','qry':'SELECT * FROM grupoProfesorMateria,profesor WHERE grupoProfesorMateria.claveProf=profesor.claveProf and grupoProfesorMateria.idG="'+grupo+'"'};
				var request=[req1,req2];
				$.post(
					'php/request/Request.php',
					{
						'_data':JSON.stringify({
							'function':'multi',
							'request':request
						})
					},
					function(respuesta,status){
						$.each(reactivos,function(i,reactivo){
							respuestas[reactivo['numP']]=new Array;
							$.each(profesores,function(j,profesor){
								eval=Math.floor((Math.random() * 5) + 1);
								respuestas[reactivo['numP']][j]=eval;
							});
						});
					}
				);
			}
		</script>
	</body>

</html>
