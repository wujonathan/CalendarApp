<?php
header("Content-Type: application/json");

session_start();
require 'database.php';
$shareTo = $_POST['shareTo'];
$sharer_id=$_SESSION['user_id'];

function alreadyShared($u){
		require 'database.php';
		$sharer_id=$_SESSION['user_id'];
		$stmt = $mysqli->prepare("SELECT COUNT(*) FROM shared_users WHERE user_id = (?) and sharer_id = (?)");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('ii', $u, $sharer_id);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();
		if($result==0){return false;}
		else{return true;}
	}
<<<<<<< HEAD
echo($shareTo);
$shareToArr = explode(", ", $shareTo);
echo(sizeof($shareToArr));
=======
$shareToArr = explode(", ", $shareTo);
$array = array();
>>>>>>> fcfbd5d975831d26b16a091d3ec2b44bb2c1dfc1
for($i=0; $i<sizeof($shareToArr) ;$i++){
	$curU=$shareToArr[$i];	
	$stmt = $mysqli->prepare("SELECT id FROM registered_users WHERE username=?");
	if(!$stmt){
		$status = array(
			"success" => false,
			"user" => $curU,
			"message" => $mysqli->error
						);
	       array_push($array, $status);
      	       exit;
	}
	$stmt->bind_param('s', $curU);
	$stmt->execute();
	$stmt->bind_result($user_id);
	$stmt->fetch();
	$stmt->close();
	if($user_id!=null && !alreadyShared($user_id)){
		$stmt = $mysqli->prepare("INSERT INTO shared_users (user_id, sharer_id) VALUES (?, ?)");
		if(!$stmt){
			$status = array(
				"success" => false,
				"user" => $curU,
				"message" => $mysqli->error						);
 			array_push($array, $status);
			exit;
		}
		$stmt->bind_param('ii', $user_id, $sharer_id);
		$stmt->execute();
		$stmt->close();
<<<<<<< HEAD
		echo json_encode(array(
			"success" => true
			));
=======
		$status = array(
			"success" => true,
			"user" => $curU
			);
		array_push($array, $status);

			
>>>>>>> fcfbd5d975831d26b16a091d3ec2b44bb2c1dfc1
	}
	else{
		$status = array(
			"success" => false,
			"user" => $curU,
			"message" => "Failed to Share Calendar"
			);
                array_push($array, $status);
	}
}
echo json_encode($array);
?>
