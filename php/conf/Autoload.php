<?php namespace conf;
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
class Autoload{
	public static function load(){
		spl_autoload_register(function($class){
			$path=BASE_PATH.'/php/'.str_replace('\\','/',$class.'.php');
			if(is_readable($path)){
				require_once($path);
			}
		});
	}
}
?>
