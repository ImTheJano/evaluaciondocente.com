<form>
	<center>
		<div class="card">
			<div class="card-body p-5">
				<h5 class="card-title">Nuevo usuario</h5>
				<div class="form-group">
					<label for="inputNick">Nick</label>
					<input type="text" class="form-control" id="inputNick">
				</div>
				<div class="form-group">
					<label for="inputPassword">Password</label>
					<input type="password" class="form-control" id="inputPassword">
				</div>
				<div class="form-group">
					<label for="inputCPassword">Confirmar password</label>
					<input type="password" class="form-control" id="inputCPassword">
				</div>
				<span class="card-link btn btn-primary" id="btnGuardar">Guardar</span>
			</div>
		</div>
	</center>
</form>
<script>
$(document).ready(function(){
	$('#btnGuardar').click(function(){
		if($('#inputNick').val()==''){
			alertify.error('<span class="text-white">Debes escribir un nick</span>');
			return 0;
		}
		if($('#inputPassword').val()==''){
			alertify.error('<span class="text-white">Debes escribir un password</span>');
			return 0;
		}
		if($('#inputCPassword').val()==''){
			alertify.error('<span class="text-white">Debes confirmar el password</span>');
			return 0;
		}
		if($('#inputPassword').val()!=$('#inputCPassword').val()){
			alertify.error('<span class="text-white">Confirmación de password incorrecta</span>');
			return 0;
		}
		qry1='INSERT INTO usuario VALUES ("'+$('#inputNick').val()+'","'+$('#inputPassword').val()+'")';
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
					showAlert('','Se creo un usuario exitosamente');
					$('#inputNick').val('');
					$('#inputPassword').val('');
				}else alertify.error('<span class="text-white">No se pudo crear el usuario, intenta otro nick</span>');
			}
		);
	});
});
</script>
