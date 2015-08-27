<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/login.php");

if ($_GET['project']) {
  $query= "SELECT * FROM `project` WHERE title_url ='".mysqli_real_escape_string($link, $_GET['project'])."'";     
  $result = mysqli_query($link, $query);  
  $results = mysqli_fetch_array($result);
  $type="project";

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

  // Get updates from new_update table
  $updates = array();
  $query= "SELECT * FROM `new_update` WHERE reference_id =".$results['id']." AND `reference_type` = 'project' AND `hide`=0";     
  $result = mysqli_query($link, $query);
  while ($update = mysqli_fetch_array($result)){
    $updates[]=$update;
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

  background-image: url(/img/proj-min.jpg);
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
  margin-top: 80px;
  margin-bottom: 0px;
  padding-top: 30px;
}

.splash h1 {
  font-weight: bold;
  font-size: 2.5em;
  margin:0 0 20px 0;
}

.splash h4 {
  margin:0 0 20px 0;
  font-weight: bold;
}

.splash p {
  margin:0;
}


/* Content Styles */

#content {
  background: radial-gradient(circle, #FFFF00 40%, #FFA500);
  background-size: cover;
  padding: 20px 0px;
  margin:0;
}

.panel-heading {
  background-color: #F5F5F5 !important;
  color:#222222 !important;
  font-weight: bold;
}

#tagcloud {
  text-align: center;
}

#images .panel-body{
  padding:15px 0 0 15px;
  margin:0;
}

img {
  padding:0;
  margin:0;
}


#images ul {
  padding:0;
  margin:0;
}

#images ul li {
  padding:0 15px 15px 0;
  margin:0;
  list-style:none;
}

#images ul li img {
  padding:0;
  margin:0;
  cursor: pointer;
}




    </style>
    
</head>

<body>
    
<?php include($root."/header.html"); ?>

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
          <p>Created:</p>
          <h4><?php echo time_elapsed_string($results['date_created']); ?></h4>
        </div>
        <div class="col-xs-4">
          <p>Type:</p>
          <h4><?php echo $results['type']; ?></h4>
        </div>
        <div class="col-xs-4">
          <p>Updated:</p>
          <h4><?php if (!$results['date_updated']) echo "Never"; else echo time_elapsed_string($results['date_updated']); ?></h4>
        </div>
      </div>

    </div>
  </div>
</div>

<div id="content" class="row">
  
  <div class="container">

    <div class="col-md-2">

      <div class="panel panel-primary">

        <div class="panel-heading">Info</div>

        <div class="panel-body">

          <?php 
            if ($results['latest']!="") {
              echo "<a target='_blank' href='".$results['latest']."'>Latest Version </a><br/><br/>";
            }
          ?>

          <div class="progress">
            <div class="progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" <?php echo "style='text-align:center; width:".$results['progress']."'"; ?>>Progress
            </div>
          </div>

          <div class="progress">
            <div class="progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="50"
  aria-valuemin="0" aria-valuemax="100" <?php echo "style='text-align:center; width:".$results['priority']."'"; ?>>Priority
            </div>
          </div>

          <div id="tagcloud"></div>

          <?php 
            
            if ($_SESSION['id']==="jon") {
              echo "<a target='_blank' href='/updateform.php?reference_id=".$results['id']."&reference_type=project&title=".$results['title']."'><span class='glyphicon glyphicon-wrench'></span></a><a target='_blank' href='/project/projform.php?project=".$results['title_url']."'> <span class='glyphicon glyphicon-refresh'></span></a>";
            
            }
          ?>

        </div>
      </div>


      <div class="panel panel-primary" id="images">
        <div class="panel-body">
          
          <ul id="imageCloud">
          </ul>
          
        </div>  
      </div>

    </div>



    <div class="col-md-7">

      

      <div class="panel panel-primary">
        <div class="panel-heading">
          Background
          <a class="pull-right" href="12"><span class="glyphicon glyphicon-minus"></span></a>
        </div>
        <div class="panel-body"><?php echo $results['background']; ?></div> 
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading">
          Details
          <a class="pull-right" href="#"><span class="glyphicon glyphicon-minus"></span></a>
        </div>
        <div class="panel-body"><?php echo $results['details']; ?></div> 
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading">
          Instructions
          <a class="pull-right" href="#"><span class="glyphicon glyphicon-minus"></span></a>
        </div>
        <div class="panel-body"><?php echo $results['instructions']; ?></div> 
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading">
          To-Do
          <a class="pull-right" href="#"><span class="glyphicon glyphicon-minus"></span></a>
        </div>
        <div class="panel-body"><?php echo $results['todo']; ?></div> 
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading">
          Bugs / Issues
          <a class="pull-right" href="#"><span class="glyphicon glyphicon-minus"></span></a>
        </div>
        <div class="panel-body"><?php echo $results['bugs']; ?></div> 
      </div>

      <div id="updates" class="panel panel-primary">
        <div class="panel-heading">
          Updates
          <a class="pull-right" href="#"><span class="glyphicon glyphicon-minus"></span></a>
        </div>
        <div class="panel-body">
          <ul><?php foreach ($updates as $update) { echo "<li><strong>".$update['title']."</strong> (".time_elapsed_string($update['date']).")<p>".$update['content']."</p></li>";}?></ul>
        </div> 
      </div>
    </div>

    <div class="col-md-3">
      <?php include($root."/comment.html"); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php include($root."/contact.html"); ?>

<?php include($root."/foot.html"); ?>

<script type="text/javascript">
var backgroundPos;

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
  if ($("#updates .panel-body ul").text()=="") $("#updates").hide();

  getTags();
  getComments();
  getImages();

  // Get initial background position
  backgroundPos = $(".jumbo").css('backgroundPosition').split(" ");
  
})

// Show / hide panel body on icon click
$(".panel-heading a").click(function(event) {
  event.preventDefault();
  if ($(this).find("span").hasClass('glyphicon-minus')) {
    $(this).find("span").removeClass('glyphicon-minus');
    $(this).find("span").addClass('glyphicon-plus');
    $(this).parent().parent().find(".panel-body").hide();
  }
  else {
    $(this).find("span").removeClass('glyphicon-plus');
    $(this).find("span").addClass('glyphicon-minus');
    $(this).parent().parent().find(".panel-body").show();
  }
})


$("#commentBtn").click(function(event) {
  event.preventDefault();
  addComment();
})

/* //Parallax bitch
$(document).scroll(function() {
  console.log("initial:"+backgroundPos+" current:"+$(window).scrollTop()+"  "+backgroundPos[1]-$(window).scrollTop()+"%");

  $(".jumbo").css("background-position","0% "+(backgroundPos[1]-$(window).scrollTop())+"%");
  
});

*/

</script>


</body>
</html>