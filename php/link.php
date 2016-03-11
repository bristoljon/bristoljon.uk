<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/config.php");

if ($_SERVER['SERVER_NAME']==="localhost") $ip = "46.32.240.35";
else $ip = "10.16.16.2";

$link = new MySQLi($ip, $db_name, $db_pass, $db_name);

if ($link->connect_errno > 0) {
	$error ="Database not connected, try again later";
	die('Unable to connect ['.$link->connect_error.']');
}


?>