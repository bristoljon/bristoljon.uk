<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/login.php");

if ($_SESSION['id']!="jon") {
  header('Location: /php/private.php');
}


if ($_SESSION['id'] && $_GET['update']) {
  $query= "SELECT * FROM `new_update` WHERE id ='".$_GET['update']."'";     
  $result = mysqli_query($link, $query);  
  $results = mysqli_fetch_array($result);
}

// Submit new update (no id entered)
if ($_POST['submit']=="Submit" && $_POST['id']=="") {

  if (!$_POST['title']) $error.="<br />Please enter a title";
  if (!$_POST['content']) $error.="<br />Please enter some content";
  if (!$_POST['type']) $error .="<br />Please enter a type";
  if (!$_POST['reference_id']) $error .="<br />Please enter a reference ID";
  if (!$_POST['reference_type']) $error .="<br />Please enter a reference type";
  
  if (!$error) {

    $query = "INSERT INTO `new_update` (`id`,`title`,`content`,`type`,`reference_id`,`reference_type`,`url`,`privacy`) 
              VALUES (NULL, '".
                mysqli_real_escape_string($link, $_POST['title']).
                "','".
                mysqli_real_escape_string($link, $_POST['content']).
                "','".
                mysqli_real_escape_string($link, $_POST['type']).
                "',".
                $_POST['reference_id'].
                ",'".
                mysqli_real_escape_string($link, $_POST['reference_type']).
                "','".
                mysqli_real_escape_string($link, $_POST['url']).
                "',".
                $_POST['privacy'].
                ")";

      mysqli_query($link, $query) or die(mysqli_error($link));

      $blog_id = $link->insert_id;
     
      $message.=$_POST['title']." submitted<br/>";
  }  
  else {
    $error = '<div style = "margin:5px" class="alert alert-danger">There were error(s) in your submission:'.$error.'</div>';
  }
}

// Edit existing update (id entered)
if ($_POST['submit']=="Submit" && $_POST['id']!="") {

   $query = "UPDATE `new_update` SET 
      `title`='".mysqli_real_escape_string($link, $_POST['title'])."',
      `content`='".mysqli_real_escape_string($link, $_POST['content'])."',
      `type`='".mysqli_real_escape_string($link, $_POST['type'])."',
      `reference_id`=".$_POST['reference_id'].",
      `url`=".mysqli_real_escape_string($link, $_POST['url']).",
      `privacy`=".$_POST['privacy'].",
      `reference_type`='".mysqli_real_escape_string($link, $_POST['reference_type'])."' 
       WHERE `id`='".$_POST['id']."' LIMIT 1";

      if(!mysqli_query($link, $query)){
        $message.=("Error: ".mysqli_error($link));
      }  
}

unset($_POST['submit']);


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>New Update</title>

    <link href="/css/styles.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <link href="/css/header.css" rel="stylesheet" type="text/css">


<style type="text/css">

body {
  background: radial-gradient(circle, #FFFF00 40%, #FFA500);
  background-size: cover;
}

#blogform {
  margin-top: 60px;
}

.row {
  margin:0;
  width:100%;
}



</style>
    
</head>

<body>
    
<?php include($root."/html/header.html"); ?>

<div class="row">

<div class="container">

  <form id="blogform" method="post">

    <?php echo $message; ?>

    <div class="form-group">
      <label for="id">ID</label>
      <input value="<?php echo $results['id'] ?>" class="form-control" type="text" name="id">
    </div>

    <div class="form-group">
      <label for="type">Type</label>
      <input value="<?php if ($results['type']) echo $results['type']; else echo $_GET['type'];?>" class="form-control" type="text" name="type">
    </div>

    <div class="form-group">
      <label for="type">Privacy</label>
      <input value="<?php if ($results['privacy']) echo $results['privacy']; else echo $_GET['privacy'];?>" class="form-control" type="text" name="privacy">
    </div>

    <div class="form-group">
      <label for="type">URL</label>
      <input value="<?php if ($results['url']) echo $results['url']; else echo $_GET['url'];?>" class="form-control" type="text" name="url">
    </div>

    <div class="form-group">
      <label for="tags">Reference ID</label>
      <input value="<?php if ($results['reference_id']) echo $results['reference_id']; else echo $_GET['reference_id'];?>" id="reference_id" class="form-control" type="text" name="reference_id">
    </div>

    <div class="form-group">
      <label for="tags">Reference Type</label>
      <input value="<?php if ($results['reference_type']) echo $results['reference_type']; else echo $_GET['reference_type'];?>" id="reference_type" class="form-control" type="text" name="reference_type">
    </div>

    <div class="form-group">
      <label for="title">Title</label>
      <input value="<?php if ($results['title']) echo $results['title']; else echo $_GET['title'];?>" class="form-control" type="text" name="title">
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea class="form-control" rows="20" name="content"><?php echo $results['content']; ?></textarea>
    </div>

    <input id="submit" type="submit" name="submit" value="Submit" class="pull-right btn btn-success">

    <?php echo $message; ?>
</form>
</div>
  </div>



    <script type="text/javascript">

    $(".row").css("height",$(window).height());

    $(document).ready(function() {
    })

    
    </script>


  </body>
</html>