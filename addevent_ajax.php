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

		//Gets the required variables
$date=$_POST['date'];
$grouped=$_POST['grouped'];
$group=$_POST['group'];
$user_id=$_SESSION['user_id'];
$title=$_POST['title'];
$description=$_POST['description'];
$time=$_POST['time'];
require 'database.php';
		//Inserts into database
$stmt = $mysqli->prepare("INSERT INTO events (date, grouped, userid, title, description, time) VALUES (?, ?, ?, ?, ?, ?)");
	if(!$stmt){
		echo json_encode(array(
                "success" => false,
                "message" => $mysqli->error
                ));
		exit;
	}
	$stmt->bind_param('ssisss',$date, $grouped, $user_id, $title, $description, $time);
	echo  $mysqli->error;
	$stmt->execute();
	$stmt->close();

if(strcmp(grouped,"yes")==0){
	echo "lala";
	$stmt = $mysqli->prepare("SELECT scope_identity() FROM events");
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
	for($i=0; $i<sizeof($groups) ;$i++){
		$curU=$groups[$i];				
		$stmt = $mysqli->prepare("SELECT user_id FROM registered_users WHERE username=?");
  		if(!$stmt){
			echo json_encode(array(
                	"success" => false,
                	"message" => $mysqli->error						));
			exit;
		}
		$stmt->bind_param('s', $curU);
		$stmt->execute();
		$stmt->bind_result($user_id, $pwd_hash);
		$stmt->fetch();
		$stmt->close();

		$stmt = $mysqli->prepare("INSERT INTO group_events (event_id, user_id) VALUES (?, ?)");
		if(!$stmt){
			echo json_encode(array(
        	        "success" => false,
                	"message" => $mysqli->error						));
			exit;
			}
		$stmt->bind_param('ii', $event_id, $cur_id);
		$stmt->execute();
		$stmt->close();
	}
}	
echo json_encode(array(	     	        
"success" => true
));				
exit;

?>