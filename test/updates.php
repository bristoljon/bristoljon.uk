<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/link.php");

$output=array();

if ($_POST['get']==="recent") {
	if ($_SESSION['id']) {
		$query= "SELECT new_update.*, project.title AS projTitle, project.title_url AS projURL FROM `new_update` LEFT JOIN project ON new_update.reference_id=project.id ORDER BY new_update.id DESC LIMIT 10";     
  	}
	else {
		$query= "SELECT new_update.*, project.title AS projTitle, project.title_url AS projURL FROM `new_update` LEFT JOIN project ON new_update.reference_id=project.id WHERE new_update.privacy=0 ORDER BY new_update.id DESC LIMIT 10"; 
	}     
	$result = mysqli_query($link, $query);  
	while ($update = mysqli_fetch_array($result)){
		$output[]=$update;
	} 	
}




header('Content-Type: application/json');
echo json_encode($output);

?>