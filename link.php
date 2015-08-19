<?php

session_start();

$link = new MySQLi("10.16.16.2","jon-jey-u-000188","gWKFNH^4y","jon-jey-u-000188");

if ($link->connect_errno > 0) {
	$error ="Database not connected, try again later";
	die('Unable to connect ['.$link->connect_error.']');
}

?>