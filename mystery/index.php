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

      .container-fluid {
        color:#111111;
        background: #000 url("pano.jpg") center center;
        background-size: cover;
        text-align: center;
      }

      .jumbotron { 
      }

      h1 {
        font-size: 3em;
        font-weight: bold;
        margin-top: 80px;
      }

     
      input {
        margin-top: 5px;
      }



      

    </style>


  </head>

<body>
  

    <div class="container-fluid">
      <row>
        <div class="col-md-4 col-md-offset-4">        
          <h1>Welcome</h1>
        <p>Enter your username and password below to get this party started..</p>    

        <form method="post">
          <div class="form-group">
            <input name="user" type="user" class="form-control" placeholder="Username">
            <input name="pass" type="password" class="form-control" placeholder="Password">
          </div>
          <input type="submit" name="submit" value="Log In" class="btn-lg btn-success">
        </form>
        <br/>

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
  </div>

  




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">
    console.log($(window).height());
     $(".container-fluid").css("height",$(window).height());



</script>

</body>