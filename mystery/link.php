<?php
$link = new MySQLi("10.16.16.2","jon-o10","VmtNMW6/z","jon-o10");
if ($link->connect_error) {
	$status = "Link failed";
}
else {
	$status ="Link connected";
}
?>