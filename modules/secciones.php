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
function logout(){
?>
	<script>window.location.href = "/evaluaciondocente.com";</script>
<?php }
$session=new \session\Session();
if($session::$mode!='usuario'){
	logout();
	die();
}
$mySql=new db\MySQL();
?>
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>Profesores
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="tablaPromedios" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Clave</th>
						<th>Nombre</th>
						<th>Suma de puntos</th>
						<th>Total de evaluaciones</th>
						<th>Promedio</th>
						<th>Grafica</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="card">
	<h5 class="card-title p-3" id="graficaGeneralTitle">Vista general de todos los docentes</h5>
	<div class="img-responsive">
		<canvas id="canvasGraficaGeneral" width="200%" height="60"></canvas>
	</div>
	<div class="card-body">
	</div>
</div>

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-attr('hidden','"true') id="modalGrafica">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="card">
				<div id="modalGraficaContent" class="p-5"></div>
				<div id="canvasGraficaProfesor"></div>
				<div class="card-body">
					<h5 class="card-title" id="graficaProfesorNombre">...</h5>
					<p class="card-text" id="graficaProfesorText">...</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="vendor/chart.js/Chart.min.js"></script>
<script>
	$(document).ready(function(){
		tablaPromedios=$('#tablaPromedios').DataTable();
		qry='SELECT'
			+' p.claveProf as claveProf,'
			+' p.nombre as nombre,'
			+' sum(ep.evaluacion) as sumEvaluacion,'
			+' count(ep.evaluacion) as countEvaluacion,'
			+' (sum(ep.evaluacion)/count(ep.evaluacion)) as promedio'
		+' FROM'
			+' encuestapregunta ep,'
			+' encuestaconteo e,'
			+' profesor p'
		+' WHERE'
			+' e.claveProf=p.claveProf and'
			+' ep.idE=e.idE'
		+' GROUP BY'
			+' p.claveProf;';
		$.post(
			'php/request/Request.php',
			{
				'_data':JSON.stringify({
					'function':'get',
					'qry':qry
				})
			},
			function(respuesta,status){
				data=JSON.parse(respuesta);
				tabla=data['obj'];
				profesoresNombre=new Array;
				profesoresClave=new Array;
				promedios=new Array
				$.each(tabla,function(i,row){
					claveProf=row['claveProf'];
					nombre=row['nombre'];
					promedio=row['promedio'];
					profesoresNombre[i]=row['nombre'];
					profesoresClave[i]=row['claveProf'];
					promedios[i]=row['promedio'];
					fn="graficarProfesor('"+claveProf+"','"+nombre+"','"+promedio+"')";
					tablaPromedios.row.add([
						row['claveProf'],
						row['nombre'],
						row['sumEvaluacion'],
						row['countEvaluacion'],
						row['promedio'],
						'<span class="btn btn-primary" onClick="'+fn+'">Detalles</span>'
					]).draw(true);
				});
				Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
				Chart.defaults.global.defaultFontColor = '#292b2c';
				var ctx=$('#canvasGraficaGeneral');
				var myLineChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: profesoresClave,
						datasets: [{
							label: "Promedio",
							lineTension: 0.3,
							backgroundColor: "rgba(2,117,216,0.2)",
							borderColor: "rgba(2,117,216,1)",
							pointRadius: 3,
							pointBackgroundColor: "rgba(2,117,216,1)",
							pointBorderColor: "rgba(255,255,255,0.8)",
							pointHoverRadius: 3,
							pointHoverBackgroundColor: "rgba(2,117,216,1)",
							pointHitRadius: 50,
							pointBorderWidth: 2,
							data: promedios,
						}],
					},
					options: {
						scales: {
							xAxes: [{
								time: {
									unit: 'pts'
								},
								gridLines: {
									display: true
								},
								ticks: {
									maxTicksLimit: profesoresNombre.lenght
								}
							}],
							yAxes: [{
								ticks: {
									min: 0,
									max: 5,
									maxTicksLimit: 5
								},
								gridLines: {
									color: "rgba(0, 0, 0, .125)",
								}
							}],
						},
						legend: {
							display: false
						}
					}
				});
			}
		);
	});
	function graficarProfesor(claveProf,nombreProf,promedioGeneral){
		loadSpinnerGrow($('#modalGraficaContent'),'Cargando grafica...');
		$('#canvasGraficaProfesor').html('');
		$('#modalGrafica').modal('show');
		$('#chartProfesor').attr('hidden','true');
		$('#graficaProfesorNombre').attr('hidden','true');
		$('#graficaProfesorText').attr('hidden','true');
		setTimeout(
			function(){
				qry='SELECT'
				+' ep.numP as numP,'
				+' sum(ep.evaluacion) as sumEvaluacion,'
				+' count(ep.evaluacion) as countEvaluacion,'
				+' (sum(ep.evaluacion)/count(ep.evaluacion)) as promedio'
				+' FROM'
				+' encuestapregunta ep,'
				+' encuestaconteo e,'
				+' profesor p,'
				+' pregunta preg'
				+' WHERE'
				+' p.claveProf="'+claveProf+'" and'
				+' e.claveProf=p.claveProf and'
				+' preg.numP=ep.numP and'
				+' ep.idE=e.idE'
				+' GROUP BY'
				+' preg.secc;';
				$.post(
					'php/request/Request.php',
					{
						'_data':JSON.stringify({
							'function':'get',
							'qry':qry
						})
					},
					function(respuesta,status){
						data=JSON.parse(respuesta);
						rows=data['obj'];
						preguntas=new Array;
						promedios=new Array;
						$.each(rows,function(i,row){
							preguntas[i]=row['numP'];
							promedios[i]=row['promedio'];
						})
						Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
						Chart.defaults.global.defaultFontColor = '#292b2c';
						var ctx=$('<canvas width="100%" height="30">');
						$('#canvasGraficaProfesor').html('');
						$('#canvasGraficaProfesor').append(ctx);
						var myLineChart = new Chart(ctx, {
							type: 'line',
							data: {
								labels: preguntas,
								datasets: [{
									label: "Puntuación",
									lineTension: 0.3,
									backgroundColor: "rgba(2,117,216,0.2)",
									borderColor: "rgba(2,117,216,1)",
									pointRadius: 5,
									pointBackgroundColor: "rgba(2,117,216,1)",
									pointBorderColor: "rgba(255,255,255,0.8)",
									pointHoverRadius: 5,
									pointHoverBackgroundColor: "rgba(2,117,216,1)",
									pointHitRadius: 50,
									pointBorderWidth: 2,
									data: promedios,
								}],
							},
							options: {
								scales: {
									xAxes: [{
										time: {
											unit: 'date'
										},
										gridLines: {
											display: true
										},
										ticks: {
											maxTicksLimit: preguntas.lenght
										}
									}],
									yAxes: [{
										ticks: {
											min: 0,
											max: 5,
											maxTicksLimit: 5
										},
										gridLines: {
											color: "rgba(0, 0, 0, .125)",
										}
									}],
								},
								legend: {
									display: false
								}
							}
						});
					}
				);
				$('#modalGraficaContent').html('');
				$('#chartProfesor').removeAttr('hidden');
				$('#graficaProfesorNombre').removeAttr('hidden');
				$('#graficaProfesorText').removeAttr('hidden');
				$('#graficaProfesorNombre').html(nombreProf);
				$('#graficaProfesorText').html('Promedio general= '+promedioGeneral);
			}
		,1000);
	}


</script>
