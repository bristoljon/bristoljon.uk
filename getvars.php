<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/link.php");

if ($_POST['all']) {
  	echo json_encode($results);	
}