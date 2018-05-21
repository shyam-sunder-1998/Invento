<?php
 
 include "db.php";

$name=$_POST['fcname'];
 $pass=$_POST['fpass'];

 $query="UPDATE sign_in SET password='$pass' WHERE username='$name'";
 $result=mysqli_query($connection,$query);
 if($result){
 	header("location:http://localhost/email/login.html");
 }

?>