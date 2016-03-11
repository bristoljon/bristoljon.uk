<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/php/login.php");


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Log in first</title>

    <?php include($root."/html/head.html"); ?>


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

    </style>
    
</head>

<body>
    
<?php include($root."/html/header.html"); ?>

<div id="home" class="row jumbo">
  <div class="container">
    <div class="col-md-8 col-md-offset-2 splash">

      <div class="row">
        <div class="col-md-12 title">
          <h1>Private Area</h1>
          <h4>You need to register and/or log-in first</h4>
        </div>
      </div>

    </div>
  </div>
</div>



<?php include($root."/html/contact.html"); ?>
<?php include($root."/html/foot.html"); ?>



 <script src="/script.js"></script>

    <script type="text/javascript">

    $(window).load(function() {
      $("#contact").css("min-height",$(window).height()-310);
    })

    
    </script>


  </body>
</html>