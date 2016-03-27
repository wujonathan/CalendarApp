<?php
header("Content-Type: application/json");

session_start();
require 'database.php';
$user_id=$_SESSION['user_id'];
$queryMonth=$_POST["queryMonth"];

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
$stmt->bind_result($sharer_id);
while($stmt->fetch()){
	array_push($users_array,  htmlspecialchars($shared_id));
}

$stmt->close();
$events_array=array();
echo("this is used");
echo($userid);
echo($querryMonth);
for($i=0;$i<sizeof($users_array);$i++){
	$stmt = $mysqli->prepare("SELECT title, description, day, time FROM events WHERE userid=? AND month=? ORDER BY day ASC");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => $mysqli->error						));
		exit;
	}
	$stmt->bind_param('ss', $users_array[$i], $queryMonth);
	$stmt->execute();
	$stmt->bind_result($curTitle, $curDescription, $curDay, $curTime);
	echo $queryMonth;
	while($stmt->fetch()){
		
		array_push($events_array, array(htmlspecialchars($curTitle), htmlspecialchars($curDescription), htmlspecialchars($curTime), htmlspecialchars($curDay)));
	}
	$stmt->close();
}
echo json_encode($events_array);

?>