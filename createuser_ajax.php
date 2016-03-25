<?php
header("Content-Type: application/json");
if(isset($_POST['submit'])){
	if(isset($_POST['newUsername'])&&isset($_POST['newPassword'])){
		require 'database.php';
// This function checks if the username matches one in the database
		function existingUserCheck($u){
			require 'database.php';
			$stmt = $mysqli->prepare("SELECT COUNT(*) FROM registered_users WHERE username = (?) LIMIT 1");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
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

		$newUsername = $_POST['newUsername'];
		$newPassword = $_POST['newPassword'];
		if(!existingUserCheck($newUsername)){
			$stmt = $mysqli->prepare("INSERT INTO registered_users (username, password) VALUES (?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
		//hashes the password
			$CryptPass=crypt($newPassword);
			$stmt->bind_param('ss', $newUsername, $CryptPass);

			$stmt->execute();

			$stmt->close();
		//New user is now created
			echo json_encode(array(
				"success" => true
				));
			exit;
		}

		else{
			echo json_encode(array(
				"success" => false,
				"message" => "Failed to Create User"
				));
			exit;
		}
	}
}
?>
