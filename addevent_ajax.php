<?php

header("Content-Type: application/json");
session_start();
require 'database.php';
require 'user_agent_test.php';

$date=$mysqli->real_escape_string($_POST['date']);
$month=$mysqli->real_escape_string(substr($date, 0,7));
$day=$mysqli->real_escape_string(substr($date, 8,10));
$host="yes";
$group=$mysqli->real_escape_string($_POST['groups']);
$user_id=$_SESSION['user_id'];
$title=$mysqli->real_escape_string($_POST['title']);
$description=$mysqli->real_escape_string($_POST['description']);
$time=$mysqli->real_escape_string($_POST['time']);

		//Inserts into database
$stmt = $mysqli->prepare("INSERT INTO events (month, host, userid, title, description, time, day) VALUES (?, ?, ?, ?, ?, ?, ?)");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error
		));
	exit;
}
$stmt->bind_param('ssissss',$month, $host, $user_id, $title, $description, $time, $day);
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("SELECT last_insert_id() FROM events");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error						));
	exit;
}
$stmt->execute();
$stmt->bind_result($event_id);
$stmt->fetch();
$stmt->close();
$groups = explode(", ", $group);
$host="no";
for($i=0; $i<sizeof($groups) ;$i++){
	$curU=$groups[$i];				
	$stmt = $mysqli->prepare("SELECT id FROM registered_users WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => $mysqli->error						));
		exit;
	}
	$stmt->bind_param('s', $curU);
	$stmt->execute();
	$stmt->bind_result($curUser_id);
	$stmt->fetch();
	$stmt->close();
	if($curUser_id!=null){
		$stmt = $mysqli->prepare("INSERT INTO events (month, host, userid, title, description, time, day) VALUES (?, ?, ?, ?, ?, ?, ?)");
		if(!$stmt){
			echo json_encode(array(
				"success" => false,
				"message" => $mysqli->error
				));
			exit;
		}
		$stmt->bind_param('ssissss',$month, $host, $curUser_id, $title, $description, $time, $day);
		$stmt->execute();
		$stmt->close();
	}
}

echo json_encode(array(	     	        
	"success" => true
	));				
exit;

?>