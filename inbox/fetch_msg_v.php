<?php
include ("db.php");

$sender=$_POST["del_msg"];
$value=array(); 

$query="SELECT MAX(id) FROM inbox WHERE sender='$sender' and read_msg=1";
$result=mysqli_query($connection,$query);
$row = mysqli_fetch_row($result);

$query1="SELECT sender FROM inbox WHERE id='$row[0]'";
$result1=mysqli_query($connection,$query1);
$value[0]=mysqli_fetch_row($result1);

$query2="SELECT time_sent FROM inbox WHERE id='$row[0]'";
$result2=mysqli_query($connection,$query2);
$value[1]=mysqli_fetch_row($result2);

$query3="SELECT subject FROM inbox WHERE id='$row[0]' ";
$result3=mysqli_query($connection,$query3);
$value[2]=mysqli_fetch_row($result3);


$query4="SELECT message FROM inbox WHERE id='$row[0]' ";
$result4=mysqli_query($connection,$query4);
$value[3]=mysqli_fetch_row($result4);

$rvalue=json_encode($value);
echo "$rvalue";

?>