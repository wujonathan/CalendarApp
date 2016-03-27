<?php
header("Content-Type: application/json");

session_start();
require 'database.php';
require 'user_agent_test.php';

$user_id=$mysqli->real_escape_string($_SESSION['user_id']);
$queryMonth=$mysqli->real_escape_string($_POST["queryMonth"]);

$shared_id;
$users_array=array($user_id);
$stmt = $mysqli->prepare("SELECT sharer_id FROM shared_users WHERE user_id=?");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error						));
	exit;
}
$stmt->bind_param('s', $user_id);
$stmt->execute();
$stmt->bind_result($shared_id);
while($stmt->fetch()){
	array_push($users_array,  htmlspecialchars($shared_id));
}

$stmt->close();
$events_array=array();
for($i=0;$i<sizeof($users_array);$i++){
	$stmt = $mysqli->prepare("SELECT username FROM registered_users WHERE id=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => $mysqli->error						));
		exit;
	}
	$stmt->bind_param('s', $users_array[$i]);
	$stmt->execute();
	$stmt->bind_result($ownerName);
	$stmt->fetch();
	$stmt->close();
	
	$stmt = $mysqli->prepare("SELECT title, description, day, time, host FROM events WHERE userid=? AND month=? ORDER BY day ASC");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => $mysqli->error						));
		exit;
	}
	$stmt->bind_param('ss', $users_array[$i], $queryMonth);
	$stmt->execute();
	$stmt->bind_result($curTitle, $curDescription, $curDay, $curTime, $curHost);
	while($stmt->fetch()){

		$status =  array( "title" => htmlspecialchars($curTitle), "desc" => htmlspecialchars($curDescription), "time" => htmlspecialchars($curTime), "day" => htmlspecialchars($curDay), "host" => htmlspecialchars($curHost), "owner" => htmlspecialchars($ownerName) );		
		array_push($events_array, $status);
	}
	$stmt->close();
}
echo json_encode($events_array);

?>