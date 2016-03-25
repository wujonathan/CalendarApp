<!--This php script is required whenever we need to access the database-->
<?php
$mysqli = new mysqli('localhost', 'module5', 'module5', 'calender');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>