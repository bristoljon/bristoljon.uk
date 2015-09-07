<?php
session_start();
include("link.php");

  $query="SELECT firstname FROM users WHERE name='".$_SESSION['id']."' LIMIT 1";
  
  $result = mysqli_query($link,$query);
  
  $row = mysqli_fetch_array($result);
  
  $loggedinUser=$row['firstname'];

?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mystery Party</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">

      .jumbotron {
        color:#111111;
        background: #000 url("pano.jpg") center center;
        width: 100%;
        background-size: cover;
        margin:0;
        text-align: center
      }

      .jumbotron h1 {
        margin-top:100px;
      }


      .row1 {
        color:black;
        background-color:lightgrey;
        width: 100%;
        height: 100%;
        
      }

    </style>


  </head>

<body>
  
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">?</a>
      </div>
    
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href=#><?php echo $_SESSION['id']; ?></a></li>
          <li><a href="index.php?logout=1">Logout</a></li>

        </ul>
      
      </div>
    </nav>
  </div>

  <div class="jumbotron">
    <div class="container">
    <h1>Hello <?php echo $loggedinUser; ?></h1>
    <p>You have been logged in..</p>
    </div>
  </div>

  




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">

     $(".jumbotron").css("height",$(window).height());



</script>

</body>