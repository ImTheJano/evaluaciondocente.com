<?php namespace db;
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
spl_autoload_register(function($class){
	$filename=BASE_PATH.'/' . str_replace("\\","/",$class) . ".php";
	if(is_readable($filename))require_once $filename;
	else echo $filename." File not found";
});

class Connection{
	public $conn;
	public static $print=0;
	public function __construct(){
		require_once(BASE_PATH.'/php/conf/conf.php');
		$this->conn=new \mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
		if (mysqli_connect_errno()) {
			printf("No se pudo conectar: %s\n", $this->conn->connect_error);
			exit();
		}
	}
}
?>
