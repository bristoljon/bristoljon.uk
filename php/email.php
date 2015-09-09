<?php
if ($_POST['send']) {

  if ($_POST["name"] AND $_POST["email"] AND $_POST["subject"] AND $_POST["message"]) {

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

      $emailTo="jon@bristoljon.uk";
      $subject="bristoljon.uk - ".$_POST["subject"];
      $fromName=$_POST["name"];
      $fromEmail=$_POST["email"];     
      $log = "From: ".$fromName." ".$fromEmail."\r\nSubject: ".$subject."\r\n";
      

      $headers ="From: ".$fromName." <message@bristoljon.uk>"."\r\n"."Reply-To:".$fromName." <".$fromEmail.">\r\n";

      if ($_SERVER['REMOTE_ADDR']) {
          $log .= $_SERVER['REMOTE_ADDR']."\r\n";
        };
      if ($_SERVER['REMOTE_HOST']) {
        $log .= $_SERVER['REMOTE_HOST']."\r\n";
      };
      if ($_SERVER['REMOTE_PORT']) {
        $log .= $_SERVER['REMOTE_PORT']."\r\n";
      };
      if ($_SERVER['HTTP_USER_AGENT']) {
        $log .= $_SERVER['HTTP_USER_AGENT']."\r\n";
      };
      if ($_SERVER['REFERER']) {
        $log .= $_SERVER['REFERER']."\r\n";
      };

      $body=$log.wordwrap($_POST["message"],70,"\r\n");
 
      if (mail($emailTo,$subject,$body,$headers)) {

        $result = '<div class="alert alert-success">Great success. e-mail sent!</div>';

        $file = "/log/log.txt";
        
        file_put_contents($file, $log, FILE_APPEND);
      }
      else {

        $result= '<div class="alert alert-danger">Computer says no. Not sent.</div>';
      }
    }
    else {
      $result ="<div class='alert alert-danger'>That ain't no e-mail I ever heard of</div>";
    }
  }
  else {
    $result ="<div class='alert alert-danger'>You didn't fill out all the fields you knob-jockey</div>";
  }
}
echo $result;
?>