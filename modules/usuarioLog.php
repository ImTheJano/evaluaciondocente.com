<div class="containter">
	<div class="form-row">
		<div class="col-md-6">
			<div class="form-label-group">
				<input type="text" id="inputNick" class="form-control" placeholder="Nick" required="required" autofocus="autofocus">
				<div id="outputMatricula" class=""></div>
				<label for="inputNick">Nick</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-label-group">
				<input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" autofocus="autofocus">
				<div id="outputPassword" class=""></div>
				<label for="inputPassword">Password</label>
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
					'nick':$('#inputNick').val(),
					'password':$('#inputPassword').val(),
				})
			},
			function(respuesta,status){
				data=JSON.parse(respuesta);
				if(data['status']==1){
					window.location.href = "admin";
				}
				else showAlert('','Error de autentificacion');
				if(data==null){
					showAlert('','Error');
				}
			}
		);
	});
</script>
