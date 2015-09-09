<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/login.php");

if (!$_SESSION['id']) {
  header('Location: /private.php');
}

function tagsToArray ($tagString, $link, $project_id) {

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
      $query = "INSERT INTO `project_tag` (`project_id`,`tag_id`) VALUES ('".$project_id."','".$tag_id."')";
      mysqli_query($link, $query);

    }
  }
}


if ($_SESSION['id'] && $_GET['project']) {
  $query= "SELECT * FROM `project` WHERE title_url ='".mysqli_real_escape_string($link, $_GET['project'])."'";     
  $result = mysqli_query($link, $query);  
  $results = mysqli_fetch_array($result);
}

// New project submission (no id entered)
if ($_POST['submit']=="Submit" && $_POST['id']=="") {

  if (!$_POST['title']) $error.="<br />Please enter a title";
  if (!$_POST['title_url']) $error.="<br />Please enter a URL";
  if (!$_POST['type']) $error .="<br />Please enter a type";
  if (!$_POST['background']) $error .="<br />Please enter some content";
  
  if (!$error) {
    $query = "INSERT INTO `project` (`id`,`title`,`title_url`,`latest`,`type`,`date_created`,`date_updated`,`progress`,`background`,`instructions`,`bugs`,`details`,`todo`,`privacy`) 
              VALUES (NULL, '".
                mysqli_real_escape_string($link, $_POST['title']).
                "','".
                mysqli_real_escape_string($link, $_POST['title_url']).
                "','".
                mysqli_real_escape_string($link, $_POST['latest']).
                "','".
                mysqli_real_escape_string($link, $_POST['type']).
                "',NULL, NULL,'".
                mysqli_real_escape_string($link, $_POST['progress']).
                "','".
                mysqli_real_escape_string($link, $_POST['background']).
                "','".
                mysqli_real_escape_string($link, $_POST['instructions']).
                "','".
                mysqli_real_escape_string($link, $_POST['bugs']).
                "','".
                mysqli_real_escape_string($link, $_POST['details']).
                "','".
                mysqli_real_escape_string($link, $_POST['todo']).
                "',".
                $_POST['privacy'].")";

      mysqli_query($link, $query) or die(mysqli_error($link));

      $project_id = $link->insert_id;

      tagsToArray($_POST['tags'],$link, $project_id);

      // Enter update into new_update table
      if ($_POST['update']) {
        $query = "INSERT INTO `new_update` (`id`,`title`,`content`,`type`,`reference_type`,`reference_id`,`hide`,`privacy`,`url`) 
              VALUES (NULL, '".
                mysqli_real_escape_string($link, $_POST['title']).
                "','".
                mysqli_real_escape_string($link, substr(strip_tags($_POST['background']),0,300)).
                "','New ".mysqli_real_escape_string($link, $_POST['type'])." Project',
                'project',".
                $project_id.
                ",1,".
                $_POST['privacy'].
                ",'/project/".mysqli_real_escape_string($link, $_POST['title_url']).
                "')"; 

        mysqli_query($link, $query) or die(mysqli_error($link));
      }
  }

  else {
    $error.= '<div style = "margin:5px" class="alert alert-danger">There were error(s) in your submission:'.$error.'</div>';
  }
}

// Edit existing project (id entered)
if ($_POST['submit']=="Submit" && $_POST['id']!="") {
   $query = "UPDATE `project` SET 
      `title`='".mysqli_real_escape_string($link, $_POST['title'])."',
      `title_url`='".mysqli_real_escape_string($link, $_POST['title_url'])."',
      `type`='".mysqli_real_escape_string($link, $_POST['type'])."',
      `latest`='".mysqli_real_escape_string($link, $_POST['latest'])."',
      `progress`='".mysqli_real_escape_string($link, $_POST['progress'])."',
      `background`='".mysqli_real_escape_string($link, $_POST['background'])."',
      `instructions`='".mysqli_real_escape_string($link, $_POST['instructions'])."',
      `bugs`='".mysqli_real_escape_string($link, $_POST['bugs'])."',
      `details`='".mysqli_real_escape_string($link, $_POST['details'])."',
      `todo`='".mysqli_real_escape_string($link, $_POST['todo'])."',
      `privacy`=".$_POST['privacy'].",
      `date_updated`= now() WHERE `id`='".$_POST['id']."' LIMIT 1";

      mysqli_query($link, $query) or die(mysqli_error($link));

      tagsToArray($_POST['tags'],$link, $_POST['id']);

      // Enter update into new_update table
      if ($_POST['update']) {
        $query = "INSERT INTO `new_update` (`id`,`title`,`content`,`type`,`reference_type`,`reference_id`,`privacy`,`url`) 
              VALUES (NULL, '".
                mysqli_real_escape_string($link, $_POST['update_title']).
                "','".
                mysqli_real_escape_string($link, substr($_POST['content'],0,300)).
                "','Edited ".mysqli_real_escape_string($link, $_POST['type'])." Project',
                'project',".
                $_POST['id'].
                ",".$_POST['privacy'].
                ",'/project/".mysqli_real_escape_string($link, $_POST['title_url']).
                "')";

        mysqli_query($link, $query) or die(mysqli_error($link));
      }
}

// Upload image if present
if ($_POST['imageTitle']) {

  //Process the image that is uploaded by the user



$target_dir = $root."/uploads/";
$target_file = $target_dir.basename($_FILES["imageUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
    if($check !== false) {
        $message .= "<br/>"."File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $message .= "<br/>"."File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $message .= "<br/>"."Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["imageUpload"]["size"] > 500000) {
    $message .= "<br/>"."Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $message .= "<br/>"."Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $message .= "<br/>"."Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
        $message .= "<br/>"."The file ". basename( $_FILES["imageUpload"]["name"]). " has been uploaded.";
    } else {
        $message .= "<br/>"."Sorry, there was an error uploading your file.";
    }
}

  //Add image to database
  $query= "INSERT INTO `image` (`id`,`title`,`description`,`url`) 
            VALUES (NULL,'".
              mysqli_real_escape_string($link,$_POST['imageTitle']).
              "','".
              mysqli_real_escape_string($link,$_POST['imageDescription']).
              "','/uploads/".
              $_FILES["imageUpload"]["name"]."')";

  mysqli_query($link,$query) or die(mysqli_error($link));

  // Associate image with this project
  $image_id = $link->insert_id;
  $project_id = $_POST['id'];

  $query= "INSERT INTO `project_image` (`project_id`,`image_id`) 
            VALUES ('".$project_id."','".$image_id."')";

  mysqli_query($link,$query) or die(mysqli_error($link));
}

if ($_POST['title_url']) {
  header("Location: /project/".$_POST['title_url']);
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>New Project</title>

    <?php include($root."/html/head.html"); ?>


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

  <form id="blogform" method="post" enctype="multipart/form-data">

    <input type="file" name="imageUpload" id="imageUpload">

    <div class="form-group">
      <label for="imageDescription">Image Description</label>
      <input class="form-control" type="text" name="imageDescription">
    </div>

    <div class="form-group">
      <label for="imageTitle">Image Title</label>
      <input class="form-control" type="text" name="imageTitle">
    </div>

    <br/>

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
      <label for="tags">Tags</label>
      <input id="tags" class="form-control" type="text" name="tags">
    </div>

    <div class="form-group">
      <label for="tags">Latest</label>
      <input value="<?php echo $results['latest']; ?>" class="form-control" type="text" name="latest">
    </div>

    <div class="form-group">
      <label for="type">Type</label>
      <input value="<?php echo $results['type'];  ?>" class="form-control" type="text" name="type">
    </div>

    <div class="form-group">
      <label for="tags">Progress</label>
      <input value="<?php echo $results['progress']; ?>" class="form-control" type="text" name="progress">
    </div>

    <div class="form-group">
      <label for="background">Background</label>
      <textarea class="form-control" rows="20" name="background"><?php echo $results['background']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="details">Details</label>
      <textarea class="form-control" rows="20" name="details"><?php echo $results['details']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="instructions">Instructions</label>
      <textarea class="form-control" rows="20" name="instructions"><?php echo $results['instructions']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="todo">Todo</label>
      <textarea class="form-control" rows="20" name="todo"><?php echo $results['todo']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="content">Bugs</label>
      <textarea class="form-control" rows="20" name="bugs"><?php echo $results['bugs']; ?></textarea>
    </div>


    <input class="pull-left" type="checkbox" class="form-control" name="update">Generate Update
    
    <div class="form-group">
      <label for="update_title">Update Title</label>
      <input class="form-control" type="text" name="update_title">
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea class="form-control" rows="20" name="content"></textarea>
    </div> 

    <input id="submit" type="submit" name="submit" value="Submit" class="pull-right btn btn-success">

    <?php if ($error) echo $error; else if ($message) echo $message; ?>
</form>
</div>
  </div>





 <script src="/script.js"></script>

    <script type="text/javascript">

    $(".row").css("height",$(window).height());


    $(document).ready(function() {
      getTags();
    })

    function getTags(){
      $.ajax({
        url:"/tagger.php",
        type:"POST",
        data: { reference:<?php if ($results['id']) echo $results['id']; else echo 0; ?>,
                type:"project"},
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
          console.log("Get tags failed");
        }
      });
    }

    </script>


  </body>
</html>