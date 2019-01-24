<?php
//error_reporting(E_ERROR | E_PARSE);
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
	<script>window.location.href = "admin";</script>
<?php }
$session=new \session\Session();
if($session::$status){
	if($session::$mode!='encuestado'){
		alert('No se ha podido cargar el reactivo','alert-danger');
		logout();
		die();
	}
}else{
	alert('No se ha podido cargar el reactivo','alert-danger');
	logout();
	die();
}
?>
<div class="container">
	<div class="card" >
		<div class="card-body">
			<h5 class="card-title" id="pregunta"></h5>
			<h6 class="card-subtitle text-muted" id="idReactivo"></h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="tablaEvaluacion">

				</table>
			</div>
		</div>
	</div>
</div>
<script>
	function radioOnClick(_idReactivo,_idProfesor,evaluacion){
		setInputEvaluacion(_idReactivo,_idProfesor,evaluacion);
		setRespuesta(_idReactivo,_idProfesor,evaluacion);
	}
	function setInputEvaluacion(_idReactivo,_idProfesor,evaluacion){
		$('#inputEvaluacion-reactivo'+_idReactivo+'-profesor'+_idProfesor).val(evaluacion);
	}
	function setRespuesta(_idReactivo,_idProfesor,evaluacion){
		respuestas[_idReactivo][_idProfesor]=evaluacion;
	}
	idReactivo=<?php echo (isset($_GET['reactivo']))?$_GET['reactivo']:'null'; ?>;
	if(idReactivo!=null){
		$('#idReactivo').html('Reactivo: '+idReactivo);
		var req1={'function':'get','qry':'SELECT * FROM pregunta WHERE numP = "'+idReactivo+'"'};
		var req2={'function':'get','qry':'SELECT * FROM grupoProfesorMateria,profesor WHERE grupoProfesorMateria.idG = "<?php echo $session::$usuario->grupo?>" and grupoProfesorMateria.claveProf = profesor.claveProf'};
		var req3={'function':'get','qry':'SELECT * FROM grupoProfesorMateria,materia WHERE grupoProfesorMateria.idG = "<?php echo $session::$usuario->grupo?>" and grupoProfesorMateria.claveMat = materia.claveMat'};
		var request=[req1,req2,req3];
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
				$('#pregunta').html(data[0]['obj'][0]['preg']);
				profesores=data[1]['obj'];
				materias=data[2]['obj'];
				$.each(profesores,function(i,profesor){
					radioBtn=new Array;
					ev='';
					for(j=1;j<=5;j++){
						if(respuestas[idReactivo][i]==j){
							btnClass='btn btn-primary active';
							checked='true';
							ev=j;
						}
						else{
							btnClass='btn btn-primary';
							checked='false';
						}
						radioBtn[j]=$('<lavel>',{
							'class':btnClass,
							'id':'lbl-option1-reactivo'+idReactivo+'-profesor'+profesor['claveProf'],
							'onClick':'radioOnClick('+idReactivo+','+profesor['claveProf']+','+j+')',
							'html':j
						}).append($('<input>',{
							'hidden':'true',
							'type':'radio',
							'autocomplete':'off',
							'id':'option'+j+'-reactivo'+idReactivo+'-profesor'+profesor['claveProf'],
							'checked':checked,
							'html':j,
						}));
					}
					inputEvaluacion=$('<input>',{
						'type':'text',
						'max':'5',
						'min':'1',
						'class':'form-control form-control-plaintext',
						'id':'inputEvaluacion-reactivo'+idReactivo+'-profesor'+profesor['claveProf'],
						'val':ev,
						'size':2,
						'width':'3rem',
						'tabindex':'-1',
						'readonly':'true'
					});
					row=$('<tr>')
						.append(
							$('<td>',{'html':profesor['nombre']+'<br>',})
								.append(
									$('<span>',{
									'class':'badge badge-secondary text-wrap font-italic',
									'html':materias[i]['nombre']
									})
								)
							)
						.append(
							$('<td>')
								.append(
									$('<div>',{
										'class':'btn-group btn-group-toggle btn-group-lg',
										'data-toggle':'buttons'
									})
										.append(radioBtn[1])
										.append(radioBtn[2])
										.append(radioBtn[3])
										.append(radioBtn[4])
										.append(radioBtn[5])
								)

						)
						.append($('<td>')
							.append(inputEvaluacion)
						);
					$('#tablaEvaluacion').append(row);
				})
				if(data==null){
					showAlert('','No se encontro nada');
				}
			}
		);
	}
</script>
