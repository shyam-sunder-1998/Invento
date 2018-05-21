<?php
	include ("db.php");
	include ("../session.php");
	if(!isset($_SESSION)){
		session_start();
	}

	$names=array();
	$i=0;

	$query = "SELECT * from inbox where reciever='$login_user' AND read_msg=1";
	$result = mysqli_query($connection,$query);
	while( $row = mysqli_fetch_row($result)){
		$names[$i]=$row[1];
		$i++;
	}
	$inbox=json_encode($names);

	echo "$inbox";
?>