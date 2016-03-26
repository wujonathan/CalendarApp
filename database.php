<?php
//This php script is required whenever we need to access the database

$mysqli = new mysqli('localhost', 'module5', 'module5', 'calendar'); 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>