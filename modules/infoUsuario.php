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
	<script>window.location.href = "admin";</script>
<?php }
$session=new \session\Session();
if($session::$mode!='usuario'){
	logout();
	die();
}
?>
<div class="card">
	<div class="card-header">
		Administrador
	</div>
	<div class="card-body">
		<div class="form-row">
			<div class="form-group">
				<label for="inputNick">Nick</label>
				<input id="inputNick" type="text" class="form-control form-control-plaintext">
			</div>
		</div>
		<div class="form-row">
			<span class="btn btn-primary mx-1" id="btnCambiarNick">Cambiar nick</span>
			<span class="btn btn-primary mx-1" id="btnCambiarPassword">Cambiar Password</span>
		</div>
	</div>
</div>
<script>
	var nick="<?php echo $session::$usuario->usuario?>";
	$('#inputNick').val(nick);
	$('#btnCambiarNick').click(function(){
		alertify.prompt( 'Autentificate', 'Escribe tu password', '', function(evt, password) {
			$.post(
				'php/request/Request.php',
				{
					'_data':JSON.stringify({
						'function':'get',
						'qry':'SELECT * FROM usuario WHERE nick= "'+nick+'" ',
					})
				},
				function(respuesta,status){
					data=JSON.parse(respuesta);
					if(data['obj'][0]['password']==password){
						alertify.prompt( 'Nuevo nick', 'Escribe tu nuevo nick', '',
							function(evt2,newNick){
								$.post(
									'php/request/Request.php',
									{
										'_data':JSON.stringify({
											'function':'set',
											'st':'UPDATE usuario SET nick = "'+newNick+'" WHERE nick = "'+nick+'"',
										})
									},
									function(respuesta2,status2){
										data2=JSON.parse(respuesta2);
										if(data2['status']==1){
											$.post(
												'php/request/Session.php',
												{
													'_data':JSON.stringify({
														'function':'usuario',
														'nick':newNick,
														'password':password,
													})
												},
												function(respuesta,status){}
											);
											nick=newNick;
											$('#inputNick').val(newNick);
											alertify.success('<span class="text-white">Cambio de nick a '+newNick+'</span>');
										}else{
											alertify.error('<span class="text-white">Nick '+newNick+' no disponible</span>');
										}
									}
								);
							},
							function(){

							}
						);
					}
					else{
						alertify.error('<span class="text-white">Autentificación incorrecta</span>');
					}
				}
			);
		},function(){

		}).set('type', 'password');
	});
	$('#btnCambiarPassword').click(function(){
		alertify.prompt( 'Autentificate', 'Escribe tu password', '', function(evt, password) {
			$.post(
				'php/request/Request.php',
				{
					'_data':JSON.stringify({
						'function':'get',
						'qry':'SELECT * FROM usuario WHERE nick= "'+nick+'" ',
					})
				},
				function(respuesta,status){
					data=JSON.parse(respuesta);
					if(data['obj'][0]['password']==password){
						alertify.prompt( 'Nuevo password', 'Escribe tu nuevo passwor', '',
							function(evt2,newPassword){
								$.post(
									'php/request/Request.php',
									{
										'_data':JSON.stringify({
											'function':'set',
											'st':'UPDATE usuario SET password = "'+newPassword+'" WHERE nick = "'+nick+'"',
										})
									},
									function(respuesta2,status2){
										data3=JSON.parse(respuesta2);
										if(data3['status']==1){
											$.post(
												'php/request/Session.php',
												{
													'_data':JSON.stringify({
														'function':'usuario',
														'nick':newPassword,
														'password':password,
													})
												},
												function(respuesta,status){}
											);
											alertify.success('<span class="text-white">Se ha cambiado el password</span>');
										}else{
											alertify.error('<span class="text-white">Ocurrio un error</span>');
										}
									}
								);
							},
							function(){
								alertify.error('<span class="text-white">Cancelado</span>');
							}
						).set('type', 'password');
					}
					else{
						alertify.error('<span class="text-white">Autentificación incorrecta</span>');
					}
				}
			);
		},function(){

		}).set('type', 'password');
	});
</script>
