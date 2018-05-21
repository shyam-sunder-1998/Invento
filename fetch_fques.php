<?php

include "db.php";

$name=$_POST['refer_name'];
$query="SELECT sques FROM sign_in WHERE username='$name'";
$result=mysqli_query($connection,$query);
$select=mysqli_num_rows($result);
if($select==1){
	while($row=mysqli_fetch_array($result)){
		$value=$row[0];
	}
}
else{
	$value="no";
}
echo "$value";


?>