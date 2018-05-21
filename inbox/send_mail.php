<?php
	include ("../session.php");
	include ("db.php");
	if(!isset($_SESSION)){
			session_start();
	}

	$from=$_POST['sender'];
	$reciever=$_POST['reciever'];
	$subject=$_POST['subj'];
	$message=$_POST['message'];

	$query="INSERT into inbox (id,sender,reciever,subject,message,time_sent,read_msg) VALUES ('','$from','$reciever','$subject','$message',now(),1)";
	$result=mysqli_query($connection,$query) or die(mysqli_error($connection));
	if($result){
		header("location:http://localhost/email/inbox/msg.php");	
	}
?>
