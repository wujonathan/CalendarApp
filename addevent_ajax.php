<?php

header("Content-Type: application/json");
session_start();
$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];
function existingUserCheck($u){
	require 'database.php';
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM registered_usersWHERE username = (?) LIMIT 1");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => $mysqli->error
			));
		exit;
	}
	$stmt->bind_param('s', $u);
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$stmt->close();
	if($result==0){return false;}
	else{return true;}
}

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	echo json_encode(array(
		"success" => false,
		"message" => "Session hijack detected"
		));
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}
$date=$_POST['date'];
$host="yes";
$group=$_POST['groups'];
$user_id=$_SESSION['user_id'];
$title=$_POST['title'];
$description=$_POST['description'];
$time=$_POST['time'];
require 'database.php';
		//Inserts into database
$stmt = $mysqli->prepare("INSERT INTO events (date, host, userid, title, description, time) VALUES (?, ?, ?, ?, ?, ?)");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => $mysqli->error
		));
	exit;
}
$stmt->bind_param('ssisss',$date, $host, $user_id, $title, $description, $time);
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
$groups = explode(",", $group);
echo(sizeof($groups));
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
	echo($curUser_id);
	if($curUser_id!=null){
		$stmt = $mysqli->prepare("INSERT INTO events (date, host, userid, title, description, time) VALUES (?, ?, ?, ?, ?, ?)");
		if(!$stmt){
			echo json_encode(array(
				"success" => false,
				"message" => $mysqli->error
				));
			exit;
		}
		$stmt->bind_param('ssisss',$date, $host, $curUser_id, $title, $description, $time);
		$stmt->execute();
		$stmt->close();
	}
}

echo json_encode(array(	     	        
	"success" => true
	));				
exit;

?>