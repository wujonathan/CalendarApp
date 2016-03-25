<?php

header("Content-Type: application/json");

if(isset($_POST['submit'])){ 
		//Gets the required variables
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	$grouped=$_POST['grouped']
	$user_id=$_SESSION['user_id'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$hour=$_POST['hour'];
	$minute=$_POST['minute'];
	require 'database.php';
		//Inserts into database
	$stmt = $mysqli->prepare("INSERT INTO event (day, month, year, grouped, user_id, title, description, hour, minute) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('iiisissii',$day, $month, $year, $grouped, $user_id, $title, $description, $hour, $minute);
	$stmt->execute();
	$stmt->close();

	/*
	*
	*
	* ADD CODE TO CHECK IF THIS EVENT DAY IS ON THE CURRENT CALLENDER
	* IF TRUE, ADD THIS EVENT TO THE CORRECT DAY
	*
	*
	*/

}
?>