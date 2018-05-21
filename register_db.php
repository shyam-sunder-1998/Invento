<?php

include "db.php";

$uname=$_POST['uname'];
$pass=$_POST['pass'];
$ques=$_POST['ques'];
$ans=$_POST['ans'];

$query="INSERT INTO sign_in (id_no,username,password,sques,sans) VALUES ('','$uname','$pass','$ques','$ans')";
$result=mysqli_query($connection,$query) or die(mysqli_error($connection));
if($result){
	header("location:http://localhost/email/login.html");
}





?>