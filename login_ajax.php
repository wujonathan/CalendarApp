<?php

header("Content-Type: application/json"); 
$username = $_POST['username'];
$password = $_POST['password'];

require 'database.php';
$stmt = $mysqli->prepare("SELECT COUNT(*), id, password FROM registered_users WHERE username=?");
if (!$stmt){
   echo json_encode(array(
		"success" => false,
		"message" => $mysli->error	
		));
		exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
$stmt->close();
if($cnt == 1 && crypt($password, $pwd_hash)==$pwd_hash){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
	$_SESSION['user_id'] = $user_id;

	echo json_encode(array(
		"success" => true
		));
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
		));
	exit;
}
?>