<?php
	include ("db.php");
	if(!isset($_SESSION)){
		session_start();
	}
	$login_user=$_SESSION['name'];
?>
