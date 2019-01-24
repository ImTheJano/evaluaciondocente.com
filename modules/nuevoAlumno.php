<form>
	<center>
		<div class="card">
			<div class="card-body p-5">
				<h5 class="card-title">Nuevo alumno</h5>
				<div class="form-group">
					<label for="inputMatricula">Matricula</label>
					<input type="text" class="form-control" id="inputMatricula">
				</div>
				<div class="form-group">
					<label for="inputGrupo">Grupo</label>
					<select name="" id="inputGrupo" class="form-control">

					</select>
				</div>
				<span class="card-link btn btn-primary" id="btnGuardar">Guardar</span>
			</div>
		</div>
	</center>
</form>
<script>
$(document).ready(function(){
	$.post(
		'php/request/Request.php',
		{
			'_data':JSON.stringify({
				'function':'get',
				'qry':'SELECT * FROM grupo'
			})
		},
		function(respuesta,status){
			data=JSON.parse(respuesta);
			grupos=data['obj'];
			$('#inputGrupo').append($('<option>',{
				'val':'',
				'html':'Selecciona grupo'
			}));
			$.each(grupos,function(i,grupo){
				$('#inputGrupo').append(
					$('<option>',
						{
							'val':grupo['idG'],
							'html':grupo['idG']
						}
					)
				);
			});
		}
	);
	$('#btnGuardar').click(function(){
		if($('#inputMatricula').val()==''){
			alertify.error('<span class="text-white">Debes escribir una matricula</span>');
			return 0;
		}
		if($('#inputGrupo').val()==''){
			alertify.error('<span class="text-white">Debes seleccionar un grupo</span>');
			return 0;
		}
		qry1='INSERT INTO encuestado VALUES ("'+$('#inputMatricula').val()+'","N")';
		qry2='INSERT INTO encuestadogrupo VALUES ("'+$('#inputMatricula').val()+'","'+$('#inputGrupo').val()+'")';
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
								showAlert('','Se creo una matricula exitosamente');
								$('#inputMatricula').val('');
							}else alertify.error('<span class="text-white">No se pudo ligar con el grupo</span>');
						}
					);
				}else alertify.error('<span class="text-white">No se pudo crear la matricula</span>');
			}
		);
	});
});
</script>
