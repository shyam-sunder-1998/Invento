<?php

include "db.php";

$sender=$_POST['del_name'];

$query="SELECT MAX(id) FROM inbox WHERE sender='$sender' and read_msg=1";
$result=mysqli_query($connection,$query);
$row = mysqli_fetch_row($result);
$query1="UPDATE inbox SET read_msg=0 where id='$row[0]'";
$result1=mysqli_query($connection,$query1);

$query2="SELECT * FROM inbox where read_msg=1";
$result2=mysqli_query($connection,$query2);
$new_msg=mysqli_num_rows($result2);

echo "$new_msg";
?>