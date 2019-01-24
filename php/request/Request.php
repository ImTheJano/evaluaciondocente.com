<?php namespace request;
error_reporting(E_ERROR | E_PARSE);
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
require_once(BASE_PATH.'/php/conf/Autoload.php');
\conf\Autoload::load();
$data=json_decode($_POST['_data']);
switch($data->function){
	case 'get':$response=get($data->qry);break;
	case 'set':$response=set($data->st);break;
	case 'multi':{
		for($i=0;$i<count($data->request);$i++){
			switch($data->request[$i]->function){
				case 'get':$response[$i]=get($data->request[$i]->qry);break;
				case 'set':$response[$i]=set($data->request[$i]->st);break;
			}
		}
		break;
	}
}
echo json_encode($response);

function get($qry){
	//echo $qry;
	$query=new \db\MySQL();
	try{
		$rs=$query->doQuery($qry);
		$obj=$rs;
		$count=count($obj);
		if($count==0)$status=0;
		else if($count==1)$status=1;
		else if($count>1)$status=2;
	}catch(Exception $e){
		$status=-1;
	}
	$res['obj']=$obj;
	$res['status']=$status;
	$res['count']=$count;
	return $res;
}
function set($st){
	$query=new \db\MySQL();
	try{
		if($rs=$query->doStatiment($st))$status=1;
		else $status=0;
	}catch(Exception $e){
		$status=-1;
	}
	$res['status']=$status;
	return $res;
}
?>
