<?php
if($_SESSION['token'] !== $_POST['token']){
	echo($_POST['token']);
	die("Request forgery detected");
}
?>