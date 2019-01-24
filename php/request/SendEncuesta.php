<?php namespace request;
error_reporting(E_ERROR | E_PARSE);
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
require_once(BASE_PATH.'/php/conf/Autoload.php');
\conf\Autoload::load();
$data=json_decode($_POST['_data']);
$profesores=$data->profesores;
$respuestas=$data->respuestas;
$mySql=new \db\MySQL;
$status=true;
//var_dump($respuestas);
foreach($profesores as $i => $profesor){
	$envio[$i]=intentosRecursivos(10000,false,$profesores,$respuestas,$i);
	if(!$envio[$i])$status=false;
}
$response->envios=$envio;
$response->status=$status;
echo json_encode($response);
function intentosRecursivos($intento,$exito,$profesores,$respuestas,$i){
	$mySql=new \db\MySQL;
	if($intento>0&&!$exito){
		$status=true;
		$rs=$mySql::doQuery('SELECT idE FROM encuestaconteo ORDER BY  idE DESC LIMIT 1');
		$lastId=$rs[0]['idE'];
		$nextId=$lastId+1;
		$rs=$mySql::doQuery('SELECT * FROM pregunta');
		$preguntas=$rs;
		$st='INSERT INTO encuestaconteo VALUES ("'.$nextId.'","2019/1","'.$profesores[$i]->claveProf.'")';
		if($mySql::doStatiment($st)){
			foreach($preguntas as $j => $pregunta){
				$st='INSERT INTO encuestapregunta VALUES ("'.$nextId.'","'.$pregunta['numP'].'","'.$respuestas[$pregunta['numP']][$i].'")';
				if($mySql::doStatiment($st)){
					$response->envio[$j][$i]=true;
				}
				else{
					$response->envio[$j][$i]=false;
					$status=false;
				}
			}
		}else $status=false;
		if($status){
			$exito=true;
			return $status;
		}
		$intento--;
		$status=intentosRecursivos($intento,$exito,$profesores,$respuestas,$i);
	}
	return $status;
}

?>
