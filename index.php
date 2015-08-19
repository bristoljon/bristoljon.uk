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
    <meta name="description" content="BRISTOLJON.UK - Software, Apps, Tools, Hardware, Hacking.. A place where ideas run wild like the marmalade of your mind.">
    
    <title>bristoljon.uk</title>

    <?php include($root."/head.html"); ?>

    <link href="/styles.css" rel="stylesheet" type="text/css">
   
  </head>

  <body data-spy="scroll" data-target="#navbar">
    
    <?php include("header.html"); ?>

    <div id="home" class="row jumbo">
      <div class="container">
      <div class="col-md-4 col-md-offset-4 splash">
        <h1><?php if ($message) {
                    echo $message;
                    $message="";
                  }
                  else echo 'BRISTOLJON.UK'; ?></h1>
      </div>
      <p id="photocred">Photo by <a href="https://www.flickr.com/photos/sagesolar/">@sage_solar</a> on Flickr</p>
      </div>
    </div>

    <div class="row recent">
      <a name="recent"></a>
      <div class="container" id="recent">

        
      </div>
    </div>

    <div id="about" class="row about">
      <a name="about"></a>
      <div class="container">
        <div class="col-md-4  col-md-offset-1 panel panel-primary">
          <div class="panel-body">
            <h4>About Me</h4>
            <p>I worked as a paramedic in London for 5 years until finally escaping (via Costa Rica) and making a fresh start doing what I really enjoy, hacking.</p>
            <p>When I say hacking I mean doing what all humans do and have done since our earliest ancestor picked up a sharp rock and started hitting things (and people) with it.. Exploring, building, solving problems, evolving ideas and tools etc.</p>
            <p>With so much technology available now there is infinite potential for getting creative and combining it all together to make new things.
            </p>
            <p>But for now I'm learning my basics (HTML/CSS, JS/JQuery, PHP, MySQL) and applying them to my own projects and this website.</p>
            <p>After that I just have to work out some way I can get paid to do this!</p>
            </p>
          </div>
        </div>
        <div class="col-md-4 col-md-offset-2  panel panel-primary">
          <div class="panel-body">
          <h4>About bristoljon.uk</h4>
           <p>The main purpose of this site is to provide a single location to put all the projects I’ve been working on. But it's also a playground to test my skills.</p>

            <p>I'm hoping it'll help me keep track of my various project ideas and hopefully progress them into actual things that people can use. Also I hope that sharing my thought processes might inspire conversation and collaboration leading to better ideas.</p>

            <p>For now I'm going to put everything in the 'projects' menu. Including all the mini-side-tangent projects I'm collecting on the way. Later I might organise things a bit more.</p>

            <p>So it's kind of part journal, part blog and part collaboration station. Please feel free to chip in and share your thoughts or links to relevant resources in the comments or contact me personally.</p>
          </div>
        </div>
      </div>
    </div>

<?php include($root."/email.html"); ?>

<div id="footer">
  <p>All contents © 2015 Jon Wyatt. All rights reserved.</p>
</div>

<?php include($root."/foot.html"); ?>

<script type="text/javascript">

$(window).load(function() {

  $(".jumbo").css("min-height",$(window).height());
  //set row heights to window height
  if ($(window).height()<400) {
    $(".row").css("min-height",$(window).height());
  }

  // Call scrollspy
  $("body").scrollspy({target: "#navbar"});

  <?php echo $openSignUpModal; ?>

  getUpdates();
});

function getUpdates () {
  $.ajax({
    url:"/updates.php",
    type:"POST",
    data: { get:"recent"},
    success:function(result) {

      // Convert JSON to array
      var update = JSON.parse(result);
      var date;

      for (i=0; i<update.length; i++) {

        date = Date.parseExact(update[i]['date'],"yyyy-MM-dd HH:mm:ss");

        if (update[i]['type']==="New Feature") {
          $("#recent").append("<div class='panel panel-primary update'><div class='panel-body'><i class='fa fa-star'></i> "+update[i]['type']+" : <a href='/project/"+update[i]['projURL']+"'>"+update[i]['projTitle']+"</a> <div class='pull-right'>"+timeSince(date)+"</div><h4><a href='"+update[i]['url']+"'>"+update[i]['title']+"</a></h4><p>"+update[i]['content']+"...</p></div></div>");
        }

        else if (update[i]['type']==="Code Tweak") {
          $("#recent").append("<div class='panel panel-primary update'><div class='panel-body'><i class='fa fa-code'></i> "+update[i]['type']+" : <a href='/project/"+update[i]['projURL']+"'>"+update[i]['projTitle']+"</a> <div class='pull-right'>"+timeSince(date)+"</div><h4><a href='"+update[i]['url']+"'>"+update[i]['title']+"</a></h4><p>"+update[i]['content']+"...</p></div></div>");
        }

        else if (update[i]['type']==="New Geek Blog Post") {
          $("#recent").append("<div class='panel panel-primary update'><div class='panel-body'><i class='fa fa-pencil'></i> "+update[i]['type']+": <div class='pull-right'>"+timeSince(date)+"</div><h4><a href='"+update[i]['url']+"'>"+update[i]['title']+"</a></h4><p>"+update[i]['content']+"...</p></div></div>");
        }

        else if (update[i]['type'].match(/New/g)) {
          $("#recent").append("<div class='panel panel-primary update'><div class='panel-body'><i class='fa fa-star'></i> "+update[i]['type']+": <div class='pull-right'>"+timeSince(date)+"</div><h4><a href='"+update[i]['url']+"'>"+update[i]['title']+"</a></h4><p>"+update[i]['content']+"...</p></div></div>");
        }

        else if (update[i]['type'].match(/Edited/g)) {
          $("#recent").append("<div class='panel panel-primary update'><div class='panel-body'><i class='fa fa-pencil'></i> "+update[i]['type']+": <a href='/project/"+update[i]['projURL']+"'>"+update[i]['projTitle']+"</a> <div class='pull-right'>"+timeSince(date)+"</div><h4><a href='"+update[i]['url']+"'>"+update[i]['title']+"</a></h4><p>"+update[i]['content']+"...</p></div></div>");
        }

        else {
          $("#recent").append("<div class='panel panel-primary update'><div class='panel-body'>"+update[i]['type']+": <div class='pull-right'>"+timeSince(date)+"</div><h4><a href='"+update[i]['url']+"'>"+update[i]['title']+"</a></h4><p>"+update[i]['content']+"...</p></div></div>");
        }
      }
    },

    error: function (jqXHR) {
      console.log("Get updates failed");
    }
  });
}

</script>
   

    

  </body>
</html>