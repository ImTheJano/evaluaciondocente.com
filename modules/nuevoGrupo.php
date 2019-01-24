<form>
	<center>
		<div class="card">
			<div class="card-body p-5">
				<h5 class="card-title">Nuevo grupo</h5>
				<div class="form-group">
					<label for="inputIdGrupo">Id grupo</label>
					<input type="text" class="form-control" id="inputIdGrupo">
				</div>
				<span class="card-link btn btn-primary" id="btnGuardar">Guardar</span>
			</div>
		</div>
	</center>
</form>
<script>
$(document).ready(function(){
	$('#btnGuardar').click(function(){
		if($('#inputIdGrupo').val()==''){
			alertify.error('<span class="text-white">Debes escribir un grupo</span>');
			return 0;
		}
		qry1='INSERT INTO grupo VALUES ("'+$('#inputIdGrupo').val()+'")';
		$.post(
			'php/request/Request.php',
			{
				'_data':JSON.stringify({
					'function':'set',
					'st':qry1
				})
			},
			function(respuesta,status){
				data=JSON.parse(respuesta);
				if(data['status']==1){
					showAlert('','Se creo un grupo exitosamente');
					$('#inputIdGrupo').val('');
				}else alertify.error('<span class="text-white">No se pudo crear el grupo, intenta otro nombre</span>');
			}
		);
	});
});
</script>
