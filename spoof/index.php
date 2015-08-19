<?php

if ($_POST["send"]) {

	if ($_POST["emailFrom"] AND $_POST["fromName"] AND $_POST["emailTo"] AND $_POST["subject"] AND $_POST["body"]) {

		$emailTo=$_POST["emailTo"];
		$subject=$_POST["subject"];
		$body=$_POST["body"];
		$fromName=$_POST["fromName"];
		$fromEmail=$_POST["emailFrom"];

		$headers ="From: $fromName <$fromEmail>";

		if (mail($emailTo,$subject,$body,$headers)) {


			$result = '<div class="alert alert-success">Great success. e-mail sent to '.$emailTo.'</div>';

			$file = "log.txt";
			$log = "To: $emailTo\nFrom: $fromName $fromEmail\nSubject: $subject\nBody: $body\n";

			if ($_SERVER['REMOTE_ADDR']) {
				$log .= $_SERVER['REMOTE_ADDR']."\n\n";
			};

			file_put_contents($file, $log, FILE_APPEND);

			mail("j.j.wyatt@hotmail.com","New spoof sent",$log,"From: Spoofer <spoofer@bristoljon.uk>");
		}
		else {

			$result= '<div class="alert alert-danger">Not sent. Computer says no.</div>';
		}
	}

	else {
		$result= "<div class='alert alert-danger'>You didn't fill out all the fields, you knob-jockey!</div>";
	}
}
?>


<!doctype html>
<html>
<head>
    <title>Spoofer</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

	
    <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


    <style type="text/css">
    	.container {
    		margin-top:12px;
    	}
    	.input-group {
    		margin-bottom: 5px;
    	}

    	h1 {
    		text-align: center;
    		margin:0;
    	}

    	h3 {
    		margin:0 0 10px 0;
    		text-align: center;
    	}

    	.input-group-addon {
    		min-width:80px;
    		text-align:left;
		}

		textarea {
			min-height: 150px;
		}

		.btn {
			margin-top:10px;
			position:relative;
			float:right;
		}

		
    	

    </style>

</head>

<body>
	<div class="container">

		<h1>E-mail Spoofer</h1>
		<h3>With great power comes great responsibility..</h3>

		<?php echo $result; ?>

		<form method="post">
			<div class="form-group">				

				<div class="input-group">
					<span class="input-group-addon">From</span>
					<input value="<?php echo $_POST['fromName']; ?>" type="text" class="form-control" name="fromName" placeholder="Sender's name"/>
				</div>

				<div class="input-group">
					<span class="input-group-addon">From @</span>
					<input  value="<?php echo $_POST['emailFrom']; ?>" type="email" class="form-control" name="emailFrom" placeholder="Sender's e-mail address"/>
				</div>

				<div class="input-group">
					<span class="input-group-addon">To @</span>
					<input  value="<?php echo $_POST['emailTo']; ?>" type="email" class="form-control" name="emailTo" placeholder="Target's email address"/>
				</div>
				
				<div class="input-group">
					<span class="input-group-addon">Subject</span>
					<input  value="<?php echo $_POST['subject']; ?>" type="text" class="form-control" name="subject" />
				</div>

				<div class="input-group">
					<span class="input-group-addon">Content</span>
					<textarea  id="textarea" class="form-control" name="body"></textarea>
				</div>

				<input type="submit" name="send" class="btn btn-success btn-lg"></button>
			</div>
		</form>

	</div>

<script type="text/javascript">
	
	$("#textarea").val("<?php echo $_POST['body']; ?>");

</script>




	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->




 

</body>
</html>
