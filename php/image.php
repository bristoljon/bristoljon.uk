<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/link.php");

$output=array();

if ($_POST['type']==="project") {
  $query= "SELECT image.url FROM `image` INNER JOIN `project_image` ON project_image.image_id = image.id WHERE project_image.project_id =".$_POST['reference'];     
  $result = mysqli_query($link, $query);  
  while ($tags = mysqli_fetch_array($result)){
  	$output[]=$tags;
  } 	
}

if ($_POST['type']==="blog") {
  
}


echo json_encode($output);

?>