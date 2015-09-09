<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/login.php");

if ($_GET['title']) {
  $type="blog";
  $query= "SELECT * FROM `blog` WHERE title_url ='".mysqli_real_escape_string($link, $_GET['title'])."'";     
  $result = mysqli_query($link, $query);  
  $results = mysqli_fetch_array($result);

  if ($results['title']=="") {
    header('Location: /notfound'); 
    exit;
  }

  // Redirect if project is private
  if ($results['privacy']==1 && !$_SESSION['id']) {
    $query = explode('=',$_SERVER['QUERY_STRING']);
    header('Location: /private/'.$query[1]);
    exit;
  }
}

else {
  header("Location: /notfound");
}


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo $results['title']; ?></title>

    <?php include($root."/head.html"); ?>

<style type="text/css">


/* Jumbo styles */
.jumbo {
  position:relative;
  margin:0;
  padding-top: 30px;
  height:310px;

  background-image: url(/img/pano-min.jpg);
  background-size: cover;
  background-position:center;
  background-repeat: no-repeat;
}

.splash {
  opacity: 0.5;
  font-family: 'Yanone Kaffeesatz', sans-serif;
  background-color:#222;
  text-align: center;
  border-radius: 5px;
  color:#ddd;
  margin-top: 90px;
  margin-bottom: 0px;
}

.title {
  padding-top: 20px;
}

.splash h1 {
  font-weight: bold;
  font-size: 2.3em;
  margin:0;
}

.splash h3 {
	font-size:1.5em;
}

/* Content Styles */
.btn-group {
  margin-bottom:20px;
}

#content {
  background: radial-gradient(circle, #FFFF00 40%, #FFA500);
  background-size: cover;
  padding: 20px 0px;
  margin:0;
}





    </style>
    
</head>

<body>
    
<?php include($root."/header.html"); ?>
<?php include($root."/signupmodal.html"); ?>

<div id="home" class="row jumbo">
  <div class="container">
    <div class="col-md-8 col-md-offset-2 splash">
      <div class="row">
        <div class="col-md-12 title">
          <h1><?php echo $results['title']; ?></h1>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-4">
          <h3><?php echo time_elapsed_string($results['date_created']); ?></h3>
        </div>
        <div class="col-xs-4">
          <h3><?php echo $results['type']; ?></h3>
        </div>
        <div class="col-xs-4">
          <h3><?php echo $results['issue']; ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="content" class="row">
  
    <div class="container">

      <div class="col-md-2">
        <div class="panel panel-info" id="tags">
          <div class="panel-heading">Tags</div>
          <div class="panel-body" id="tagcloud"></div>
        </div>
      </div>
      
      <div class="col-md-7">

        <div class="btn-group btn-group-justified" role="group" aria-label="...">
          <a role="button" id="nontech" class="btn btn-default" href="#">Non-technical</a>
          <a role="button" id="tech" class="btn btn-default" href="#">Technical</a>
          <a role="button" id="pain" class="btn btn-default active" href="#">Bring the pain!</a>
        </div>

        <div class="panel panel-info">
          <div class="panel-body"> 
            <?php echo $results['content']; ?>
          </div> 
        </div>

      </div>

      <div class="col-md-3">
        <?php include($root."/comment.html"); ?>
      </div>
    </div>
</div>

<?php include($root."/contact.html"); ?>  

<?php include($root."/foot.html"); ?>

<script type="text/javascript">

// Get MySQL / PHP vars
var results = {
  id:<?php echo $results['id']; ?>,
  title:<?php echo "'".$results['title']."'"; ?>,
  userid:<?php echo "'".$_SESSION['id']."'"; ?>,
  type:<?php echo "'".$type."'"; ?>
};

$(document).ready(function() {

  // Hide empty tabs
  var tabs = $(".panel-body");
  for (var i=0; i<tabs.length; i++) {
    if ($(tabs[i]).text()=="") {
      $(tabs[i]).parent().hide();
    }
  }
  getTags();
  getComments();
})

$("#commentBtn").click(function(event) {
  event.preventDefault();
  addComment();
})

// Technical detail level buttons
$("#nontech").click(function(event){
  event.preventDefault();
  if (!$(this).hasClass("active")) {
  	$("#tech").removeClass("active");
  	$("#pain").removeClass("active"); 
    $(".tech").hide();
    $(".pain").hide();
    $(this).addClass("active");
  }
  $(this).blur();
})

$("#tech").click(function(event){
  event.preventDefault();
  if (!$(this).hasClass("active")) {
    console.log("this notfound");
		$("#nontech").removeClass("active");
		$("#pain").removeClass("active"); 
		$(".pain").hide();
    $(".tech").show();
		$(this).addClass("active");
  }
  $(this).blur();
})

$("#pain").click(function(event){
  event.preventDefault();
  if (!$(this).hasClass("active")) {
    $("#nontech").removeClass("active");
    $("#tech").removeClass("active"); 
    $(".pain").show();
    $(".tech").show();
    $(this).addClass("active");
  }
  $(this).blur();
})




</script>


</body>
</html>