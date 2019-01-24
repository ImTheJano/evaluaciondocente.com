<div class="containter">
	<div class="form-row">
		<div class="col-md-6">
			<div class="form-label-group">
				<input type="text" id="inputNombre" class="form-control" placeholder="Nombre" required="required" autofocus="autofocus">
				<div id="outputMatricula" class=""></div>
				<label for="inputNombre">Nombre</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-label-group">
				<input type="clave" id="inputClave" class="form-control" placeholder="Clave" required="required" autofocus="autofocus">
				<div id="outputClave" class=""></div>
				<label for="inputClave">Clave</label>
			</div>
		</div>
	</div>
	<div class="form-row mt-3">
		<div class="col-md-12">
			<span class="btn btn-primary btn-block" id="btnAcceso">Acceso</span>
		</div>
	</div>
</div>
<script>
	$("#btnAcceso").click(function(evt){
		$.post(
			'php/request/Session.php',
			{
				'_data':JSON.stringify({
					'function':'usuario',
					'nick':$('#inputNombre').val(),
					'clave':$('#inputClave').val(),
				})
			},
			function(respuesta,status){
				showAlert('',respuesta);
				data=JSON.parse(respuesta);
				if(data['status']==1){
					alertify.confirm('Correcto', '¿Deseas iniciar secion con la matricula "'+data['obj'][0]['matricula']+'"?',
					function(){
						alertify.success('Ok')
						window.location.href = "evaluacion";
					},function(){});
				}
				else showAlert('','Error de autentificacion');
				if(data==null){
					showAlert('','Error');
				}
			}
		);
	});
</script>
