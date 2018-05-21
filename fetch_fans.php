<?php

include "db.php";

$name=$_POST['refer_uname'];
$ans=$_POST['refer_ans'];
$query="SELECT sans FROM sign_in WHERE sans='$ans' AND username='$name'";
$result=mysqli_query($connection,$query);
$select=mysqli_num_rows($result);
if($select==1){
	$value=1;
}
else{
	$value=0;
}
echo "$value";

?>