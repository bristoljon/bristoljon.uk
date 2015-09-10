<?php

	if ($_POST["submit"]) {

		if ($_POST["style"]=="css2") {
			$stylesheet = '<link rel="stylesheet" type="text/css" href="styles2.css"></style>';
			$scriptsheet = '<script type="text/javascript" src="script2.js"></script>';
		}
		else if ($_POST["style"]=="css1") {
			$stylesheet = '<link rel="stylesheet" type="text/css" href="styles1.css"></style>';
			$scriptsheet = '<script type="text/javascript" src="script1.js"></script>';
		}
		else if ($_POST["style"]=="bs1") {
			$stylesheet = '	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
							<link rel="stylesheet" type="text/css" href="styles3.css"></style>';
			$scriptsheet = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
							<script type="text/javascript" src="script3.js"></script>';
		}
		
		else {
			$stylesheet = '<link rel="stylesheet" type="text/css" href="styles1.css"></style>';
			$scriptsheet = '<script type="text/javascript" src="script1.js"></script>';
		}
	}
	else {
		$stylesheet = '<link rel="stylesheet" type="text/css" href="styles1.css"></style>';
		$scriptsheet = '<script type="text/javascript" src="script1.js"></script>';
	}

?>


<!doctype html>
<html>

<head>
 	<title>bristoljon's place</title>
	<meta charset="utf-8" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
	
	<?php echo $stylesheet ?>

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

</head>

<body>

	<div id="container" class="container">

		<div id="topbar">

			<div class="fixedwidth">
				
				<ul class="navbuttons" id="projbuttons">

					<li><a href=#><img id="homeicon" src="img/home-icon.png"/></a></li>

					<li id="softwareBtn"><a href=#>Software</a>
						<ul class="dropdown" id="softwareList" >
							<li><a href=#>Urban Sports App</a></li>
		 					<li><a href=#>Internet Driver Database</a></li>
			 				<li><a href=#>iMedic App</a></li>
			 				<li><a href=#>Wifi Positioning System (WPS)</a></li>
			 				<li><a href="./touchtimer/index.html">Touch Timer</a></li>
			 				<li><a href=#>Sound Positioning System (SPS)</a></li>
						</ul>
					</li>

					<li id="hardwareBtn"><a href=#>Hardware</a>
						<ul class="dropdown" id="hardwareList">
							<li><a href=#>Timelapse Gadget</a></li>
			 				<li><a href=#>Digital Sundial</a></li>
			 				<li><a href=#>NO2 Dispenser</a></li>
			 				<li><a href=#>Table Tennis Ball Collecting Robot</a></li>
			 				<li><a href=#>Karting Telemetry Unit</a></li>
						</ul>
					</li>

					<li id="miscBtn"><a href=#>Miscellaneous</a>
						<ul class="dropdown" id="miscList">
 							<li id="css1"><a href=#>Quick release ballon knot</a></li>
 							<li id="css2"><a href=#>Reinventing the fork</a></li>
 						</ul>
					</li>
					
				</ul>

				
				<ul class="navbuttons" id="sitebuttons">
					<li id="aboutBtn"><a href=#>About</a></li>
					<li id="contactBtn"><a href=#>Contact</a></li>
				</ul>
				
			</div>
		</div>

		<div class="_break"></div>

		<div id="mainPage" class="fixedwidth">

			<div id="jumbotron" class="stylebox">

				<h1>BRISTOLJON.UK</h1>

	 			<h3>Welcome to my world, a place where ideas run wild like the marmalade of your mind..</h3>

	 		</div>

	 		
	 		<div id="welcomebox" class="stylebox">
	 				<h4>Welcome</h4>
	 				<p>The purpose of this site is to provide a single location to put all the projects I’ve been working on (cerebrally at least) in one place. And also ptovide a playground to test my coding skills</p>

	 				<p>I hope it'll help me keep track of my ideas and progress them beyond just ideas into actual things that people can use. And similarly I hope that sharing my thought processes, especially the really retarded ones, will entertain and potentially inspire conversation and collaboration leading to better ideas and inventions.</p>

<p>I refer to all of these ‘ideas’ as projects, although most of them have barely been developed outside of my head so far. And I’ve broadly categorised them as being either Hardware, Software or Miscelaneous.</p>

<p>So its kind of part blog, part journal and part collaboration station. Please feel free to chip in and share your thoughts or links to relevant resources in the comments, and/or e-mail me personally. Enjoy.</p>
			</div>
	 			

	 		<ul id="recentList">
	 			<li class="stylebox">
	 				<h4>iMedic - Paramedic App</h4>
	 				<p>I started working on this whilst I was finishing my paramedic training. Got some books on iOS coding and Objective-C and made pretty good progress but then I started working full time and it got neglected.</p>

<p>The original plan was to incorporate the latest JRCALC clinical guidelines into a easily navigable UI along with a few other useful features. The only other mobile JRCALC app was a really horrible cut and paste, html based interface but it was selling for $15 and getting good reviews...<span class="moreinfo"><a href="/imedic"> Read More</a></span></p>
	 			</li>
	 			<li class="stylebox">
	 				<h4>RDDB: Race Driver Data Base</h4>
	 				<p>The idea for this came about when I was trying to organise regular racing events for a group of mates. The plan was to do mixture of karting, sim racing and track day events. I wanted to make it more interesting by calculating individual ratings for each driver based on their performance against everyone else. Similar to the Elo system for rating chess players.</p>
<p>The Elo system is zero sum so the rating gains or losses in a match balance out. I applied the same system to a selection of results, see below (yes I did come out on top but this is not the only reason I was so keen to get this started).</p>
<p><a title="Google Docs MUDI Race Driver Spreadsheet" href="https://docs.google.com/spreadsheets/d/170fWBjFp63T28AzinCO5P8DCqYNbG_5X7JwJ8gEEAQU/edit?usp=sharing" target="_blank">https://docs.google.com/spreadsheets/d/170fWBjFp63T28AzinCO5P8DCqYNbG_5X7JwJ8gEEAQU/edit?usp=sharing</a></p>
<p>The cool thing about having a system like this is that it allows people that have never actually raced each other to compare their skills and also know who their competition is before the race starts. <span class="moreinfo"><a href="/imedic"> Read More</a></span></p>
	 			</li>
	 			<li class="stylebox">
	 				<h4>Style Changer</h4>
	 				<p>Enter stylesheet to use: (Choose from 'css1', 'css2' and, if your feeling brave, 'bs1'!)</p>
	 				<form method="post">
	 					<input type="text" name="style" placeholder="Style me baby"/>
	 					<input type="submit" name="submit"></button>
	 				</form>

	 			</li>
	 		</ul>
	 		
			
		</div>

	</div>

	<?php echo $scriptsheet ?>

</body>

</html>