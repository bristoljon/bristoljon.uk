<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/login.php");


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Not Found</title>

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





/* E-mail contact form styles */
.contact {
  background: radial-gradient(circle, #6bd7ff 50%, #77ffe3);
  margin:0;
  background-size: cover;
  font-size:1.2em;
  padding:50px 0;
  text-align: center;
}

.input-group {
  margin-bottom:20px;
  min-width: 100%;
}

.form-control {
  width:100%;
}

textarea {
  min-height:400px;
}

.input-group-addon {
    min-width:70px;
    text-align:left;
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
          <h1>Page Not Found</h1>
          <h4>Check the name and try again</h4>
        </div>
      </div>

    </div>
  </div>
</div>



    
<div id="contact" class="row contact">
    <a name="contact"></a>
      <div class="container">
        <div class="col-md-6 col-md-offset-3">

          <h1>Get in touch</h1>
          <p>And I'll pretend I care</p>

        <form method="post">
          <div class="form-group">        
            <div class="input-group">
              <span class="input-group-addon">Name </span>
              <input id="name" type="text" class="form-control"/>
            </div>

            <div class="input-group">
              <span class="input-group-addon">Email </span>
              <input  id="email" type="email" class="form-control"/>
            </div>

            <div class="input-group">
              <span class="input-group-addon">Subject </span>
              <input id="subject" type="text" class="form-control"/>
            </div>

            <div class="input-group">
              <textarea id="textarea" class="form-control"></textarea>
            </div>

            <input id="send" value="Send" type="submit" class="btn-success btn-lg"></button>
          </div>
        </form>

        <div id="result"></div>  
      </div>
    </div>
</div>




 <script src="/script.js"></script>

    <script type="text/javascript">

      

    
    </script>


  </body>
</html>