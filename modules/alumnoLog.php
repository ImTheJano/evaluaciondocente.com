<div class="containter">
	<div class="form-row">
		<div class="col-md-12">
			<div class="form-label-group">
				<input type="text" id="inputMatricula" class="form-control" placeholder="Matricula" required="required" autofocus="autofocus">
				<div id="outputMatricula" class=""></div>
				<label for="inputMatricula">Matricula</label>
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
					'function':'encuestado',
					'matricula':$('#inputMatricula').val(),
				})
			},
			function(respuesta,status){
				data=JSON.parse(respuesta);
				if(data['status']==1){
					alertify.confirm('Correcto', '¿Deseas iniciar secion con la matricula "'+$('#inputMatricula').val()+'"?',
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
