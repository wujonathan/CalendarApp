<?php

header("Content-Type: application/json");
require 'database.php';
require 'user_agent_test.php';
//require 'csrf_detector.php';

$eventID=$mysqli->real_escape_string($_POST['eventID']);
$user_id=$_SESSION['user_id'];
$title=$mysqli->real_escape_string($_POST['title']);
$description=$mysqli->real_escape_string($_POST['description']);
echo($description);
$time=$mysqli->real_escape_string($_POST['time']);

$stmt = $mysqli->prepare("SELECT title, description, time FROM events WHERE id=?");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error						));
	exit;
}
$stmt->bind_param('i', $eventID);
$stmt->execute();
$stmt->bind_result($origTitle, $origDescription, $origTime);
$stmt->fetch();
$stmt->close();
if($title==""){
	$title=$origTitle;
}
if($description==""){
	$description=$origDescription;
}
if($time==""){
	$time=$origTime;
}

$stmt = $mysqli->prepare("UPDATE events SET description=?, title=?, time=? WHERE id=?");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error
		));
	exit;
}
$stmt->bind_param('sssi',$description, $title, $time, $eventID);
$stmt->execute();
$stmt->close();

echo json_encode(array(	     	        
	"success" => true
	));				
exit;

?>