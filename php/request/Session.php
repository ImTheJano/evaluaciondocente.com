<?php namespace request;
//error_reporting(E_ERROR | E_PARSE);
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
require_once(BASE_PATH.'/php/conf/Autoload.php');
\conf\Autoload::load();
$data=json_decode($_POST['_data']);
switch($data->function){
	case 'encuestado':$response=encuestado($data);break;
	case 'profesor':$response=profesor($data);break;
	case 'usuario':$response=usuario($data);break;
}
echo json_encode($response);

function encuestado($data){
	$query=new \db\MySQL();
	try{
		$rs=$query->doQuery('SELECT * FROM encuestado WHERE matricula = "'.$data->matricula.'"');
		if(count($rs)==1)$status=1;
		else $status=0;
		$res['status']=$status;
		$session=new \session\Session();
		$session->setEncuestado($data->matricula);
		return $res;
	}catch(Exeption $e){}
}
function profesor($data){
	$query=new \db\MySQL();
	try{
		$rs=$query->doQuery('SELECT * FROM profesor WHERE claveProf = "'.$data->clave.'"');
		if(count($rs)==1){
			$_profesor=$rs[0];
			if($_profesor['nombre']==$data->nombre)$status=1;
			else $status=0;
		}else $status=-1;
		$res['status']=$status;
		$session=new \session\Session();
		$session->setProfesor($data->clave);
		return $res;
	}catch(Exception $e){}
}
function usuario($data){
	$query=new \db\MySQL();
	try{
		$rs=$query->doQuery('SELECT * FROM usuario WHERE nick = "'.$data->nick.'"');
		if(count($rs)==1){
			$_usuario=$rs[0];
			if($_usuario['password']==$data->password)$status=1;
			else $status=0;
		}else $status=-1;
		$res['status']=$status;
		$session=new \session\Session();
		$session->setUsuario($data->nick);
		return $res;
	}catch(Exception $e){}
}
?>
