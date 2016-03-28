<?php

header("Content-Type: application/json");
require 'database.php';
require 'user_agent_test.php';
//require 'csrf_detector.php';

$eventID=$mysqli->real_escape_string($_POST['eventID']);

$stmt = $mysqli->prepare("DELETE FROM events WHERE id=?");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error
		));
	exit;
}
$stmt->bind_param('i',$eventID);
$stmt->execute();
$stmt->close();

echo json_encode(array(	     	        
	"success" => true
	));				
exit;

?>