<?php namespace session;
error_reporting(E_ERROR | E_PARSE);
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
require_once(BASE_PATH.'/php/conf/Autoload.php');
\conf\Autoload::load();
class Session{
	public static $status;
	public static $usuario;
	public static $mode;
	public function __construct(){
		session_start();
		if(isset($_SESSION['id'])&&isset($_SESSION['mode'])){
			$idUsuario=$_SESSION['id'];
			$sessionMode=$_SESSION['mode'];
			$this::$status=true;
			switch($sessionMode){
				case 'encuestado':
					$this::getEncuestado($idUsuario);
					break;
				case 'profesor':
					$this::getProfesor($idUsuario);
					break;
				case 'usuario':
					$this::getUsuario($idUsuario);
					break;
			}
		}
		else{
			$this::$status=false;
			session_destroy();
		}
	}
	public function setEncuestado($matricula){
		session_start();
		$_SESSION['id']=$matricula;
		$_SESSION['mode']='encuestado';
	}
	public function getEncuestado($matricula){
		$sql=new \db\MySQL();
		$_encuestado=$sql->doQuery('SELECT * FROM encuestado WHERE matricula = "'.$matricula.'"');
		$_grupo=$sql->doQuery('SELECT * FROM encuestadoGrupo WHERE matricula = "'.$matricula.'"');
		$encuestado=json_decode(json_encode($_encuestado));
		$this::$usuario->encuestado=$encuestado[0];
		$this::$usuario->grupo=$_grupo[0]['idG'];
		$this::$mode='encuestado';
	}
	public function setUsuario($idUsuario){
		session_start();
		$_SESSION['id']=$idUsuario;
		$_SESSION['mode']='usuario';
	}
	public function getUsuario($idUsuario){
		$sql=new \db\MySQL();
		$_usuario=$sql->doQuery('SELECT * FROM usuario WHERE nick ="'.$idUsuario.'"');
		$this::$usuario->usuario=$_usuario[0]['nick'];
		$this::$mode='usuario';
	}
	public function setProfesor($idUsuario){
		session_start();
		$_SESSION['id']=$idUsuario;
		$_SESSION['mode']='profesor';
	}
	public function getProfesor($idUsuario){
		$sql=new \db\MySQL();
		$_profesor=$sql->doQuery('SELECT * FROM profesor WHERE claveProf ="'.$idUsuario.'"');
		$this::$usuario->profesor=$_profesor[0]['nick'];
		$this::$mode='profesor';
	}
	public function sessionDestroy(){
		session_destroy();
	}
}
?>
