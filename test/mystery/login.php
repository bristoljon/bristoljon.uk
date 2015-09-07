<?php

session_start();
include("link.php");

if ($_GET['logout']) {
  session_destroy();
  $message = "You have been logged out";
}


if ($_POST['submit']=="Sign Up") {

  if (!$_POST['newUser']) $error.="<br/>Please enter your username";  
  if (!$_POST['newPass']) $error.="<br />Please enter your password";
  else { 
    if (strlen($_POST['newPass'])<8) $error.="<br />Please enter at least 8 characters";
    if(!preg_match('/[A-Z]/', $_POST['newPass'])) $error.= "<br />Please include min 1 capital letter";
  }
  if ($error) $error = "There were error(s) in your sign up details:".$error;
  
  else {
    $query= "SELECT * FROM `users` WHERE name ='".mysqli_real_escape_string($link, $_POST['newUser'])."'";     
    $result = mysqli_query($link, $query);  
    $results = mysqli_num_rows($result);     
    if ($results) $error = "That username is already registered. Do you want to log in?";

    else {
    $query = "INSERT INTO `users` (`name`, `password`,`firstname`) VALUES ('".mysqli_real_escape_string($link, $_POST['newUser'])."', '".md5(md5($_POST['newUser']).$_POST['newPass'])."','".mysqli_real_escape_string($link, $_POST['newName'])."')";
      mysqli_query($link, $query);
      $message.="You've been signed up!";
      $_SESSION['id']= $_POST['newUser'];
      header("Location:main.php");
    }  
  }
}



if ($_POST['submit']=="Log In") {
  $query = "SELECT * FROM users WHERE name='".mysqli_real_escape_string($link, $_POST['user'])."'AND 
    password='".md5(md5($_POST['user']) .$_POST['pass']). "'LIMIT 1";

  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);

  if ($row) {
    $_SESSION['id']=$row["name"];
    header("Location:main.php");
  }
  else {
    $error = "If you ain't on the list, you ain't coming in!";
  }
}

?>