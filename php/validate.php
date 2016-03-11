<?php

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/link.php");

if ($_POST['newUser']) {

	$query= "SELECT * FROM `user` WHERE name ='".mysqli_real_escape_string($link, $_POST['newUser'])."'";     
    $result = mysqli_query($link, $query);  
    $row = mysqli_fetch_array($result);     
    if ($row) $return = "Taken";
}

if ($_POST['answer']) {

	if (strtolower($_POST['answer'])=="carpet") {
		$return = "correct";
	}
}



echo $return;

?>