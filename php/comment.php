<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/link.php");

if ($_POST['grab']) {

	$output=array();

  $query = "SELECT comment.id, comment.date, comment.content, comment.private, user.name FROM `comment` INNER JOIN `user` on user.id = comment.user_id WHERE comment.reference_id=".$_POST['reference']." AND comment.type='".$_POST['type']."'";

	$results = mysqli_query($link, $query);

	while ($comment = mysqli_fetch_array($results)){
  			$output[]=$comment;
  		}

  echo json_encode($output);	
}

if ($_POST['comment']) {

	if ($_SESSION['id']) {
	// Get user ID from name in _SESSION['id']
	$query = "SELECT `id` FROM `user` WHERE `name`='".$_SESSION['id']."' LIMIT 1";

	$results = mysqli_query($link, $query);
	$result = mysqli_fetch_array($results);
	$userID = $result['id'];
  $userName = $_SESSION['id'];
	}
	else {
		$userID = 8;
    $userName = "Anon";
	}

	// Enter comment in db
	$query = "INSERT INTO `comment` (`id`,`user_id`,`type`,`content`,`reference_id`) 
              VALUES (NULL,".
                $userID.
                ",'".$_POST['type']."','".
                mysqli_real_escape_string($link, $_POST['comment']).
                "',".$_POST['reference'].")";

    if(!mysqli_query($link, $query)){
    	echo("Error: ".mysqli_error($link));
    }
    else {
    	echo $userName;
    }
}

if ($_POST['deleteComment']) {
	$query = "DELETE FROM `comment` WHERE `id`=".$_POST['deleteComment']." LIMIT 1";
	if(!mysqli_query($link, $query)){
    	echo("Error: ".mysqli_error($link));
    }
    else {
    	echo("Post deleted");
    }

}

?>