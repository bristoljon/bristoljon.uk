<?php
include("login.php");
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


        <form class="navbar-form navbar-right" role="login" method="post">
          <div class="form-group">
            <input name="user" type="user" class="form-control" placeholder="Username">
            <input name="pass" type="password" class="form-control" placeholder="Password">
          </div>
          <input type="submit" name="submit" value="Log In" class="btn btn-default">
        </form>
      
    </div>
    </nav>
  </div>

  <div class="jumbotron">
    <div class="container">
    <h1>Congratulations</h1>
    <p>Enter your username and password above to get this party started..</p>
     <form role="signup" method="post">
          <div class="form-group">
            <input name="newUser" type="text" class="form-control" placeholder="Username">
            <input name="newPass" type="password" class="form-control" placeholder="Password">
            <input name="newName" type="text" class="form-control" placeholder="Your Name">
          </div>
          <input type="submit" name="submit" value="Sign Up" class="btn btn-default">
        </form>
      <?php
        if ($error) {
          echo "<div class='alert alert-danger'>".$error."</div>";
        }
        
        if ($message) {
           echo "<div class='alert alert-danger'>".$message."</div>";
        }
       ?>
    </div>
  </div>

  




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">
    console.log($(window).height());
     $(".jumbotron").css("height",$(window).height());



</script>

</body>