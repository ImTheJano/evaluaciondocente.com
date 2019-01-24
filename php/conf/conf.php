<?php
if (!defined("ROOT_PATH"))define("ROOT_PATH","/evdocente.com");
if (!defined("BASE_PATH")) define('BASE_PATH', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].ROOT_PATH : substr($_SERVER['PATH_TRANSLATED'].ROOT_PATH,0, -1*strlen($_SERVER['SCRIPT_NAME'])));
//mysql
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASSWORD","");
define("DB_DATABASE","evdocente");

//security
define("METHOD","AES-256-CBC");
define("SECRET_KEY","iamthejano@2018");
define("SECRET_IV","101712");
define("HASH","sha256");
