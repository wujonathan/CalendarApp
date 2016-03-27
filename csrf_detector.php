<?php
$destination_username = $_POST['dest'];
$amount = $_POST['amount'];
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
?>