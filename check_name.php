<?php

include ("db.php");

if(isset($_POST['user_name']))
{
 $name=$_POST['user_name'];

 $checkdata=" SELECT * FROM sign_in WHERE username='$name' ";

 $result = mysqli_query( $connection,$checkdata);

$a= mysqli_num_rows($result);
 if($a==0)
 {
  echo "1"; 
 }
 else
 {
  echo "0";
 }

}

?>