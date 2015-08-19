<?php

	session_start();

	require "../twitteroauth-master/autoload.php";

	use Abraham\TwitterOAuth\TwitterOAuth;

	//include("../twitteroauth-master/src/TwitterOAuth.php");

	$apikey="0h2JHtwACYDcBJXdzh1Sl3Twn";
	$apisecret="KsxoAYh1bHvErd6mtcKv1N2fXGjqaPtEvlIZuJCptLVr0ooXnu";
	$token="30726743-Ec4SBSUf7i5P7ivpZPbovF3lj6CqYBfhUd0iPpu4q";
	$tokensecret="HpMrVmxiGB76Cns3yk8VTSExms32LRJ8iIxaGcpSA2X4Q";

	$connection = new TwitterOAuth($apikey, $apisecret, $token, $tokensecret);

	$tweets = $connection->get("https://api.twitter.com/1/statuses/user_timeline/twitterapi.json");	

	print_r($tweets);
?>