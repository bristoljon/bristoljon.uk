<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/login.php");

if ($_SESSION['id']!="jon") {
  header('Location: /private.php');
}

function tagsToArray ($tagString, $link, $blog_id) {

  $tagArray = explode(',',$tagString);

  foreach ($tagArray as $tag) {

    // Check whether string exists in tag table
    $query = "SELECT * FROM `tag` WHERE `name` ='".mysqli_real_escape_string($link,$tag)."'";
    $result = mysqli_query($link, $query);

    if ($result) {

      // If not insert that shit
      if ($result->num_rows === 0) {
        $query = "INSERT INTO `tag` (`id`,`name`) VALUES (NULL,'".mysqli_real_escape_string($link,$tag)."')";
        mysqli_query($link, $query);

        // Get id of tag inserted for inclusion in project_tag insertion
        $tag_id = $link->insert_id;
      }

      // Get tag id of existing record
      else {
        $results = mysqli_fetch_array($result);
        $tag_id=$results['id'];
      }

      // Then add record in project_tag table
      $query = "INSERT INTO `blog_tag` (`blog_id`,`tag_id`) VALUES ('".$blog_id."','".$tag_id."')";
      mysqli_query($link, $query);

    }
  }
}


if ($_SESSION['id'] && $_GET['blog']) {
  $query= "SELECT * FROM `blog` WHERE title_url ='".mysqli_real_escape_string($link, $_GET['blog'])."'";     
  $result = mysqli_query($link, $query);  
  $results = mysqli_fetch_array($result);
}

// Submit new blog (no id entered)
if ($_POST['submit']=="Submit" && $_POST['id']=="") {

  if (!$_POST['title']) $error.="<br />Please enter a title";
  if (!$_POST['title_url']) $error.="<br />Please enter a URL";
  if (!$_POST['type']) $error .="<br />Please enter a type";
  if (!$_POST['content']) $error .="<br />Please enter some content";
  
  if (!$error) {

    $query = "INSERT INTO `blog` (`id`,`privacy`,`title`,`title_url`,`type`,`issue`,`content`) 
              VALUES (NULL, ".
                $_POST['privacy'].
                ",'".
                mysqli_real_escape_string($link, $_POST['title']).
                "','".
                mysqli_real_escape_string($link, $_POST['title_url']).
                "','".
                mysqli_real_escape_string($link, $_POST['type']).
                "','".
                mysqli_real_escape_string($link, $_POST['issue']).
                "','".
                mysqli_real_escape_string($link, $_POST['content']).
                "')";

      mysqli_query($link, $query) or die(mysqli_error($link));

      $blog_id = $link->insert_id;
     
      $message.=$_POST['title']." submitted<br/>";

      tagsToArray($_POST['tags'],$link, $blog_id);

      // Enter update into new_update table
      if ($_POST['update']) {
        $query = "INSERT INTO `new_update` (`id`,`title`,`content`,`type`,`reference_type`,`reference_id`,`privacy`,`url`) 
              VALUES (NULL, '".
                mysqli_real_escape_string($link, $_POST['title']).
                "','".
                mysqli_real_escape_string($link, substr(strip_tags($_POST['content']),0,300)).
                "','New ".mysqli_real_escape_string($link, $_POST['type'])." Post',
                'blog',".
                $blog_id.
                ",".$_POST['privacy'].
                ",'/blog/".mysqli_real_escape_string($link, $_POST['title_url']).
                "')";

        mysqli_query($link, $query) or die(mysqli_error($link));
      }

      header("Location: /blog/".$_POST['title_url']);
  }  
  else {
    $error = '<div style = "margin:5px" class="alert alert-danger">There were error(s) in your submission:'.$error.'</div>';
  }
}

// Edit existing blog (id entered)
if ($_POST['submit']=="Submit" && $_POST['id']!="") {

   $query = "UPDATE `blog` SET 
      `title`='".mysqli_real_escape_string($link, $_POST['title'])."',
      `privacy`=".$_POST['privacy'].",
      `title_url`='".mysqli_real_escape_string($link, $_POST['title_url'])."',
      `type`='".mysqli_real_escape_string($link, $_POST['type'])."',
      `content`='".mysqli_real_escape_string($link, $_POST['content'])."',
      `issue`='".mysqli_real_escape_string($link, $_POST['issue'])."',
      `date_updated`= now() WHERE `id`='".$_POST['id']."' LIMIT 1";

      if(!mysqli_query($link, $query)){
        $message.=("Error: ".mysqli_error($link));
      }
      else {
        tagsToArray($_POST['tags'],$link, $_POST['id']);

        // Enter update into new_update table
        if ($_POST['update']) {
          $query = "INSERT INTO `new_update` (`id`,`title`,`content`,`type`,`reference_type`,`reference_id`,`privacy`,`url`) 
                VALUES (NULL, '".
                  mysqli_real_escape_string($link, $_POST['title']).
                  "','".
                  mysqli_real_escape_string($link, substr(strip_tags($_POST['content']),0,300)).
                  "','Edited ".mysqli_real_escape_string($link, $_POST['type'])." Post',
                  'blog',".
                  $_POST['id'].
                  ",".$_POST['privacy'].
                  ",'/blog/".mysqli_real_escape_string($link, $_POST['title_url']).
                  "')";

          mysqli_query($link, $query) or die(mysqli_error($link));
        }

        header("Location: /blog/".$_POST['title_url']);
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
    
    <title>New Blog</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <link href="/html/header.css" rel="stylesheet" type="text/css">


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
      <input value="<?php echo $results['id']; ?>" class="form-control" type="text" name="id">
    </div>

    <div class="form-group">
      <label for="privacy">Privacy</label>
      <input value="<?php echo $results['privacy']; ?>" class="form-control" type="text" name="privacy">
    </div>

    <div class="form-group">
      <label for="title">Title</label>
      <input value="<?php echo $results['title']; ?>" class="form-control" type="text" name="title">
    </div>

    <div class="form-group">
      <label for="title_url">URL Title</label>
      <input value="<?php echo $results['title_url']; ?>" class="form-control" type="text" name="title_url">
    </div>
	
    <div class="form-group">
      <label for="issue">Issue</label>
      <input value="<?php echo $results['issue']; ?>" class="form-control" type="text" name="issue">
    </div>

    <div class="form-group">
      <label for="type">Type</label>
      <input value="<?php echo $results['type']; ?>" class="form-control" type="text" name="type">
    </div>

    <div class="form-group">
      <label for="tags">Tags</label>
      <input id="tags" class="form-control" type="text" name="tags">
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea class="form-control" rows="20" name="content"><?php echo $results['content']; ?></textarea>
    </div>

    <input class="pull-left" type="checkbox" class="form-control" name="update">Generate Update
    

    <input id="submit" type="submit" name="submit" value="Submit" class="pull-right btn btn-success">

    <?php echo $message; ?>
</form>
</div>
  </div>



    <script type="text/javascript">

    $(".row").css("height",$(window).height());

    $(document).ready(function() {
      getTags();
    })

    function getTags(){
      $.ajax({
        url:"/php/tagger.php",
        type:"POST",
        data: { reference:<?php if ($results['id']) echo $results['id']; else echo 0; ?>,
                type:"blog"},
        success:function(result) {
          var tags = JSON.parse(result);
          var tagString ="";

          for (var i=0; i<tags.length; i++){
            tagString+=tags[i]['name']+",";
          }
          tagString = tagString.substring(0,tagString.length-1);
          $("#tags").val(tagString);
        },
        error: function (jqXHR) {
          console.log("there were a error, bruva");
        }
      });
    }
    </script>


  </body>
</html>