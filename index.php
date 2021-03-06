<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include ($root . "/php/login.php");
?>


<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BRISTOLJON.UK - A place where ideas run wild like the marmalade of your mind. Software, Apps, Tools, Hardware, Hacking.">
    
    <title>bristoljon.uk</title>

    <?php
		include ($root . "/html/head.html");
 	?>

    <link href="/css/homepage.css" rel="stylesheet" type="text/css">
   
  </head>

  <body>
    
<?php
include ($root . "/html/header.html");
 ?>

<?php
include ($root . "/html/signupmodal.html");
 ?>

    <div id="home" class="row jumbo">
      <div class="container">
      <div class="col-md-4 col-md-offset-4 splash">
        <h1><?php
		if ($message) {
			echo $message;
			$message = "";
		} else
			echo "BRISTOLJON.UK";
 ?></h1>
      </div>
      <p id="photocred">Photo by <a href="https://www.flickr.com/photos/sagesolar/">@sage_solar</a> on Flickr</p>
      </div>

    </div>

    <div id="recent" ng-controller="mainController" class="row recent">
      
      <div class="container" id="recents">

      	<div class='panel panel-primary update' ng-cloak class="ng-cloak" ng-repeat="update in updates">
      		<div class='panel-body'>
      			<i ng-if="update.type.indexOf('New') > -1" class='fa fa-star'></i>
      			<i ng-if="update.type.indexOf('Edited') > -1" class='fa fa-pencil'></i>
      			{{ update.type }} : <a ng-href="/project/{{ update.projURL }}"> {{ update.projTitle }} </a>
      			<div class="pull-right">{{ convertDate(update.date) }}</div>
      			<h4><a ng-href="{{ update.latest || update.url }}"> {{ update.title }}</a></h4>
      			
      			<p> {{ update.content }}</p>
      		</div>
        </div>
      </div>
    </div>

    <div id="about" class="row about">
      <div class="container">
        <div class="col-md-4  col-md-offset-1 panel panel-primary">
          <div class="panel-body">
            <h4>About Me</h4>
            <p>I worked as a paramedic in London for 5 years until finally escaping (via Costa Rica) and making a fresh start doing what I really enjoy.</p>
            <p>I started out doing an online web development course and applied what I learnt to this site and the various side projects along the way. Having projects to apply my learning to really helped and my knowledge (and this site) grew rapidly.</p>
            <p>After 3 months I applied for and got my first job as a developer working on an open source ward management <a href="http://github.com/neovahealth">application</a>. Alongside developing my coding skills I learnt a lot about the benefits of agile methodologies, test driven development, continuous delivery and tools like gulp, vagrant and git.</p>
            <p>Unfortunately despite the companies progressive approach, it recently went under so I'm back in the job market. On the plus side I can get back to all the projects I had on the backburner so it's not all bad!.</p>
            <p>Besides software, I enjoy reading, expanding my mind, partying, frisbee and kite flying among other things..</p>
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

<?php
include ($root . "/html/contact.html");
 ?>

<?php
include ($root . "/html/foot.html");
 ?>

<script src="http://code.angularjs.org/1.3.0-rc.1/angular.min.js"></script>



<script type="text/javascript">

		$(window).load(function() {

	$(".jumbo").css("min-height",$(window).height());

  	//set row heights to window height
	  if ($(window).height()<400) {
	    $(".row").css("min-height",$(window).height());
	  }
	
  <?php echo $openSignUpModal; ?>
	});

	var myApp = angular.module('myApp', []);

	myApp.controller('mainController', ['$scope', '$log', '$http', '$timeout',
	function($scope, $log, $http, $timeout) {

		$scope.convertDate = function(dater) {
			return timeSince(Date.parseExact(dater, "yyyy-MM-dd HH:mm:ss"));
		};

		$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

		$http.post('/php/updates.php', "get=recent").then(function(response) {
			$scope.updates = angular.fromJson(response.data);
		}, function(response) {
			$log.log("Failed");
		});

	}]);

</script>
   

    

  </body>
</html>