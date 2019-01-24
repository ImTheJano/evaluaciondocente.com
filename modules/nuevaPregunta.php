<form>
	<center>
		<div class="card">
			<div class="card-body p-5">
				<h5 class="card-title">Nueva pregunta</h5>
				<div class="form-group">
					<label for="inputPregunta">Pregunta</label>
					<input type="text" class="form-control" id="inputPregunta">
				</div>
				<span class="card-link btn btn-primary" id="btnGuardar">Guardar</span>
			</div>
		</div>
	</center>
</form>
<script>
$(document).ready(function(){
	$('#btnGuardar').click(function(){
		if($('#inputPregunta').val()==''){
			alertify.error('<span class="text-white">Debes escribir una pregunta</span>');
			return 0;
		}
		qry1='SELECT (numP)+1 FROM pregunta ORDER BY numP DESC LIMIT 1';
		$.post(
			'php/request/Request.php',
			{
				'_data':JSON.stringify({
					'function':'get',
					'qry':qry1
				})
			},
			function(respuesta,status){
				data=JSON.parse(respuesta);
				nextId=data['obj'][0][0];
				qry2='INSERT INTO pregunta VALUES ("'+nextId+'","'+$('#inputPregunta').val()+'","10")';
				$.post(
					'php/request/Request.php',
					{
						'_data':JSON.stringify({
							'function':'set',
							'st':qry2
						})
					},
					function(respuesta2,status){
						data2=JSON.parse(respuesta2);
						if(data2['status']==1){
							showAlert('','Se creo una pregunta exitosamente');
							$('#inputPregunta').val('');
						}else alertify.error('<span class="text-white">No se pudo crear la pregunta</span>');
					}
				);
			}
		);
	});
});
</script>
