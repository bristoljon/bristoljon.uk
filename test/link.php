<?php

session_start();

if ($_SERVER['SERVER_NAME']==="localhost") $ip = "46.32.240.35";
else $ip = "10.16.16.2";

$link = new MySQLi($ip,"jon-jey-u-000188","gWKFNH^4y","jon-jey-u-000188");

if ($link->connect_errno > 0) {
	$error ="Database not connected, try again later";
	die('Unable to connect ['.$link->connect_error.']');
}


?>