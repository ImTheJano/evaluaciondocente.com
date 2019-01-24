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
$encuestados=$mySql::doQuery('SELECT * FROM encuestado');
?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a>Administrar</a></li>
		<li class="breadcrumb-item"><a>Tablas</a></li>
		<li class="breadcrumb-item active" aria-current="page">Encuestados</li>
	</ol>
</nav>
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>Encuestados
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTableEncuestados" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Matricula</th>
						<th>Status</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php for($i=0;$i<count($encuestados);$i++){?>
					<tr id="row-<?php echo $i?>">
						<td>
							<?php echo $encuestados[$i]['matricula']?>
						</td>
						<td><span hidden id="statusEncuestado-<?php echo $i?>"><?php echo $encuestados[$i]['status']?></span>
							<select class="form-control form-control-plaintext" id="inputStatus-<?php echo $i?>" readonly size="1" disabled >
								<option value="R" <?php if($encuestados[$i]['status']=='R')echo'selected="true"'?>>Encuestado</option>
								<option value="N" <?php if($encuestados[$i]['status']=='N')echo'selected="true"'?>>Sin encuestar</option>
							</select>
						</td>
						<td>
							<span class="btn btn-primary my-1" id="btnEditar-<?php echo $i?>">Editar</span>
							<span class="btn btn-success my-1" hidden disabled id="btnGuardar-<?php echo $i?>">Guardar</span>
							<span class="btn btn-warning my-1" hidden disabled id="btnCancelar-<?php echo $i?>">Cancelar</span>
						</td>
						<td>
							<span class="btn btn-danger" id="btnEliminar-<?php echo $i?>">Eliminar</span>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		btnFunction=new Array;
		tabla=$('#dataTableEncuestados').DataTable();
		$.post(
			'php/request/Request.php',
			{
				'_data':JSON.stringify({
					'function':'get',
					'qry':'SELECT * FROM encuestado',
				})
			},
			function(respuesta,status){
				data=JSON.parse(respuesta);
				encuestados=data['obj']
				$.each(encuestados,function(i,encuestado){
					btnFunction[i]=true;
					$('#btnEditar-'+i).click(function(){
						btnFunction[i]=toggleInputs(i,btnFunction[i]);
					});
					$('#btnGuardar-'+i).click(function(){
						if($('#inputStatus-'+i).val()!=''){
							$.post(
								'php/request/Request.php',
								{
									'_data':JSON.stringify({
										'function':'set',
										'st':'UPDATE encuestado SET status ="'+$('#inputStatus-'+i).val()+'" WHERE matricula ='+encuestado['matricula'],
									})
								},
								function(respuesta2,status2){
									data2=JSON.parse(respuesta2);
									if(data2['status']==1){
										$('#statusEncuestado-'+i).html($('#inputStatus-'+i).val());
										alertify.success('<span class="text-white">Se ha hecho una modificacion</span>');
									}else alertify.error('<span class="text-white">Ocurrio un error</span>');
									$('#btnCancelar-'+i).click();
								}
							);
						}else alertify.error('<span class="text-white">No puedes dejar el campo vacio</span>');
					});
					$('#btnCancelar-'+i).click(function(){
						$.post(
							'php/request/Request.php',
							{
								'_data':JSON.stringify({
									'function':'get',
									'qry':'SELECT * FROM encuestado WHERE matricula= "'+encuestado['matricula']+'"',
								})
							},
							function(respuesta2,status2){
								data2=JSON.parse(respuesta2);
								$('#inputStatus-'+i).val(data2['obj'][0]['status']);
							}
						);
						btnFunction[i]=toggleInputs(i,btnFunction[i]);
					});
					$('#btnEliminar-'+i).click(function(){
						alertify.confirm('Confirmar','¿Estas seguro?',
							function(){
								$.post(
									'php/request/Request.php',
									{
										'_data':JSON.stringify({
											'function':'set',
											'st':'DELETE FROM encuestado WHERE matricula = "'+encuestado['matricula']+'"',
										})
									},
									function(respuesta2,status2){
										data2=JSON.parse(respuesta2);
										if(data2['status']==1){
											alertify.success('<span class="text-white">Se ha eliminado correctamente un elemento</span>');
											tabla.row(':eq('+i+')').remove().draw();
										}else alertify.error('<span class="text-white">Ocurrio un error</span>');
									}
								);
							},
							function(){

							}
						);
					});
				});
			}
		);
	});
	function toggleInputs(i,togg){
		if(togg){
			$('#inputStatus-'+i).removeAttr('disabled').removeAttr('readonly').removeClass('form-control-plaintext');;
			$('#btnGuardar-'+i).removeAttr('hidden');
			$('#btnCancelar-'+i).removeAttr('hidden');
			$('#btnEditar-'+i).attr('hidden','true');
			return false;
		}else{
			$('#inputStatus-'+i).attr('disabled','true').attr('readonly','true').addClass('form-control-textplain');
			$('#btnGuardar-'+i).attr('hidden','true');
			$('#btnCancelar-'+i).attr('hidden','true');
			$('#btnEditar-'+i).removeAttr('hidden');
			return true;
		}
	}
</script>
