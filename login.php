<?php

session_start();

include("link.php");

if ($_GET['logout']) {
  unset($_GET['logout']);
  session_destroy();
  unset($_SESSION['id']);
  $message="You've been logged out";
}


if ($_POST['submit']=="Sign Up") {

  if (!$_POST['newName']) $error.="<br />Please enter your name";
  else { 
    if (strlen($_POST['newName'])<3) $error.="<br />Name must be at least 3 characters";
    if(preg_match('/[^a-zA-Z ]/', $_POST['newUser'])) $error.= "<br />Name must be letters only";
  }

  if (!$_POST['newUser']) $error.="<br/>Please enter a username";
  else {
    if (strlen($_POST['newUser'])<3) $error.="<br />Username must be at least 3 characters";
    if(preg_match('/[^a-zA-Z0-9]/', $_POST['newUser'])) $error.= "<br />Username must contain only letters and numbers";
  }

  if (!$_POST['newEmail']) $error.="<br/>Please enter an e-mail";
  else {
    if (filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL) === false) {
      $error.="<br/> Invalid e-mail address";
    }
  }

  if (!$_POST['newPass']) $error.="<br />Please enter your password";
  else {
    if (strlen($_POST['newPass'])<8) $error.="<br />Password must be at least 8 characters";
  }

  if (!$_POST['conPass']) $error.="<br />Please confirm your password";
  else {
    if ($_POST['conPass']!=$_POST['newPass']) $error .= "<br/>Passwords don't match";
  }

  if (!$_POST['answer']) $error.="<br />Please answer the riddle";
  else {
    if (strtolower($_POST['answer'])!="carpet") $error.="<br />Riddle answer incorrect";
  }

  
  if (!$error) {
    $query= "SELECT * FROM `user` WHERE name ='".mysqli_real_escape_string($link, strtolower($_POST['newUser']))."'";     
    $result = mysqli_query($link, $query);  
    $results = mysqli_num_rows($result);     
    if ($results) $error = "That username is already registered. Do you want to log in?";

    else {

    $query = "INSERT INTO `user` (`id`,`name`,`email`,`pass`,`fullname`) 
              VALUES (NULL, '".
                strtolower(mysqli_real_escape_string($link, $_POST['newUser'])).
                "','".
                mysqli_real_escape_string($link, $_POST['newEmail']).
                "','".
                md5(md5(strtolower($_POST['newUser'])).$_POST['newPass']).
                "','".
                mysqli_real_escape_string($link, $_POST['newName']).
                "')";

      mysqli_query($link, $query);
      $message.="Hello ".$_POST['newName'];
      $_SESSION['id']= strtolower($_POST['newUser']);

      $error='';

      // E-mail notification
      $emailTo="j.j.wyatt@hotmail.com";
      $subject="bristoljon.uk - New User";
      $fromName=$_POST['newName'];
      $fromEmail=$_POST["newEmail"];     

      $headers ="From: ".$fromName." <message@bristoljon.uk>"."\r\n"."Reply-To:".$fromName." <".$fromEmail.">\r\n";

      mail($emailTo,$subject,$body,$headers); 
    }  
  }

  else $error = '<div style = "margin:5px" class="alert alert-danger">There were error(s) in your sign up details:'.$error.'</div>';

  unset($_POST['submit']);
}



if ($_POST['submit']=="Log In") {
  
  $query = "SELECT * FROM user WHERE name='".mysqli_real_escape_string($link, strtolower($_POST['user']))."'AND 
    pass='".md5(md5(strtolower($_POST['user'])).$_POST['pass'])."' LIMIT 1";

  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);

  if ($row) {
    $_SESSION['id']=$row["name"];
    $message ="You have been logged in";
  }
  else {
    $message = "Sorry, you ain't on the list!";
  }

  unset($_POST['submit']);
}

if ($_GET['query'] && $_SESSION['id']) {
  header("Location: /project/".$_GET['query']);
} 


if ($_SESSION['id']) {

  // Get name if already entered or just use username
  $query= "SELECT fullname FROM user WHERE name='".$_SESSION['id']."' LIMIT 1";

  if ($result = mysqli_query($link,$query)) {
    $row = mysqli_fetch_array($result);
    $loggedinUser=$row['fullname'];
  }
  else {
    $loggedinUser=$_SESSION['id'];
  }

  $login = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$loggedinUser.'<span class="caret"></span></a><ul class="dropdown-menu"><li><a href="/logout">Logout?</a></li></ul></li>';
}

else {

  $login = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a><div id="loginDropdown" class="dropdown-menu col-md-6"><form method="post"><div class="form-group"><input id="user" name="user" type="user" class="form-control" placeholder="Username"><input id="pass" name="pass" type="password" class="form-control" placeholder="Password"></div><div class="pull-left signLabel"><a data-toggle="modal" data-target="#signupModal" href="#">New user?</a></div><input id="login" type="submit" name="submit" value="Log In" class="btn btn-success pull-right"></form></div></li>';
}


if ($error || $_GET['signup']) {
  $openSignUpModal = '$("#signupModal").modal("show"); validateAll();';
}
else {
  $openSignUpModal = '';
}

?>