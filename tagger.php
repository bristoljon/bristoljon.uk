<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/link.php");

$output=array();

if ($_POST['type']==="project") {
  $query= "SELECT tag.name FROM `project` JOIN project_tag ON project.id = project_tag.project_ID JOIN tag ON tag.id = project_tag.tag_id and project.id=".$_POST['reference'];     
  $result = mysqli_query($link, $query);  
  while ($tags = mysqli_fetch_array($result)){
  	$output[]=$tags;
  } 	
}

if ($_POST['type']==="blog") {
  $query= "SELECT tag.name FROM `blog` JOIN blog_tag ON blog.id = blog_tag.blog_id JOIN tag ON tag.id = blog_tag.tag_id and blog.id=".$_POST['reference'];     
  $result = mysqli_query($link, $query);  
  while ($tags = mysqli_fetch_array($result)){
  	$output[]=$tags;
  }
}


echo json_encode($output);

?>