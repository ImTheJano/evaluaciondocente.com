<?php namespace db;
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evaluaciondocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
require_once(BASE_PATH.'/php/conf/Autoload.php');
\conf\Autoload::load();

class MySQL{
	public static $print=false;
	private static $connection;
	public function __construct(){
		self::$connection=new \db\Connection();
	}
	public static function setPrintable($bol){
		$this->print=$bol;
	}
	public static function doQuery($qry){
		if(self::$print)print($qry);
		try {
			$rs = self::$connection->conn->query($qry);
			$i=0;
			while($r=$rs->fetch_array()){
				$result[$i]=$r;
				$i++;
			}
			if($i>=1)return $result;
			else return null;
		} catch (\Exception $e) {return null;}
	}
	public static function doStatiment($st){
		if(self::$print)print($st);
		try {
			if(self::$connection->conn->query($st))return true;
			else return false;
		} catch (\Exception $e) {return null;}
	}
}
?>
