<?php
/*Adds an event to the database after getting the post variables from the ajax request. Adds events to other group users if they exist*/
header("Content-Type: application/json");
require 'database.php';
require 'user_agent_test.php';

$date=$mysqli->real_escape_string($_POST['date']);
$month=$mysqli->real_escape_string(substr($date, 0,7));
$day=$mysqli->real_escape_string(substr($date, 8,10));
$host=$_SESSION['username'];
$group=$mysqli->real_escape_string($_POST['groups']);
$user_id=$_SESSION['user_id'];
$title=$mysqli->real_escape_string($_POST['title']);
$description=$mysqli->real_escape_string($_POST['description']);
$time=$mysqli->real_escape_string($_POST['time']);
$tag=$mysqli->real_escape_string($_POST['tag']);

		//Inserts into database
$stmt = $mysqli->prepare("INSERT INTO events (month, host, userid, title, description, time, day, tag) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error
		));
	exit;
}
$stmt->bind_param('ssisssss',$month, $host, $user_id, $title, $description, $time, $day, $tag);
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
//For group events i.e. other invited users
$groups = explode(", ", $group);
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
		$stmt = $mysqli->prepare("INSERT INTO events (month, host, userid, title, description, time, day, tag) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		if(!$stmt){
			echo json_encode(array(
				"success" => false,
				"message" => $mysqli->error
				));
			exit;
		}
		$stmt->bind_param('ssissss',$month, $host, $curUser_id, $title, $description, $time, $day, $tag);
		$stmt->execute();
		$stmt->close();
	}
}

echo json_encode(array(	     	        
	"success" => true
	));				
exit;

?>