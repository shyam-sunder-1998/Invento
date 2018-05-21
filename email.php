 <?php

	include("db.php");
	if(!isset($_SESSION)){
		session_start();
	}

	$uname=$_POST['uname'];
	$pass=$_POST['pass'];

	$query = "SELECT * FROM sign_in WHERE username='$uname' and password='$pass'";
	$result = mysqli_query($connection,$query) or die(mysqli_error($connection));
	$rows = mysqli_num_rows($result);
	if($rows==1){
		header("location:http://localhost/email/inbox/msg.php"); 
		$_SESSION['name']=$uname;
	}
	else{
		header("location:http://localhost/email/temp.php");
	}
?>