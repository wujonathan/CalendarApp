<?php
header("Content-Type: application/json");

session_start();
require 'database.php';
$user_id=$_SESSION['user_id'];

$shared_id;
$users_array=array($user_id);
$stmt = $mysqli->prepare("SELECT sharer_id FROM shared_users WHERE user_id=?");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error						));
	exit;
}
$stmt->bind_param('s', $shared_id);
$stmt->execute();
$stmt->bind_result($sharer_id);
while($stmt->fetch()){
	array_push($users_array,  htmlspecialchars($shared_id));
}
$stmt->close();
$events_array=array();
for($i=0;$i<sizeof($users_array);$i++){
	$stmt = $mysqli->prepare("SELECT title, description, time, FROM events WHERE user_id=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => $mysqli->error						));
		exit;
	}
	$stmt->bind_param('s', $users_array[$i]);
	$stmt->execute();
	$stmt->bind_result($curTitle, $curDescription, $curTime);
	while($stmt->fetch()){
		array_push($events_array,  htmlspecialchars($curTitle), htmlspecialchars($curDescription), htmlspecialchars($curTime));
	}
	$stmt->close();
}
echo json_encode($events_array);

?>